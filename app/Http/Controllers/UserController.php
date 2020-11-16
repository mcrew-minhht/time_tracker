<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProjectRequest;
use App\Http\Requests\UserRequest;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function __construct()
    {
        $this->users = new User();
    }
    public function index(Request $request){
        $params = [
            'search' => isset($request->search) ? $request->search : "",
            'sortfield' => isset($request->sortfield) ? $request->sortfield : "id",
            'sorttype' => isset($request->sorttype) ? $request->sorttype : "DESC",
        ];
        $listUsers = $this->users->getAllUsers($params);
        $result = $listUsers->paginate(10);
        $data['lists'] = $result;
        return view('users.index', compact('data', $data));
    }

    public function create(){
        $users = new User();
        return view('users.create')->with('users',$users);
    }

    public function store(UserRequest $request){
        try {
            $params = $this->getParams($request);
            $result  = $this->users->insertUser($params);
            $response = [
                'message' => __('Create successfully')
            ];
            return redirect('users/create')->with(['message' => $response['message'], 'alert-class' => 'alert-success']);
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
        $users = $this->users->find($id);
        if(!$users){
            abort(404);
        }
        return view('users.edit')->with('users',$users);
    }


    public function update(UserRequest $request) {
        try {
            $params = $this->getParams($request);
            $id = $request['id'];
            $result  = $this->users->updateUser($params, $id);
            $response = [
                'message' => __('Update successfully')
            ];
            return redirect('users/edit/'.$id)->with(['message' => $response['message'], 'alert-class' => 'alert-success']);
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
        $result  = $this->users->deleteUser($arr_ids);
        $response = [
            'message' => __('Delete successfully')
        ];
        return redirect('users')->with(['message' => $response['message'], 'alert-class' => 'alert-success']);
    }
    public function getParams(Request $request){
        $params = [
            'name' => $request->name,
            'email' => $request->email,
            'employee_code' => $request->employee_code,
            'address' => $request->address,
            'birthdate' => convert_dmy_to_ymd($request->birthdate),
            'level' => $request->level ?? 0,
        ];
        if (empty($request->id) || (!empty($request->password) || !empty($request->password_confirmation))){
            $params['password']=Hash::make($request->password);
        }
        return $params;
    }
}
