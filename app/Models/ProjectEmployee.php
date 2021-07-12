<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class ProjectEmployee extends Model
{
    use HasFactory;
    protected  $table = 'project_employee';
    protected $primaryKey = 'id';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id',
        'id_project',
        'id_user',
        'project_name',
        'user_name',
        'created_at',
        'updated_at'
    ];

    public function User()
    {
        return $this->belongsTo(User::class,'id_user');
    }

    public function Project(){
        return $this->belongsTo(Projects::class, 'id_project');
    }

}
