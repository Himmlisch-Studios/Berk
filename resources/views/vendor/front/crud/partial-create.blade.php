{{ html()->form('POST', $front->getBaseUrl())->acceptsFiles()->open() }}

{{ html()->hidden('redirect_url') }}
@foreach ($front->createPanels() as $panel)
    {!! $panel->formHtml() !!}
@endforeach
<div class="mt-3 text-right">
    <button type="submit" class="inline-flex items-center px-4 py-2 ml-3 text-sm font-medium text-white bg-blue-600 rounded-md border border-transparent shadow-sm hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="mr-2 w-6 h-6">
            <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
        </svg>

        {{ __('Add') }} {{ $front->label }}
    </button>
</div>

{{ html()->form()->close() }}
