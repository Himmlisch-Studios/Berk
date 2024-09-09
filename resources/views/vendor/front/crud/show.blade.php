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

    <div class="my-10" x-data="{ tab: 'panel-0' }">
        <nav class="-mb-0.5">
            <ul class="flex gap-2">
                @foreach ($panels as $panel)
                    <li class="p-3 text-sm bg-white rounded-t border-t border-gray-300 border-x">
                        <button x-on:click="tab = 'panel-' + {{ $loop->index }}" class="transition-colors"
                            x-bind:class="tab === 'panel-' + {{ $loop->index }} ? 'text-primary-600' : 'text-gray-500'">
                            @lang($panel->title ? $panel->title : 'Information')
                        </button>
                    </li>
                @endforeach
                @foreach ($front->showRelations() as $relation)
                    <li class="p-3 text-sm bg-white rounded-t border-t border-gray-300 border-x">
                        <button x-on:click="tab = 'rel-' + {{ $loop->index }}" class="transition-colors"
                            x-bind:class="tab === 'rel-' + {{ $loop->index }} ? 'text-primary-600' : 'text-gray-500'">
                            @lang($relation->title ? $relation->title : 'Information')
                        </button>
                    </li>
                @endforeach
            </ul>
        </nav>
        <div class="py-2 bg-white rounded-b rounded-tr border shadow">
            @foreach ($panels as $panel)
                <div x-show="tab === 'panel-' + {{ $loop->index }}" {{ $loop->first ?: 'x-cloak' }}>
                    @if ($loop->first)
                        <div class="flex flex-col gap-6 md:flex-wrap md:flex-row">
                            <div class="flex-1 space-y-6">
                                {!! $panels->shift()->showHtml($object) !!}
                            </div>

                            @if (method_exists($object, 'activities'))
                                @php $activities = $object->activities()->latest()->take(6)->get(); @endphp
                                @if ($activities->isNotEmpty())
                                    <section class="md:w-1/3">
                                        @include('front.timeline', ['activities' => $activities])
                                    </section>
                                @endif
                            @endif
                        </div>
                    @else
                        {!! $panel->showHtml($object) !!}
                    @endif
                </div>
            @endforeach
            @php $percentage = 0; @endphp
            @foreach ($front->showRelations() as $key => $relation)
                <div x-show="tab === 'rel-' + {{ $loop->index }}" class="px-4 py-5`" x-cloak>
                    @php $percentage += $relation->width_porcentage(); @endphp
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
                    @if ($percentage >= 100)
                        @php $percentage = 0; @endphp
                        <div style="clear:both;"></div>
                    @endif
                </div>
            @endforeach
        </div>
    </div>
@endsection
