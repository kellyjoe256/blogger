<div class="flex flex-col my-2 sm:flex-row" x-data="{}">
    <div class="flex flex-row mb-1 sm:mb-0">
        <select
            id="sort"
            name="sort"
            class="block w-full h-full px-4 py-2 pr-8 leading-tight
            text-gray-700 bg-white border border-gray-400 rounded
            focus:outline-none focus:bg-white focus:border-gray-500"
            x-ref="sort"
            x-on:change="sorter(sort)">
            <option
                value="newest"
                @if(isset($_GET['sort']) && $_GET['sort'] == 'newest')
                selected @endif>Newest</option>
            <option
                value="oldest"
                @if(isset($_GET['sort']) && $_GET['sort'] == 'oldest') selected @endif>Oldest</option>
        </select>
    </div>
</div>
