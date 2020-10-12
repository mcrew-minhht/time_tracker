const APP_TIMES = {};
$(function () {
    'use strict';
    APP_TIMES.init = function () {
        APP_TIMES.Open_Modal();
    }
    APP_TIMES.getFormData = function (elmForm) {
        let formData = new FormData();
        let arr = elmForm.serializeArray();
        for (let i = 0; i < arr.length; i++) {
            formData.append(arr[i].name, arr[i].value);
        }
        return formData;
    };
    APP_TIMES.postAjax = function (formData, url, callback) {
        $.ajax({
            type: "POST",
            url: url,
            data: formData,
            contentType: false,
            cache: false,
            processData: false,
            dataType: "json",
            beforeSend: function () {
            },
            success: callback,
            error: function (jqXHR, textStatus, errorMessage) {
            }

        });
    };

    APP_TIMES.alertDanger = function (msg) {
        return '<div class="alert alert-danger">' +
            '<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>' +
            '<h4 class="single-text"><i class="icon fa fa-ban"></i> ' + msg + '</h4></div>';
    };

    /**
     * @param msg
     * @returns {string}
     */
    APP_TIMES.alertSuccess = function (msg) {
        return '<div class="alert alert-success">' +
            '<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>' +
            '<h4 class="single-text"><i class="icon fa fa-check"></i> ' + msg + '</h4></div>';
    };

    APP_TIMES.Open_Modal = function () {
        var openmodal = document.querySelectorAll('.modal-open')
        for (var i = 0; i < openmodal.length; i++) {
            openmodal[i].addEventListener('click', function(event){
                event.preventDefault()
                toggleModal()
            })
        }

        const overlay = document.querySelector('.modal-overlay')
        overlay.addEventListener('click', toggleModal)

        var closemodal = document.querySelectorAll('.modal-close')
        for (var i = 0; i < closemodal.length; i++) {
            closemodal[i].addEventListener('click', toggleModal)
        }

        document.onkeydown = function(evt) {
            evt = evt || window.event
            var isEscape = false
            if ("key" in evt) {
                isEscape = (evt.key === "Escape" || evt.key === "Esc")
            } else {
                isEscape = (evt.keyCode === 27)
            }
            if (isEscape && document.body.classList.contains('modal-active')) {
                toggleModal()
            }
        };


        function toggleModal () {
            const body = document.querySelector('body')
            const modal = document.querySelector('.modal')
            modal.classList.toggle('opacity-0')
            modal.classList.toggle('pointer-events-none')
            body.classList.toggle('modal-active')
        }
    }

})

$(document).ready(function () {
    APP_TIMES.init();
});


