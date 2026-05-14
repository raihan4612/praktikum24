<?php

namespace App\Http\Controllers;

use App\Models\Peminjaman;
use App\Models\Mahasiswa;
use App\Models\Buku;
use Illuminate\Http\Request;
use Carbon\Carbon;

class PeminjamanController extends Controller
{
    public function index()
    {
        $dtPeminjaman = Peminjaman::with(['mahasiswa', 'buku'])->latest()->get();
        return view('peminjaman.index', compact('dtPeminjaman'));
    }

    public function create()
    {
        // Hanya mahasiswa aktif
        $mahasiswaList = Mahasiswa::where('status', 'Aktif')->orderBy('nama')->get();
        // Hanya buku yang tersedia
        $bukuList = Buku::where('status', 'Tersedia')->where('jumlah_tersedia', '>', 0)->orderBy('judul')->get();

        return view('peminjaman.create', compact('mahasiswaList', 'bukuList'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'mahasiswa_id'            => 'required|exists:mhs,id',
            'buku_id'                 => 'required|exists:buku,id',
            'tanggal_pinjam'          => 'required|date',
            'tanggal_kembali_rencana' => 'required|date|after:tanggal_pinjam',
            'catatan'                 => 'nullable',
        ]);

        // Cek stok buku
        $buku = Buku::findOrFail($request->buku_id);
        if ($buku->jumlah_tersedia <= 0) {
            return back()->withInput()->with('error', 'Stok buku "' . $buku->judul . '" sudah habis!');
        }

        // Generate kode peminjaman otomatis
        $kode = 'PJM-' . date('Ymd') . '-' . str_pad(Peminjaman::whereDate('created_at', today())->count() + 1, 3, '0', STR_PAD_LEFT);

        Peminjaman::create([
            'kode_peminjaman'         => $kode,
            'mahasiswa_id'            => $request->mahasiswa_id,
            'buku_id'                 => $request->buku_id,
            'tanggal_pinjam'          => $request->tanggal_pinjam,
            'tanggal_kembali_rencana' => $request->tanggal_kembali_rencana,
            'status'                  => 'Dipinjam',
            'denda'                   => 0,
            'catatan'                 => $request->catatan,
        ]);

        // Kurangi stok tersedia
        $buku->jumlah_tersedia -= 1;
        $buku->status = $buku->jumlah_tersedia > 0 ? 'Tersedia' : 'Habis';
        $buku->save();

        return redirect()->route('peminjaman.index')->with('success', 'Peminjaman berhasil dicatat dengan kode ' . $kode . '!');
    }

    public function show($id)
    {
        $peminjaman = Peminjaman::with(['mahasiswa', 'buku'])->findOrFail($id);
        return view('peminjaman.show', compact('peminjaman'));
    }

    public function edit($id)
    {
        $peminjaman = Peminjaman::findOrFail($id);
        $mahasiswaList = Mahasiswa::orderBy('nama')->get();
        $bukuList = Buku::orderBy('judul')->get();
        return view('peminjaman.edit', compact('peminjaman', 'mahasiswaList', 'bukuList'));
    }

    public function pengembalian($id)
    {
        $peminjaman = Peminjaman::with(['mahasiswa', 'buku'])->findOrFail($id);

        if ($peminjaman->status === 'Dikembalikan') {
            return redirect()->route('peminjaman.index')->with('error', 'Buku sudah dikembalikan!');
        }

        $tanggalHariIni = Carbon::today();
        $tanggalRencana = Carbon::parse($peminjaman->tanggal_kembali_rencana);
        $denda = 0;

        if ($tanggalHariIni->gt($tanggalRencana)) {
            $hariTerlambat = $tanggalHariIni->diffInDays($tanggalRencana);
            $denda = $hariTerlambat * 1000; // Rp 1.000/hari
        }

        $peminjaman->update([
            'tanggal_kembali_aktual' => $tanggalHariIni,
            'status'                 => $tanggalHariIni->gt($tanggalRencana) ? 'Terlambat' : 'Dikembalikan',
            'denda'                  => $denda,
        ]);

        // Kembalikan stok buku
        $buku = $peminjaman->buku;
        $buku->jumlah_tersedia += 1;
        $buku->status = 'Tersedia';
        $buku->save();

        $msg = 'Buku berhasil dikembalikan!';
        if ($denda > 0) {
            $msg .= ' Terdapat denda Rp ' . number_format($denda, 0, ',', '.');
        }

        return redirect()->route('peminjaman.index')->with('success', $msg);
    }

    public function destroy($id)
    {
        $peminjaman = Peminjaman::findOrFail($id);

        if ($peminjaman->status === 'Dipinjam') {
            return redirect()->route('peminjaman.index')->with('error', 'Tidak dapat menghapus peminjaman yang masih aktif!');
        }

        $peminjaman->delete();
        return redirect()->route('peminjaman.index')->with('success', 'Data peminjaman berhasil dihapus!');
    }
}
