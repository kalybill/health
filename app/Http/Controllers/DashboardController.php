<?php

namespace App\Http\Controllers;

use App\Models\Nurse;
use App\Models\Nurse_geographical;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index(){

        return view('dashboard.index');
    }

    public function search_area_rn(Request $req){
        $nurseId = $req->input('search_rn');
$location = $req->input('search_location');

$query = Nurse_geographical::query();

// Apply search conditions
$query->where(function ($query) use ($nurseId, $location) {
    if ($nurseId && $location) {
        $query->where('nurse_id', $nurseId)->where('area', $location);
    } elseif ($nurseId) {
        $query->where('nurse_id', $nurseId);
    } elseif ($location) {
        $query->where('area', $location);
    }
});
    
        // Get the matching records
        $results = $query->get();
       
        $html = '';
       foreach($results as $key){
        $nurse = Nurse::find($key->nurse_id);
            $html .='<tr>
            <td>' . $nurse->name . '</td>
                <td>'.$key->area.'</td>
            </tr>';
       }
    
        // Optionally, you can pass the $results variable to a view for display
    
        return response()->json($html);
    }
}
