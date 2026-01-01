<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title') - LAUNDRY</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"/>

    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; font-family: 'Segoe UI', sans-serif; }
        body { background: #f8fafc; display: flex; overflow-x: hidden; }

        .header {
            position: fixed;
            top: 0;
            right: 0;
            left: 260px;
            height: 70px;
            background: white;
            display: flex;
            align-items: center;
            justify-content: space-between; 
            padding: 0 30px;
            border-bottom: 1px solid #e2e8f0;
            z-index: 1000;
        }

        .header-title {
            font-size: 18px;
            font-weight: 700;
            color: #1f2937;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .main-content {
            margin-left: 260px;
            width: calc(100% - 260px);
            min-height: 100vh;
            padding-top: 70px; 
            display: flex;
            flex-direction: column;
        }

        .profile-wrapper { position: relative; }
        .profile-circle {
            width: 45px;
            height: 45px;
            background: #f97316; 
            color: white;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            transition: 0.3s;
        }

        .dropdown-logout {
            display: none;
            position: absolute;
            top: 120%;
            right: 0;
            background: white;
            min-width: 150px;
            border-radius: 10px;
            box-shadow: 0 10px 25px rgba(0,0,0,0.1);
            padding: 5px;
            z-index: 1100;
            border: 1px solid #f1f5f9;
        }
        .dropdown-logout.show { display: block; animation: fadeIn 0.2s ease; }

        .btn-logout {
            width: 100%;
            text-align: left;
            background: none;
            border: none;
            padding: 10px 15px;
            color: #ef4444;
            font-weight: 600;
            cursor: pointer;
            display: flex;
            align-items: center;
            gap: 10px;
            border-radius: 6px;
        }
        .btn-logout:hover { background: #fef2f2; }
    </style>
    @stack('styles')
</head>
<body>

    @include('partials.sidebar')

    <div class="main-content">
        <header class="header">
            <div class="header-title">
                <i class="fa-solid fa-desktop" style="color: #f97316;"></i>
                SISTEM MANAJEMEN LAUNDRY
            </div>

            <div class="profile-wrapper">
                <div class="profile-circle" id="profileBtn">
                    <i class="fa-solid fa-user"></i>
                </div>
                
                <div class="dropdown-logout" id="profileDropdown">
                    <div style="padding: 10px 15px; border-bottom: 1px solid #f1f5f9; font-size: 12px; color: #64748b;">
                        Halo, <b>{{ Auth::user()->name ?? 'Admin' }}</b>
                    </div>
                    <form action="{{ route('logout') }}" method="POST">
                        @csrf
                        <button type="submit" class="btn-logout">
                            <i class="fa-solid fa-right-from-bracket"></i> Logout
                        </button>
                    </form>
                </div>
            </div>
        </header>

        <div style="flex: 1; padding: 30px;">
            @yield('content')
        </div>

        <div style="padding: 20px 30px; border-top: 1px solid #e2e8f0; background: white;">
            @include('partials.footer')
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Dropdown Profile
            const btn = document.getElementById('profileBtn');
            const dropdown = document.getElementById('profileDropdown');

            if (btn && dropdown) {
                btn.addEventListener('click', function(e) {
                    e.stopPropagation();
                    dropdown.classList.toggle('show');
                });
                document.addEventListener('click', function(e) {
                    if (!btn.contains(e.target)) dropdown.classList.remove('show');
                });
            }

            // --- SWEETALERT2 LOGIC ---
            @if(session('success'))
                Swal.fire({
                    icon: 'success',
                    title: 'Berhasil!',
                    text: "{{ session('success') }}",
                    showConfirmButton: false,
                    timer: 2500,
                    showClass: {
                        popup: 'animate__animated animate__zoomIn'
                    },
                    hideClass: {
                        popup: 'animate__animated animate__zoomOut'
                    }
                });
            @endif

            @if(session('error'))
                Swal.fire({
                    icon: 'error',
                    title: 'Kesalahan!',
                    text: "{{ session('error') }}",
                    confirmButtonColor: '#f97316'
                });
            @endif
        });
    </script>
    @stack('scripts')
</body>
</html>