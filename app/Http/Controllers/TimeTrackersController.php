<?php


namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Models\TimeTrackers;
use App\Models\User;
use App\Models\Projects;
use App\Models\ProjectTime;
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
        $this->project_time = new ProjectTime();
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


//        $employee_code = $request->employee_code;
//        $working_day = $request->working_day;
//        $working_time = $request->working_time;
//        $time_overtime = $request->time_overtime;
//        $time_off = $request->time_off;
//        $memo = $request->memo;
//        $id_project = $request->id_project;
//        $validator = Validator::make($request->all(), [
//            'time_trackers.*' => 'nullable|integer|max:24'
//        ]);
//        if ($validator->fails()) {
//            return redirect()->back()->withInput($request->all())->withErrors($validator);
//        } else {
//            for ($i = 0; $i < sizeof($working_day); $i++) {
//                $params = [
//                    'employee_code' => $employee_code,
//                    'id_project' => $id_project,
//                    'working_day' => $working_day[$i]
//                ];
//                $check_date = $this->time_trackers->CheckDateByParams($params);
//                if($check_date){
//                    $dataUpdate = [
//                        'working_time' => !empty($working_time[$i]) ? $working_time[$i] : null,
//                        'time_overtime' => !empty($time_overtime[$i]) ? $time_overtime[$i] : null,
//                        'time_off' => !empty($time_off[$i]) ? $time_off[$i] : null,
//                        'memo' => $memo[$i],
//                        'updated_user' => Auth::user()->id,
//                        'id' => $check_date->id,
//                    ];
//                    $this->time_trackers->updateByDateAndProject($dataUpdate);
//                }else{
//                    if(!empty($working_time[$i]) || !empty($time_overtime[$i]) || $time_off[$i]){
//                        $dataInsert = [
//                            'employee_code' => $employee_code,
//                            'id_project' => $id_project,
//                            'working_day' => $working_day[$i],
//                            'working_time' => !empty($working_time[$i]) ? $working_time[$i] : null,
//                            'time_overtime' => !empty($time_overtime[$i]) ? $time_overtime[$i] : null,
//                            'time_off' => !empty($time_off[$i]) ? $time_off[$i] : null,
//                            'memo' => $memo[$i],
//                            'created_user' => Auth::user()->id,
//                        ];
//                        $this->time_trackers->insertByDateAndProject($dataInsert);
//                    }
//                }
//
//            }
//            return redirect()->back()->withInput($request->all());
//        }


    }

    public function store(Request $request){
        $validator = Validator::make($request->all(), [
            'user_id' => 'required|numeric',
            'id_project' => 'required|numeric',
            'working_date' => 'required',
            'start_working_day' => 'required',
            'end_working_day' => 'required',
            'rest_time' => 'numeric',
        ]);
        if ($validator->fails()) {
            return $this->sendResponse(['errors' => $validator->errors()], 0);
        }
        $params = [
            'user_id' => $request->user_id,
            'working_date' => date('Y-m-d', strtotime($request->working_date))
        ];
        $check_project = $this->time_trackers->CheckProjectByParams($params);

        $dataInsert = [
            'user_id' => $request->user_id,
            'working_date' => !empty($request->working_date) ? date('Y-m-d', strtotime($request->working_date)) : null,
            'start_working_day' => !empty($request->start_working_day) ? date('Y-m-d', strtotime($request->start_working_day)) : null,
            'start_working_time' => !empty($request->start_working_day) ? date('H:i:s', strtotime($request->start_working_day)) : null,
            'end_working_day' => !empty($request->end_working_day) ? date('Y-m-d', strtotime($request->end_working_day)) : null,
            'end_working_time' => !empty($request->end_working_day) ? date('H:i:s', strtotime($request->end_working_day)) : null,
            'rest_time' => !empty($request->rest_time) ? $request->rest_time : null,
        ];
        if (empty($check_project)) {
            $id = $this->time_trackers->InsertTrackersByParams(array_merge($dataInsert, ['created_user' => Auth::user()->id,'created_at' => date('Y-m-d')]));
            // insert project_time
            $dataInsertProjectTime = [
                'id_time_tracker' => $id,
                'id_project' => $request->id_project
            ];
            $this->project_time->InsertProjectTimeByParams(array_merge($dataInsertProjectTime));
            $msg = 'Insert successful!';
            $success = 1;
        } else {
            $this->time_trackers->UpdateTrackersByParams(array_merge(['id' => $request->id],$dataInsert, ['updated_user' => Auth::user()->id,'updated_at' => date('Y-m-d'),]));
            $msg = 'Update successful!';
            $success = 1;
        }
        return $this->sendResponse(['msg' => $msg], $success);
    }

}
