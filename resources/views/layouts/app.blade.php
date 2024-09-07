@extends('layouts.base')
@section('content-base')
    <x-navbar />
    <div class="py-12 mx-auto w-full max-w-7xl">
        {{ $slot }}
    </div>
@endsection
