<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ProjectManagers;
use Illuminate\Support\Facades\Auth;

class ProjectManagersController extends Controller
{
    public function index(){
        $data['lists'] = ProjectManagers::all();
        return view('project_managers.index', compact('data', $data));
    }
}
