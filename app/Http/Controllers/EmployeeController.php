<?php


namespace App\Http\Controllers;
use App\Models\User;
use App\Models\Projects;
use App\Models\ProjectTime;
use App\Models\TimeTrackers;
use App\Rules\FromToDateCheck;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class EmployeeController extends Controller
{
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
            'start_working_day' => (!empty($request->year) && !empty($request->month)) ? $request->year.'-'.$request->month.'-01' : ($is_admin == false ? date('Y-m').'-01' : ''),
            'end_working_day' => $end_working_day,
            'year' => ($request->year != "" ) ? $request->year : date('Y'),
            'month' => ($request->month != "" ) ? $request->month : date('m'),
            'sortfield' => isset($request->sortfield) ? $request->sortfield : "working_date",
            'sorttype' => isset($request->sorttype) ? $request->sorttype : "ASC",
        ];
        if (isset($request->reload) && !empty($request->reload)){
            $data['params'] = $request->session()->get('time_trackers_search_params');
        }
        $request->session()->put('time_trackers_search_params', $data['params']);
        $listTime = $this->time_trackers->getAllEmployee($data['params']);
        $result = $listTime->paginate(35);
        $data['lists'] = $result;
        if($is_admin == true){
            $data['employees'] = $this->employees->getEmployees();
        }else{
            $id_employee = Auth::id();
            $data['employees'] = DB::table('users')->where('id' ,'=', $id_employee)->where('id' ,'=', $id_employee)->get();;
        }
        $data['projects'] = $this->projects->get();
        return view('employee.index', $data);
    }
}
