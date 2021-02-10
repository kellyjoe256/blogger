@extends('layouts.app')

@section('content')
    <div class="container w-full md:max-w-3xl mx-auto pt-20">
        @if ($blog_posts->count())
            @include('includes.common.sorter')

            @foreach($blog_posts as $blog_post)
                <div class="w-full px-4 md:px-6 text-xl text-gray-800 leading-normal" style="font-family:Georgia,serif;">
                    <!--Title-->
                    <div class="font-sans">
                        <h1 class="font-bold font-sans break-normal text-gray-900 pt-6 pb-2 text-3xl md:text-4xl">
                            <a href="{{ route('show_blog_post', $blog_post->id)}}">
                                {{ $blog_post->title }}
                            </a>
                        </h1>
                        <p class="text-sm md:text-base font-normal text-gray-600">
                            Published on
                            <span>{{ optional
                        ($blog_post->publication_date)
                        ->format('F j, Y') }}</span>
                        </p>
                    </div>

                    <p class="py-6">{{ $blog_post->blogPostIntro() }}</p>
                </div>
            @endforeach

            {{ $blog_posts->appends($_GET)->links('includes.pagination.simple') }}
        @else
            <div class="w-full px-4 md:px-6 text-xl text-gray-800 leading-normal" style="font-family:Georgia,serif;">
                <div class="font-sans">
                    <h1 class="font-bold font-sans break-normal text-gray-900 pt-6 pb-2 text-3xl md:text-4xl">
                        No posts available
                    </h1>
                </div>
            </div>
        @endif
    </div>
@endsection
