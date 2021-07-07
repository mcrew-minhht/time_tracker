<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Edit Devices') }}
        </h2>
    </x-slot>
    {!! Form::open(array('url' => url("devices/update"), 'id' => 'form-update', 'files'=> true), ) !!}
    @include('devices._form')
    {!! Form::close() !!}
</x-app-layout>
@section('javascript')
