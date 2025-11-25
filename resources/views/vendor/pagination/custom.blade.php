@if ($paginator->hasPages())
    <div class="d-flex justify-content-center mt-3">
        <nav>
            <ul class="pagination align-items-center">

                {{-- Previous Page --}}
                @if ($paginator->onFirstPage())
                    <li class="page-item disabled mx-1">
                        <span class="page-link">« Previous</span>
                    </li>
                @else
                    <li class="page-item mx-1">
                        <a class="page-link" href="{{ $paginator->previousPageUrl() }}" rel="prev">« Previous</a>
                    </li>
                @endif

                {{-- Info --}}
                <li class="page-item mx-3 text-muted" style="font-size: 14px;">
                    Showing {{ $paginator->firstItem() }} to {{ $paginator->lastItem() }} of {{ $paginator->total() }} results
                </li>

                {{-- Pagination Numbers --}}
                @foreach ($elements as $element)
                    @if (is_string($element))
                        <li class="page-item disabled mx-1"><span class="page-link">{{ $element }}</span></li>
                    @endif

                    @if (is_array($element))
                        @foreach ($element as $page => $url)
                            @if ($page == $paginator->currentPage())
                                <li class="page-item active mx-1">
                                    <span class="page-link">{{ $page }}</span>
                                </li>
                            @else
                                <li class="page-item mx-1">
                                    <a class="page-link" href="{{ $url }}">{{ $page }}</a>
                                </li>
                            @endif
                        @endforeach
                    @endif
                @endforeach

                {{-- Next Page --}}
                @if ($paginator->hasMorePages())
                    <li class="page-item mx-1">
                        <a class="page-link" href="{{ $paginator->nextPageUrl() }}" rel="next">Next »</a>
                    </li>
                @else
                    <li class="page-item disabled mx-1">
                        <span class="page-link">Next »</span>
                    </li>
                @endif
            </ul>
        </nav>
    </div>
@endif
