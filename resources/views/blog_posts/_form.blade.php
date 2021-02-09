<form method="post"
      action="{{ route('dashboard.posts') }}"
      autocomplete="off"
      class="m-3">
    @csrf
    <div class="w-full mt-4">
        <label for="title"
               class="block mb-2 text-sm font-medium text-gray-600
               dark:text-gray-200 font-semibold">Title</label>

        <input type="text"
               id="title"
               name="title"
               placeholder="Title"
               value="{{ old('title') }}"
               class="block w-full px-4 py-2 text-gray-700
        bg-white border border-gray-300 rounded dark:bg-gray-800
        dark:text-gray-300 dark:border-gray-600 focus:border-blue-500
        dark:focus:border-blue-500 focus:outline-none focus:ring @error('title')
                   border-red-500 @enderror" required>

        @error('title')
            <p class="text-red-500 text-xs italic mt-2">
                {{ $message }}
            </p>
        @enderror
    </div>

    <div class="w-full mt-4">
        <label for="description"
               class="block mb-2 text-sm font-medium text-gray-600
               dark:text-gray-200 font-semibold">Content</label>

        <textarea id="description"
                  name="description"
                  placeholder="Content"
                  class="block w-full h-20 px-4 py-2 text-gray-700 bg-white
        border border-gray-300 rounded dark:bg-gray-800 dark:text-gray-300
        dark:border-gray-600 focus:border-blue-500 dark:focus:border-blue-500
         focus:outline-none focus:ring @error('description') border-red-500
@enderror" required>{{ old('description') }}</textarea>

        @error('description')
            <p class="text-red-500 text-xs italic mt-2">
                {{ $message }}
            </p>
        @enderror
    </div>

    <div class="flex justify-center mt-6">
        <button type="submit"
                class="px-4 py-3 text-white transition-colors duration-200
        transform bg-gray-700 rounded hover:bg-gray-600 focus:outline-none
        focus:bg-gray-600">Create Blog Post</button>
    </div>
</form>
