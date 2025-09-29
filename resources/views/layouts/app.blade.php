<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'PurelyHome') }}</title>

    {{-- ✅ Load global assets --}}
    @vite([
        'resources/css/app.css',
        'resources/js/app.js',
        'resources/js/bootstrap.js'
    ])
    @livewireStyles

    {{-- ✅ Store token into localStorage after login --}}
    <script>
        @if(session('auth_token'))
            localStorage.setItem('auth_token', "{{ session('auth_token') }}");
        @endif
    </script>
</head>
<body class="font-sans antialiased bg-gray-100">
    <div class="min-h-screen">
        {{ $slot }}
    </div>

    @stack('modals')
    @livewireScripts

    {{-- ✅ Load page-specific scripts only when needed --}}
    @if(request()->routeIs('admin.products.index'))
        @vite('resources/js/products.js')
    @endif
</body>
</html>
