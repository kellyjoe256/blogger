@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
<main class="sm:container sm:mx-auto sm:mt-10">
    <div class="w-full sm:px-6">
        <section class="flex flex-col break-words bg-white sm:border-1 sm:rounded-md sm:shadow-sm sm:shadow-lg">

            <header class="font-semibold bg-gray-200 text-gray-700 py-3 px-6
            sm:py-6 sm:px-8 sm:rounded-t-md">
                <div class="flex justify-between items-center" x-data="{}">
                    <span>Dashboard</span>

                    @if(Auth::user()->admin)
                        <a href="#"
                           class="no-underline hover:no-underline
                       hover:text-white flex items-center justify-center
                       bg-blue-800 outline-none hover:bg-blue-700
                       focus:border-blue-900 text-white font-semibold px-4 py-2
                       rounded shadow"
                           x-on:click.prevent="document.getElementById('import-posts-form').submit()"
                        >Import posts</a>
                        <form id="import-posts-form"
                              action="{{ route('dashboard.import_posts') }}"
                              method="POST" class="hidden">
                            {{ csrf_field() }}
                        </form>
                    @endif
                </div>
            </header>

            <div class="w-full p-6">
                <p class="text-gray-700">
                    You are logged in!
                </p>
            </div>
        </section>
    </div>
</main>
@endsection
