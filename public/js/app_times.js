const APP_TIMES = {};
$(function () {
    'use strict';
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


    APP_TIMES.validate = function (res, elmForm, cl = '.form-group', scroll = true) {
        let name, type, elms = elmForm.find('input, select, textarea'), elmMsg = $('#msg'),
            msg = $('meta[name=msg_input_error]').attr('content');
        msg = (typeof msg !== 'undefined') ? msg : '';
        elmForm.find('p.error').remove();
        if (typeof res.errors !== 'undefined') {
            $.each(elms, function (index, elm) {
                name = $(elm).attr('name');
                type = $(elm)[0].localName;
                if (typeof res.errors[name] !== 'undefined') {
                    APP_TIMES.addErrorMsg(cl, elmForm.find(type + "[name='" + name + "']"), res.errors[name]);
                } else {
                    // group input
                    let elms2 = $(elm).closest(cl).find('input, select'), del = true;
                    $.each(elms2, function (i, e) {
                        if (typeof res.errors[$(e).attr('name')] !== 'undefined') {
                            del = false;
                            if (scroll) {
                                $('#msg').html(APP_TIMES.alertDanger(msg));
                                APP_TIMES.scrollTop(elmMsg);
                            }
                            return false;
                        }
                    });

                    if (del) {
                        APP_TIMES.delErrorMsg(cl, type + "[name='" + name + "']");
                    }
                }
            });
            $(".has-error.text-danger").each(function () {
                if ($(this).find("p.error").length > 1) {
                    $(this).addClass('error-group');
                } else {
                    $(this).removeClass('error-group');
                }
            })
            if (scroll) {
                $('#msg').html(APP_TIMES.alertDanger(msg));
                APP_TIMES.scrollTop(elmMsg);
            }
            return false;
        }
        $.each(elms, function (index, elm) {
            name = $(elm).attr('name');
            type = $(elm)[0].localName;
            APP_TIMES.delErrorMsg(cl, type + "[name='" + name + "']");
        });

        return true;
    };

    APP_TIMES.addErrorMsg = function (clElm, current, msg) {
        let elmName = $(current).attr('name').replace('[]', '');
        let elmInput = 'error_' + elmName;
       ;
        $(current).addClass('is-invalid');
        (current).closest(clElm).find('label.col-form-label').addClass('text-danger');
        let e = $(current).closest(clElm).find('div#' + elmInput);
        if (e.length) {
            e.html(msg);
        } else {
            $(current).closest(clElm).append("<div class='errors col-sm-12' id='" + elmInput + "'><div class='invalid-feedback d-block'>" + msg + "</div></div>");
        }

    };
    APP_TIMES.delErrorMsg = function (clElm, current) {

        $(current).closest(clElm).find('label.col-form-label').removeClass('text-danger');
        $(current).removeClass('is-invalid');
        $(current).closest(clElm).find('div.errors').remove();
    };
    APP_TIMES.alertDanger = function (msg) {
        return '<div class="alert alert-danger">' +
            '<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>' +
            '<h4 class="single-text"><i class="icon fa fa-ban"></i> ' + msg + '</h4></div>';
    };
    APP_TIMES.alertSuccess = function (msg) {
        return '<div class="alert alert-success">' +
            '<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>' +
            '<h4 class="single-text"><i class="icon fa fa-check"></i> ' + msg + '</h4></div>';
    };

    APP_TIMES.scrollTop = function (elm) {
        $("html, body").animate({scrollTop: elm.offset().top}, 300);
    };
})



