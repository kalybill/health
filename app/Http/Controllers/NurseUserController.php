<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class NurseUserController extends Controller
{
    public function nurse_user(){

        return view('nurse_user.index');
    }
}
