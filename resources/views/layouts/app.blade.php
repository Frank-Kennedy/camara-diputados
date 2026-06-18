<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Cámara de Diputados')</title>
    
    <!-- Tailwind CSS desde CDN (temporal) -->
    <script src="https://cdn.tailwindcss.com"></script>
    
    <!-- Estilos personalizados -->
    <style>
        .btn-primary {
            background-color: #1a3a5c;
            color: white;
            padding: 0.5rem 1.5rem;
            border-radius: 0.5rem;
            transition: all 0.3s;
            display: inline-block;
        }
        .btn-primary:hover {
            background-color: #2a5a8c;
        }
        .btn-secondary {
            background-color: #c9a84c;
            color: white;
            padding: 0.5rem 1.5rem;
            border-radius: 0.5rem;
            transition: all 0.3s;
            display: inline-block;
        }
        .btn-secondary:hover {
            background-color: #dbb95c;
        }
        .card {
            background-color: white;
            border-radius: 0.75rem;
            box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1);
            padding: 1.5rem;
            transition: all 0.3s;
        }
        .card:hover {
            box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1);
        }
        .bg-parlamento-azul { background-color: #1a3a5c; }
        .bg-parlamento-azul-claro { background-color: #2a5a8c; }
        .bg-parlamento-oro { background-color: #c9a84c; }
        .text-parlamento-azul { color: #1a3a5c; }
        .text-parlamento-oro { color: #c9a84c; }
        .hover\\:text-parlamento-oro:hover { color: #c9a84c; }
    </style>
    
    @stack('styles')
</head>
<body class="bg-gray-100 font-sans antialiased">
    @include('partials.header')
    
    <main class="min-h-screen">
        @yield('content')
    </main>
    
    @include('partials.footer')
    
    @stack('scripts')
</body>
</html>