@extends('layouts.app')

@section('title', 'Mis sitios favoritos')

@php
    // Paleta de colores para las insignias de categoría (elegida de forma estable por id).
    $palette = [
        'bg-indigo-50 text-indigo-700 ring-indigo-200',
        'bg-rose-50 text-rose-700 ring-rose-200',
        'bg-amber-50 text-amber-700 ring-amber-200',
        'bg-emerald-50 text-emerald-700 ring-emerald-200',
        'bg-sky-50 text-sky-700 ring-sky-200',
        'bg-violet-50 text-violet-700 ring-violet-200',
        'bg-teal-50 text-teal-700 ring-teal-200',
        'bg-fuchsia-50 text-fuchsia-700 ring-fuchsia-200',
    ];
    $badge = fn ($id) => $palette[$id % count($palette)];
@endphp

@section('content')
    <div class="mb-8 flex flex-col gap-4 sm:flex-row sm:items-end sm:justify-between">
        <div>
            <h1 class="text-2xl font-bold tracking-tight text-slate-900 sm:text-3xl">Mis sitios favoritos</h1>
            <p class="mt-1 text-sm text-slate-500">
                {{ $sites->count() }} {{ Str::plural('sitio', $sites->count()) }} ·
                {{ $categories->count() }} {{ Str::plural('categoría', $categories->count()) }}
            </p>
        </div>

        @if ($sites->isNotEmpty())
            <div class="relative w-full sm:w-72">
                <svg class="pointer-events-none absolute left-3 top-1/2 h-4 w-4 -translate-y-1/2 text-slate-400" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-5.2-5.2m2.2-5.3a7.5 7.5 0 11-15 0 7.5 7.5 0 0115 0z"/></svg>
                <input id="site-search" type="search" placeholder="Buscar sitio o categoría…" autocomplete="off"
                    class="w-full rounded-xl border border-slate-200 bg-white py-2.5 pl-9 pr-3 text-sm shadow-sm outline-none transition placeholder:text-slate-400 focus:border-indigo-400 focus:ring-4 focus:ring-indigo-100">
            </div>
        @endif
    </div>

    {{-- Aviso si no hay categorías: no se puede agregar un sitio sin categoría --}}
    @if ($categories->isEmpty())
        <div class="mb-6 flex flex-col items-start gap-3 rounded-2xl border border-amber-200 bg-amber-50 p-5 text-sm text-amber-800 sm:flex-row sm:items-center sm:justify-between">
            <span>Aún no hay categorías. Debes crear al menos una antes de agregar un sitio.</span>
            <a href="{{ route('categories.index') }}" class="inline-flex items-center gap-1.5 rounded-lg bg-amber-600 px-3.5 py-2 font-medium text-white transition hover:bg-amber-700">
                Ir a categorías
            </a>
        </div>
    @else
        {{-- Formulario para agregar un nuevo sitio --}}
        <form action="{{ route('sites.store') }}" method="POST" novalidate
              class="mb-8 rounded-2xl border border-slate-200 bg-white p-5 shadow-sm">
            @csrf
            <h2 class="mb-4 flex items-center gap-2 text-sm font-semibold text-slate-700">
                <svg class="h-4 w-4 text-indigo-500" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15"/></svg>
                Agregar sitio
            </h2>

            <div class="grid grid-cols-1 gap-4 sm:grid-cols-12">
                <div class="sm:col-span-3">
                    <label for="name" class="mb-1 block text-xs font-medium text-slate-500">Nombre</label>
                    <input id="name" name="name" type="text" value="{{ old('name') }}" required
                        placeholder="Ej. Zara"
                        class="w-full rounded-xl border bg-white px-3 py-2.5 text-sm shadow-sm outline-none transition focus:ring-4 @error('name') border-red-400 focus:border-red-400 focus:ring-red-100 @else border-slate-200 focus:border-indigo-400 focus:ring-indigo-100 @enderror">
                    @error('name') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
                </div>

                <div class="sm:col-span-5">
                    <label for="url" class="mb-1 block text-xs font-medium text-slate-500">Dirección</label>
                    <input id="url" name="url" type="text" value="{{ old('url') }}" required
                        placeholder="https://www.zara.com"
                        class="w-full rounded-xl border bg-white px-3 py-2.5 text-sm shadow-sm outline-none transition focus:ring-4 @error('url') border-red-400 focus:border-red-400 focus:ring-red-100 @else border-slate-200 focus:border-indigo-400 focus:ring-indigo-100 @enderror">
                    @error('url') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
                </div>

                <div class="sm:col-span-2">
                    <label for="category_id" class="mb-1 block text-xs font-medium text-slate-500">Categoría</label>
                    <select id="category_id" name="category_id" required
                        class="w-full rounded-xl border bg-white px-3 py-2.5 text-sm shadow-sm outline-none transition focus:ring-4 @error('category_id') border-red-400 focus:border-red-400 focus:ring-red-100 @else border-slate-200 focus:border-indigo-400 focus:ring-indigo-100 @enderror">
                        <option value="" disabled {{ old('category_id') ? '' : 'selected' }}>Seleccione…</option>
                        @foreach ($categories as $category)
                            <option value="{{ $category->id }}" @selected(old('category_id') == $category->id)>{{ $category->name }}</option>
                        @endforeach
                    </select>
                    @error('category_id') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
                </div>

                <div class="flex items-end sm:col-span-2">
                    <button type="submit"
                        class="w-full rounded-xl bg-indigo-600 px-4 py-2.5 text-sm font-semibold text-white shadow-sm shadow-indigo-500/30 transition hover:bg-indigo-700 focus:ring-4 focus:ring-indigo-200">
                        Agregar
                    </button>
                </div>
            </div>
        </form>
    @endif

    {{-- Lista de sitios --}}
    @if ($sites->isEmpty())
        <div class="rounded-2xl border border-dashed border-slate-300 bg-white/60 px-6 py-16 text-center">
            <div class="mx-auto mb-4 grid h-12 w-12 place-items-center rounded-full bg-slate-100 text-slate-400">
                <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke-width="1.6" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M12 21a9 9 0 100-18 9 9 0 000 18zm0 0c2.5-2.5 3.75-5.5 3.75-9S14.5 5.5 12 3m0 18c-2.5-2.5-3.75-5.5-3.75-9S9.5 5.5 12 3m-8.25 9h16.5"/></svg>
            </div>
            <h3 class="text-sm font-semibold text-slate-700">Todavía no hay sitios</h3>
            <p class="mt-1 text-sm text-slate-400">Agrega tu primer sitio usando el formulario de arriba.</p>
        </div>
    @else
        <div class="overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm">
            <table class="w-full text-sm" id="sites-table">
                <thead>
                    <tr class="border-b border-slate-200 bg-slate-50 text-left text-xs font-semibold uppercase tracking-wide text-slate-500">
                        <th class="px-5 py-3">Nombre</th>
                        <th class="px-5 py-3">Dirección</th>
                        <th class="px-5 py-3">Categoría</th>
                        <th class="px-5 py-3 text-right">Acción</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @foreach ($sites as $site)
                        <tr class="group transition hover:bg-slate-50/70"
                            data-search="{{ Str::lower($site->name.' '.$site->url.' '.$site->category->name) }}">
                            <td class="px-5 py-3.5">
                                <div class="flex items-center gap-3">
                                    <img src="https://www.google.com/s2/favicons?domain={{ urlencode($site->host) }}&sz=64"
                                         alt="" width="20" height="20" loading="lazy"
                                         class="h-5 w-5 flex-none rounded"
                                         onerror="this.style.visibility='hidden'">
                                    <span class="font-medium text-slate-800">{{ $site->name }}</span>
                                </div>
                            </td>
                            <td class="px-5 py-3.5">
                                <a href="{{ $site->url }}" target="_blank" rel="noopener noreferrer"
                                   class="inline-flex max-w-xs items-center gap-1 truncate font-medium text-indigo-600 hover:text-indigo-800 hover:underline">
                                    <span class="truncate">{{ $site->host }}</span>
                                    <svg class="h-3.5 w-3.5 flex-none opacity-60" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M13.5 6H5.25A2.25 2.25 0 003 8.25v10.5A2.25 2.25 0 005.25 21h10.5A2.25 2.25 0 0018 18.75V10.5m-10.5 6L21 3m0 0h-5.25M21 3v5.25"/></svg>
                                </a>
                            </td>
                            <td class="px-5 py-3.5">
                                <span class="inline-flex items-center rounded-full px-2.5 py-0.5 text-xs font-medium ring-1 ring-inset {{ $badge($site->category_id) }}">
                                    {{ $site->category->name }}
                                </span>
                            </td>
                            <td class="px-5 py-3.5 text-right">
                                <form action="{{ route('sites.destroy', $site) }}" method="POST" class="inline"
                                      data-confirm="¿Eliminar «{{ $site->name }}» de tus sitios?">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit"
                                        class="inline-flex items-center gap-1 rounded-lg px-2.5 py-1.5 text-xs font-medium text-slate-400 transition hover:bg-red-50 hover:text-red-600">
                                        <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M14.74 9l-.35 9m-4.78 0L9.26 9M9.97 4.24h4.06m-9.9 1.51h15.68m-1.58 0l-.7 12.63A2.25 2.25 0 0115.36 21H8.64a2.25 2.25 0 01-2.24-2.11L5.7 5.75"/></svg>
                                        Borrar
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            {{-- Fila mostrada cuando el buscador no encuentra coincidencias --}}
            <div id="sites-empty-search" class="hidden px-5 py-10 text-center text-sm text-slate-400">
                No hay sitios que coincidan con la búsqueda.
            </div>
        </div>
    @endif
@endsection
