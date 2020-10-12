let TIME_TRACKERS = {};

$(function () {
    'use strict';
    TIME_TRACKERS.init = function () {
        TIME_TRACKERS.Add_Project_User();
    }
    TIME_TRACKERS.Add_Project_User = function () {
        $('#add_project').click(function () {
            let formData = APP_TIMES.getFormData($('#add_project'));
            formData.append('_token',$('[name=_token]').val());
            formData.append('employee_code',$('[name=employee_code]').val());
            formData.append('id_project',$('[name=id_project]').val());
            APP_TIMES.postAjax(formData,'/time_trackers/add_project', function (res) {
                if(res.success == 1){
                    $("#msg_modal").html(APP_TIMES.alertSuccess(res.msg));
                }else{
                    $("#msg_modal").html(APP_TIMES.alertDanger(res.msg));
                }
            })
        })
    }


})
$(document).ready(function () {
    TIME_TRACKERS.init();
});
