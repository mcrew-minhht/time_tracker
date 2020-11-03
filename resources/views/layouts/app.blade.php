<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap">

        <!-- Styles -->
        <link rel="stylesheet" href="{{ asset('css/jquery-ui.css') }}">
        <link rel="stylesheet" href="{{ asset('css/app.css') }}">
        <link rel="stylesheet" href="{{ asset('fontawesome-free-5.15.1-web/css/all.css') }}">
        <link rel="stylesheet" href="{{ asset('css/style.css') }}">
        @livewireStyles
        <!-- Scripts -->
        <script src="https://cdn.jsdelivr.net/gh/alpinejs/alpine@v2.7.0/dist/alpine.js" defer></script>
    </head>
    <body class="font-sans antialiased">
    <script type="text/javascript" src="{{ asset('js/jquery-3.5.1.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('js/jquery-ui.js') }}"></script>
    <script src="{{  asset('fontawesome-free-5.15.1-web/js/all.js') }}"></script>
    <script type="text/javascript" src="{{ asset('js/common.js') }}"></script>
        <div class="min-h-screen bg-gray-100">
            <livewire:navigation-dropdown></livewire:navigation-dropdown>
            <!-- Page Heading -->
            <header class="bg-white shadow">
                <div class="max-w-7xl mx-auto pt-3 px-4 sm:px-6 lg:px-8">
                    {{ $header }}
                </div>
                <div class="row m-0 p-0">
                    <div class="col-12">
                        <div id="flash_message">
                            @if(Session::has('message'))
                                <div class="alert {{ Session::get('alert-class', 'alert-info') }} alert-dismissable">
                                    <button data-dismiss="alert" class="close" type="button">
                                        <i class="ace-icon fa fa-times"></i>
                                    </button>
                                    {{Session::get('message')}}
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </header>

            <livewire:head-master></livewire:head-master>
            <!-- Page Content -->
            <main>
                {{ $slot }}
            </main>
        </div>

        @stack('modals')

        @livewireScripts

        <script type="text/javascript">
            $( ".datepicker" ).datepicker({
                dateFormat: 'yy/mm/dd'
            });
            $('.required').append(' <span class="text-danger">*</span>');
        </script>

        <script type="text/javascript" src="{{ asset('js/app.js') }}"></script>
        @yield('javascript')

    </body>
</html>
