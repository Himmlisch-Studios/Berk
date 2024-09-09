@extends('layouts.base')
@section('content-base')
    <div x-data="{ menu_user: false, menu: false }">
        <div class="relative z-40 lg:hidden" role="dialog" aria-modal="true" 
            x-show="menu" 
            x-cloak>
            <div class="fixed inset-0 bg-gray-600 bg-opacity-75"></div>
            <div class="flex fixed inset-0 z-40">
                <div class="flex relative flex-col flex-1 pt-5 pb-4 w-full max-w-xs bg-white">
                    <div class="absolute top-0 right-0 pt-2 -mr-12">
                        <button type="button"
                            class="flex justify-center items-center ml-1 w-10 h-10 rounded-full focus:outline-none focus:ring-2 focus:ring-inset focus:ring-white"
                            x-on:click="menu = !menu">
                            <span class="sr-only">Close sidebar</span>
                            <svg class="w-6 h-6 text-white" xmlns="http://www.w3.org/2000/svg" fill="none"
                                viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        </button>
                    </div>
                    <div class="flex flex-shrink-0 items-center px-4">
                        <img class="w-auto h-8" src="{{ asset(config('app.logo')) }}" alt="{{ config('app.name') }}">
                    </div>
                    <div class="overflow-y-auto flex-1 mt-5 h-0">
                        <nav class="px-2 space-y-1">
                            @include('front.sidebar')
                        </nav>
                    </div>
                </div>
                <div class="flex-shrink-0 w-14" aria-hidden="true"></div>
            </div>
        </div>

        <div class="hidden lg:fixed lg:inset-y-0 lg:flex lg:w-64 lg:flex-col">
            <div class="flex overflow-y-auto flex-col flex-grow pt-5 bg-white border-r border-gray-200">
                <div class="flex flex-shrink-0 items-center px-4">
                    <img class="w-auto h-10" src="{{ asset(config('app.icon')) }}" alt="{{ config('app.name') }}">
                </div>
                <div class="flex flex-col flex-grow mt-5">
                    <nav class="flex-1 px-2 pb-4 space-y-1">
                        @includeIf('front.sidebar')
                    </nav>
                </div>
            </div>
        </div>

        <div class="flex flex-col flex-1 lg:pl-64">
            <x-navbar>
                <x-slot name="button">
                    <button type="button"
                        class="px-4 text-gray-500 border-r border-gray-200 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-blue-500 lg:hidden"
                        x-on:click="menu = !menu">
                        <span class="sr-only">Open sidebar</span>
                        <svg class="w-6 h-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                            stroke-width="1.5" stroke="currentColor" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25H12" />
                        </svg>
                    </button>
                </x-slot>
                @isset($front)
                    <form action="{{ $front->base_url }}" method="GET" class="flex w-full lg:ml-0">
                        <label for="search-field" class="sr-only">Search</label>
                        @php
                            $request = collect(request()->all())->filter(function ($item, $key) {
                                return $key != 'search' && !is_array($item) && strlen($item) > 0;
                            });
                        @endphp
                        @foreach ($request as $key => $value)
                            <input type="hidden" name="{{ $key }}" value="{{ $value }}">
                        @endforeach
                        <div class="relative w-full text-gray-400 focus-within:text-gray-600">
                            <div class="flex absolute inset-y-0 left-0 items-center pointer-events-none">
                                <!-- Heroicon name: mini/magnifying-glass -->
                                <svg class="w-5 h-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"
                                    fill="currentColor" aria-hidden="true">
                                    <path fill-rule="evenodd"
                                        d="M9 3.5a5.5 5.5 0 100 11 5.5 5.5 0 000-11zM2 9a7 7 0 1112.452 4.391l3.328 3.329a.75.75 0 11-1.06 1.06l-3.329-3.328A7 7 0 012 9z"
                                        clip-rule="evenodd" />
                                </svg>
                            </div>
                            <input id="search-field"
                                class="block py-2 pr-3 pl-8 w-full h-full placeholder-gray-500 text-gray-900 border-transparent focus:border-transparent focus:placeholder-gray-400 focus:outline-none focus:ring-0 sm:text-sm"
                                placeholder="{{ __('Search') }} {{ $front->label }}" type="search"
                                name="search" value="{{ request()->search }}">
                        </div>
                    </form>
                @endisset
            </x-navbar>
            <main class="flex-1">
                <div class="py-6">
                    <div class="relative px-4 mx-auto sm:px-6 lg:px-8">
                        @include('flash::message')
                        @yield('content')
                    </div>
                </div>
            </main>
        </div>
    </div>
@endsection
@section('footer')
    <script
        src="https://code.jquery.com/jquery-3.4.1.min.js"
        integrity="sha256-CSXorXvZcTkaix6Yvo6HppcZGetbYMGWSFlBw8HfCJo="
        crossorigin="anonymous"></script>
    @stack('scripts-footer')
@endsection
