<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>QR Nəticə{{ $shop ? ' - ' . $shop->name : '' }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700;800;900&display=swap" rel="stylesheet">
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        primary: { DEFAULT: '#ff5f00', hover: '#e65600' },
                        secondary: { DEFAULT: '#0a2a66', dark: '#071d47' },
                    },
                    fontFamily: { sans: ['Inter', 'sans-serif'] },
                }
            }
        }
    </script>
</head>
<body class="antialiased font-sans min-h-screen flex flex-col items-center justify-center p-6 {{ $success ? 'bg-green-50' : 'bg-red-50' }}">

    <div class="w-full max-w-sm text-center">

        @if($success)
        {{-- SUCCESS --}}
        <div class="bg-white rounded-3xl shadow-2xl p-10">
            <div class="w-24 h-24 rounded-full bg-green-100 flex items-center justify-center mx-auto mb-6">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor" class="w-12 h-12 text-green-500">
                    <path stroke-linecap="round" stroke-linejoin="round" d="m4.5 12.75 6 6 9-13.5" />
                </svg>
            </div>

            <h1 class="text-3xl font-black text-secondary mb-2">Uğurlu!</h1>
            <p class="text-slate-500 mb-8">Endirim tətbiq edildi</p>

            @if($shop)
            <div class="bg-secondary rounded-2xl p-6 text-white mb-6">
                <p class="text-white/60 text-sm font-bold uppercase tracking-widest mb-1">Mağaza</p>
                <p class="text-xl font-bold mb-4">{{ $shop->name }}</p>
                <div class="text-6xl font-black text-primary mb-2">{{ $shop->discount_percent }}%</div>
                <p class="text-white/70 text-sm">Endirim tətbiq edildi</p>
            </div>
            @endif

            @if($remaining !== null)
            <div class="bg-slate-50 rounded-xl p-4 text-slate-600 text-sm font-medium">
                İstifadəçinin qalan balansı: <span class="font-black text-secondary text-base">{{ $remaining }}</span>
            </div>
            @endif
        </div>

        @else
        {{-- FAILURE --}}
        <div class="bg-white rounded-3xl shadow-2xl p-10">
            <div class="w-24 h-24 rounded-full bg-red-100 flex items-center justify-center mx-auto mb-6">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor" class="w-12 h-12 text-red-500">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </div>

            <h1 class="text-3xl font-black text-secondary mb-2">Uğursuz</h1>
            <p class="text-slate-500 mb-8">{{ $message }}</p>

            <div class="bg-red-50 border border-red-100 rounded-xl p-4 text-red-700 text-sm font-medium">
                {{ $message }}
            </div>
        </div>
        @endif

    </div>

</body>
</html>
