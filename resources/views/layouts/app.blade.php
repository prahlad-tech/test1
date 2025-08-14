<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'URL Shortener')</title>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/tailwindcss/2.2.19/tailwind.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/alpinejs/3.10.2/cdn.min.js" defer></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/qrcode/1.5.3/qrcode.min.js"></script>
    <style>
        .dark .dark\:bg-gray-900 { background-color: #111827; }
        .dark .dark\:text-white { color: #ffffff; }
        .gradient-bg { background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); }
        .glass { backdrop-filter: blur(10px); background: rgba(255, 255, 255, 0.1); }
        .animate-fade-in { animation: fadeIn 0.5s ease-in; }
        @keyframes fadeIn { from { opacity: 0; transform: translateY(20px); } to { opacity: 1; transform: translateY(0); } }
        .hover-scale { transition: transform 0.2s; }
        .hover-scale:hover { transform: scale(1.05); }
    </style>
</head>
<body class="min-h-screen transition-colors duration-300" x-data="{ darkMode: localStorage.getItem('darkMode') === 'true' }" 
      :class="{ 'dark bg-gray-900': darkMode, 'bg-gray-50': !darkMode }">
    
    <!-- Navigation -->
    <nav class="glass border-b" :class="{ 'border-gray-700': darkMode, 'border-gray-200': !darkMode }">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-16">
                <div class="flex items-center">
                    <a href="{{ route('home') }}" class="text-xl font-bold gradient-text">
                        <i class="fas fa-link mr-2"></i>QuickLink
                    </a>
                </div>
                
                <div class="flex items-center space-x-4">
                    <a href="{{ route('home') }}" class="hover:text-blue-500 transition-colors" 
                       :class="{ 'text-white': darkMode, 'text-gray-700': !darkMode }">
                        <i class="fas fa-home mr-1"></i>Home
                    </a>
                    <a href="{{ route('analytics') }}" class="hover:text-blue-500 transition-colors" 
                       :class="{ 'text-white': darkMode, 'text-gray-700': !darkMode }">
                        <i class="fas fa-chart-bar mr-1"></i>Analytics
                    </a>
                    
                    <!-- Dark mode toggle -->
                    <button @click="darkMode = !darkMode; localStorage.setItem('darkMode', darkMode)" 
                            class="p-2 rounded-lg hover:bg-gray-200 dark:hover:bg-gray-700 transition-colors">
                        <i class="fas fa-moon" x-show="!darkMode"></i>
                        <i class="fas fa-sun text-yellow-400" x-show="darkMode"></i>
                    </button>
                </div>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <main class="flex-1">
        @yield('content')
    </main>

    <!-- Footer -->
    <footer class="glass border-t mt-12" :class="{ 'border-gray-700': darkMode, 'border-gray-200': !darkMode }">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
            <div class="text-center" :class="{ 'text-gray-400': darkMode, 'text-gray-600': !darkMode }">
                <p>&copy; 2024 QuickLink. Built with Laravel & TailwindCSS.</p>
            </div>
        </div>
    </footer>

    <script>
        // Set up CSRF token for all AJAX requests
        window.axios = axios;
        window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';
        const token = document.head.querySelector('meta[name="csrf-token"]');
        if (token) {
            window.axios.defaults.headers.common['X-CSRF-TOKEN'] = token.content;
        }
    </script>
</body>
</html>