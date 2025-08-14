<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>URL Shortener</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        .gradient-bg { 
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); 
        }
    </style>
</head>
<body class="gradient-bg min-h-screen">
    <div class="container mx-auto px-4 py-12">
        
        <!-- Header -->
        <div class="text-center mb-12">
            <h1 class="text-5xl font-bold text-white mb-4">URL Shortener</h1>
            <p class="text-xl text-gray-200">Make long URLs short and easy to share</p>
        </div>

        <!-- URL Form -->
        <div class="max-w-2xl mx-auto bg-white bg-opacity-20 rounded-lg p-8 mb-8">
            <form id="urlForm" class="space-y-6">
                <div>
                    <input type="url" 
                           id="urlInput" 
                           placeholder="Enter your long URL here..."
                           class="w-full px-4 py-3 rounded-lg border focus:ring-2 focus:ring-blue-400 text-lg"
                           required>
                </div>
                
                <button type="submit" 
                        class="w-full bg-blue-600 hover:bg-blue-700 text-white font-bold py-3 px-6 rounded-lg text-lg transition-colors">
                    Shorten URL
                </button>
            </form>
        </div>

        <!-- Result -->
        <div id="result" class="max-w-2xl mx-auto bg-white bg-opacity-20 rounded-lg p-8 hidden">
            <h3 class="text-2xl font-bold text-white mb-4 text-center">Your Shortened URL:</h3>
            
            <div class="flex items-center space-x-4">
                <input type="text" 
                       id="shortenedUrl" 
                       readonly 
                       class="flex-1 px-4 py-3 bg-white rounded-lg text-lg font-mono">
                
                <button onclick="copyUrl()" 
                        class="bg-green-600 hover:bg-green-700 text-white px-6 py-3 rounded-lg font-bold transition-colors">
                    Copy
                </button>
            </div>
        </div>

    </div>

    <script>
        // Form submit handle करने के लिए
        document.getElementById('urlForm').addEventListener('submit', async function(e) {
            e.preventDefault();
            
            const url = document.getElementById('urlInput').value;
            
            try {
                const response = await fetch('/shorten', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                    },
                    body: JSON.stringify({ url: url })
                });
                
                const data = await response.json();
                
                if (data.success) {
                    // Result show करो
                    document.getElementById('shortenedUrl').value = data.shortened_url;
                    document.getElementById('result').classList.remove('hidden');
                }
                
            } catch (error) {
                alert('Something went wrong! Please try again.');
            }
        });

        // Copy functionality
        function copyUrl() {
            const urlInput = document.getElementById('shortenedUrl');
            urlInput.select();
            document.execCommand('copy');
            
            alert('URL copied to clipboard!');
        }
    </script>
</body>
</html>