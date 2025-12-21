<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title') - LAUNDRY</title>

    @vite('resources/css/app.css')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    
   
</head>
<body>

    @include('partials.sidebar')

    <div class="main-content" style="margin-left: 260px; min-height: 100vh; display: flex; flex-direction: column; background: #f8fafc;">
    
    <div style="flex: 1; padding: 30px;">
        @yield('content')
    </div>

    <div style="padding: 0 30px;">
        @include('partials.footer')
    </div>

</div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const btn = document.querySelector('.account-btn');
            const menu = document.querySelector('.account-menu');

            if (btn && menu) {
                btn.addEventListener('click', function (e) {
                    e.stopPropagation();
                    menu.classList.toggle('show');
                });
            }

           
            document.addEventListener('click', function() {
                if(menu) menu.classList.remove('show');
            });
        });
    </script>
</body>
</html>