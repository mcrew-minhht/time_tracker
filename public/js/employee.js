let TIME_TRACKERS = {};
let frm_search = $('meta[name=frm_search]').attr('content');
$(function () {
    'use strict';
    TIME_TRACKERS.init = function () {
        TIME_TRACKERS.searchTimes();

    }

    TIME_TRACKERS.searchTimes = function(){
        $('.btn_search').click(function () {
             $('#'+ frm_search).attr('target', '');
             $('#'+ frm_search).attr('action', '');
             $('#'+ frm_search).find('[name=action]').val('search');
             $('#'+ frm_search).submit();
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
