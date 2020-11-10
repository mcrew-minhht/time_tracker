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
use PDF;

class StatisticalController extends Controller
{
    protected $validator;

    public function __construct()
    {
        $this->time_trackers = new TimeTrackers;
        $this->projects = new Projects();
        $this->project_time = new ProjectTime();
    }

    public function index(Request $request)
    {
        dd('ggg');
    }

    public function statistical_project(Request $request)
    {
        $data['projects'] = $this->projects->get();
        if($request->action == 'search'){
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
        }
        return view('statistical.project', $data);
    }

    public function statistical_month(Request $request)
    {
        $data['projects'] = $this->projects->get();
        $start_working_day = (isset($request->year) && isset($request->month)) ? $request->year.'-'.$request->month.'-01' : null;
        if($request->action == 'search'){
            $data['params'] = [
                'start_working_day' => $start_working_day,
                'sortfield' => isset($request->sortfield) ? $request->sortfield : "id",
                'sorttype' => isset($request->sorttype) ? $request->sorttype : "DESC",
            ];
            $listTimeTrackers = $this->time_trackers->getAllByIdEmployee($data['params']);
            $result = $listTimeTrackers->paginate(5);
            $data['lists'] = $result;
        }
        return view('statistical.month', $data);
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
        $start_working_day = (isset($request->year) && isset($request->month)) ? $request->year.'-'.$request->month.'-01' : null;
        $data['params'] = [
            'start_working_day' => $start_working_day,
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
        return $pdf->download('static_with_month.pdf');
    }
}
