<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class ProjectManagers extends Model
{
    use HasFactory;
    protected $table = 'projects';
    protected $primaryKey = 'id';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id',
        'name_project',
        'start_date',
        'end_date',
        'created_user',
        'updated_user',
        'created_at',
        'updated_at'
    ];
    public $timestamps = true;
    public function getAllProject($params){
        $result =  DB::table($this->table);
        if (!empty($params['search'])){
            $result->where('name_project','like','%'.$params['search'].'%');
        }
        if (!empty($params['sortfield']) && !empty($params['sorttype'])){
            $result->orderBy(DB::raw($params['sortfield']),$params['sorttype']);
        }
        return $result;
    }
    public function insertProject($params){
        $result =  DB::table($this->table);
        $result = $result->insert($params);
        return $result;
    }
}
