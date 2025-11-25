@if ($paginator->hasPages())
    <div class="d-flex justify-content-center align-items-center gap-2 my-4">

        {{-- Previous --}}
        @if ($paginator->onFirstPage())
            <span class="page-bubble disabled">
                <i class="bi bi-arrow-left"></i>
            </span>
        @else
            <a href="{{ $paginator->previousPageUrl() }}" class="page-bubble">
                <i class="bi bi-arrow-left"></i>
            </a>
        @endif

        {{-- Numbers --}}
        @foreach ($elements as $element)
            @if (is_array($element))
                @foreach ($element as $page => $url)
                    @if ($page == $paginator->currentPage())
                        <span class="page-bubble active">{{ $page }}</span>
                    @else
                        <a href="{{ $url }}" class="page-bubble">{{ $page }}</a>
                    @endif
                @endforeach
            @endif
        @endforeach

        {{-- Next --}}
        @if ($paginator->hasMorePages())
            <a href="{{ $paginator->nextPageUrl() }}" class="page-bubble">
                <i class="bi bi-arrow-right"></i>
            </a>
        @else
            <span class="page-bubble disabled">
                <i class="bi bi-arrow-right"></i>
            </span>
        @endif

    </div>
@endif
