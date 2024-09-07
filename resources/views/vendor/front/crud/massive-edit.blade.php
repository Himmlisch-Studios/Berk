@extends('front::layout')

@section('sidebar')

    @if (count($front->filters()) > 0)
        <div class="mb-2 sidenav-header small font-weight-semibold text-uppercase">{{ __('Options') }}</div>
        {{ html()->form('GET', request()->url())->open() }}
        <div class="pt-3 card sidenav-forms">
            @foreach ($input->getMassiveForms() as $form)
                {!! $form->formHtml() !!}
            @endforeach
        </div>
        {{ html()->submit(__('Search'))->class('bg-green-800 text-white py-2 px-4 rounded block w-full mt-2') }}
        {{ html()->form()->close() }}
    @endif

@endsection

@section('content')
    @include('front::elements.breadcrumbs', ['data' => ['massive' => $input]])
    @include ('front::elements.errors')


    <h4 class="py-3 font-weight-bold">{{ __('Edit') }} {{ $input->title }}</h4>

    {!! Form::open(['url' => request()->url(), 'files' => true]) !!}

    <div class="table-responsive">
        <table class="table bg-white table-striped">
            <thead class="thead-dark">
                <tr>
                    @foreach ($input->getTableHeadings($object) as $title)
                        <th>{{ $title }}</th>
                    @endforeach
                </tr>
            </thead>
            <tbody>
                @foreach ($result as $object)
                    <tr>
                        @foreach ($input->getTableValues($object) as $value)
                            <td>{!! $value !!}</td>
                        @endforeach
                    </tr>
                @endforeach
                @foreach ($input->getExtraTableValues() as $row)
                    <tr>
                        @foreach ($row as $value)
                            <td>{!! $value !!}</td>
                        @endforeach
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    @foreach (request()->except('rows') as $key => $value)
        {!! Form::hidden($key) !!}
    @endforeach

    <div class="mt-3 text-right">
        @foreach ($input->getTableButtons() as $name => $title)
            <button type="submit" class="inline-flex items-center px-4 py-2 ml-3 text-sm font-medium text-white bg-blue-600 rounded-md border border-transparent shadow-sm hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2"
                @if (strlen($name) > 0) name="submitName" value="{{ $name }}" @endif>{!! $title !!}</button>
        @endforeach
    </div>

    {!! Form::close() !!}
@endsection
