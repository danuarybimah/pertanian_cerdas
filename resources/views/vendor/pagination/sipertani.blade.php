@if ($paginator->hasPages())
    <div class="pagination-wrapper">
        {{-- Showing Results Info (Left Side) --}}
        <div class="pagination-info">
            @if ($paginator->firstItem())
                Showing <span class="font-semibold">{{ $paginator->firstItem() }}</span> to <span class="font-semibold">{{ $paginator->lastItem() }}</span> of <span class="font-semibold">{{ $paginator->total() }}</span> results
            @else
                Showing <span class="font-semibold">{{ $paginator->count() }}</span> results
            @endif
        </div>

        {{-- Navigation Buttons & Page Links (Right Side) --}}
        <nav class="pagination-nav" role="navigation" aria-label="Pagination Navigation">
            {{-- Previous Page Link --}}
            @if ($paginator->onFirstPage())
                <span class="pagination-btn disabled" aria-disabled="true" aria-label="@lang('pagination.previous')">
                    &laquo; Prev
                </span>
            @else
                <a href="{{ $paginator->previousPageUrl() }}" class="pagination-btn" rel="prev" aria-label="@lang('pagination.previous')">
                    &laquo; Prev
                </a>
            @endif

            {{-- Page Numbers --}}
            <div class="pagination-pages">
                @foreach ($elements as $element)
                    {{-- "Three Dots" Separator --}}
                    @if (is_string($element))
                        <span class="pagination-dots" aria-disabled="true">{{ $element }}</span>
                    @endif

                    {{-- Array Of Links --}}
                    @if (is_array($element))
                        @foreach ($element as $page => $url)
                            @if ($page == $paginator->currentPage())
                                <span class="pagination-page active" aria-current="page">{{ $page }}</span>
                            @else
                                <a href="{{ $url }}" class="pagination-page" aria-label="Go to page {{ $page }}">{{ $page }}</a>
                            @endif
                        @endforeach
                    @endif
                @endforeach
            </div>

            {{-- Next Page Link --}}
            @if ($paginator->hasMorePages())
                <a href="{{ $paginator->nextPageUrl() }}" class="pagination-btn" rel="next" aria-label="@lang('pagination.next')">
                    Next &raquo;
                </a>
            @else
                <span class="pagination-btn disabled" aria-disabled="true" aria-label="@lang('pagination.next')">
                    Next &raquo;
                </span>
            @endif
        </nav>
    </div>
@endif
