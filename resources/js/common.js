const common = {};
$(function () {
    'use strict';
    common.dateFormat = 'yy/mm/dd';

});

$(document).ready(function () {

});

window.common = {
    replaceUrlParam :  function (url, paramName, paramValue) {
        if (paramValue == null)
            paramValue = '';
        var pattern = new RegExp('\\b(' + paramName + '=).*?(&|$)')
        if (url.search(pattern) >= 0) {
            return url.replace(pattern, '$1' + paramValue + '$2');
        }
        return url + (url.indexOf('?') > 0 ? '&' : '?') + paramName + '=' + paramValue
    }
};


