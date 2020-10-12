<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class TimeTrackers extends Model
{
    use HasFactory;
    protected $table = 'time_trackers';
    protected $primaryKey = 'id';
    public $timestamps = false;

    public function getAllByIdEmployee(){
       return DB::table('time_trackers')
            ->select('id_project', DB::raw("DATE_FORMAT(working_day, '%m-%Y') as working_day"),'projects.name_project as name_project', 'users.employee_code as employee_code','users.name as employee_name')
            ->join('projects','projects.id','=','time_trackers.id_project')
            ->join('users','users.employee_code','=','time_trackers.employee_code')
            ->groupBy(DB::raw("DATE_FORMAT(time_trackers.working_day, '%m-%Y'), time_trackers.id_project, projects.name_project, users.employee_code, users.name"))
            ->orderBy(DB::raw("YEAR(working_day)"),'DESC')
            ->orderBy(DB::raw("id_project"),'ASC')
            ->get();
    }

    public function CheckDateByParams($params){
        return DB::table('time_trackers')
            ->where('employee_code', $params['employee_code'])
            ->where('id_project', $params['id_project'])
            ->where('working_day', $params['working_day'])
            ->first();
    }
    public function updateByDateAndProject($params){
        DB::table('time_trackers')
            ->where('id', $params['id'])
            ->update(
                [
                    'working_time' => $params['working_time'],
                    'memo' => $params['memo'],
                    'updated_user' => $params['updated_user']
                ]
            );
    }
    public function insertByDateAndProject($params){
        DB::table('time_trackers')->insert(
            [
                'employee_code' => $params['employee_code'],
                'id_project' => $params['id_project'],
                'working_day' => $params['working_day'],
                'working_time' => $params['working_time'],
                'memo' => $params['memo'],
                'created_user' => $params['created_user'],
            ]
        );
    }

    public function CheckProjectByParams($params){
        return DB::table('time_trackers')
            ->where('employee_code', $params['employee_code'])
            ->where('id_project', $params['id_project'])
            ->where('working_day','LIKE',$params['working_day'].'%')
            ->first();
    }

    public function InsertProjectByParams($params){
        DB::table('time_trackers')->insert([
            'employee_code' => $params['employee_code'],
            'id_project' => $params['id_project'],
            'working_day' => date_format(now(),'Y-m-d'),
        ]);
    }
}
