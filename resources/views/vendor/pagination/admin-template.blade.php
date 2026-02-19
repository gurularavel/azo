@if ($paginator->hasPages())
    <nav class="flex justify-center gap-2 lg:justify-end pagination pagination-primary" role="navigation" aria-label="Pagination">
        @if ($paginator->onFirstPage())
            <span class="pagination-pre opacity-50 cursor-not-allowed">
                <i data-lucide="chevron-left" class="ltr:inline-block rtl:hidden size-4"></i>
            </span>
        @else
            <a class="pagination-pre" href="{{ $paginator->previousPageUrl() }}" rel="prev">
                <i data-lucide="chevron-left" class="ltr:inline-block rtl:hidden size-4"></i>
            </a>
        @endif

        @foreach ($elements as $element)
            @if (is_string($element))
                <span class="pagination-item opacity-50 cursor-not-allowed">{{ $element }}</span>
            @endif

            @if (is_array($element))
                @foreach ($element as $page => $url)
                    @if ($page == $paginator->currentPage())
                        <span class="pagination-item active">{{ $page }}</span>
                    @else
                        <a class="pagination-item" href="{{ $url }}">{{ $page }}</a>
                    @endif
                @endforeach
            @endif
        @endforeach

        @if ($paginator->hasMorePages())
            <a class="pagination-next" href="{{ $paginator->nextPageUrl() }}" rel="next">
                <i data-lucide="chevron-right" class="ltr:inline-block rtl:hidden size-4"></i>
            </a>
        @else
            <span class="pagination-next opacity-50 cursor-not-allowed">
                <i data-lucide="chevron-right" class="ltr:inline-block rtl:hidden size-4"></i>
            </span>
        @endif
    </nav>
@endif
