<?php


namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Carbon\CarbonPeriod;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use App\Http\Requests\TimeTrackersRequest;
use App\Models\TimeTrackers;
use App\Models\Projects;
use App\Models\ProjectTime;
use App\Models\User;
use PDF;

class StatisticalController extends Controller
{
    protected $validator;

    public function __construct()
    {
        $this->time_trackers = new TimeTrackers;
        $this->projects = new Projects();
        $this->employees = new User();
        $this->project_time = new ProjectTime();
    }

    public function index(Request $request)
    {
        dd('ggg');
    }

    public function statistical_project(Request $request)
    {
        $data['old'] = $request;
        $data['projects'] = $this->projects->get();
        $data['params'] = [
            'id_project' => isset($request->id_project) ? $request->id_project : '',
            'sortfield' => isset($request->sortfield) ? $request->sortfield : "id",
            'sorttype' => isset($request->sorttype) ? $request->sorttype : "DESC",
        ];
        $listTimeTrackers = $this->time_trackers->getAllByIdEmployee($data['params']);
        $result = $listTimeTrackers->paginate(5);
        $data['lists'] = $result;
        if(isset($request->id_project)){
            $data['project_info'] = $this->projects->find($request->id_project);
        }
        return view('statistical.project', $data);
    }

    public function statistical_month(Request $request)
    {
        $validator = '';
        if($request->action == 'search') {
            $validator = Validator::make($request->all(), [
                'month' => 'required',
                'year' => 'required',
            ]);
            if ($validator->fails()) {
                $data['errors'] = $validator->errors();
            }
        }

        $data['old'] = $request;
        $data['projects'] = $this->projects->get();
        $data['employees'] = $this->employees->getEmployees();
        $start_working_day = null;
        $end_working_day = null;
        if(!empty($request->year) && !empty($request->month)){
            $end = Carbon::parse($request->year.'-'.$request->month)->endOfMonth();
            $start_working_day = $request->year.'-'.$request->month.'-01';
            $end_working_day = isset($end) ? $end->format('Y-m-d') : null;
        }
        $data['params'] = [
            'user_id' => isset($request->user_id) ? intval($request->user_id) : '',
            'start_working_day' => $start_working_day,
            'end_working_day' => $end_working_day,
            'sortfield' => isset($request->sortfield) ? $request->sortfield : "working_date",
            'sorttype' => isset($request->sorttype) ? $request->sorttype : "ASC",
        ];
        $listTimeTrackers = $this->time_trackers->getAllByIdEmployee($data['params']);
        $result = $listTimeTrackers->paginate(5);
        $data['lists'] = $result;
        return view('statistical.month', $data)->withErrors($validator);
    }
    public function pdf_project(Request $request){
        $data['params'] = [
            'id_project' => isset($request->id_project) ? $request->id_project : '',
            'sortfield' => isset($request->sortfield) ? $request->sortfield : "id",
            'sorttype' => isset($request->sorttype) ? $request->sorttype : "DESC",
        ];
        $listTimeTrackers = $this->time_trackers->getAllByIdEmployee($data['params']);
        if($request->get('all') != 1){
            $result = $listTimeTrackers->paginate(5);
            $data['lists'] = $result;
        }else{
            $data['lists'] = $listTimeTrackers->get();
        }

        $pdf = PDF::loadView('statistical.pdf_project', $data);
        return $pdf->download('static_with_project.pdf');
    }

    public function pdf_month(Request $request){
        
        $data['request'] = $request->all();
        $data['time_trackers'] = $this->time_trackers;
        $start_working_day = (isset($request->year) && isset($request->month)) ? $request->year.'-'.$request->month.'-01' : null;
        $data['params'] = [
            'user_id' => isset($request->user_id) ? intval($request->user_id) : '',
            'start_working_day' => $start_working_day,
        ];
        $data['user_id'] = $data['params']['user_id'];
        if(isset($request->user_id) && $request->user_id != null){
            $month = (isset($request->year) && isset($request->month)) ? $request->year.'-'.$request->month : date('Y-m');
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
            $pdf = PDF::loadView('statistical.pdf_month_user', $data);
        }else{
            $data['lists'] = $this->time_trackers->getExport($data['params']);
            $pdf = PDF::loadView('statistical.pdf_project', $data);
        }
        return $pdf->stream();

    }
}
