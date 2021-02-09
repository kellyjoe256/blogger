@if ($paginator->hasPages())
    <div class="px-4 py-3 flex items-center justify-between border-t border-gray-200 sm:px-6">
        <div class="flex-1 flex justify-between">
            @if ($paginator->currentPage() != 1)
                <a href="{{ $paginator->url($paginator->currentPage() - 1) }}"
                   class="relative inline-flex items-center px-4
                    py-4 border border-gray-300 text-sm font-medium rounded-md
                    text-gray-700 bg-gray-100 hover:text-gray-500">
                    Previous
                </a>
            @endif

            @if ($paginator->currentPage() != $paginator->lastPage())
                <a href="{{ $paginator->url($paginator->currentPage() + 1) }}"
                   class="ml-3 relative inline-flex items-center
            px-4 py-4 border border-gray-300 text-sm font-medium
            rounded-md text-gray-700 bg-gray-100 hover:text-gray-500">
                    Next
                </a>
            @endif
        </div>
    </div>
@endif
