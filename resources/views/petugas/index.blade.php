@extends('layouts.app')

@section('title', 'Data Petugas')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h4 class="mb-0 fw-bold">
            <i class="bi bi-person-workspace text-primary me-2"></i>Data Petugas
        </h4>
        <small class="text-muted">
            Total: {{ $dtPetugas->count() }} petugas
        </small>
    </div>

    <a href="{{ route('petugas.create') }}" class="btn btn-primary">
        <i class="bi bi-plus-circle me-1"></i> Tambah Petugas
    </a>
</div>

<div class="card">
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover mb-0">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Kode</th>
                        <th>Nama</th>
                        <th>Email</th>
                        <th>No HP</th>
                        <th>Jabatan</th>
                        <th>Status</th>
                        <th class="text-center">Aksi</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse ($dtPetugas as $item)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>
                            <span class="fw-semibold">
                                {{ $item->kode_petugas }}
                            </span>
                        </td>
                        <td>{{ $item->nama }}</td>
                        <td>{{ $item->email }}</td>
                        <td>{{ $item->no_hp }}</td>
                        <td>{{ $item->jabatan }}</td>

                        <td>
                            <span class="badge {{ $item->status == 'Aktif' ? 'bg-success' : 'bg-secondary' }}">
                                {{ $item->status }}
                            </span>
                        </td>

                        <td class="text-center">
                            <a href="{{ route('petugas.show', $item->id) }}"
                               class="btn btn-sm btn-outline-info">
                                <i class="bi bi-eye"></i>
                            </a>

                            <a href="{{ route('petugas.edit', $item->id) }}"
                               class="btn btn-sm btn-outline-warning">
                                <i class="bi bi-pencil"></i>
                            </a>

                            <form action="{{ route('petugas.destroy', $item->id) }}"
                                  method="POST"
                                  class="d-inline"
                                  onsubmit="return confirm('Yakin hapus data {{ $item->nama }}?')">
                                @csrf
                                @method('DELETE')

                                <button type="submit"
                                        class="btn btn-sm btn-outline-danger">
                                    <i class="bi bi-trash"></i>
                                </button>
                            </form>
                        </td>
                    </tr>

                    @empty
                    <tr>
                        <td colspan="8" class="text-center text-muted py-4">
                            <i class="bi bi-inbox fs-3 d-block mb-2"></i>
                            Belum ada data petugas
                        </td>
                    </tr>
                    @endforelse
                </tbody>

            </table>
        </div>
    </div>
</div>
@endsection