<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class Devices extends Model
{
    use HasFactory;
    protected $table = 'devices';
    protected $primaryKey = 'id';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id',
        'name',
        'user_id',
        'description',
        'invoice',
        'created_user',
        'updated_user',
        'created_at',
        'updated_at',
        'is_delete'
    ];
    public function getAllDevice($params){
        $result =  DB::table($this->table);
        $result->leftJoin(DB::raw('users as users_insert'), 'users_insert.id', '=', 'devices.created_user');
        $result->leftJoin(DB::raw('users as users_update'), 'users_update.id', '=', 'devices.updated_user');
        $result->leftJoin(DB::raw('users as users_employees'), 'users_employees.id', '=', 'devices.user_id');
        $result->whereRaw('(devices.is_delete != 1 OR devices.is_delete is null)');
        if (!empty($params['search'])){
            $result->where('devices.name','like','%'.$params['search'].'%');
        }
        if (!empty($params['user_id'])){
            $result->where('devices.user_id','=',$params['user_id']);
        }
        if (!empty($params['sortfield']) && !empty($params['sorttype'])){
            $result->orderBy(DB::raw($params['sortfield']),$params['sorttype']);
        }
        return $result->select('devices.*', DB::raw('users_employees.name as employees'),DB::raw('users_insert.name as users_insert'), DB::raw('users_update.name as users_update') );
    }
    public function insertDevice($params){
        $params['is_delete'] = 0;
        $params['created_at'] = now();
        $params['updated_at'] = now();
        $params['created_user'] = Auth::id();
        $params['updated_user'] = Auth::id();
        $result =  DB::table($this->table);
        $result = $result->insert($params);
        return $result;
    }
    public function updateDevice($params, $id){
        $params['updated_at'] = now();
        $params['updated_user'] = Auth::id();
        $result =  DB::table($this->table)->where('id','=', $id);
        $result = $result->update($params);
        return $result;
    }
    public function deleteDevice($ids){
        $params['updated_at'] = now();
        $params['updated_user'] = Auth::id();
        $params['is_delete'] = 1;
        $result =  DB::table($this->table)->whereIn('id',$ids);
        $result = $result->update($params);
        return $result;
    }
}
