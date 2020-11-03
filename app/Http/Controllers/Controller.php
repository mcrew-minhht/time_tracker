<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;
    public function sendResponse($data = [], $success = 1)
    {
        $data['token'] = csrf_token();
        $data['success'] = $success;

        return response(json_encode($data))
            ->header('Content-Type', 'application/json')
            ->header('X-Header-One', 'Header Value')
            ->header('X-Header-Two', 'Header Value');
    }
}
