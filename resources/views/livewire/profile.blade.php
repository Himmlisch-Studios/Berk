<div>
    <div wire:loading>
        <div class="inline-flex absolute top-0 right-0 items-center px-4 py-2 mr-8 text-sm font-semibold leading-6 text-white rounded-md shadow transition duration-150 ease-in-out bg-primary-500">
            <svg class="mr-3 -ml-1 w-5 h-5 text-white animate-spin" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
            </svg>
            {{ __('Processing...') }}
        </div>
    </div>
    <div class="grid grid-cols-1 xl:grid-cols-3 xl:gap-4 dark:bg-gray-900">
        <div class="col-span-full mb-4 xl:mb-2">
            <h1 class="text-xl font-semibold text-gray-900 sm:text-2xl dark:text-white">{{ __('Manage profile') }}</h1>
        </div>
        <!-- Right Content -->
        <div class="col-span-full xl:col-auto">
            <div class="p-4 mb-4 bg-white rounded-lg border border-gray-200 shadow-sm 2xl:col-span-2 dark:border-gray-700 sm:p-6 dark:bg-gray-800">
                <div class="items-center sm:flex xl:block 2xl:flex sm:space-x-4 xl:space-x-0 2xl:space-x-4">
                    <img class="mb-4 w-28 h-28 rounded-lg sm:mb-0 xl:mb-4 2xl:mb-0" src="{{ auth()->user()->avatar }}" alt="{{ auth()->user()->name }}">
                    <div>
                        <h3 class="mb-1 text-xl font-bold text-gray-900 dark:text-white">{{ __('Profile picture') }}</h3>
                        <div class="mb-4 text-sm text-gray-500 dark:text-gray-400">
                            {{ __('JPG, GIF or PNG. Max size of 800K') }}
                        </div>
                        <x-input type="file" wire:model.live="avatar" class="hidden" id="file" />
                        <div class="flex items-center space-x-4">
                            <button type="button" onclick="document.getElementById('file').click();"
                                class="inline-flex items-center px-3 py-2 text-sm font-medium text-center text-white rounded-lg bg-primary-700 hover:bg-primary-800 focus:ring-4 focus:ring-primary-300 dark:bg-primary-600 dark:hover:bg-primary-700 dark:focus:ring-primary-800">
                                <svg class="mr-2 -ml-1 w-4 h-4" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M5.5 13a3.5 3.5 0 01-.369-6.98 4 4 0 117.753-1.977A4.5 4.5 0 1113.5 13H11V9.413l1.293 1.293a1 1 0 001.414-1.414l-3-3a1 1 0 00-1.414 0l-3 3a1 1 0 001.414 1.414L9 9.414V13H5.5z"></path>
                                    <path d="M9 13h2v5a1 1 0 11-2 0v-5z"></path>
                                </svg>
                                {{ __('Change picture') }}
                            </button>
                        </div>
                        @error('file')
                            <span class="error">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
            </div>
        </div>
        <div class="col-span-2">
            <div class="p-4 mb-4 bg-white rounded-lg border border-gray-200 shadow-sm 2xl:col-span-2 dark:border-gray-700 sm:p-6 dark:bg-gray-800">
                <h3 class="mb-4 text-xl font-semibold dark:text-white">{{ __('Password information') }}</h3>
                <form wire:submit="changePassword" class="flex flex-col gap-6">
                    <x-password :label="__('New password')" wire:model="password.new" />
                    <x-password :label="__('Confirm password')" wire:model="password.new_confirmation" />
                    <div class="col-span-6 sm:col-full">
                        <x-button type="submit" :label="__('Save')" primary md />
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
