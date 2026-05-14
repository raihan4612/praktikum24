@extends('layouts.app')

@section('title', 'Data Buku')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h4 class="mb-0 fw-bold"><i class="bi bi-book-fill text-primary me-2"></i>Data Buku</h4>
        <small class="text-muted">Total: {{ $dtBuku->count() }} buku</small>
    </div>
    @if(auth()->user()->isAdmin())
    <a href="{{ route('buku.create') }}" class="btn btn-primary">
        <i class="bi bi-plus-circle me-1"></i> Tambah Buku
    </a>
    @endif
</div>

<div class="card">
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover mb-0">
                <thead>
                    <tr>
                        <th style="width:4%">#</th>
                        <th>Kode</th>
                        <th>Judul Buku</th>
                        <th>Pengarang</th>
                        <th>Kategori</th>
                        <th>Stok</th>
                        <th>Tersedia</th>
                        <th>Status</th>
                        <th class="text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($dtBuku as $item)
                    <tr>
                        <td class="text-muted">{{ $loop->iteration }}</td>
                        <td><span class="fw-semibold text-primary">{{ $item->kode_buku }}</span></td>
                        <td>
                            <div class="fw-semibold">{{ $item->judul }}</div>
                            <small class="text-muted">{{ $item->penerbit }}, {{ $item->tahun_terbit }}</small>
                        </td>
                        <td>{{ $item->pengarang }}</td>
                        <td><span class="badge bg-secondary">{{ $item->kategori }}</span></td>
                        <td class="text-center">{{ $item->jumlah_stok }}</td>
                        <td class="text-center">
                            <span class="fw-bold {{ $item->jumlah_tersedia > 0 ? 'text-success' : 'text-danger' }}">
                                {{ $item->jumlah_tersedia }}
                            </span>
                        </td>
                        <td>
                            @if($item->status === 'Tersedia')
                                <span class="badge bg-success">Tersedia</span>
                            @else
                                <span class="badge bg-danger">Habis</span>
                            @endif
                        </td>
                        <td class="text-center">
                            <a href="{{ route('buku.show', $item->id) }}"
                               class="btn btn-sm btn-outline-info" title="Detail">
                                <i class="bi bi-eye"></i>
                            </a>
                            @if(auth()->user()->isAdmin())
                            <a href="{{ route('buku.edit', $item->id) }}"
                               class="btn btn-sm btn-outline-warning" title="Edit">
                                <i class="bi bi-pencil"></i>
                            </a>
                            <form action="{{ route('buku.destroy', $item->id) }}"
                                  method="POST" class="d-inline"
                                  onsubmit="return confirm('Yakin hapus buku {{ $item->judul }}?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-outline-danger" title="Hapus">
                                    <i class="bi bi-trash"></i>
                                </button>
                            </form>
                            @endif
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="9" class="text-center text-muted py-4">
                            <i class="bi bi-book fs-3 d-block mb-2"></i>
                            Belum ada data buku
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
