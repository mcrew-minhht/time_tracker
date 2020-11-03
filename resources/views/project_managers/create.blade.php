<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Create project Mamanagers') }}
        </h2>
    </x-slot>
    {!! Form::open(array('url' => url("project_managers/store"), 'id' => 'form-project')) !!}
    @include('project_managers._form')
    {!! Form::close() !!}
</x-app-layout>
