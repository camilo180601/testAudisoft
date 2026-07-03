@extends('layouts.app')

@section('title', 'Mis categorías')

@section('content')
    <div class="mb-8 flex flex-col gap-2 sm:flex-row sm:items-end sm:justify-between">
        <div>
            <a href="{{ route('sites.index') }}" class="mb-2 inline-flex items-center gap-1 text-sm font-medium text-slate-500 transition hover:text-indigo-600">
                <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M15.75 19.5L8.25 12l7.5-7.5"/></svg>
                Regresar
            </a>
            <h1 class="text-2xl font-bold tracking-tight text-slate-900 sm:text-3xl">Mis categorías</h1>
            <p class="mt-1 text-sm text-slate-500">
                {{ $categories->total() }} {{ $categories->total() === 1 ? 'categoría' : 'categorías' }}
            </p>
        </div>
    </div>

    {{-- Formulario para agregar una categoría --}}
    <form action="{{ route('categories.store') }}" method="POST" novalidate
          class="mb-8 rounded-2xl border border-slate-200 bg-white p-5 shadow-sm">
        @csrf
        <h2 class="mb-4 flex items-center gap-2 text-sm font-semibold text-slate-700">
            <svg class="h-4 w-4 text-indigo-500" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15"/></svg>
            Agregar categoría
        </h2>
        <div class="flex flex-col gap-3 sm:flex-row sm:items-start">
            <div class="flex-1">
                <input id="name" name="name" type="text" value="{{ old('name') }}" required
                    placeholder="Ej. Electrónicos"
                    class="w-full rounded-xl border bg-white px-3 py-2.5 text-sm shadow-sm outline-none transition focus:ring-4 @error('name') border-red-400 focus:border-red-400 focus:ring-red-100 @else border-slate-200 focus:border-indigo-400 focus:ring-indigo-100 @enderror">
                @error('name') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
            </div>
            <button type="submit"
                class="rounded-xl bg-indigo-600 px-5 py-2.5 text-sm font-semibold text-white shadow-sm shadow-indigo-500/30 transition hover:bg-indigo-700 focus:ring-4 focus:ring-indigo-200">
                Agregar
            </button>
        </div>
    </form>

    {{-- Lista de categorías --}}
    @if ($categories->total() === 0)
        <div class="rounded-2xl border border-dashed border-slate-300 bg-white/60 px-6 py-16 text-center">
            <div class="mx-auto mb-4 grid h-12 w-12 place-items-center rounded-full bg-slate-100 text-slate-400">
                <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke-width="1.6" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M6 6.878V6a2.25 2.25 0 012.25-2.25h7.5A2.25 2.25 0 0118 6v.878m-12 0c.235-.083.487-.128.75-.128h10.5c.263 0 .515.045.75.128m-12 0A2.25 2.25 0 004.5 9v.878m13.5-3A2.25 2.25 0 0119.5 9v.878m0 0a2.246 2.246 0 00-.75-.128H5.25c-.263 0-.515.045-.75.128m15 0A2.25 2.25 0 0121 12v6a2.25 2.25 0 01-2.25 2.25H5.25A2.25 2.25 0 013 18v-6c0-.98.626-1.813 1.5-2.122"/></svg>
            </div>
            <h3 class="text-sm font-semibold text-slate-700">Todavía no hay categorías</h3>
            <p class="mt-1 text-sm text-slate-400">Agrega tu primera categoría usando el formulario de arriba.</p>
        </div>
    @else
        <div class="overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm">
            <table class="w-full text-sm">
                <thead>
                    <tr class="border-b border-slate-200 bg-slate-50 text-left text-xs font-semibold uppercase tracking-wide text-slate-500">
                        <th class="px-5 py-3">Nombre</th>
                        <th class="px-5 py-3">Sitios</th>
                        <th class="px-5 py-3 text-right">Acción</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @foreach ($categories as $category)
                        <tr class="transition hover:bg-slate-50/70">
                            <td class="px-5 py-3.5 font-medium text-slate-800">{{ $category->name }}</td>
                            <td class="px-5 py-3.5">
                                @if ($category->sites_count > 0)
                                    <span class="inline-flex items-center rounded-full bg-slate-100 px-2.5 py-0.5 text-xs font-medium text-slate-600">
                                        {{ $category->sites_count }} en uso
                                    </span>
                                @else
                                    <span class="text-xs text-slate-400">Sin uso</span>
                                @endif
                            </td>
                            <td class="px-5 py-3.5 text-right">
                                @if ($category->sites_count > 0)
                                    {{-- No se puede borrar una categoría en uso --}}
                                    <span class="inline-flex cursor-not-allowed items-center gap-1 rounded-lg px-2.5 py-1.5 text-xs font-medium text-slate-300"
                                          title="No se puede eliminar: está asignada a {{ $category->sites_count }} {{ $category->sites_count === 1 ? 'sitio' : 'sitios' }}.">
                                        <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M16.5 10.5V6.75a4.5 4.5 0 10-9 0v3.75m-.75 11.25h10.5a2.25 2.25 0 002.25-2.25v-6.75a2.25 2.25 0 00-2.25-2.25H6.75a2.25 2.25 0 00-2.25 2.25v6.75a2.25 2.25 0 002.25 2.25z"/></svg>
                                        Borrar
                                    </span>
                                @else
                                    <form action="{{ route('categories.destroy', $category) }}" method="POST" class="inline"
                                          data-confirm="¿Eliminar la categoría «{{ $category->name }}»?">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                            class="inline-flex items-center gap-1 rounded-lg px-2.5 py-1.5 text-xs font-medium text-slate-400 transition hover:bg-red-50 hover:text-red-600">
                                            <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M14.74 9l-.35 9m-4.78 0L9.26 9M9.97 4.24h4.06m-9.9 1.51h15.68m-1.58 0l-.7 12.63A2.25 2.25 0 0115.36 21H8.64a2.25 2.25 0 01-2.24-2.11L5.7 5.75"/></svg>
                                            Borrar
                                        </button>
                                    </form>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

            @include('partials.pagination', ['paginator' => $categories])
        </div>
    @endif
@endsection
