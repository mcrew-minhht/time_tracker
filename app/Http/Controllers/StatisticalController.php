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
use App\Http\Requests\ExportMonthRequest;
use App\Http\Requests\StatisticalMonthRequest;

class StatisticalController extends Controller
{
    protected $validator;

    public function __construct()
    {
        $this->time_trackers = new TimeTrackers;
        $this->projects = new Projects();
        $this->employees = new User();
        $this->project_time = new ProjectTime();
        $this->users = new User();
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
        $data['old'] = $request;
        $data['projects'] = $this->projects->get();
        $data['employees'] = $this->employees->getEmployees();
        $start_working_day = null;
        $end_working_day = null;
        $data['params'] = [
            'user_id' => null,
            'start_working_day' => null,
            'end_working_day' => null,
            'sortfield' => 'working_date',
            'sorttype' => 'ASC',
        ];
        $listTimeTrackers = $this->time_trackers->getAllByIdEmployee($data['params']);
        $result = $listTimeTrackers->paginate(5);
        $data['lists'] = $result;
        return view('statistical.month', $data);
    }

    public function search_statistical_month(StatisticalMonthRequest $request)
    {
        if($request->ajax()){
            return response()->json(['success' => 1]);
        }
        $data['projects'] = $this->projects->get();
        $data['employees'] = $this->employees->getEmployees();
        $end = Carbon::parse($request['year'].'-'.$request['month'])->endOfMonth();
        $start_working_day = $request['year'].'-'.$request['month'].'-01';
        $end_working_day = isset($end) ? $end->format('Y-m-d') : null;
        $data['request'] = $request->all();
        $data['params'] = [
            'user_id' => isset($request['user_id']) ? intval($request['user_id']) : '',
            'start_working_day' => $start_working_day,
            'end_working_day' => $end_working_day,
            'sortfield' => isset($request['sortfield']) ? $request['sortfield'] : "working_date",
            'sorttype' => isset($request['sorttype']) ? $request['sorttype'] : "ASC",
        ];
        $listTimeTrackers = $this->time_trackers->getAllByIdEmployee($data['params']);
        $result = $listTimeTrackers->paginate(5);
        $data['lists'] = $result;
        return view('statistical.month', $data);

    }


    public function pdf_project(Request $request){
        if($request->ajax()){
            return response()->json(['success' => 1]);
        }
        $data['request'] = $request->all();
        $data['users'] = $this->users->getEmployees();
        $data['time_trackers'] = $this->time_trackers;
        $pdf = PDF::loadView('statistical.pdf_project', $data);
        //return $pdf->download('static_with_project.pdf');
        return $pdf->stream();
    }

    public function pdf_month(ExportMonthRequest $request){

        $data['request'] = $request->all();
        $data['time_trackers'] = $this->time_trackers;
        $start_working_day = (isset($request->year) && isset($request->month)) ? $request->year.'-'.$request->month.'-01' : null;
        $data['params'] = [
            'user_id' => isset($request->user_id) ? intval($request->user_id) : '',
            'start_working_day' => $start_working_day,
        ];
        $data['user_id'] = $data['params']['user_id'];
        $month = (isset($request->year) && isset($request->month)) ? $request->year.'-'.$request->month : date('Y-m');
        $start = Carbon::parse($month)->startOfMonth();
        $end = Carbon::parse($month)->endOfMonth();
        $data['period'] = CarbonPeriod::create($start, $end);
        $data['weekMap'] = config('setting.weekMap');
        $data['info'] = $this->time_trackers->CheckDateByParams(['user_id' => $data['user_id']]);
        if($request->ajax()){
            if(empty($data['info'])){
                return response()->json(['success' => 0,'message' => 'No data export']);
            }
            return response()->json(['success' => 1]);
        }
        $pdf = PDF::loadView('statistical.pdf_month_user', $data);
        return $pdf->stream();

    }
}
