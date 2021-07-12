<?php

namespace App\Http\Controllers;

use App\Models\ProjectManagers;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use App\Models\ProjectEmployee;

class ProjectEmployeeController extends Controller
{
    public function __construct()
    {
        $this->users = new User();
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
        $lists = $result;
        return view('employee.index', compact('lists'));
    }


    public function get_employee_of_project(Request $request)
    {
        $list_employees = $this->users->getEmployees();
        $view = view('employee.form.index')->with(['list_employees' => $list_employees]);
        $view = $view->render();
        return response()->json([
            'view' => $view
        ]);
    }

    public function add_member_into_project()
    {
       
    }


}
