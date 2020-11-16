<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Profile') }}
        </h2>
    </x-slot>
    <div class="container">
        <div class="row bg-white p-1 mb-5">
            <div class="col-md-4">
                <h3 class="text-lg font-medium text-gray-900">{{ __('Profile Information') }}</h3>
                <p class="mt-1 text-sm text-gray-600">
                    {{ __('Update your account\'s profile information.') }}
                </p>
            </div>
            <div class="col-md-8">
            {!! Form::open(array('url' => url("profile/update"), 'id' => 'form-update-info')) !!}
                @include('profile_user._form_info')
            {!! Form::close() !!}
            </div>
        </div>
        <div class="row bg-white p-1">
            <div class="col-md-4">
                <h3 class="text-lg font-medium text-gray-900">{{ __('Update Password') }}</h3>
                <p class="mt-1 text-sm text-gray-600">
                    {{ __('Ensure your account is using a long, random password to stay secure.') }}
                </p>
            </div>
            <div class="col-md-8">
                {!! Form::open(array('url' => url("profile/confirm-password"), 'id' => 'form-confirm-password')) !!}
                    @include('profile_user._form_confirm_password')
                {!! Form::close() !!}
            </div>
        </div>
    </div>
    @section('javascript')
        <script>
            $('.datepicker').datetimepicker({
                showClose: true,
                format: 'DD/MM/YYYY'
            });
        </script>
    @stop
</x-app-layout>
@section('javascript')
