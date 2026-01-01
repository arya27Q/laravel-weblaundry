<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Atur Ulang Password - LAUNDRY</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; font-family: 'Segoe UI', sans-serif; }
        
        /* --- CSS LOADING BAR (DI ATAS) --- */
        #preloader {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 3px;
            background: transparent;
            z-index: 9999;
        }
        .loading-bar {
            width: 0%;
            height: 100%;
            background: #f97316;
            box-shadow: 0 0 10px #f97316;
            transition: width 0.4s ease;
        }

        body { 
            background-color: #f3f4f6; 
            display: flex; 
            align-items: center; 
            justify-content: center; 
            height: 100vh;
            opacity: 0; /* Untuk efek fade in */
            transition: opacity 0.5s ease;
        }
        
        .auth-card { 
            background: #fff; 
            padding: 40px; 
            border-radius: 20px; 
            box-shadow: 0 10px 25px rgba(0,0,0,0.05); 
            width: 100%; 
            max-width: 400px; 
            text-align: center; 
        }

        .auth-header i { font-size: 40px; color: #f97316; margin-bottom: 15px; }
        .auth-header h2 { font-size: 22px; font-weight: 700; color: #1f2937; margin-bottom: 10px; }
        .auth-header p { color: #6b7280; font-size: 14px; margin-bottom: 25px; }

        .form-group { text-align: left; margin-bottom: 20px; }
        .form-group label { display: block; font-size: 14px; font-weight: 600; margin-bottom: 8px; color: #374151; }
        
        .input-wrapper { position: relative; }
        .input-wrapper i { position: absolute; left: 14px; top: 50%; transform: translateY(-50%); color: #9ca3af; }
        
        .form-control { 
            width: 100%; 
            padding: 12px 14px 12px 40px; 
            border-radius: 12px; 
            border: 1px solid #d1d5db; 
            font-size: 14px; 
        }

        .form-control:focus { 
            outline: none; 
            border-color: #f97316; 
            box-shadow: 0 0 0 3px rgba(249, 115, 22, 0.1); 
        }

        .btn-auth { 
            width: 100%; 
            background: #f97316; 
            color: white; 
            border: none; 
            padding: 14px; 
            border-radius: 12px; 
            font-size: 15px; 
            font-weight: 600; 
            cursor: pointer; 
            transition: 0.3s;
            display: flex;
            justify-content: center;
            align-items: center;
            gap: 10px;
        }

        .btn-auth:hover { background: #ea580c; }
        .btn-auth:disabled { background: #fdba74; cursor: not-allowed; }

        /* Spinner Animasi */
        .spinner {
            width: 18px;
            height: 18px;
            border: 2px solid #ffffff;
            border-bottom-color: transparent;
            border-radius: 50%;
            display: none;
            animation: rotation 1s linear infinite;
        }

        @keyframes rotation {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }
    </style>
</head>
<body>

<div id="preloader">
    <div class="loading-bar" id="loadingBar"></div>
</div>

<div class="auth-card">
    <div class="auth-header">
        <i class="fa-solid fa-user-shield"></i>
        <h2>Reset Password</h2>
        <p>Silakan masukkan password baru Anda.</p>
    </div>

    <form action="{{ route('password.update') }}" method="POST" id="authForm">
    @csrf
    <input type="hidden" name="token" value="{{ $token }}">
    <input type="hidden" name="email" value="{{ $email ?? old('email') }}">

    <div class="form-group">
        <label>Password Baru</label>
        <div class="input-wrapper">
            <i class="fa-solid fa-lock"></i>
            <input type="password" name="password" class="form-control" placeholder="Minimal 8 karakter" required autofocus>
        </div>
        @error('password')
            <small style="color: #ef4444; margin-top: 5px; display: block;">{{ $message }}</small>
        @enderror
    </div>

    <div class="form-group">
        <label>Konfirmasi Password Baru</label>
        <div class="input-wrapper">
            <i class="fa-solid fa-circle-check"></i>
            <input type="password" name="password_confirmation" class="form-control" placeholder="Ulangi password baru" required>
        </div>
    </div>

    <button type="submit" class="btn-auth" id="btnSubmit">
        <div class="spinner" id="btnSpinner"></div>
        <span id="btnText">Simpan Password Baru</span>
    </button>
</form>
</div>

<script>
    // 1. Loading Bar saat halaman dibuka
    window.addEventListener('load', function() {
        const bar = document.getElementById('loadingBar');
        bar.style.width = '100%';
        
        setTimeout(() => {
            document.body.style.opacity = '1';
            bar.style.opacity = '0';
        }, 500);
    });

    // 2. Efek Loading saat Form di-submit
    const authForm = document.getElementById('authForm');
    const btnSubmit = document.getElementById('btnSubmit');
    const btnSpinner = document.getElementById('btnSpinner');
    const btnText = document.getElementById('btnText');

    authForm.addEventListener('submit', function() {
        // Disable tombol biar gak double click
        btnSubmit.disabled = true;
        // Munculkan spinner
        btnSpinner.style.display = 'inline-block';
        // Ubah teks
        btnText.innerText = 'Menyimpan...';
        
        // Jalankan loading bar lagi
        const bar = document.getElementById('loadingBar');
        bar.style.opacity = '1';
        bar.style.width = '50%';
    });
</script>

</body>
</html>