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
            'sortfield' => isset($request->sortfield) ? $request->sortfield : "id",
            'sorttype' => isset($request->sorttype) ? $request->sorttype : "DESC",
        ];
        $listAllProject = $this->projectManagers->getAllProject($params);
        $result = $listAllProject->paginate(35);
        $data['lists'] = $result;
        return view('project_managers.index', compact('data', $data));
    }

    public function create(){
        $projectManagers = new ProjectManagers();
        return view('project_managers.create')->with('projectManagers',$projectManagers);
    }

    public function store(ProjectRequest $request){
        try {
            $params = $this->getParams($request);
            $result  = $this->projectManagers->insertProject($params);
            $response = [
                'message' => __('Create successfully')
            ];
            return redirect('project_managers/create')->with(['message' => $response['message'], 'alert-class' => 'alert-success']);
        } catch (ValidatorException $e) {
            if ($request->wantsJson()) {
                return response()->json([
                    'error' => true,
                    'message' => $e->getMessageBag()
                ]);
            }
            return redirect()->back()->withErrors($e->getMessageBag())->withInput();
        }
    }


    public function edit($id) {
        $projectManagers = $this->projectManagers->find($id);
        if(!$projectManagers){
            abort(404);
        }
        return view('project_managers.edit')->with('projectManagers',$projectManagers);
    }


    public function update(ProjectRequest $request) {
        try {
            $params = $this->getParams($request);
            $id = $request['id'];
            $result  = $this->projectManagers->updateProject($params, $id);
            $response = [
                'message' => __('Update successfully')
            ];
            return redirect('project_managers/edit/'.$id)->with(['message' => $response['message'], 'alert-class' => 'alert-success']);
        } catch (ValidatorException $e) {

            if ($request->wantsJson()) {

                return response()->json([
                    'error' => true,
                    'message' => $e->getMessageBag()
                ]);
            }

            return redirect()->back()->withErrors($e->getMessageBag())->withInput();
        }
    }
    public function destroy(Request $request){
        $ids = $request['id'];
        $arr_ids = explode(",", $ids);
        $result  = $this->projectManagers->deleteProject($arr_ids);
        $response = [
            'message' => __('Delete successfully')
        ];
        return redirect('project_managers')->with(['message' => $response['message'], 'alert-class' => 'alert-success']);
    }
    public function getParams(Request $request){
        $start_date_arr = explode('/',$request->start_date);
        $start_date_str = $start_date_arr[2].'/'.$start_date_arr[1].'/'.$start_date_arr[0];
        $end_date_str = null;
        if ($request->end_date!=null){
            $end_date_arr = explode('/',$request->end_date);
            $end_date_str = $end_date_str ?? $end_date_arr[2].'/'.$end_date_arr[1].'/'.$end_date_arr[0];
        }
        return [
            'name_project' => $request->name_project,
            'start_date' => $start_date_str,
            'end_date' => $end_date_str ?? null
        ];
    }

}
