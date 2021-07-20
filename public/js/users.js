const USERS = {};
$(function () {
    'use strict';
    $(document).ready(function (){
        $("#export_users").on('click',function (){
            loading();
            $("#form-search").attr('target','_blank');
            $('#form-search').attr('action', './users/export_users');
            $('#form-search').submit();
            $("#form-search").attr('target','');
            $('#form-search').attr('action', './users');
            loaded();
        });

        $('#form-import').on('submit',function (){
            var file  = $('#file').val();
            var validExtensions = ['xlsx','xls'];
            var fileNameExt = file.substr(file.lastIndexOf('.') + 1);
            if (file==""){
                $('#file_error').text("The file field is required.");
                $('#file').addClass('is-invalid');
                return false;
            }else{
                if ($.inArray(fileNameExt, validExtensions) == -1){
                    $('#file_error').text("Invalid file type");
                    $('#file').addClass('is-invalid');
                    return false;
                }
            }
            $('#file_error').text("");
            $('#file').removeClass('is-invalid');
        });

    });
})



