@if ($paginator->hasPages())
    <nav role="navigation" aria-label="Pagination Navigation" style="display: flex; justify-content: center; align-items: center; gap: 0.5rem; flex-wrap: wrap;">
        {{-- Previous Page Link --}}
        @if ($paginator->onFirstPage())
            <span style="padding: 0.5rem 0.875rem; border-radius: 0.5rem; background-color: #e2e8f0; color: #94a3b8; cursor: not-allowed; font-weight: 600;">
                &lsaquo; Prev
            </span>
        @else
            <a href="{{ $paginator->previousPageUrl() }}" style="padding: 0.5rem 0.875rem; border-radius: 0.5rem; background-color: #f1f5f9; color: #0b1f3a; text-decoration: none; font-weight: 600; transition: all 0.2s;" onmouseover="this.style.backgroundColor='#087ea4';this.style.color='#ffffff';" onmouseout="this.style.backgroundColor='#f1f5f9';this.style.color='#0b1f3a';">
                &lsaquo; Prev
            </a>
        @endif

        {{-- Pagination Elements --}}
        @foreach ($elements as $element)
            {{-- "Three Dots" Separator --}}
            @if (is_string($element))
                <span style="padding: 0.5rem 0.75rem; color: #64748b; font-weight: 600;">{{ $element }}</span>
            @endif

            {{-- Array Of Links --}}
            @if (is_array($element))
                @foreach ($element as $page => $url)
                    @if ($page == $paginator->currentPage())
                        <span style="padding: 0.5rem 0.875rem; border-radius: 0.5rem; background-color: #087ea4; color: #ffffff; font-weight: 700; min-width: 2.5rem; text-align: center;">
                            {{ $page }}
                        </span>
                    @else
                        <a href="{{ $url }}" style="padding: 0.5rem 0.875rem; border-radius: 0.5rem; background-color: #f1f5f9; color: #0b1f3a; text-decoration: none; font-weight: 600; min-width: 2.5rem; text-align: center; transition: all 0.2s;" onmouseover="this.style.backgroundColor='#087ea4';this.style.color='#ffffff';" onmouseout="this.style.backgroundColor='#f1f5f9';this.style.color='#0b1f3a';">
                            {{ $page }}
                        </a>
                    @endif
                @endforeach
            @endif
        @endforeach

        {{-- Next Page Link --}}
        @if ($paginator->hasMorePages())
            <a href="{{ $paginator->nextPageUrl() }}" style="padding: 0.5rem 0.875rem; border-radius: 0.5rem; background-color: #f1f5f9; color: #0b1f3a; text-decoration: none; font-weight: 600; transition: all 0.2s;" onmouseover="this.style.backgroundColor='#087ea4';this.style.color='#ffffff';" onmouseout="this.style.backgroundColor='#f1f5f9';this.style.color='#0b1f3a';">
                Next &rsaquo;
            </a>
        @else
            <span style="padding: 0.5rem 0.875rem; border-radius: 0.5rem; background-color: #e2e8f0; color: #94a3b8; cursor: not-allowed; font-weight: 600;">
                Next &rsaquo;
            </span>
        @endif
    </nav>
@endif
