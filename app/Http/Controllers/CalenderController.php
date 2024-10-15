<?php

namespace App\Http\Controllers;

use App\Models\Calender;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class CalenderController extends Controller
{
    public function save_cal_event(Request $req)
    {

        try {
            $cal = new Calender();
            $start_date = preg_replace('/\s\(.*\)/', '', $req->start);
            $end_date = preg_replace('/\s\(.*\)/', '', $req->end);

            $cal->title = $req->title;
            $cal->backgroundColor = $req->backgroundColor;
            $cal->start = Carbon::parse($start_date);
            $cal->end = Carbon::parse($end_date);

            $cal->save();
            return response()->json(['success' => "Added Successfully"]);
        } catch (\Exception $ex) {
            Log::channel('custom')->error($ex->getMessage());
            return response()->json(['logginError' => "Error Occured. Contact System Admin"]);
        }
    }

    public function get_dates_cal(){
        $date = Calender::select('title', 'backgroundColor', 'start', 'end')->get();

        return response()->json($date);
    }

    public function delete_cal($id){
        $event = Calender::where('title', $id)->first();
        $event->delete();

        return response()->json(['success' => "Successfully"]);
    }
}
