<!DOCTYPE html>
<html lang="es" class="h-full">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Mis sitios favoritos') · Audisoft</title>

    {{-- Favicon SVG en línea (marcador de sitios) --}}
    <link rel="icon" href="data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 24 24' fill='%234f46e5'%3E%3Cpath d='M12 2C8.13 2 5 5.13 5 9c0 5.25 7 13 7 13s7-7.75 7-13c0-3.87-3.13-7-7-7zm0 9.5A2.5 2.5 0 1112 6.5a2.5 2.5 0 010 5z'/%3E%3C/svg%3E">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="h-full bg-slate-50 text-slate-800 antialiased">
    <div class="min-h-full flex flex-col">
        {{-- Barra superior --}}
        <header class="sticky top-0 z-20 border-b border-slate-200 bg-white/80 backdrop-blur">
            <div class="mx-auto flex max-w-5xl items-center justify-between px-4 py-3 sm:px-6">
                <a href="{{ route('sites.index') }}" class="flex items-center gap-2.5 font-semibold text-slate-900">
                    <span class="grid h-9 w-9 place-items-center rounded-xl bg-gradient-to-br from-indigo-500 to-violet-600 text-white shadow-sm shadow-indigo-500/30">
                        <svg class="h-5 w-5" viewBox="0 0 24 24" fill="currentColor"><path d="M12 2C8.13 2 5 5.13 5 9c0 5.25 7 13 7 13s7-7.75 7-13c0-3.87-3.13-7-7-7zm0 9.5A2.5 2.5 0 1112 6.5a2.5 2.5 0 010 5z"/></svg>
                    </span>
                    <span class="text-base tracking-tight">Audisoft <span class="text-slate-400 font-normal">/ Sitios</span></span>
                </a>

                <nav class="flex items-center gap-1 text-sm font-medium">
                    @php $current = request()->routeIs('sites.*') ? 'sites' : 'categories'; @endphp
                    <a href="{{ route('sites.index') }}"
                       class="rounded-lg px-3 py-1.5 transition {{ $current === 'sites' ? 'bg-indigo-50 text-indigo-700' : 'text-slate-500 hover:bg-slate-100 hover:text-slate-800' }}">
                        Sitios
                    </a>
                    <a href="{{ route('categories.index') }}"
                       class="rounded-lg px-3 py-1.5 transition {{ $current === 'categories' ? 'bg-indigo-50 text-indigo-700' : 'text-slate-500 hover:bg-slate-100 hover:text-slate-800' }}">
                        Categorías
                    </a>
                </nav>
            </div>
        </header>

        {{-- Contenido --}}
        <main class="mx-auto w-full max-w-5xl flex-1 px-4 py-8 sm:px-6 sm:py-10">
            @include('partials.flash')
            @yield('content')
        </main>

        <footer class="border-t border-slate-200 py-6 text-center text-xs text-slate-400">
            Prueba técnica · Laravel {{ Illuminate\Foundation\Application::VERSION }} + MySQL · Audisoft
        </footer>
    </div>

    {{-- Modal de confirmación reutilizable (controlado por app.js) --}}
    <div id="confirm-modal" class="fixed inset-0 z-50 hidden items-center justify-center p-4" role="dialog" aria-modal="true">
        <div class="absolute inset-0 bg-slate-900/50 backdrop-blur-sm" data-confirm-cancel></div>
        <div class="relative w-full max-w-sm scale-95 rounded-2xl bg-white p-6 shadow-2xl transition-transform duration-150" data-confirm-panel>
            <div class="mx-auto mb-4 grid h-12 w-12 place-items-center rounded-full bg-red-100 text-red-600">
                <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M9.75 9.75l4.5 4.5m0-4.5l-4.5 4.5M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            </div>
            <h3 class="text-center text-base font-semibold text-slate-900" data-confirm-title>¿Confirmar acción?</h3>
            <p class="mt-1.5 text-center text-sm text-slate-500" data-confirm-message>Esta acción no se puede deshacer.</p>
            <div class="mt-6 flex gap-3">
                <button type="button" data-confirm-cancel
                    class="flex-1 rounded-xl border border-slate-200 bg-white px-4 py-2.5 text-sm font-medium text-slate-700 transition hover:bg-slate-50">
                    Cancelar
                </button>
                <button type="button" data-confirm-accept
                    class="flex-1 rounded-xl bg-red-600 px-4 py-2.5 text-sm font-semibold text-white shadow-sm transition hover:bg-red-700">
                    Eliminar
                </button>
            </div>
        </div>
    </div>
</body>
</html>
