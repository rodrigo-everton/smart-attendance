<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Smart Attendance')</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap');
        body { font-family: "Inter", sans-serif; }
        
        .gradient-bg { 
            background: radial-gradient(circle at center, #a855f7 0%, #7e22ce 100%); 
        }
        
        /* Custom Scrollbar */
        ::-webkit-scrollbar {
            width: 8px;
        }
        ::-webkit-scrollbar-track {
            background: #f1f1f1; 
        }
        ::-webkit-scrollbar-thumb {
            background: #888; 
            border-radius: 4px;
        }
        ::-webkit-scrollbar-thumb:hover {
            background: #555; 
        }

        @stack('styles')
    </style>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        primary: '#a855f7', 
                        secondary: '#7e22ce',
                        accent: '#ffffff',
                        card_purple: '#820ad1', /* Kept darker/richer to stand out against lighter bg */
                        button_accent: '#ffffff', 
                        button_hover: '#f0f0f0',
                        light: '#ffffff',
                    },
                }
            }
        }
    </script>
</head>
<body class="@yield('body-class', 'bg-gray-100') text-gray-800 antialiased min-h-screen flex flex-col">

    <div class="flex-grow flex flex-col">
        @yield('content')
    </div>

    <footer class="@yield('footer-class', 'py-6 text-center text-sm text-gray-500')">
        &copy; 2025 Smart Attendance. Todos os direitos reservados.
    </footer>

    @stack('scripts')
</body>
</html>
