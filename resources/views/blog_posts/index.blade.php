@extends('layouts.app')

@section('title', 'Posts')

@section('content')
<main class="sm:container sm:mx-auto sm:mt-10">
    <div class="w-full sm:px-6">
        <section class="flex flex-col break-words bg-white sm:border-1 sm:rounded-md sm:shadow-sm sm:shadow-lg">

            <header class="font-semibold bg-gray-200 text-gray-700 py-3 px-6
            sm:py-6 sm:px-8 sm:rounded-t-md">
                Posts
            </header>

            <div class="w-full p-4">
                @include('blog_posts._form')

                @if($blog_posts->count())
                    @include('includes.common.sorter')

                    <table class="items-center w-full bg-transparent border-collapse">
                        <thead>
                            <tr>
                                <th class="px-6 bg-gray-100 text-gray-600 align-middle border border-solid border-gray-200 py-3 text-xs uppercase border-l-0 border-r-0 whitespace-no-wrap font-semibold text-left">
                                    Title
                                </th>
                                <th class="px-6 bg-gray-100 text-gray-600 align-middle border border-solid border-gray-200 py-3 text-xs uppercase border-l-0 border-r-0 whitespace-no-wrap font-semibold text-left">
                                    Published
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($blog_posts as $blog_post)
                                <tr>
                                    <td class="border-t-0 px-6 align-middle
                                    border-l-0 border-r-0 text-xs whitespace-no-wrap p-4 text-left">
                                        {{ $blog_post->title }}
                                    </td>
                                    <td class="border-t-0 px-6 align-middle border-l-0 border-r-0 text-xs whitespace-no-wrap p-4">
                                        {{ optional
                                        ($blog_post->publication_date)
                                        ->diffForHumans() }}
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    {{ $blog_posts->appends($_GET)->links() }}
                @endif
            </div>
        </section>
    </div>
</main>
@endsection
