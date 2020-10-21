<?php

if (!function_exists('format_date')) {

    function format_date($date, $format = 'Y/m/d') {
        if ($date) {
            return date_format(date_create($date),$format);
        }
        return "";
    }

}
