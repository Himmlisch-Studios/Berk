<div class="mt-6 md:grid md:grid-cols-3 md:gap-6">
    <div class="mt-5 md:col-span-3 md:mt-0">
        <div class="px-4 py-4 sm:px-0">
            <h3 class="text-lg font-medium leading-6 text-gray-900">@lang($panel->title ?: 'Information')</h3>
            <p class="mt-1 text-sm text-gray-600">{{ $panel->description }}</p>
        </div>
        <div class="shadow sm:overflow-hidden sm:rounded-md">
            <div class="flex flex-col gap-6 px-4 py-5 bg-white md:grid md:grid-cols-12 sm:p-6">
                @foreach ($panel->fields()->where('needs_to_be_on_panel', true) as $field)
                    {!! $field->formHtml() !!}
                @endforeach
            </div>
        </div>
    </div>
</div>
