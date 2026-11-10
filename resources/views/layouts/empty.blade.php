<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'Church Membership Pro') }}</title>
    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link href="{{ asset('css/theme-toggle.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <script>
        (function() {
            try {
                var savedTheme = localStorage.getItem('churchcms_theme');
                if (savedTheme === 'dark' || (!savedTheme && window.matchMedia && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
                    document.documentElement.classList.add('dark-theme');
                } else {
                    document.documentElement.classList.remove('dark-theme');
                }
            } catch (e) {}
        })();
    </script>
    <script src="https://www.google.com/recaptcha/api.js" async defer></script>
    <!-- g-captcha -->
</head>

<body>
    <div id="app">
        <main>
            <div class="login-page flex flex-col items-center justify-between">
                <div class="absolute top-4 right-6 z-50">
                    <div class="theme-switch-wrapper">
                        <button id="themeToggleBtn" type="button" aria-label="Toggle Theme" class="theme-toggle-btn" title="Toggle Dark/Light Mode">
                            <span class="icon-indicator"><i id="themeToggleIcon" class="fas fa-sun"></i></span>
                            <span id="themeToggleText" class="hidden sm:inline">Light</span>
                        </button>
                    </div>
                </div>
                <div class="flex-1 flex items-center w-full">
                    @yield('content')
                </div>
                <p class="text-xs text-white text-opacity-60 py-4">
                    Powered by <a href="https://churchcms.app" target="_blank" rel="noopener noreferrer"
                        class="underline text-white text-opacity-80 hover:text-opacity-100">ChurchCMS</a>
                </p>
            </div>
        </main>
    </div>
    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}"></script>
    <script src="{{ asset('js/custom.js') }}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-easing/1.3/jquery.easing.min.js"></script>



    <script>
        (function() {
            function updateToggleUI() {
                var isDark = document.documentElement.classList.contains('dark-theme');
                var toggleIcon = document.getElementById('themeToggleIcon');
                var toggleText = document.getElementById('themeToggleText');
                if (toggleIcon) {
                    toggleIcon.className = isDark ? 'fas fa-moon' : 'fas fa-sun';
                }
                if (toggleText) {
                    toggleText.textContent = isDark ? 'Dark' : 'Light';
                }
            }

            function setupThemeToggle() {
                var toggleBtn = document.getElementById('themeToggleBtn');
                updateToggleUI();
                if (toggleBtn && !toggleBtn.__themeListenerAttached) {
                    toggleBtn.__themeListenerAttached = true;
                    toggleBtn.addEventListener('click', function(e) {
                        e.preventDefault();
                        var isDark = document.documentElement.classList.toggle('dark-theme');
                        try {
                            localStorage.setItem('churchcms_theme', isDark ? 'dark' : 'light');
                        } catch (err) {}
                        updateToggleUI();
                    });
                }
            }

            if (document.readyState === 'loading') {
                document.addEventListener('DOMContentLoaded', setupThemeToggle);
            } else {
                setupThemeToggle();
            }
        })();
    </script>

    @stack('scripts')
    <style>
        .login-page {
            background: linear-gradient(160deg, #0f172a 0%, #1e3a5f 45%, #0e7490 100%);
            min-height: 100vh;
            padding: 40px 0;
            position: relative;
        }

        .alert-success {
            display: flex;
            justify-content: space-between;
            padding: 10px;
            background: #def0d8;
            color: #445441;
            border-radius: 5px;
            margin-bottom: 15px;
        }

        .alert-warning {
            display: flex;
            justify-content: space-between;
            padding: 10px;
            background: #f8e8c1;
            border-color: #f4d899;
            color: #856e34;
            border-radius: 5px;
            margin-bottom: 15px;
        }

        @media(max-width: 640px) {
            .login-page {
                padding: 15px;
            }
        }

    </style>
</body>

</html>
