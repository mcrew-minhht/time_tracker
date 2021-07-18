<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProjectRequest;
use App\Http\Requests\UserRequest;
use App\Imports\UsersImport;
use App\Models\UserType;
use Carbon\Carbon;
use Carbon\CarbonPeriod;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Facades\Excel;
use PDF;
use function GuzzleHttp\Promise\all;

class UserController extends Controller
{
    public function __construct()
    {
        $this->users = new User();
        $this->user_type = new UserType();
    }
    public function index(Request $request){
        $params = [
            'username' => isset($request->username) ? $request->username : "",
            'region' => isset($request->region) ? $request->region : "",
            'part_time' => isset($request->part_time) ? $request->part_time : "",
            'sortfield' => isset($request->sortfield) ? $request->sortfield : "id",
            'sorttype' => isset($request->sorttype) ? $request->sorttype : "DESC",
        ];
        $listUsers = $this->users->getAllUsers($params);
        $result = $listUsers->paginate(35);
        $data['lists'] = $result;
        return view('users.index', compact('data', $data));
    }

    public function create(){
        $users = new User();
        $userType = $this->user_type->pluck('name','id')->all();

        return view('users.create')->with(['users' => $users, 'userType' => $userType]);
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
        $userType = $this->user_type->pluck('name','id')->all();
        return view('users.edit')->with(['users' => $users, 'userType' => $userType]);
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
            'name' => $request->name ?? null,
            'email' => $request->email ?? null,
            'address' => $request->address,
            'birthdate' => !empty(convert_dmy_to_ymd($request->birthdate)) ? convert_dmy_to_ymd($request->birthdate) :  null,
            'region' => $request->region ?? null,
            'part_time' => $request->part_time ?? 0,
            'level' => $request->level ?? 0,
        ];
        if (empty($request->id) || (!empty($request->password) || !empty($request->password_confirmation))){
            $params['password']=Hash::make($request->password);
        }
        return $params;
    }
    public function export_users(Request $request){
        $params = [
            'username' => isset($request->username) ? $request->username : "",
            'region' => isset($request->region) ? $request->region : "",
            'part_time' => isset($request->part_time) ? $request->part_time : "",
            'sortfield' => isset($request->sortfield) ? $request->sortfield : "id",
            'sorttype' => isset($request->sorttype) ? $request->sorttype : "DESC",
        ];
        $listUsers = $this->users->getAllUsers($params);
        $result = $listUsers->get();
        $data['lists'] = $result;
        $pdf = PDF::loadView('users.export_user_pdf', $data);
        return $pdf->stream();
    }
    public function import_users(Request $request)
    {
        try {
            $import = Excel::import(new UsersImport(), $request->file('file')->store('temp'));
            $response = [
                'message' => __('Import successfully')
            ];
            return redirect()->back()->with(['message' => $response['message'], 'alert-class' => 'alert-success']);
        } catch (\Maatwebsite\Excel\Validators\ValidationException $e) {
            $failures = $e->failures();
            return redirect()->back()->with('failures',$failures);
        }
        return redirect()->back();
    }

    public function get_download()
    {
        $file= public_path(). "/downloads/file_import.xlsx";
        $headers = array(
            'Content-Type: application/xlsx',
        );
        return response()->download($file, 'file_import.xlsx', $headers);
    }
}
