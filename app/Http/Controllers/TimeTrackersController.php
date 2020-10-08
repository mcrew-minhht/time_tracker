<?php


namespace App\Http\Controllers;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use App\Models\TimeTrackers;
use Illuminate\Support\Facades\Auth;

class TimeTrackersController extends Controller
{
    public function index(){
        $data['list'] = TimeTrackers::all();
        //dd(Auth::user()->email);
        return view('time_trackers.index', $data);
    }

}
