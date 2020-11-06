<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Create users') }}
        </h2>
    </x-slot>
    {!! Form::open(array('url' => url("users/store"), 'id' => 'form-create')) !!}
    @include('users._form')
    {!! Form::close() !!}
</x-app-layout>
