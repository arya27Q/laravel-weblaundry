<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>@yield('title')</title>

    @vite('resources/css/app.css')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
   


</head>
<body>

    @include('partials.sidebar')

    <div class="main">
        @yield('content')
    </div>
<script>
        document.addEventListener('DOMContentLoaded', function () {
            const btn = document.querySelector('.account-btn');
            const menu = document.querySelector('.account-menu');

            if (btn && menu) {
                btn.addEventListener('click', function () {
                    menu.classList.toggle('show');
                });
            }
        });
    </script>
</body>
</html>
