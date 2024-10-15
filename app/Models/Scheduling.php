<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Support\Facades\Date;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Scheduling extends Model
{
    use HasFactory,SoftDeletes;

    protected $dates = ['deleted_at'];

    public static function visit_today(){
       return Scheduling::where('visit_date', Carbon::today()->format('Y-m-d'))->count();
    }
}
