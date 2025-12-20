<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Atur Ulang Password - LAUNDRY</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; font-family: 'Segoe UI', sans-serif; }
        body { background-color: #f3f4f6; display: flex; align-items: center; justify-content: center; height: 100vh; }
        
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
        }

        .btn-auth:hover { background: #ea580c; }
    </style>
</head>
<body>

<div class="auth-card">
    <div class="auth-header">
        <i class="fa-solid fa-user-shield"></i>
        <h2>Reset Password</h2>
        <p>Silakan masukkan password baru Anda.</p>
    </div>

    <form action="{{ route('login') }}" method="GET">
        <div class="form-group">
            <label>Password Baru</label>
            <div class="input-wrapper">
                <i class="fa-solid fa-lock"></i>
                <input type="password" class="form-control" placeholder="Minimal 8 karakter" required>
            </div>
        </div>

        <div class="form-group">
            <label>Konfirmasi Password Baru</label>
            <div class="input-wrapper">
                <i class="fa-solid fa-circle-check"></i>
                <input type="password" class="form-control" placeholder="Ulangi password baru" required>
            </div>
        </div>

        <button type="submit" class="btn-auth">Simpan Password Baru</button>
    </form>
</div>

</body>
</html>