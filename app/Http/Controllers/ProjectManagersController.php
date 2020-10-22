<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ProjectManagers;
use Illuminate\Support\Facades\Auth;

class ProjectManagersController extends Controller
{
    public function index(Request $request){
        $projectManagers = new ProjectManagers();
        $params = [
            'search' => isset($request->search) ? $request->search : "",
            'sortfield' => isset($request->sortfield) ? $request->sortfield : "",
            'sorttype' => isset($request->sorttype) ? $request->sorttype : "",
        ];
        $listAllProject = $projectManagers->getAllProject($params);
        $result = $listAllProject->paginate(10);
        $data['lists'] = $result;
        return view('project_managers.index', compact('data', $data));
    }
}
