<?php

if (!function_exists('format_date')) {

    function format_date($date, $format = 'd/m/Y') {
        if ($date) {
            return date_format(date_create($date),$format);
        }
        return "";
    }

}

/**
 * @return link sort title table
 * @ $name: fields table need sort
 * @ $title: string show header table
 * */
if (!function_exists('sort_title')) {

    function sort_title($name = '', $title = '') {
        if (Request::has('filter')) {
            return $title;
        }

        $base_url = Request::all();
        $base_url['sortfield'] = $name;
        $base_url['sorttype'] = "ASC";
        if (Request::has('page')) {
            $base_url['page'] = Request::get('page');
        }

        //sorting
        if (Request::has('sortfield') && Request::has('sorttype')) {
            $base_url['sortfield'] = $name;
            $base_url['sorttype'] = (Request::get('sorttype') == "ASC") ? "DESC" : "ASC";
        }

        $type_sort = Request::get('sorttype') == "ASC" ? '<i class="fas fa-sort-amount-up"></i>' : '<i class="fas fa-sort-amount-down"></i>';
        $link = "<a href=" . base_url($base_url) . ">" . (($name == Request::get('sortfield')) ? $type_sort : '') . " " . (($title != '') ? $title : $name) . "</a>";

        return $link;
    }

}

if (!function_exists('base_url')) {

    /**
     *
     * @param type $base_url
     * @return type
     */
    function base_url($base_url = array()) {
        $url = Request::url() . '?';
        foreach ($base_url as $key => $value) {
            $url .= $key . "=" . $value . "&";
        }
        //remove last '&'

        return rtrim($url, "&");
    }

}


if (!function_exists('convert_dmy_to_ymd')) {

    function convert_dmy_to_ymd($date) {
        if ($date) {
            $date_arr = explode('/',$date);
            $date_str = $date_arr[2].'/'.$date_arr[1].'/'.$date_arr[0];
            return $date_str;
        }
        return "";
    }

}

if (!function_exists('is_admin')) {
    function is_admin() {
        $user = Auth::user();
        if ($user->level == 1){
            return true;
        }
        return false;
    }
}
