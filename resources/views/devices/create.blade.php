<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Create Devices') }}
        </h2>
    </x-slot>
    {!! Form::open(array('url' => url("devices/store"), 'id' => 'form-device-create',  'enctype' => "multipart/form-data")) !!}
    @include('devices._form')
    {!! Form::close() !!}
</x-app-layout>
