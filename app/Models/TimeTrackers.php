<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TimeTrackers extends Model
{
    use HasFactory;
    protected $table = 'time_trackers';
    protected $primaryKey = 'id';
    public $timestamps = false;

}
