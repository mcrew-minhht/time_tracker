let TIME_TRACKERS = {};

$(function () {
    'use strict';
    TIME_TRACKERS.init = function () {
        TIME_TRACKERS.Add_Project_User();
        TIME_TRACKERS.changeWorkingTime();
    }

    TIME_TRACKERS.Add_Project_User = function () {
        $('#add_project').click(function () {
            let formData = APP_TIMES.getFormData($('#frm_add_project'));
            APP_TIMES.postAjax(formData,'/time_trackers/add_project', function (res) {
                if (APP_TIMES.validate(res, $('#frm_add_project'), '.u-flex')) {
                    if (res.success == 1) {
                        $("#msg_modal").html(APP_TIMES.alertSuccess(res.msg));
                    } else {
                        $("#msg_modal").html(APP_TIMES.alertDanger(res.msg));
                    }
                }
            })
        })

        $('.btn_edit_times').click(function () {
            let elm = $(this).closest('tr');
            let working_date = elm.find('[name=working_date]').val();
            let start_working_day = elm.find('[name=start_working_day]').val();
            let rest_time = elm.find('[name=rest_time]').val();
            let end_working_day = elm.find('[name=end_working_day]').val();

            $("#modal_add_times").find('[name=id]').val($(this).attr('data-id'));
            $("#modal_add_times").find('[name=working_date]').val(working_date);
            $("#modal_add_times").find('[name=start_working_day]').val(start_working_day);
            $("#modal_add_times").find('[name=rest_time]').val(rest_time);
            $("#modal_add_times").find('[name=end_working_day]').val(end_working_day);
            $("#modal_add_times").modal('show');
        })

        $('#btn_reload').click(function () {
            //$('#frm_reload').submit();
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

})
$(document).ready(function () {
    TIME_TRACKERS.init();
    $('.datetimepicker').datetimepicker();
    $('.datepicker').datetimepicker({
        showClose: true,
        format: 'YYYY/MM/DD'
    });
    $('.timepicker').datetimepicker({ format: 'LT'});
});
