<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class ProjectTime extends Model
{
    use HasFactory;
    protected $table = 'project_time';
    protected $primaryKey = 'id';
    public $timestamps = false;

    public function InsertProjectTimeByParams($params){
        DB::table('project_time')->insert([
            'id_time_tracker' => $params['id_time_tracker'],
            'id_project' => $params['id_project'],
        ]);
    }
}
