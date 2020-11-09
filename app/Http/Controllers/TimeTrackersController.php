<?php


namespace App\Http\Controllers;

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
use App\Http\Requests\TimeTrackersRequest;
use App\Rules\FromToDateCheck;

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

    public function index(Request $request)
    {
        if($request->action == 'search'){
//            $validator = Validator::make($request->all(), [
//                'end_working_day' => [
//                    new FromToDateCheck($request)
//                ],
//            ]);
//            if ($validator->fails()) {
//                $data['errors'] = $validator->errors();
//            }else{
//                $data['errors'] = [];
//            }
        }
        $data['params'] = [
            'user_id' => isset($request->user_id) ? intval($request->user_id) : '',
            'id_project' => isset($request->id_project) ? $request->id_project : '',
            'working_date' => isset($request->working_date) ? $request->working_date : '',
            'start_working_day' => isset($request->start_working_day) ? $request->start_working_day : '',
            'end_working_day' => isset($request->end_working_day) ? $request->end_working_day : '',
            'sortfield' => isset($request->sortfield) ? $request->sortfield : "id",
            'sorttype' => isset($request->sorttype) ? $request->sorttype : "DESC",
        ];
        $listTimeTrackers = $this->time_trackers->getAllByIdEmployee($data['params']);
        $result = $listTimeTrackers->paginate(5);
        $data['lists'] = $result;
        $data['employees'] = $this->employees->getEmployees();
        $data['projects'] = $this->projects->get();
        return view('time_trackers.index', $data);
    }

    public function search(Request $request){
        $validator = Validator::make($request->all(), [
            'working_date' => 'required',
        ]);
        if ($validator->fails()) {
            $request->session()->flash('message', 'Task was successful!');
        }
        $data['params'] = [
            'user_id' => isset($request->user_id) ? intval($request->user_id) : '',
            'id_project' => isset($request->id_project) ? $request->id_project : '',
            'working_date' => isset($request->working_date) ? $request->working_date : '',
            'start_working_day' => isset($request->start_working_day) ? $request->start_working_day : '',
            'end_working_day' => isset($request->end_working_day) ? $request->end_working_day : '',
            'sortfield' => isset($request->sortfield) ? $request->sortfield : "id",
            'sorttype' => isset($request->sorttype) ? $request->sorttype : "DESC",
        ];
        $listTimeTrackers = $this->time_trackers->getAllByIdEmployee($data['params']);
        $result = $listTimeTrackers->paginate(5);
        $data['lists'] = $result;
        return $data;
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

    public function store(TimeTrackersRequest $request){
        $dataInsert = [
            'user_id' => $request->user_id,
            'working_date' => !empty($request->working_date) ? date('Y-m-d', strtotime($request->working_date)) : null,
            'start_working_day' => !empty($request->start_working_day) ? date('Y-m-d', strtotime($request->start_working_day)) : null,
            'start_working_time' => !empty($request->start_working_time) ? date("H:i:s", strtotime($request->start_working_time)) : null,
            'end_working_day' => !empty($request->end_working_day) ? date('Y-m-d', strtotime($request->end_working_day)) : null,
            'end_working_time' => !empty($request->end_working_time) ? date("H:i:s", strtotime($request->end_working_time)) : null,
            'rest_time' => !empty($request->rest_time) ? $request->rest_time : null,
        ];
        if (empty($request->id)) {
            $params = [
                'user_id' => $request->user_id,
                'working_date' => date('Y-m-d', strtotime($request->working_date))
            ];
            $check_project = $this->time_trackers->CheckProjectByParams($params);

            if(empty($check_project)){
                $id = $this->time_trackers->InsertTrackersByParams(array_merge($dataInsert, ['created_user' => Auth::user()->id,'created_at' => date('Y-m-d')]));
                // insert project_time
                $dataInsertProjectTime = [
                    'id_time_tracker' => $id,
                    'id_project' => $request->id_project
                ];
                $this->project_time->InsertProjectTimeByParams(array_merge($dataInsertProjectTime));
                $msg = 'Insert successful!';
                $success = 1;
            }else{
                $msg = 'Exits DB';
                $success = 0;
            }
        } else {
            $this->time_trackers->UpdateTrackersByParams(array_merge(['id' => $request->id],$dataInsert, ['updated_user' => Auth::user()->id,'updated_at' => date('Y-m-d'),]));
            $msg = 'Update successful!';
            $success = 1;
        }
        return $this->sendResponse(['msg' => $msg], $success);
    }

    public function destroy(Request $request){
        DB::table('time_trackers')->where('id', $request->id)->update(['is_delete' => 1]);
        return $this->sendResponse(['msg' => 'Del successful!'], 1);
    }

}
