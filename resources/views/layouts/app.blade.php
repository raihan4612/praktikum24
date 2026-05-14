<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Sistem Data Mahasiswa')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        body { background-color: #f0f2f5; }
        .sidebar {
            min-height: 100vh;
            background: linear-gradient(180deg, #1a3c6e 0%, #2563a8 100%);
        }
        .sidebar .nav-link {
            color: rgba(255,255,255,0.8);
            border-radius: 8px;
            margin-bottom: 4px;
            transition: all 0.2s;
        }
        .sidebar .nav-link:hover,
        .sidebar .nav-link.active {
            background-color: rgba(255,255,255,0.2);
            color: #fff;
        }
        .sidebar .nav-link i { margin-right: 8px; }
        .sidebar-brand {
            padding: 1.5rem 1rem;
            color: #fff;
            font-weight: 700;
            font-size: 1.1rem;
            border-bottom: 1px solid rgba(255,255,255,0.15);
            margin-bottom: 1rem;
        }
        .sidebar-footer {
            position: absolute;
            bottom: 0;
            width: 100%;
            padding: 1rem;
            border-top: 1px solid rgba(255,255,255,0.15);
        }
        .main-content { padding: 2rem; }
        .card { border: none; border-radius: 12px; box-shadow: 0 2px 12px rgba(0,0,0,0.07); }
        .card-header { border-radius: 12px 12px 0 0 !important; font-weight: 600; }
        .btn-primary { background-color: #2563a8; border-color: #2563a8; }
        .btn-primary:hover { background-color: #1a3c6e; border-color: #1a3c6e; }
        .table thead th { background-color: #1a3c6e; color: #fff; border: none; }
        .badge-admin { background-color: #dc3545; }
        .badge-user  { background-color: #0d6efd; }
    </style>
</head>
<body>
<div class="container-fluid">
    <div class="row">
        <!-- Sidebar -->
        <div class="col-md-2 p-0 sidebar position-relative">
            <div class="sidebar-brand text-center">
                <i class="bi bi-mortarboard-fill me-2"></i>SIMAK
            </div>
            <ul class="nav flex-column px-3">
                <li class="nav-item">
                    <a href="{{ route('data-mahasiswa') }}"
                       class="nav-link {{ request()->is('data-mahasiswa*') ? 'active' : '' }}">
                        <i class="bi bi-people-fill"></i> Data Mahasiswa
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('buku.index') }}"
                       class="nav-link {{ request()->is('buku*') ? 'active' : '' }}">
                        <i class="bi bi-book-fill"></i> Data Buku
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('peminjaman.index') }}"
                       class="nav-link {{ request()->is('peminjaman*') ? 'active' : '' }}">
                        <i class="bi bi-journal-bookmark-fill"></i> Peminjaman
                    </a>
                </li>

                {{-- Menu khusus Admin --}}
                @if(auth()->user()->isAdmin())
                <li class="nav-item">
                    <a href="{{ route('hak-akses') }}"
                       class="nav-link {{ request()->is('hak-akses*') ? 'active' : '' }}">
                        <i class="bi bi-shield-lock-fill"></i> Hak Akses
                    </a>
                </li>
                @endif
            </ul>

            <!-- User info & logout -->
            <div class="sidebar-footer">
                <div class="text-white mb-2" style="font-size:0.85rem;">
                    <i class="bi bi-person-circle me-1"></i>
                    {{ auth()->user()->nama }}
                    <span class="badge ms-1 {{ auth()->user()->isAdmin() ? 'badge-admin' : 'badge-user' }}">
                        {{ ucfirst(auth()->user()->role) }}
                    </span>
                </div>
                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button type="submit" class="btn btn-sm btn-outline-light w-100">
                        <i class="bi bi-box-arrow-left me-1"></i> Logout
                    </button>
                </form>
            </div>
        </div>

        <!-- Main Content -->
        <div class="col-md-10 main-content">
            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <i class="bi bi-check-circle-fill me-2"></i>{{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            @if(session('error'))
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <i class="bi bi-x-circle-fill me-2"></i>{{ session('error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            @yield('content')
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
@yield('scripts')
</body>
</html>