<section aria-labelledby="applicant-information-title" style="{{ $panel->style_width() }}">
    <div class="px-4 py-5 sm:px-6">
        @if (count($panel->actions) > 0)
            @foreach ($panel->actions as $action)
                <a href="{{ $panel->resource->base_url }}/{{ $object->getKey() }}/action/{{ $action->slug }}" class="mx-2 btn btn-outline-dark btn-sm">{!! $action->button_text !!}</a>
            @endforeach
        @endif
        @if (count($panel->links) > 0)
            @foreach ($panel->links as $link => $title)
                <a href="{{ $link }}" class="mx-2 btn btn-outline-dark btn-sm">{!! $title !!}</a>
            @endforeach
        @endif
        <h2 id="applicant-information-title" class="text-lg font-medium leading-6 text-gray-900">@lang($panel->title ?: 'Information')</h2>
    </div>
    <div class="px-4 py-5 border-t border-gray-200 sm:px-6">
        <dl class="grid grid-cols-12 gap-x-4 gap-y-8">
            @foreach ($panel->fields() as $field)
                {!! $field->showHtml($object) !!}
            @endforeach
        </dl>
    </div>
</section>
