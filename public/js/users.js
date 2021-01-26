const USERS = {};
$(function () {
    'use strict';
    $(document).ready(function (){
        $("#export_users").on('click',function (){
            $("#form-search").attr('target','_blank');
            $('#form-search').attr('action', './users/export_users');
            $('#form-search').submit();
            $("#form-search").attr('target','');
            $('#form-search').attr('action', './users');
        });
    });
})



