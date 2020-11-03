<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProjectRequest;
use Illuminate\Http\Request;
use App\Models\ProjectManagers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class ProjectManagersController extends Controller
{
    public function __construct()
    {
        $this->projectManagers = new ProjectManagers();
    }
    public function index(Request $request){
        $params = [
            'search' => isset($request->search) ? $request->search : "",
            'sortfield' => isset($request->sortfield) ? $request->sortfield : "",
            'sorttype' => isset($request->sorttype) ? $request->sorttype : "",
        ];
        $listAllProject = $this->projectManagers->getAllProject($params);
        $result = $listAllProject->paginate(10);
        $data['lists'] = $result;
        return view('project_managers.index', compact('data', $data));
    }

    public function create(){
        return view('project_managers.create');
    }

    public function store(ProjectRequest $request){
        $params = $this->getParams($request);
        $result  = $this->projectManagers->insertProject($params);
        $response = [
            'message' => __('Create successfully')
        ];
        return redirect('project_managers/create')->with(['message' => $response['message'], 'alert-class' => 'alert-success']);
    }

    public function getParams(Request $request){
        return [
            'name_project' => $request->input_name,
            'start_date' => $request->input_start_date,
            'end_date' => $request->input_end_date
        ];
    }

}
