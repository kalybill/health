<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Nurse extends Model
{
    use HasFactory;

    public function nurse_geographicals()
    {
        return $this->hasMany(Nurse_geographical::class);
    }
}
