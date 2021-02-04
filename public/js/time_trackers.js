let TIME_TRACKERS = {};
let frm_search = $('meta[name=frm_search]').attr('content');
$(function () {
    'use strict';
    TIME_TRACKERS.init = function () {
        TIME_TRACKERS.Add_Project_User();
        TIME_TRACKERS.changeWorkingTime();
        TIME_TRACKERS.reload();
        TIME_TRACKERS.delTimeTracker();
        TIME_TRACKERS.searchTimes();
        TIME_TRACKERS.export();
    }

    TIME_TRACKERS.Add_Project_User = function () {
        $('#add_project').click(function () {
            let formData = APP_TIMES.getFormData($('#frm_add_project'));
            $.ajax({
                type: "POST",
                url: '/time_trackers/add_project',
                data: formData,
                contentType: false,
                cache: false,
                processData: false,
                dataType: "json",
                beforeSend: function () {
                },
                done: function(error){

                },
                success: function (res) {
                    if(res.success == 1){
                        $("#msg_modal").html(APP_TIMES.alertSuccess(res.msg));
                        APP_TIMES.delAllErrorMsg('#frm_add_project');
                    }else{
                        $("#msg_modal").html(APP_TIMES.alertDanger(res.msg));
                    }
                },
                error: function(json) {
                    //if(res.valid == 1){
                        APP_TIMES.validate(json.responseJSON, $('#frm_add_project'), '.form-group', false);
                    //}

                }

            });

        })

        $('.btn_edit_times').click(function () {
            let elm = $(this).closest('tr');
            let id_project = elm.find('[name=id_project]').val();
            let user_id = elm.find('[name=user_id]').val();
            let working_date = elm.find('[name=working_date]').val();
            let working_time = elm.find('[name=working_time]').val();
            let memo = elm.find('[name=memo]').val();

            $("#modal_add_times").find('[name=id]').val($(this).attr('data-id'));
            $("#modal_add_times").find('[name=user_id]').val(user_id);
            $("#modal_add_times").find('[name=id_project]').val(id_project);
            $("#modal_add_times").find('[name=start_working_day]').val(working_date);
            $("#modal_add_times").find('[name=working_time]').val(working_time);
            $("#modal_add_times").find('[name=memo]').val(memo);

            $("#modal_add_times").find('[name=user_id]').prop('disabled', true);
            $("#modal_add_times").find('[name=id_project]').prop('disabled', true);
            $("#modal_add_times").find('[name=start_working_day]').prop('disabled', true);
            $("#modal_add_times").find('.gr_end_working_day').css('display','none');

            $("#modal_add_times").modal('show');
        })


    }
    TIME_TRACKERS.reload = function(){
        $('#btn_reload').click(function () {
            $('#frm_reload').submit();
        });
        $("#modal_add_times").on('hidden.bs.modal', function(){
            $('#frm_search_times').submit();
        });
    }
    TIME_TRACKERS.delTimeTracker = function(){
        $('.btn_del_times').click(function () {
            let id = $(this).attr('data-id');
            let formData = new FormData();
            formData.append('id',id);
            var r = confirm("'Del this row?");
            if (r == true) {
                $.ajax({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    type: "POST",
                    url: '/time_trackers/destroy',
                    data: formData,
                    contentType: false,
                    cache: false,
                    processData: false,
                    dataType: "json",
                    success: function (res) {
                        $("#flash_message").html(APP_TIMES.alertSuccess(res.msg));
                        $('#frm_reload').submit();
                    },
                });

            }

        })
    }
    TIME_TRACKERS.searchTimes = function(){
        $('.btn_search').click(function () {
             $('#'+ frm_search).attr('target', '');
             $('#'+ frm_search).attr('action', '');
             $('#'+ frm_search).find('[name=action]').val('search');
             $('#'+ frm_search).submit();
        })

        $('.btn_search_month').click(function () {
            $("#frm_search_month").attr('target','');
            let formData = APP_TIMES.getFormData($('#frm_search_month'));
            $.ajax({
                type: "POST",
                url: '/search_statistical_month',
                data: formData,
                contentType: false,
                cache: false,
                processData: false,
                dataType: "json",
                beforeSend: function () {
                },
                done: function(error){

                },
                success: function (res) {
                    if(res.success == 1){
                        $("#frm_search_month").attr('action','search_statistical_month');
                        $("#frm_search_month").submit();
                        APP_TIMES.delAllErrorMsg('#frm_search_month');
                    }
                },
                error: function(json) {
                    APP_TIMES.validate(json.responseJSON, $('#frm_search_month'), '.form-group', false);
                }

            });
            return false;
        })
        $('.btn_export_month').click(function () {
            let formData = APP_TIMES.getFormData($('#frm_search_month'));
            $.ajax({
                type: "POST",
                url: '/pdf_month',
                data: formData,
                contentType: false,
                cache: false,
                processData: false,
                dataType: "json",
                beforeSend: function () {
                },
                done: function(error){

                },
                success: function (res) {
                    if(res.success == 1){
                        $("#frm_search_month").attr('target','_blank');
                        $("#frm_search_month").attr('action','pdf_month');
                        $("#frm_search_month").submit();
                        APP_TIMES.delAllErrorMsg('#frm_search_month');
                        $("#frm_search_month").attr('action','statistical_month');
                    }else{
                        APP_TIMES.delAllErrorMsg('#frm_search_month');
                        $("#flash_message").html(APP_TIMES.alertDanger(res.message));
                    }
                },
                error: function(json) {
                    APP_TIMES.validate(json.responseJSON, $('#frm_search_month'), '.form-group', false);
                }

            });
            return false;

        })

        $('.btn_export_project').click(function () {
            let formData = APP_TIMES.getFormData($('#frm_search_project'));
            $.ajax({
                type: "POST",
                url: '/pdf_project',
                data: formData,
                contentType: false,
                cache: false,
                processData: false,
                dataType: "json",
                beforeSend: function () {
                },
                done: function(error){

                },
                success: function (res) {
                    if(res.success == 1){
                        $("#frm_search_project").attr('target','_blank');
                        $("#frm_search_project").attr('action','pdf_project');
                        $("#frm_search_project").submit();
                        APP_TIMES.delAllErrorMsg('#frm_search_project');
                        $("#frm_search_month").attr('action','statistical_project');
                    }
                },
                error: function(json) {
                    APP_TIMES.validate(json.responseJSON, $('#frm_search_project'), '.form-group', false);
                }

            });
            return false;

        })
    }
    TIME_TRACKERS.changeWorkingTime = function () {
        $('.work_time').change(function () {
            TIME_TRACKERS.changeTime('[data-col=working_time]','.sum_time');
        })
        $('.over_time').change(function () {
            TIME_TRACKERS.changeTime('[data-col=time_overtime]','.sum_over');
        })
        $('.off_time').change(function () {
            TIME_TRACKERS.changeTime('[data-col=time_off]','.sum_off');
        })
    }

    TIME_TRACKERS.changeTime = function (input_name = '',sum = '') {
        var total = 0;
        var value = 0;
        $('#tbl_input_time table tbody tr').each(function() {
            value = $(this).find(input_name).val();
            if (isNaN(parseFloat(value))) {
                value = 0;
            }
            total = total + parseFloat(value);
        })
        $(sum).html(total);
    }

    TIME_TRACKERS.export = function (){
        $('#btn_export_pdf').click(function () {
            let formData = APP_TIMES.getFormData($('#frm_search_times'));
            $.ajax({
                type: "POST",
                url: '/time_trackers_pdf',
                data: formData,
                contentType: false,
                cache: false,
                processData: false,
                dataType: "json",
                beforeSend: function () {
                },
                done: function(error){

                },
                success: function (res) {
                    if(res.success == 1){
                        $("#frm_search_times").attr('target','_blank');
                        $("#frm_search_times").attr('action','time_trackers_pdf');
                        $("#frm_search_times").submit();
                        APP_TIMES.delAllErrorMsg('#frm_search_times');
                        $("#frm_search_times").attr('action','time_trackers');
                    }else{
                        APP_TIMES.delAllErrorMsg('#frm_search_times');
                        $("#flash_message").html(APP_TIMES.alertDanger(res.message));
                    }
                },
                error: function(json) {
                    //if(res.valid == 1){
                    APP_TIMES.validate(json.responseJSON, $('#frm_search_times'), '.form-group', false);

                    //}

                }

            });
            return false;
        })
    }

})
$(document).ready(function () {
    TIME_TRACKERS.init();
    $('.datetimepicker').datetimepicker();
    $('.datepicker').datetimepicker({
        showClose: true,
        format: 'DD/MM/YYYY'
    });
    $('.timepicker').datetimepicker({ format: 'LT'});

});
