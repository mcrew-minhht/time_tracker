<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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
}
