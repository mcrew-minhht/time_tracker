<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Auth;
use Laravel\Fortify\TwoFactorAuthenticatable;
use Laravel\Jetstream\HasProfilePhoto;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Support\Facades\DB;

class User extends Authenticatable
{
    use HasApiTokens;
    use HasFactory;
    use HasProfilePhoto;
    use Notifiable;
    use TwoFactorAuthenticatable;

    protected $table = 'users';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'email',
        'address',
        'birthdate',
        'password',
        'region',
        'part_time',
        'level',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
        'two_factor_recovery_codes',
        'two_factor_secret',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * The accessors to append to the model's array form.
     *
     * @var array
     */
    protected $appends = [
        'profile_photo_url',
    ];

    public function getEmployees(){
        return DB::table('users')
            ->select('id','name')
            ->get();
    }


    public function getAllUsers($params){
        $result =  DB::table($this->table);
        $result->join('users_type','users_type.id','=',$this->table.'.part_time', 'left');
        $result->whereRaw('(is_delete != 1 OR is_delete is null)');
        if (!empty($params['username'])){
            $result->where('users.name','like','%'.$params['username'].'%');
        }
        if (!empty($params['region'])){
            $result->where('region','=',$params['region']);
        }
        if ($params['part_time'] != ""){
            if ($params['part_time']==0){
                $result->whereRaw(" (part_time = ".$params['part_time']." or part_time is null) ");
            }else{
                $result->where('part_time','=',$params['part_time']);
            }
        }
        if (!empty($params['sortfield']) && !empty($params['sorttype'])){
            $result->orderBy(DB::raw($params['sortfield']),$params['sorttype']);
        }
        return $result->select('users.*', 'users_type.name as type_name');
    }
    public function insertUser($params){
        $params['is_delete'] = 0;
        $params['created_at'] = now();
        $params['updated_at'] = now();
        $params['created_user'] = Auth::id();
        $params['updated_user'] = Auth::id();
        $result =  DB::table($this->table);
        $result = $result->insert($params);
        return $result;
    }
    public function updateUser($params, $id){
        $params['updated_at'] = now();
        $params['updated_user'] = Auth::id();
        $result =  DB::table($this->table)->where('id','=', $id);
        $result = $result->update($params);
        return $result;
    }
    public function deleteUser($ids){
        $params['updated_at'] = now();
        $params['updated_user'] = Auth::id();
        $params['is_delete'] = 1;
        $result =  DB::table($this->table)->whereIn('id',$ids);
        $result = $result->update($params);
        return $result;
    }
}
