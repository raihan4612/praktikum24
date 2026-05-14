@extends('layouts.app')

@section('title', 'Data Mahasiswa')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h4 class="mb-0 fw-bold"><i class="bi bi-people-fill text-primary me-2"></i>Data Mahasiswa</h4>
        <small class="text-muted">Total: {{ $dtMhs->count() }} mahasiswa</small>
    </div>
    <a href="{{ route('create-mahasiswa') }}" class="btn btn-primary">
        <i class="bi bi-plus-circle me-1"></i> Tambah Mahasiswa
    </a>
</div>

<div class="card">
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover mb-0">
                <thead>
                    <tr>
                        <th style="width:4%">#</th>
                        <th>NIM</th>
                        <th>Nama</th>
                        <th>Prodi / Fakultas</th>
                        <th>Semester</th>
                        <th>No. HP</th>
                        <th>Status</th>
                        <th class="text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($dtMhs as $item)
                    <tr>
                        <td class="text-muted">{{ $loop->iteration }}</td>
                        <td><span class="fw-semibold">{{ $item->nim }}</span></td>
                        <td>{{ $item->nama }}</td>
                        <td>
                            <div>{{ $item->prodi }}</div>
                            <small class="text-muted">{{ $item->fakultas }}</small>
                        </td>
                        <td>{{ $item->semester }}</td>
                        <td>{{ $item->no_hp }}</td>
                        <td>
                            @php
                                $badgeClass = match($item->status) {
                                    'Aktif'   => 'bg-success',
                                    'Cuti'    => 'bg-warning text-dark',
                                    'Lulus'   => 'bg-info text-dark',
                                    'Dropout' => 'bg-danger',
                                    default   => 'bg-secondary',
                                };
                            @endphp
                            <span class="badge {{ $badgeClass }}">{{ $item->status }}</span>
                        </td>
                        <td class="text-center">
                            <a href="{{ route('show-mahasiswa', $item->id) }}"
                               class="btn btn-sm btn-outline-info" title="Detail">
                                <i class="bi bi-eye"></i>
                            </a>
                            <a href="{{ route('edit-mahasiswa', $item->id) }}"
                               class="btn btn-sm btn-outline-warning" title="Edit">
                                <i class="bi bi-pencil"></i>
                            </a>
                            <form action="{{ route('hapus-mahasiswa', $item->id) }}"
                                  method="POST" class="d-inline"
                                  onsubmit="return confirm('Yakin hapus data {{ $item->nama }}?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-outline-danger" title="Hapus">
                                    <i class="bi bi-trash"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="8" class="text-center text-muted py-4">
                            <i class="bi bi-inbox fs-3 d-block mb-2"></i>
                            Belum ada data mahasiswa
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
