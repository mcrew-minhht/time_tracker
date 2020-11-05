<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Edit project Mamanagers') }}
        </h2>
    </x-slot>
    {!! Form::open(array('url' => url("project_managers/update"), 'id' => 'form-update')) !!}
    @include('project_managers._form')
    {!! Form::close() !!}
</x-app-layout>
@section('javascript')
