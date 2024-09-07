@extends('front::layout')

@section('content')

    @include('front::elements.breadcrumbs', ['data' => ['action' => $action]])
    @include('front::elements.errors')

    <div class="mt-2 md:flex md:items-center md:justify-between">
        <div class="flex-1 min-w-0">
            <h2 class="text-2xl font-bold leading-7 text-gray-900 sm:truncate sm:text-3xl sm:tracking-tight">{{ $action->title }}</h2>
        </div>
        <div class="flex flex-shrink-0 mt-4 md:mt-0 md:ml-4">
            @foreach ($action->buttons() as $link => $button)
                <a href="{{ $link }}" class="inline-flex items-center px-4 py-2 ml-3 text-sm font-medium text-white bg-blue-600 rounded-md border border-transparent shadow-sm hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">{!! $button !!}</a>
            @endforeach
        </div>
    </div>

    {{ html()->form('POST', request()->url())->acceptsFiles()->open() }}

    @foreach ($action->createPanels() as $panel)
        {!! $panel->formHtml() !!}
    @endforeach

    @if ($action->hasHandle())
        <div class="mt-3 text-right">
            <button type="submit" class="inline-flex items-center px-4 py-2 ml-3 text-sm font-medium text-white bg-blue-600 rounded-md border border-transparent shadow-sm hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">{{ $action->save_button }}</button>
        </div>
    @endif

    {{ html()->form()->close() }}

@stop
