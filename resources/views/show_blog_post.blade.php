@extends('layouts.app')

@section('title', $blog_post->title)

@section('content')
    <div class="container w-full md:max-w-3xl mx-auto pt-20">
        <div class="w-full px-4 md:px-6 text-xl text-gray-800 leading-normal" style="font-family:Georgia,serif;">
            <!--Title-->
            <div class="font-sans">
                <span class="text-base md:text-sm text-green-500
            font-bold">&lt;</span>
                <a href="{{ route('home') }}" class="text-base md:text-sm
                text-blue-800
                font-bold
                no-underline">
                    BACK TO BLOG
                </a>

                <h1 class="font-bold font-sans break-normal text-gray-900 pt-6 pb-2 text-3xl md:text-4xl">
                    {{ $blog_post->title }}
                </h1>
                <p class="text-sm md:text-base font-normal text-gray-600">
                    Published on
                    <span>{{ optional
                    ($blog_post->publication_date)
                    ->format('F j, Y') }}</span>
                    by <span class="underline">{{ optional
                    ($blog_post->user)
                    ->name }}</span>
                </p>
            </div>

            <div class="py-6">{{ $blog_post->description }}</div>
        </div>
    </div>
@endsection
