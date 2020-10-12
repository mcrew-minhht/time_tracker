<?php


namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Models\TimeTrackers;
use App\Models\User;
use App\Models\Projects;
use Carbon\Carbon;
use Carbon\CarbonPeriod;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class TimeTrackersController extends Controller
{
    protected $validator;

    public function __construct()
    {
        $this->time_trackers = new TimeTrackers;
        $this->employees = new User();
        $this->projects = new Projects();
    }

    public function index()
    {
        $data['list'] = $this->time_trackers->getAllByIdEmployee();
        $data['employees'] = $this->employees->getEmployees();
        $data['projects'] = $this->projects->get();
        return view('time_trackers.index', $data);
    }


    public function show($id, $id_project, $employee_code)
    {
        $time = explode('-', $id);
        $data['id'] = $id;
        $data['id_project'] = $id_project;
        $data['employee_code'] = $employee_code;
        $data['time_trackers'] = $this->time_trackers;
        $month = $time[1] . '-' . $time[0];
        $start = Carbon::parse($month)->startOfMonth();
        $end = Carbon::parse($month)->endOfMonth();
        $data['period'] = CarbonPeriod::create($start, $end);
        $data['weekMap'] = [
            0 => '日',
            1 => '月',
            2 => '火',
            3 => '水',
            4 => '木',
            5 => '金',
            6 => '土',
        ];
        return view('time_trackers.update', $data);
    }

    public function update($id, Request $request)
    {
        $employee_code = $request->employee_code;
        $working_day = $request->working_day;
        $working_time = $request->working_time;
        $memo = $request->memo;
        $id_project = $request->id_project;
        $validator = Validator::make($request->all(), [
            'working_time.*' => 'nullable|integer|max:24'
        ]);
        if ($validator->fails()) {
            return redirect()->back()->withInput($request->all())->withErrors($validator);
        } else {
            for ($i = 0; $i < sizeof($working_day); $i++) {
                $params = [
                    'employee_code' => $employee_code,
                    'id_project' => $id_project,
                    'working_day' => $working_day[$i]
                ];
                $check_date = $this->time_trackers->CheckDateByParams($params);
                if($check_date){
                    $dataUpdate = [
                        'working_time' => !empty($working_time[$i]) ? $working_time[$i] : null,
                        'memo' => $memo[$i],
                        'updated_user' => Auth::user()->id,
                        'id' => $check_date->id,
                    ];
                    $this->time_trackers->updateByDateAndProject($dataUpdate);
                }else{
                    if(!empty($working_time[$i])){
                        $dataInsert = [
                            'employee_code' => $employee_code,
                            'id_project' => $id_project,
                            'working_day' => $working_day[$i],
                            'working_time' => !empty($working_time[$i]) ? $working_time[$i] : null,
                            'memo' => $memo[$i],
                            'created_user' => Auth::user()->id,
                        ];
                        $this->time_trackers->insertByDateAndProject($dataInsert);
                    }
                }

            }
            return redirect()->back()->withInput($request->all());
        }


    }

    public function store(Request $request){
        $params = [
            'employee_code' => $request->employee_code,
            'id_project' => $request->id_project,
            'working_day' => date_format(now(),'Y-m')
        ];
        $check_project = $this->time_trackers->CheckProjectByParams($params);
        $msg = '';
        if(empty($check_project)){
            $dataInsert = [
                'employee_code' => $request->employee_code,
                'id_project' => $request->id_project,
            ];
            $this->time_trackers->InsertProjectByParams($dataInsert);
            $msg = 'Insert successful!';
            $success = 1;
        }else{
            $msg = 'Exits Project in DB';
            $success = 0;
        }
        return response()->json([
            'msg' => $msg,
            'success' => $success,
        ]);
    }

}
