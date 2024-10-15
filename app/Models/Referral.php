<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Date;

class Referral extends Model
{
    use HasFactory, SoftDeletes;

    protected $dates = ['deleted_at'];

    public static function referrals_count($status){
        return Referral::where('status', $status)->count();
    }

    

    public static function referrals_month_count(){
        $dates = Referral::all();
        $date = Date('Y-m');
        $useThisDate = array();
        foreach($dates as $val){
            $dates = $val->created_at;
            $exp = explode('-',$dates);
            $useThisDate[] = $exp[0]. '-' .$exp[1];
            
        }

        $count = 0;
        foreach($useThisDate as $key){
    
            if($date == $key){
                $count++;
            }            
        } 
        return ($count); 
        
        
    }
}
