<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ProjectManagers;
use Illuminate\Support\Facades\Auth;

class ProjectManagersController extends Controller
{
    public function index(){
        $projectManagers = new ProjectManagers();
        $data['lists'] = $projectManagers->getAllProject();
        $data['total'] = $projectManagers->getTotal();
        return view('project_managers.index', compact('data', $data));
    }
}
