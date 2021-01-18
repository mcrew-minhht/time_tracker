<?php


namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Models\TimeTrackers;
use App\Models\User;
use App\Models\Projects;
use App\Models\ProjectTime;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use App\Http\Requests\TimeTrackersRequest;
use App\Rules\FromToDateCheck;
use PDF;
use Carbon\Carbon;
use Carbon\CarbonPeriod;

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
        $is_admin = (Auth::user()->level == 1) ? true : false;
        if($request->action == 'search'){
            $validator = Validator::make($request->all(), [
                'end_working_day' => [
                    new FromToDateCheck($request)
                ],
            ]);

            if ($validator->fails()) {
                $data['errors'] = $validator->errors();
            }
        }
        $data['request'] = $request;
        $end_working_day = (!empty($request->month) && !empty($request->year))?Carbon::parse($request->year.'-'.$request->month)->endOfMonth()->format('Y-m-d') : ($is_admin == false ? Carbon::parse(date('Y-m'))->endOfMonth()->format('Y-m-d') : '');
        $data['params'] = [
            'user_id' => isset($request->user_id) ? intval($request->user_id) : ($is_admin == false ? Auth::id() : ''),
            'id_project' => isset($request->id_project) ? $request->id_project : '',
            'start_working_day' => (!empty($request->year) && !empty($request->month)) ? $request->year.'-'.$request->month.'-01' : ($is_admin == false ? date('Y-m').'-01' : ''),
            'end_working_day' => $end_working_day,
            'year' => (!empty($request->year))? $request->year : date('Y'),
            'month' => (!empty($request->month))? $request->month : date('m'),
            'sortfield' => isset($request->sortfield) ? $request->sortfield : "working_date",
            'sorttype' => isset($request->sorttype) ? $request->sorttype : "ASC",
        ];
        $request->session()->put('time_trackers_search_params', $data['params']);
        $listTimeTrackers = $this->time_trackers->getAllByIdEmployee($data['params']);
        $result = $listTimeTrackers->paginate(5);
        $data['lists'] = $result;
        if($is_admin == true){
            $data['employees'] = $this->employees->getEmployees();
        }else{
            $id_employee = Auth::id();
            $data['employees'] = DB::table('users')->where('id' ,'=', $id_employee)->where('id' ,'=', $id_employee)->get();;
        }
        $data['projects'] = $this->projects->get();
        return view('time_trackers.index', $data);
    }

    public function store(TimeTrackersRequest $request){
        $start = explode('/', $request->start_working_day);
        if (empty($request->id)) {
            if (!empty($request->end_working_day)) {
                $end = explode('/', $request->end_working_day);
                for ($i = $start[0]; $i <= $end[0]; $i++) {
                    $dataInsert = [
                        'user_id' => $request->user_id,
                        'working_date' => $start[2] . '/' . $start[1] . '/' . $i,
                        'working_time' => !empty($request->working_time) ? $request->working_time : null,
                    ];
                    $params = [
                        'user_id' => $request->user_id,
                        'working_date' => $start[2] . '/' . $start[1] . '/' . $i,
                        'id_project' => $request->id_project
                    ];
                    $check_project = $this->time_trackers->CheckProjectByParams($params);
                    if(isset($check_project)) {
                        $this->time_trackers->UpdateTrackersByParams(array_merge(['id' => $check_project->id],$dataInsert, ['updated_user' => Auth::user()->id,'updated_at' => date('Y-m-d'),]));
                    }else{
                        $id = $this->time_trackers->InsertTrackersByParams(array_merge($dataInsert, ['created_user' => Auth::user()->id, 'created_at' => date('Y-m-d')]));
                        $dataInsertProjectTime = [
                            'id_time_tracker' => $id,
                            'id_project' => $request->id_project
                        ];
                        $this->project_time->InsertProjectTimeByParams(array_merge($dataInsertProjectTime));
                    }
                }
            } else {
                $dataInsert = [
                    'user_id' => $request->user_id,
                    'working_date' => format_date(str_replace('/','-',$request->start_working_day),"Y-m-d"),
                    'working_time' => !empty($request->working_time) ? $request->working_time : null,
                ];
                $params = [
                    'user_id' => $request->user_id,
                    'working_date' => format_date(str_replace('/','-',$request->start_working_day),"Y-m-d"),
                    'id_project' => $request->id_project
                ];
                $check_project = $this->time_trackers->CheckProjectByParams($params);
                if(isset($check_project)) {
                    $this->time_trackers->UpdateTrackersByParams(array_merge(['id' => $check_project->id],$dataInsert, ['updated_user' => Auth::user()->id,'updated_at' => date('Y-m-d'),]));
                }else {
                    $id = $this->time_trackers->InsertTrackersByParams(array_merge($dataInsert, ['created_user' => Auth::user()->id, 'created_at' => date('Y-m-d')]));
                    $dataInsertProjectTime = [
                        'id_time_tracker' => $id,
                        'id_project' => $request->id_project
                    ];
                    $this->project_time->InsertProjectTimeByParams(array_merge($dataInsertProjectTime));
                }
            }
            $msg = 'Insert successful!';
            $success = 1;
            $valid = 1;
        } else {
            $dataUpdate = [
                'id' => $request->id,
                'working_time' => !empty($request->working_time) ? $request->working_time : null,
                'updated_user' => Auth::user()->id,
                'updated_at' => date('Y-m-d')
            ];
            $this->time_trackers->UpdateTrackersByParams($dataUpdate);
            $msg = 'Update successful!';
            $success = 1;
            $valid = 0;
        }
        return $this->sendResponse(['msg' => $msg,'valid' => $valid], $success);
    }

    public function destroy(Request $request){
        DB::table('time_trackers')->where('id', $request->id)->update(['is_delete' => 1]);
        return $this->sendResponse(['msg' => 'Del successful!'], 1);
    }

    public function time_trackers_pdf(Request $request){
        $params = null;
        if($request->session()->has('time_trackers_search_params')){
            $params = $request->session()->get('time_trackers_search_params');
        }

        $data['request'] = $params;
        $data['user_id'] = $params['user_id'];
        $data['time_trackers'] = $this->time_trackers;
        $month = (isset($params['year']) && isset($params['month'])) ? $params['year'].'-'.$params['month'] : date('Y-m');
        $start = Carbon::parse($month)->startOfMonth();
        $end = Carbon::parse($month)->endOfMonth();
        $data['period'] = CarbonPeriod::create($start, $end);
        $data['weekMap'] = [
            0 => 'Sunday',
            1 => 'Monday',
            2 => 'Tuesday',
            3 => 'Wednesday',
            4 => 'Thursday',
            5 => 'Friday',
            6 => 'Saturday',
        ];
        $data['info'] = $this->time_trackers->CheckDateByParams(['user_id' => $data['user_id']]);
        $pdf = PDF::loadView('time_trackers.pdf_month_user', $data);
        return $pdf->stream();
    }

}
