<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tailwind Test</title>
    @vite('resources/css/app.css')
</head>
<body class="bg-gray-100 flex items-center justify-center h-screen">
    <div class="bg-white p-6 rounded-2xl shadow-xl text-center">
        <h1 class="text-3xl font-bold text-blue-600 mb-4">
            🚀 Tailwind is Working!
        </h1>
        <p class="text-gray-700">
            If you see this styled message, Tailwind CSS is configured properly.
        </p>
        <button class="mt-4 px-4 py-2 bg-blue-500 text-white rounded-lg hover:bg-blue-700 transition">
            Test Button
        </button>
    </div>
</body>
</html>
