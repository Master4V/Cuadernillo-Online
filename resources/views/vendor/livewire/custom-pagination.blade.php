@if ($paginator->hasPages())
    <nav class="flex justify-center items-center space-x-2 text-sm">
        {{-- Página anterior --}}
        @if ($paginator->onFirstPage())
            <span class="px-3 py-1 text-gray-400 cursor-not-allowed">&laquo;</span>
        @else
            <button wire:click="previousPage" class="px-3 py-1 bg-white text-gray-600 border rounded hover:bg-gray-100">
                &laquo;
            </button>
        @endif

        {{-- Números de página --}}
        @foreach ($elements as $element)
            @if (is_string($element))
                <span class="px-3 py-1 text-gray-400">{{ $element }}</span>
            @endif

            @if (is_array($element))
                @foreach ($element as $page => $url)
                    @if ($page == $paginator->currentPage())
                        <span class="px-3 py-1 bg-blue-600 text-white rounded">{{ $page }}</span>
                    @else
                        <button wire:click="gotoPage({{ $page }})" class="px-3 py-1 bg-white text-gray-600 border rounded hover:bg-gray-100">
                            {{ $page }}
                        </button>
                    @endif
                @endforeach
            @endif
        @endforeach

        {{-- Página siguiente --}}
        @if ($paginator->hasMorePages())
            <button wire:click="nextPage" class="px-3 py-1 bg-white text-gray-600 border rounded hover:bg-gray-100">
                &raquo;
            </button>
        @else
            <span class="px-3 py-1 text-gray-400 cursor-not-allowed">&raquo;</span>
        @endif
    </nav>
@endif
