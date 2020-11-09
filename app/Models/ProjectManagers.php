<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

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
    public function getAllProject($params){
        $result =  DB::table($this->table);
        $result->leftJoin(DB::raw('users as users_insert'), 'users_insert.id', '=', 'projects.created_user');
        $result->leftJoin(DB::raw('users as users_update'), 'users_update.id', '=', 'projects.updated_user');
        $result->whereRaw('projects.is_delete != 1 OR projects.is_delete is null');
        if (!empty($params['search'])){
            $result->where('name_project','like','%'.$params['search'].'%');
        }
        if (!empty($params['sortfield']) && !empty($params['sorttype'])){
            $result->orderBy(DB::raw($params['sortfield']),$params['sorttype']);
        }
        return $result->select('projects.*', DB::raw('users_insert.name as users_insert'), DB::raw('users_update.name as users_update') );
    }
    public function insertProject($params){
        $params['is_delete'] = 0;
        $params['created_at'] = now();
        $params['updated_at'] = now();
        $params['created_user'] = Auth::id();
        $params['updated_user'] = Auth::id();
        $result =  DB::table($this->table);
        $result = $result->insert($params);
        return $result;
    }
    public function updateProject($params, $id){
        $params['updated_at'] = now();
        $params['updated_user'] = Auth::id();
        $result =  DB::table($this->table)->where('id','=', $id);
        $result = $result->update($params);
        return $result;
    }
    public function deleteProject($ids){
        $params['updated_at'] = now();
        $params['updated_user'] = Auth::id();
        $params['is_delete'] = 1;
        $result =  DB::table($this->table)->whereIn('id',$ids);
        $result = $result->update($params);
        return $result;
    }
}
