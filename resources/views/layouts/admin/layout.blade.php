<html>

<head>

    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="shortcut icon" href="{{ url(\Config::get('settings.favicon')) }}">
    <title> ChurchCMS :: Admin Panel</title>
    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link href="{{ asset('css/theme-toggle.css') }}" rel="stylesheet">
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Titillium+Web&display=swap" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="{{ asset('css/trix.css') }}">
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
    @stack('styles')
</head>

<body>

    <div id="app">
        <div class="border-b">
            @include('layouts.partials.navigation')
        </div>

        <div class="flex flex-col lg:flex-row md:flex-row min-h-full relative">
            @include('layouts.admin.sidebar')
            <div class="w-full  bg-gray-300 px-5 py-3">
                <main class="admin-main">
                    @yield('content')

                </main>
            </div>
        </div>
    </div>

    <script src="{{ mix('js/app.js') }}"></script>
    <script src="{{ asset('js/custom.js') }}"></script>
    <script src="{{ asset('js/trix.js') }}"></script>
    <script src="{{ asset('js/attachments.js') }}"></script>
    <script src="https://canvasjs.com/assets/script/canvasjs.min.js"></script>


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
                        window.dispatchEvent(new CustomEvent('churchcms-theme-changed', { detail: { theme: isDark ? 'dark' : 'light' } }));
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



</body>
 <style>
      body {
        font-family: Arial, sans-serif;

        height: 100vh;
        gap: 40px;
      }

      .card {
        width: 400px;
        height: 260px;
        border-radius: 15px;
        /* background: url("back.png") no-repeat center/cover; */
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2);
        overflow: hidden;
/*        padding: 6px 10px 30px 10px;*/
       padding: 15px 10px 2px 16px;
        color: #000;
          margin-left: auto;
         margin-right: auto;
      }

      .company-name {
        font-size: 20px;
        font-weight: bold;
      }

      .slogan {
        font-size: 12px;
        color: #555;
      }

      .website {
        text-align: center;
        font-size: 13px;
        color: #2196f3;
      }
    </style>

</html>
