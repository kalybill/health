<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Service_info extends Model
{
    use HasFactory;

    public static function cast_type_count($case){
        return Service_info::where('case_type_id', $case)->count();
    }
}
