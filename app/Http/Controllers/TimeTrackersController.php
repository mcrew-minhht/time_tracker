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
        $data['params'] = [
            'user_id' => isset($request->user_id) ? intval($request->user_id) : '',
            'id_project' => isset($request->id_project) ? $request->id_project : '',
            'start_working_day' => isset($request->start_working_day) ? format_date(str_replace('/','-',$request->start_working_day),"Y-m-d") : '',
            'end_working_day' => isset($request->end_working_day) ? format_date(str_replace('/','-',$request->end_working_day),"Y-m-d") : '',
            'sortfield' => isset($request->sortfield) ? $request->sortfield : "working_date",
            'sorttype' => isset($request->sorttype) ? $request->sorttype : "ASC",
        ];
        $listTimeTrackers = $this->time_trackers->getAllByIdEmployee($data['params']);
        $result = $listTimeTrackers->paginate(5);
        $data['lists'] = $result;
        if($is_admin == true){
            $data['employees'] = $this->employees->getEmployees();
        }else{
            $data['employees'] = DB::table('users')->where('id' ,'=', 2)->get();;
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
        $data['params'] = [
            'user_id' => isset($request->user_id) ? intval($request->user_id) : '',
            'id_project' => isset($request->id_project) ? $request->id_project : '',
            'start_working_day' => isset($request->start_working_day) ? format_date(str_replace('/','-',$request->start_working_day),"Y-m-d") : '',
            'end_working_day' => isset($request->end_working_day) ? format_date(str_replace('/','-',$request->end_working_day),"Y-m-d") : '',
        ];
        $data['lists'] = $this->time_trackers->getExport($data['params']);
        $pdf = PDF::loadView('time_trackers.pdf', $data);

        //return $pdf->download('time_tracker_'.time().'.pdf');
        //$pdf = \App::make('dompdf.wrapper');
        //$pdf->loadHTML($this->convert_customer_data_to_html());
        return $pdf->stream();
    }

}
