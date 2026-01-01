<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - LAUNDRY</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; font-family: 'Segoe UI', sans-serif; }
        
      
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
            opacity: 0; 
            transition: opacity 0.5s ease;
        }
        
        .login-card { background: #fff; padding: 40px; border-radius: 20px; box-shadow: 0 10px 25px rgba(0,0,0,0.05); width: 100%; max-width: 400px; text-align: center; }
        .login-header i { font-size: 40px; color: #f97316; margin-bottom: 10px; }
        .login-header h2 { font-size: 24px; font-weight: 700; color: #1f2937; margin-bottom: 8px; }
        .login-header p { color: #6b7280; font-size: 14px; margin-bottom: 30px; }
        .form-group { text-align: left; margin-bottom: 20px; }
        .form-group label { display: block; font-size: 14px; font-weight: 600; margin-bottom: 8px; color: #374151; }
        .input-wrapper { position: relative; }
        .input-wrapper i { position: absolute; left: 14px; top: 50%; transform: translateY(-50%); color: #9ca3af; }
        .form-control { width: 100%; padding: 12px 14px 12px 40px; border-radius: 12px; border: 1px solid #d1d5db; font-size: 14px; transition: all 0.3s; }
        .form-control:focus { outline: none; border-color: #f97316; box-shadow: 0 0 0 3px rgba(249, 115, 22, 0.1); }
        
        .btn-login { 
            width: 100%; 
            background: #f97316; 
            color: white; 
            border: none; 
            padding: 14px; 
            border-radius: 12px; 
            font-size: 16px; 
            font-weight: 600; 
            cursor: pointer; 
            transition: all 0.3s; 
            margin-top: 10px;
            display: flex;
            justify-content: center;
            align-items: center;
            gap: 10px;
        }
        .btn-login:hover { background: #ea580c; }
        .btn-login:disabled { background: #fdba74; cursor: not-allowed; }

      
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

        .login-footer { margin-top: 25px; font-size: 14px; color: #6b7280; }
        .login-footer a { color: #f97316; text-decoration: none; font-weight: 600; }
        .forgot-password { display: block; text-align: right; font-size: 12px; margin-top: 8px; color: #6b7280; text-decoration: none; }
    </style>
</head>
<body>

<div id="preloader">
    <div class="loading-bar" id="loadingBar"></div>
</div>

<div class="login-card">
    <div class="login-header">
        <i class="fa-solid fa-shirt"></i>
        <h2>Selamat Datang</h2>
        <p>Silakan login untuk mengelola laundry Anda</p>
    </div>

    <form action="{{ route('login') }}" method="POST" id="loginForm">
        @csrf 

        @if(session('error'))
            <div style="background: #fee2e2; color: #991b1b; padding: 10px; border-radius: 8px; margin-bottom: 20px; font-size: 13px; text-align: left;">
                <i class="fa-solid fa-circle-exclamation"></i> {{ session('error') }}
            </div>
        @endif

        <div class="form-group">
            <label>Email</label>
            <div class="input-wrapper">
                <i class="fa-solid fa-envelope"></i>
                <input type="email" name="email" class="form-control" placeholder="Masukkan email Anda" value="{{ old('email') }}" required autofocus>
            </div>
            @error('email') <small style="color: #ef4444; font-size: 11px;">{{ $message }}</small> @enderror
        </div>

        <div class="form-group">
            <label>Password</label>
            <div class="input-wrapper">
                <i class="fa-solid fa-lock"></i>
                <input type="password" name="password" class="form-control" placeholder="Masukkan password" required>
            </div>
            <a href="{{ route('password.request') }}" class="forgot-password">Lupa Password?</a>
        </div>

        <button type="submit" class="btn-login" id="btnSubmit">
            <div class="spinner" id="btnSpinner"></div>
            <span id="btnText">Masuk Sekarang</span>
        </button>
    </form>

    <div class="login-footer">
        Belum punya akun? <a href="{{ route('register') }}">Daftar Gratis</a>
    </div>
</div>

<script>
    
    window.addEventListener('load', function() {
        const bar = document.getElementById('loadingBar');
        bar.style.width = '100%';
        
        setTimeout(() => {
            document.body.style.opacity = '1';
            bar.style.opacity = '0';
        }, 500);
    });

    const loginForm = document.getElementById('loginForm');
    const btnSubmit = document.getElementById('btnSubmit');
    const btnSpinner = document.getElementById('btnSpinner');
    const btnText = document.getElementById('btnText');

    loginForm.addEventListener('submit', function() {
        btnSubmit.disabled = true;
        btnSpinner.style.display = 'inline-block';
        btnText.innerText = 'Memproses...';
        const bar = document.getElementById('loadingBar');
        bar.style.opacity = '1';
        bar.style.width = '50%'; 
    });
</script>

</body>
</html>