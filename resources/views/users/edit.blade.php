<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Edit project Mamanagers') }}
        </h2>
    </x-slot>
    {!! Form::open(array('url' => url("users/update"), 'id' => 'form-update')) !!}
    @include('users._form')
    {!! Form::close() !!}
</x-app-layout>
@section('javascript')
