<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Nurse_geographical extends Model
{
    use HasFactory;

    protected $fillable = ['area', 'nurse_id'];

    public function nurse()
    {
        return $this->belongsTo(Nurse::class);
    }
}
