@extends('front::layout')

@section('sidebar')

    @if (count($front->filters()) > 0)
        <div class="mt-6 font-bold">{{ __('FILTER :name', ['name' => strtoupper($front->plural_label)]) }}</div>
        {{ html()->form('GET', request()->url())->open() }}
        <div class="pt-3 card sidenav-forms">
            {!! Form::hidden($front->getCurrentViewRequestName()) !!}
            @foreach ($front->getFilters() as $filter)
                {!! $filter->formHtml() !!}
            @endforeach
        </div>
        {{ html()->submit(__('Search'))->class('bg-green-800 text-white py-2 px-4 rounded block w-full mt-2') }}
        {{ html()->form()->close() }}
    @endif

@endsection

@section('content')

    <!-- This example requires Tailwind CSS v2.0+ -->
    @include('front::elements.breadcrumbs')

    <div class="mt-2 md:flex md:items-center md:justify-between">
        <div class="flex-1 min-w-0">
            <h2 class="text-2xl font-bold leading-7 text-gray-900 sm:truncate sm:text-3xl sm:tracking-tight">{{ $front->plural_label }}</h2>
        </div>
        <div class="flex flex-shrink-0 mt-4 md:mt-0 md:ml-4">
            @foreach ($front->getIndexLinks() as $button)
                {!! $button->form() !!}
            @endforeach
        </div>
    </div>

    @if ($front->getLenses()->count() > 1)
        <div>
            <h4>Lenses</h4>
            @foreach ($front->getLenses() as $button)
                {!! $button->form() !!}
            @endforeach
        </div>
    @endif

    @include ('front::components.cards', ['cards' => $front->cards()])
    @include ($front->getCurrentView())

@endsection
