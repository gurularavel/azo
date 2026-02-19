<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>@yield('title', 'Auth - QR Endirim')</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        primary: { DEFAULT: '#ff5f00', hover: '#e65600' },
                        secondary: { DEFAULT: '#0a2a66' },
                    },
                    fontFamily: { sans: ['Inter', 'sans-serif'] },
                },
            },
        };
    </script>
    @stack('styles')
</head>
<body class="bg-slate-50 min-h-screen flex flex-col antialiased font-sans">
<main class="flex-1 flex items-center justify-center p-4">
    <div class="w-full @yield('container_class', 'max-w-md')">
        @if(session('status'))
            <div class="mb-6 p-4 rounded-sm bg-green-50 text-green-800 border border-green-200">{{ session('status') }}</div>
        @endif
        @if(session('error'))
            <div class="mb-6 p-4 rounded-sm bg-red-50 text-red-800 border border-red-200">{{ session('error') }}</div>
        @endif
        @if($errors->any())
            <div class="mb-6 p-4 rounded-sm bg-red-50 text-red-800 border border-red-200">
                <ul class="list-disc pl-5 space-y-1">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        @yield('content')
    </div>
</main>
<footer class="py-10 text-center text-slate-400 text-sm">
    <p>&copy; {{ now()->year }} QR Endirim</p>
</footer>
@stack('scripts')
</body>
</html>
