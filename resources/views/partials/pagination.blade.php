@if ($paginator->hasPages())
    <nav class="flex flex-col items-center justify-between gap-3 border-t border-slate-200 px-5 py-3.5 text-sm sm:flex-row">
        <p class="text-slate-500">
            Mostrando
            <span class="font-medium text-slate-700">{{ $paginator->firstItem() }}</span>–<span class="font-medium text-slate-700">{{ $paginator->lastItem() }}</span>
            de <span class="font-medium text-slate-700">{{ $paginator->total() }}</span>
        </p>

        <div class="flex items-center gap-1">
            {{-- Anterior --}}
            @if ($paginator->onFirstPage())
                <span class="inline-flex h-8 items-center gap-1 rounded-lg px-2.5 font-medium text-slate-300">
                    <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M15.75 19.5L8.25 12l7.5-7.5"/></svg>
                    Anterior
                </span>
            @else
                <a href="{{ $paginator->previousPageUrl() }}" rel="prev"
                   class="inline-flex h-8 items-center gap-1 rounded-lg px-2.5 font-medium text-slate-600 transition hover:bg-slate-100">
                    <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M15.75 19.5L8.25 12l7.5-7.5"/></svg>
                    Anterior
                </a>
            @endif

            {{-- Números de página --}}
            @foreach ($paginator->getUrlRange(1, $paginator->lastPage()) as $page => $url)
                @if ($page == $paginator->currentPage())
                    <span aria-current="page"
                          class="grid h-8 w-8 place-items-center rounded-lg bg-indigo-600 text-xs font-semibold text-white shadow-sm">{{ $page }}</span>
                @else
                    <a href="{{ $url }}"
                       class="grid h-8 w-8 place-items-center rounded-lg text-xs font-medium text-slate-600 transition hover:bg-slate-100">{{ $page }}</a>
                @endif
            @endforeach

            {{-- Siguiente --}}
            @if ($paginator->hasMorePages())
                <a href="{{ $paginator->nextPageUrl() }}" rel="next"
                   class="inline-flex h-8 items-center gap-1 rounded-lg px-2.5 font-medium text-slate-600 transition hover:bg-slate-100">
                    Siguiente
                    <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M8.25 4.5l7.5 7.5-7.5 7.5"/></svg>
                </a>
            @else
                <span class="inline-flex h-8 items-center gap-1 rounded-lg px-2.5 font-medium text-slate-300">
                    Siguiente
                    <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M8.25 4.5l7.5 7.5-7.5 7.5"/></svg>
                </span>
            @endif
        </div>
    </nav>
@endif
