const EMPLOYEE = {}
$(function (){
    'use strict';
    EMPLOYEE.init = function () {
        EMPLOYEE.display_list_employee_project();
    }

    EMPLOYEE.display_list_employee_project = function () {
        $('.fas-icon').on('click', function (e){
            let data_id = $(this).data('id');
            let is_request_ajax = EMPLOYEE.replace_icon(data_id)
            if(!is_request_ajax) return;
            $.ajax({
                type: "GET",
                url: '/employee/get_employee_of_project',
                data: {id : data_id},
                contentType: false,
                cache: false,
                processData: false,
                dataType: "json",
                success: function (res) {
                    $("tr[data-id='" + data_id + "']>td:first").append(res.view);
                },
            })
        })
    }

    EMPLOYEE.replace_icon = function(id){
       if($('.fas-'+id).hasClass('fa-plus')){
           $('.fas-'+id).addClass('fa-minus').removeClass('fa-plus');
           return true;
       }else {
           $('.fas-'+id).addClass('fa-plus').removeClass('fa-minus');
           console.log($("tr[data-id='" + id + "']>td:first").closest('group-employee-project'))
           $("tr[data-id='" + id + "']>td:first .group-employee-project").remove();
           return false;
       }
    }
})


function allowDrop(ev) {
    ev.preventDefault();
}

function drag(ev) {
    ev.dataTransfer.setData("text", ev.target.id);
}

function drop(ev) {
    ev.preventDefault();
    let data = ev.dataTransfer.getData("text");
    let el_droped =  ev.target.appendChild(document.getElementById(data));
    // if($(el_droped).length){
    //     $.ajax({
    //         type: "POST",
    //         url: '/project-employee/add_member_into_project',
    //         data: {id : data_id},
    //         contentType: false,
    //         cache: false,
    //         processData: false,
    //         dataType: "json",
    //         success: function (res) {
    //             $("tr[data-id='" + data_id + "']>td:first").append(res.view);
    //         },
    //     })
    // }
}

$(document).ready(function () {
    EMPLOYEE.init();
});

