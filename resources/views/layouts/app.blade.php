<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Time tracker') }}</title>

        <!-- Fonts -->
        <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap">

        <!-- Styles -->
        <link rel="stylesheet" href="{{ asset('css/jquery-ui.css') }}">
        <link rel="stylesheet" href="{{ asset('css/app.css') }}">
        <link rel="stylesheet" href="{{ asset('fontawesome-free-5.15.1-web/css/all.css') }}">
        <link rel="stylesheet" href="{{ asset('bootstrap-4.0.0-dist/css/bootstrap.min.css') }}">
        <link rel="stylesheet" href="{{ asset('css/style.css?version='.config('setting.version')) }}">
        @livewireStyles
        <!-- Scripts -->
        <script src="https://cdn.jsdelivr.net/gh/alpinejs/alpine@v2.7.0/dist/alpine.js" defer></script>
    </head>
    <body class="font-sans antialiased">
    <script type="text/javascript" src="{{ asset('js/jquery-3.5.1.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('js/jquery-ui.js') }}"></script>
    <script src="{{  asset('fontawesome-free-5.15.1-web/js/all.js') }}"></script>
    <script src="{{ asset('bootstrap-4.0.0-dist/js/bootstrap.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('js/common.js') }}"></script>

        <div class="max-w-full mx-auto min-h-screen bg-gray-100">
            <livewire:navigation-dropdown></livewire:navigation-dropdown>
            <!-- Page Heading -->
            <header class="bg-white shadow">
                <div class="max-w-7xl mx-auto py-1">
                    {{ $header }}
                    <div id="flash_message">
                        @if(Session::has('message'))
                            <div class="alert {{ Session::get('alert-class', 'alert-info') }} alert-dismissable">
                                <button data-dismiss="alert" class="close" type="button">
                                    <i class="ace-icon fa fa-times"></i>
                                </button>
                                {{Session::get('message')}}
                            </div>
                        @endif
                        @if(Session::has('failures'))
                                <?php $failures = Session::get('failures'); ?>
                                <div class="alert alert-danger alert-dismissable">
                                <button data-dismiss="alert" class="close" type="button">
                                    <i class="ace-icon fa fa-times"></i>
                                </button>
                                    <ul>
                                        @foreach ($failures as $failure)
                                            <li>Row {{ $failure->row() }}: {{ $failure->errors()[0] }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                        @endif
                    </div>
                </div>
            </header>

            <livewire:head-master></livewire:head-master>
            <!-- Page Content -->
            <main>
                {{ $slot }}
            </main>
        </div>

    <!-- Modal Update -->
    <div id="updateModal" class="modal fade">
        <div class="modal-dialog">
            <div class="modal-content">
                {!! Form::open(array('url' => "", 'class' => 'form-horizontal', 'id' => 'form_modal_update')) !!}
                <div class="modal-header">
                    <h4 class="modal-title">{{__('Confirm')}}</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                </div>
                <div class="modal-body">
                    <p><i class="fas fa-exclamation-triangle text-warning"></i> {{__('Do you want to update?')}}</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" id="btn_yes">{{__('Yes')}}</button>
                    <button type="button" class="btn btn-default" id="btn_no" data-dismiss="modal">{{__('No')}}</button>
                </div>
                {!! Form::close() !!}
            </div>
        </div>
    </div>

    <!-- Modal Delete -->
    <div id="deleteModal" class="modal fade">
        <div class="modal-dialog">
            <div class="modal-content">
                {!! Form::open(array('url' => "", 'class' => 'form-horizontal', 'id' => 'form_modal_delete')) !!}
                <div class="modal-header">
                    <h4 class="modal-title">{{__('Confirm')}}</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                </div>
                <div class="modal-body">
                    <input type="hidden" name="id" id="del_modal_id" />
                    <p><i class="fas fa-exclamation-triangle text-danger"></i> {{__('Do you want to delete?')}}</p>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">{{__('Yes')}}</button>
                    <button type="button" class="btn btn-default" data-dismiss="modal">{{__('No')}}</button>
                </div>
                {!! Form::close() !!}
            </div>
        </div>
    </div>

        @stack('modals')

        @livewireScripts

        <script type="text/javascript">
            $(document).ready(function(){
                $('[data-toggle="tooltip"]').tooltip();
            });

            $('.required').append(' <span class="text-danger">*</span>');
            $("#checkAll").change(function () {
                $("input.checkItem:checkbox").prop('checked', $(this).prop("checked"));
                $check = false;
                $("#table-main tbody tr td .checkItem").each(function () {
                    if ($(this).is(':checked')) {
                        $check = true;
                    }
                });
                if ($check){
                    $("#btn-delete-all").removeClass('disabled');
                }else{
                    $("#btn-delete-all").addClass('disabled');
                }

            });
            $(".checkItem").change(function () {
                $check = false;
                $("#table-main tbody tr td .checkItem").each(function () {
                    if ($(this).is(':checked')) {
                        $check = true;
                    }
                });
                if ($check){
                    $("#btn-delete-all").removeClass('disabled');
                }else{
                    $("#btn-delete-all").addClass('disabled');
                }
            });
            $("#btn-delete-all").on("click", function () {
                var routes = $(this).data("routes");
                $('#form_modal_delete').attr('action', routes);
                var idArr = [];
                $("#table-main tbody tr td .checkItem").each(function () {
                    if ($(this).is(':checked')) {
                        idArr.push($(this).val());
                    }
                });
                $('#del_modal_id').val(idArr.join(","));
                $('#deleteModal').modal('show');
            });
            $(".btn-delete").on("click", function () {
                var routes = $(this).data("routes");
                var id = $(this).data("id");
                $('#form_modal_delete').attr('action', routes);
                $('#del_modal_id').val(id);
                $('#deleteModal').modal('show');
            });
            $("#form-update").on("submit", function () {
                $('#updateModal').modal('show');
                return false;
            });
            $("#updateModal #btn_yes").on('click',function (){
                $("#form-update").submit();
            });
            $("#updateModal #btn_yes").on('click',function (){
                $('#deleteModal').modal('hide');
            });

        </script>

        <script type="text/javascript" src="{{ asset('js/app.js?version='.config('setting.version')) }}"></script>
        @yield('javascript')

    </body>
</html>
