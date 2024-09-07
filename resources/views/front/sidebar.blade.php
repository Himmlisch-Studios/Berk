@include('front.sidebar-link', [
    'name' => 'Dashboard',
    'url' => '/admin',
    'icon' => 'home',
])
@foreach (front_resources() as $resource)
    @if (auth()->user()->can('viewAny', $resource))
        @php
            $instance = app($resource);
        @endphp
        @if ($instance->showOnMenu)
            @include('front.sidebar-link', [
                'name' => $instance->plural_label,
                'url' => $instance->base_url,
                'icon' => $instance?->icon ?? 'collection',
            ])
        @endif
    @endif
@endforeach
@yield('sidebar')
