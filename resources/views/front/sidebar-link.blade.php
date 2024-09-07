@props([
    'name' => '',
    'url' => '#',
    'icon' => 'collection',
])
<a href="{{ $url }}"
    class="flex items-center px-2 py-2 text-base font-medium text-gray-600 rounded-md hover:bg-gray-50 hover:text-gray-900 group">
    <x-icon :name="$icon" class="flex-shrink-0 mr-4 w-6 h-6 text-gray-400 group-hover:text-gray-500" />
    @lang($name)
</a>
