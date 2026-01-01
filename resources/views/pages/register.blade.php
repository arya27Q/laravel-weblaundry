<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Akun - LAUNDRY</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; font-family: 'Segoe UI', sans-serif; }
        body { background-color: #f3f4f6; display: flex; align-items: center; justify-content: center; min-height: 100vh; padding: 20px; }
        .auth-card { background: #fff; padding: 40px; border-radius: 20px; box-shadow: 0 10px 25px rgba(0,0,0,0.05); width: 100%; max-width: 450px; text-align: center; }
        .auth-header i { font-size: 40px; color: #f97316; margin-bottom: 10px; }
        .auth-header h2 { font-size: 24px; font-weight: 700; color: #1f2937; margin-bottom: 8px; }
        .auth-header p { color: #6b7280; font-size: 14px; margin-bottom: 30px; }
        .form-group { text-align: left; margin-bottom: 15px; }
        .form-group label { display: block; font-size: 13px; font-weight: 600; margin-bottom: 6px; color: #374151; }
        .input-wrapper { position: relative; }
        .input-wrapper i { position: absolute; left: 14px; top: 50%; transform: translateY(-50%); color: #9ca3af; }
        .form-control { width: 100%; padding: 12px 14px 12px 40px; border-radius: 12px; border: 1px solid #d1d5db; font-size: 14px; transition: all 0.3s; }
        .form-control:focus { outline: none; border-color: #f97316; box-shadow: 0 0 0 3px rgba(249, 115, 22, 0.1); }
        .btn-auth { width: 100%; background: #f97316; color: white; border: none; padding: 14px; border-radius: 12px; font-size: 16px; font-weight: 600; cursor: pointer; transition: background 0.3s; margin-top: 15px; }
        .btn-auth:hover { background: #ea580c; }
        .auth-footer { margin-top: 25px; font-size: 14px; color: #6b7280; }
        .auth-footer a { color: #f97316; text-decoration: none; font-weight: 600; }
    </style>
</head>
<body>

<div class="auth-card">
    <div class="auth-header">
        <i class="fa-solid fa-shirt"></i>
        <h2>Daftar Akun</h2>
        <p>Mulai kelola bisnis laundry Anda sekarang</p>
    </div>

    
<form action="{{ route('register') }}" method="POST">
    @csrf {{-- 2. Keamanan wajib Laravel --}}

    <div class="form-group">
        <label>Nama Lengkap</label>
        <div class="input-wrapper">
            <i class="fa-solid fa-user"></i>
            <input type="text" name="name" class="form-control" placeholder="Nama Bisnis / Owner" value="{{ old('name') }}" required>
        </div>
        @error('name') <small style="color: #ef4444;">{{ $message }}</small> @enderror
    </div>

    <div class="form-group">
        <label>Email</label>
        <div class="input-wrapper">
            <i class="fa-solid fa-envelope"></i>
            <input type="email" name="email" class="form-control" placeholder="email@contoh.com" value="{{ old('email') }}" required>
        </div>
        @error('email') <small style="color: #ef4444;">{{ $message }}</small> @enderror
    </div>

    <div class="form-group">
        <label>Password</label>
        <div class="input-wrapper">
            <i class="fa-solid fa-lock"></i>
            <input type="password" name="password" class="form-control" placeholder="Minimal 8 karakter" required>
        </div>
        @error('password') <small style="color: #ef4444;">{{ $message }}</small> @enderror
    </div>

    <div class="form-group">
        <label>Konfirmasi Password</label>
        <div class="input-wrapper">
            <i class="fa-solid fa-shield-halved"></i>
            <input type="password" name="password_confirmation" class="form-control" placeholder="Ulangi password" required>
        </div>
    </div>

    <button type="submit" class="btn-auth">Daftar Sekarang</button>
</form>

    <div class="auth-footer">
        Sudah punya akun? <a href="{{ route('login') }}">Login di sini</a>
    </div>
</div>

</body>
</html>