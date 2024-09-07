<div class="flex sticky top-0 z-10 flex-shrink-0 h-16 bg-white shadow">
    @isset($button)
        {{ $button }}
    @endisset
    <div class="flex flex-1 justify-between px-4" x-data="{ show: false }">
        <div class="flex flex-1">
            @isset($slot)
                {{ $slot }}
            @endisset
        </div>
        <div class="flex items-center ml-4 md:ml-6">
            <button type="button"
                class="p-1 text-gray-400 bg-white rounded-full hover:text-gray-500 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">
                <span class="sr-only">{{ __('View notifications') }}</span>

                <svg class="w-6 h-6" xmlns="http://www.w3.org/2000/svg" fill="none"
                    viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M14.857 17.082a23.848 23.848 0 005.454-1.31A8.967 8.967 0 0118 9.75v-.7V9A6 6 0 006 9v.75a8.967 8.967 0 01-2.312 6.022c1.733.64 3.56 1.085 5.455 1.31m5.714 0a24.255 24.255 0 01-5.714 0m5.714 0a3 3 0 11-5.714 0" />
                </svg>
            </button>

            <div class="relative ml-3">
                <div>
                    <button type="button"
                        class="flex items-center max-w-xs text-sm bg-white rounded-full focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2"
                        x-on:click="show = !show">
                        <span class="sr-only">{{ __('Open user menu') }}</span>
                        <img class="w-8 h-8 rounded-full" src="{{ auth()->user()->avatar }}" alt="{{ __('Profile image') }}">
                    </button>
                </div>

                <nav class="absolute right-0 z-10 py-1 mt-2 w-48 bg-white rounded-md ring-1 ring-black ring-opacity-5 shadow-lg origin-top-right focus:outline-none"
                    x-show="show"
                    x-on:click.away="show = false"
                    x-transition
                    x-cloak>
                    <ul>
                        @foreach ($navigation as $item)
                            <li>
                                <a class="block px-4 py-2 text-sm text-gray-700" href="{{ $item['href'] }}">
                                    @lang($item['title'])
                                </a>
                            </li>
                        @endforeach
                    </ul>
                </nav>
            </div>
        </div>
    </div>
</div>
