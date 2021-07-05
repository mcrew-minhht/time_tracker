<?php

namespace App\Http\Controllers;

use App\Http\Requests\DevicesRequest;
use App\Models\User;
use Illuminate\Http\Request;
use App\Models\Devices;
use Illuminate\Support\Facades\Auth;

class DevicesController extends Controller
{
    protected $devices;
    protected $employees;
    public function __construct()
    {
        $this->devices = new Devices();
        $this->employees = new User();
    }
    public function index(Request $request){
        $params = [
            'search' => isset($request->search) ? $request->search : "",
            'user_id' => isset($request->user_id) ? $request->user_id : "",
            'sortfield' => isset($request->sortfield) ? $request->sortfield : "id",
            'sorttype' => isset($request->sorttype) ? $request->sorttype : "DESC",
        ];

        $listAllDevice = $this->devices->getAllDevice($params);
        $result = $listAllDevice->paginate(35);
        $data['lists'] = $result;
        $data['employees'] = $this->employees->getEmployees();
        return view('devices.index', compact('data', $data));
    }

    public function create(){
        $devices = new devices();
        $data['employees'] = $this->employees->getEmployees();
        $data['devices'] = $devices;
        return view('devices.create')->with($data);
    }

    public function store(DevicesRequest $request){
        try {
            $params = $this->getParams($request);
            $invoice = $request->file('invoice');
            $uniquesavename = time().uniqid(rand()) .'.'. $invoice->getClientOriginalExtension();
            $invoice->storeAs('images', $uniquesavename, 'local');
            $params['invoice'] = $uniquesavename;
            $result  = $this->devices->insertDevice($params);
            $response = [
                'message' => __('Create successfully')
            ];
            return redirect('devices/create')->with(['message' => $response['message'], 'alert-class' => 'alert-success']);
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
        $devices = $this->devices->find($id);
        if(!$devices){
            abort(404);
        }
        $data['employees'] = $this->employees->getEmployees();
        $data['devices'] = $devices;
        return view('devices.edit')->with($data);
    }


    public function update(DevicesRequest $request) {
        try {
            $params = $this->getParams($request);
            $id = $request['id'];
            $devices = $this->devices->find($id);
            $invoice = $request->file('invoice');
            if(!empty($invoice)) {
                if(!empty($devices->invoice)) {
                    $path = storage_path().'/'.'app'.'/images/'.$devices->invoice;
                    unlink($path);
                }

                $uniquesavename = time().uniqid(rand()) .'.'. $invoice->getClientOriginalExtension();
                $invoice->storeAs('images', $uniquesavename, 'local');
                $params['invoice'] = $uniquesavename;
            }


            $result  = $this->devices->updateDevice($params, $id);
            $response = [
                'message' => __('Update successfully')
            ];
            return redirect('devices/edit/'.$id)->with(['message' => $response['message'], 'alert-class' => 'alert-success']);
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
        foreach ($arr_ids as $id) {
            $devices = $this->devices->find($id);
            if(!empty($devices->invoice)) {
                $path = storage_path().'/'.'app'.'/images/'.$devices->invoice;
                unlink($path);
            }
        }

        $result  = $this->devices->deleteDevice($arr_ids);
        $response = [
            'message' => __('Delete successfully')
        ];
        return redirect('devices')->with(['message' => $response['message'], 'alert-class' => 'alert-success']);
    }
    public function getParams(Request $request){
        return [
            'name' => $request->name,
            'user_id' => $request->user_id,
            'description' => $request->description
        ];
    }

    public function invoice($id) {
        $devices = $this->devices->find($id);
        $path = storage_path().'/'.'app'.'/images/'.$devices->invoice;
        if (file_exists($path)) {
            return response()->download($path);
        }
    }
}
