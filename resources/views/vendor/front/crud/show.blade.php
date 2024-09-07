@extends('front::layout')

@section('content')
    @include('front::elements.breadcrumbs')

    <div class="mt-2 md:flex md:items-center md:justify-between">
        <div class="flex-1 min-w-0">
            <h2 class="text-2xl font-bold leading-7 text-gray-900 sm:truncate sm:text-3xl sm:tracking-tight">
                {!! $front->getTitle($object) !!}</h2>
        </div>
        <div class="flex flex-shrink-0 mt-4 md:mt-0 md:ml-4">
            @foreach ($front->getLinks($object) as $button)
                {!! $button->form() !!}
            @endforeach
        </div>
    </div>

    @php $panels = $front->showPanels(); @endphp
    <div class="flex flex-wrap gap-6 mx-auto mt-8">
        <div class="flex-1 space-y-6">
            {!! $panels->shift()->showHtml($object) !!}
        </div>

        @if (method_exists($object, 'activities'))
            @php $activities = $object->activities()->latest()->take(6)->get(); @endphp
            @if ($activities->isNotEmpty())
                <section class="w-1/3">
                    @include('front.timeline', ['activities' => $activities])
                </section>
            @endif
        @endif
    </div>

    <div class="flex gap-6 mx-auto mt-8">
        <div class="flex-1 space-y-6">
            @foreach ($panels as $panel)
                {!! $panel->showHtml($object) !!}
            @endforeach

            @php
                $porcentage = 0;
            @endphp

            @foreach ($front->showRelations() as $key => $relation)
                <hr class="my-10">
                @php $porcentage += $relation->width_porcentage(); @endphp
                <div style="{{ $relation->style_width() }}">
                    <div class="flex justify-between items-center">
                        <h4 class="text-3xl font-bold">
                            {{ $relation->title }}
                        </h4>
                        <div>
                            @foreach ($relation->getLinks($object, $key, $front) as $button)
                                {!! $button->form() !!}
                            @endforeach
                        </div>
                    </div>
                    {!! $relation->getValue($object) !!}
                </div>
                @if ($porcentage >= 100)
                    @php $porcentage = 0; @endphp
                    <div style="clear:both;"></div>
                @endif
            @endforeach
        </div>
    </div>
@endsection
