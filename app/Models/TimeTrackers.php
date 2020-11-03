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
        //DATE_FORMAT(working_day, '%m-%Y')
        return DB::table('time_trackers')
            ->select('time_trackers.*','users.employee_code as employee_code','users.name as employee_name')
            ->join('users','users.id','=','time_trackers.user_id')
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
                    'time_overtime' => $params['time_overtime'],
                    'time_off' => $params['time_off'],
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
                'time_overtime' => $params['time_overtime'],
                'time_off' => $params['time_off'],
                'memo' => $params['memo'],
                'created_user' => $params['created_user'],
            ]
        );
    }

    public function CheckProjectByParams($params){
        return DB::table('time_trackers')
            ->where('user_id', $params['user_id'])
            ->where('working_date','=',$params['working_date'])
            ->first();
    }

    public function InsertTrackersByParams($params){
        return DB::table('time_trackers')->insertGetId([
            'user_id' => $params['user_id'],
            'working_date' => $params['working_date'],
            'start_working_day' => $params['start_working_day'],
            'start_working_time' => $params['start_working_time'],
            'end_working_day' => $params['end_working_day'],
            'end_working_time' => $params['end_working_time'],
            'created_user' => $params['created_user'],
            'created_at' => $params['created_at'],
            'rest_time' => $params['rest_time'],
        ]);
    }

    public function UpdateTrackersByParams($params){
        DB::table('time_trackers')->where('id', $params['id'])->update([
            'user_id' => $params['user_id'],
            'working_date' => $params['working_date'],
            'start_working_day' => $params['start_working_day'],
            'start_working_time' => $params['start_working_time'],
            'end_working_day' => $params['end_working_day'],
            'end_working_time' => $params['end_working_time'],
            'updated_user' => $params['updated_user'],
            'rest_time' => $params['rest_time'],
        ]);
    }
}
