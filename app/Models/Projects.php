<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Projects extends Model
{
    use HasFactory;
    protected $table = 'projects';
    protected $primaryKey = 'id';
    public $timestamps = false;

}
