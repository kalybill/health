<?php

namespace App\Http\Controllers;

use App\Models\Case_type;
use App\Models\Client_contact;
use DateTime;
use App\Models\Nurse;
use App\Models\Clients;
use App\Models\Document;
use App\Models\Referral;
use App\Models\Scheduling;
use App\Models\Visit_type;
use App\Models\Service_info;
use Illuminate\Http\Request;
use App\Models\Medical_record;
use Illuminate\Support\Facades\DB;
use App\Models\Credential_tracking;
use App\Models\Referral_source;

class ReportController extends Controller
{
    public function expired_credentail()
    {

        return view('reports.expired_credentail');
    }


    public function dt_credential_exp(Request $req)
    {
        $date = Date('Y-m-d');
        $expired = Credential_tracking::where('expiry_date', '<', $date)->get();

        $data = [];

        foreach ($expired as $val) {
            $data[] = [
                'rn_name' => Nurse::find($val->nurse_id)->name,
                'document_name' => Document::find($val->document_name)->description,
                'expiry_date' => convert_date_from_db($val->expiry_date),
                'id' => $val->id,
            ];
        }

        return response()->json([
            'data' => $data,
            'draw' => intval($req->input('draw'))
        ]);
    }


    public function nurse_report()
    {

        return view('reports.nurse_report');
    }

    public function dt_nursereport(Request $req)
    {

        $sch = Medical_record::where('date_process', '!=', null)->get();

        $data = [];

        foreach ($sch as $val) {
            $data[] = [
                'rn_name' => Nurse::find($val->nurse_id)->name,
                'patient' => Referral::find($val->patient_id)->name,
                'date_process' => convert_date_from_db($val->date_process),
                'id' => $val->scheduling_id,

            ];
        }

        return response()->json([
            'data' => $data,
            'draw' => intval($req->input('draw'))
        ]);
    }


    public function note_by_nurse()
    {

        return view('reports.note_by_nurse');
    }

    public function out_by_phama()
    {

        return view('reports.out_by_phama');
    }

    public function out_by_patient()
    {

        return view('reports.out_by_patient');
    }

    // public function dt_out_nurse_report(Request $req)
    // {
    //     $sch = Medical_record::where('nurse_id', '!=', null)->get();

    //     $data = [];

    //     foreach ($sch as $val) {
    //         $data[] = [
    //             'rn_name' => Nurse::find($val->nurse_id)->name,
    //             'patient' => Referral::find($val->patient_id)->name,
    //             'date_process' => convert_date_from_db($val->date_process),
    //             'id' => $val->scheduling_id,

    //         ];
    //     }

    //     return response()->json([
    //         'data' => $data,
    //         'draw' => intval($req->input('draw'))
    //     ]);
    // }

    public function dt_out_nurse_report(Request $req){
        $sched = Scheduling::where('billed', '=', null)->get();

        $data = [];

        foreach ($sched as $val) {
            $data[] = [
                'patient' => Referral::where('id', $val->patient_id)->first() != null ? Referral::where('id', $val->patient_id)->first()->name : '',
                'visit_date' => convert_date_from_db($val->visit_date),
                'remarks' => $val->remarks,
                'visit_type' => Visit_type::find($val->visit_type)->description,
                'rn_name' => Nurse::find($val->nurse_id)->name,
                'client' => Clients::find($val->client)->cname, //Clients::find($val->client)
                'id' => $val->id,
            ];
        }

        return response()->json([
            'data' => $data,
            'draw' => intval($req->input('draw'))
        ]);
    }

    public function dt_out_phama(Request $req)
    {
        $sched = Scheduling::where('billed', '=', null)->get();

        $data = [];

        foreach ($sched as $val) {
            $data[] = [
                'patient' => Referral::where('id', $val->patient_id)->first() != null ? Referral::where('id', $val->patient_id)->first()->name : "",
                'visit_date' => convert_date_from_db($val->visit_date),
                'remarks' => $val->remarks,
                'visit_type' => Visit_type::find($val->visit_type)->description,
                'rn_name' => Nurse::find($val->nurse_id)->name,
                'client' => Clients::find($val->client)->cname, //Clients::find($val->client)
                'id' => $val->id,
            ];
        }

        return response()->json([
            'data' => $data,
            'draw' => intval($req->input('draw'))
        ]);
    }


    public function searchByNurse(Request $req)
    {
        $data = Medical_record::where('nurse_id', $req->id)->first();

        if ($data != null) {
            return response()->json($data);
        }
    }


    public function searchByPhama(Request $req)
    {
        $data = Medical_record::where('client', $req->id)->first();

        if ($data != null) {
            return response()->json($data);
        }
    }


    public function searchByPatient(Request $req)
    {
        $data = Medical_record::where('patient_id', $req->id)->first();

        if ($data != null) {
            return response()->json($data);
        }
    }

    public function single_nurse_report($id)
    {
        $data = Medical_record::where('nurse_id', $id)->get();


        return view('reports.single_nurse_report', compact('data'));
    }


    public function single_client_report($id)
    {
        $data = Medical_record::where('client', $id)->get();


        return view('reports.single_client_report', compact('data'));
    }

    public function single_patient_report($id)
    {
        $data = Medical_record::where('patient_id', $id)->get();


        return view('reports.single_patient_report', compact('data'));
    }

    public function view_md_records(Request $req)
    {
        $md_records = Medical_record::where('scheduling_id', $req->id)->first();

        $today = new DateTime(); // Get today's date
        $dateProcess = new DateTime($md_records->date_process); // Convert the date_process to DateTime object

        $interval = $today->diff($dateProcess); // Calculate the difference between the two dates
        $daysOld = $interval->days; // Get the number of days



        $sch  = Scheduling::find($req->id);
        $html = '<script>
            $(".kt_datepicker").flatpickr({
                dateFormat: "m-d-Y",
            });
    
            $(".kt_timepicker").flatpickr({
                enableTime: true,
        noCalendar: true,
        dateFormat: "H:i",
        allowInput: true
            });
            
           
            </script>';

        $html .= '<form action="javascript:void(0)" id="frmSaveMdRecord" data-parsley-validate>
            <input type="hidden" class=" form-control form-control-solid" name="id" id="" value="' . $md_records->scheduling_id . '" readonly>
            <div class="row">
            <div class="col-md-4">
                <label for="">Patient Name</label>
                <input type="text" value="' . Referral::find($sch->patient_id)->name . '" class=" form-control form-control-solid" name="patient_name" id="" readonly>
            </div>
            <div class="col-md-4">
                <label for="">Date</label>
                <input type="text" class=" form-control form-control-solid kt_datepicker" name="" id="" readonly value="' . convert_date_from_db($sch->visit_date) . '">
            </div>
            <div class="col-md-4">
                <label for="">Visit Type</label>
                <input type="text" class=" form-control form-control-solid" name="" value="' . Visit_type::find($sch->visit_type)->description . '" id="" readonly>
            </div>
        </div>
        <div class="row mt-8">
            <div class="col-md-4">
                <label for="">Nurse</label>
                <input type="text" class=" form-control form-control-solid" name="" id="" value="' . Nurse::find($sch->nurse_id)->name . '" readonly>
            </div>
            <div class="col-md-4">
                <label for="">Client</label>
                <input type="text" class=" form-control form-control-solid" name="" id="" readonly value="' . $sch->client . '">
            </div>
        </div>
        <div class="row mt-8">
            <div class="col-md-3">
                <label for="">Time In</label>
                <input type="text" class=" form-control form-control-solid kt_timepicker" value="' . $md_records->time_in . '" name="time_in" id="time_in" >
                <span class=" alert-danger time_in-error" id=""></span>
            </div>
            <div class="col-md-3">
                <label for="">Time Out</label>
                <input type="text" class=" form-control form-control-solid kt_timepicker" name="time_out" value="' . $md_records->time_out . '" id="time_out" required>
                <span class=" alert-danger time_out-error" id=""></span>
            </div>
            <div class="col-md-3">
                <label for="">Total Time</label>
                <input type="text" class=" form-control form-control-solid kt_timepicker" name="total_time" value="' . $md_records->total_time . '" id="total_time" readonly required>
                <span class=" alert-danger total_time-error" id=""></span>
            </div>
            <div class="col-md-3">
                <label for="">Date Process</label>
                <input type="text" class="kt_datepicker form-control form-control-solid" name="date_process" value="' . convert_date_from_db($md_records->date_process) . '" id="" >
                <span class=" alert-danger date_process-error" id=""></span>
            </div>
        </div>
        <div class="row mt-8">
            <div class="col-md-3">
                <label for="">Spec Rate</label>
                <input type="text" class="form-control form-control-solid" value="' . $md_records->spec_rate . '" name="spec_rate" id="" >
                <span class=" alert-danger spec_rate-error" id=""></span>
            </div>
            <div class="col-md-3">
                <label for="">Missing Items On Notes</label>
                <textarea name="missing_item" id="" class=" form-control form-control-solid">' . $md_records->missing_item . '</textarea>
                <span class=" alert-danger missing_item-error" id=""></span>
            </div>
            <div class="col-md-3">
                <label for="">Scheduling Remark</label>
                <textarea name="remarks" id="" class="form-control form-control-solid">' . $md_records->remarks . '</textarea>
                <span class=" alert-danger remarks-error" id=""></span>
            </div>
            <div class="col-md-3">
                <label for="">Days Old</label>
                <input type="text" class="form-control form-control-solid" value="' . $daysOld . '" name="spec_rate" id="" readonly>
                
            </div>
        </div>
        <div class="row mt-8">
            <div class="col-md-3">
                <div class="form-check form-check-custom form-check-solid">';
        if ($md_records->route_sheet == 1) {
            $html .= '<input name="route_sheet" class="form-check-input" type="checkbox" value="1" id="" checked disabled id="flexCheckDisabled"/>';
        } else {
            $html .= '<input name="route_sheet" disabled id="flexCheckDisabled" class="form-check-input" type="checkbox" value="1" id=""/>';
        }
        $html .= '<label class="form-check-label" for="flexCheckDefault">
                        Route Sheet
                    </label>
                </div>
            </div>
            <div class="col-md-3">
                <div class="form-check form-check-custom form-check-solid">';
        if ($md_records->note == 1) {
            $html .= '<input name="note" class="form-check-input" type="checkbox" value="1" id="" checked disabled id="flexCheckDisabled"/>';
        } else {
            $html .= '<input name="note" disabled id="flexCheckDisabled" class="form-check-input" type="checkbox" value="1" id=""/>';
        }
        $html .= '<label class="form-check-label" for="flexCheckDefault">
                        Note
                    </label>
                </div>
            </div>
        </div>
      </form>';

        return response()->json($html);
    }


    public function visit_report()
    {

        return view('reports.visit_report');
    }


    public function dt_visit_rn_report(Request $req)
    {

        $sch = Scheduling::all();

        $data = [];

        foreach ($sch as $val) {
            $data[] = [
                'rn_name' => Nurse::find($val->nurse_id)->name != null ? Nurse::find($val->nurse_id)->name :"",
                'patient' => Referral::find($val->patient_id) != null ? Referral::find($val->patient_id)->name : '',
                'visit_type' => Visit_type::find($val->visit_type)->description,
                'visit_date' => convert_date_from_db($val->visit_date),
                'eta' => $val->eta,
                'remarks' => $val->remarks,
                'id' => $val->scheduling_id,

            ];
        }

        return response()->json([
            'data' => $data,
            'draw' => intval($req->input('draw'))
        ]);
    }


    public function dt_auth_report(Request $req)
    {

        $sch = Scheduling::groupBy('patient_id')->get();


        $data = [];

        foreach ($sch as $val) {
            $data[] = [
                'rn_name' => Nurse::find($val->nurse_id)->name,
                'patient' => Referral::find($val->patient_id) != null ? Referral::find($val->patient_id)->name : '',
                'visit_type' => Visit_type::find($val->visit_type)->description,
                'visit_date' => convert_date_from_db($val->visit_date),
                'auth' => Service_info::where('patient_id', $val->patient_id)->first()->authorization,
                'visits' => Scheduling::where('patient_id', $val->patient_id)->count(),
                'id' => $val->patient_id,

            ];
        }

        return response()->json([
            'data' => $data,
            'draw' => intval($req->input('draw'))
        ]);
    }


    public function dt_specialty_inf(Request $req)
    {

        $sch = Service_info::all();


        $data = [];

        foreach ($sch as $val) {
            $booked_rn = Referral::find($val->patient_id) != null ? Referral::find($val->patient_id)->booked_rn : '';
            
            $data[] = [
                'rn_name' => Nurse::find($booked_rn) != null ? Nurse::find($booked_rn)->name : '',
                'patient' => Referral::find($val->patient_id) != null ? Referral::find($val->patient_id)->name : '',
                'case' => $val->case_type_id != null ? Case_type::find($val->case_type_id)->description : '',
                'id' => $val->patient_id,

            ];
        }

        return response()->json([
            'data' => $data,
            'draw' => intval($req->input('draw'))
        ]);
    }


    public function dt_specialty_inf_rx(Request $req)
    {
        $sch = Service_info::all();

        $data = [];

        foreach ($sch as $val) {
            $ref_source = Referral::find($val->patient_id);
            // dd(Clients::find($ref_source->ref_source_type_id)->cname);
            $data[] = [
                'ref_source' => $ref_source != null ? Clients::find($ref_source->ref_source_type_id)->cname : '',
                'patient' => Referral::find($val->patient_id) != null ? Referral::find($val->patient_id)->name : '',
                'dob' => Referral::find($val->patient_id) != null ? convert_date_from_db(Referral::find($val->patient_id)->dob) : '',
                'md_orders1' => Referral::find($val->patient_id) != null ? Referral::find($val->patient_id)->md_order_1 : '',
                'md_orders2' => Referral::find($val->patient_id) != null ? Referral::find($val->patient_id)->md_order_2 : '',
                'md_orders3' => Referral::find($val->patient_id) != null ? Referral::find($val->patient_id)->md_order_3 : '',
                'primary_rn' => $ref_source != null ? Nurse::find($ref_source->booked_rn)->name : '',
                'staff' => $ref_source != null ? Client_contact::find($ref_source->ref_source_staff)->contact_person : '',
                'case' => $val->case_type_id != null ? Case_type::find($val->case_type_id)->description : '',
                'id' => $val->patient_id,

            ];
        }

        return response()->json([
            'data' => $data,
            'draw' => intval($req->input('draw'))
        ]);
    }


    public function dt_weekly_visit_rx(Request $req)
    {
        $sch = Medical_record::all();

        $data = [];

        foreach ($sch as $val) {
            $ref_source = Referral::find($val->patient_id);
            $service_inf = Service_info::where('patient_id',$val->patient_id)->first()->case_type_id;
            // dd(Clients::find($ref_source->ref_source_type_id)->cname);
            $data[] = [
                'client' => Clients::find($ref_source->ref_source_type_id)->cname,
                'patient' => Referral::find($val->patient_id)->name,
                'visit_type' => Visit_type::find($val->visit_type)->description,
                'visit_date' => convert_date_from_db($val->visit_date),
                'hours' => $val->total_time,
                'time_in' => $val->time_in,
                'time_out' => $val->time_out,
                'bill' => $val->bill_rate,
                'date_process' => convert_date_from_db($val->date_process),
                'mileage' => $val->mileage,
                'dob' => convert_date_from_db(Referral::find($val->patient_id)->dob),
                'rn_name' => Nurse::find($val->nurse_id)->name,
                'case' => Case_type::find($service_inf)->description,
                'id' => $val->patient_id,

            ];
        }

        return response()->json([
            'data' => $data,
            'draw' => intval($req->input('draw'))
        ]);
    }

   
    
     


    public function dt_specialty_infusion_patient_visit(Request $req)
    {
        $sch = Scheduling::all();

        $data = [];

        foreach ($sch as $val) {
            $ref_source = Referral::find($val->patient_id);
            $sch = Service_info::where('patient_id',$val->patient_id)->first();
            
            // dd(Clients::find($ref_source->ref_source_type_id)->cname);
            $data[] = [
                'ref_source' => $ref_source != null ? Clients::find($ref_source->ref_source_type_id)->cname : '',
                'patient' =>  Referral::find($val->patient_id) != null ? Referral::find($val->patient_id)->name : '',
                'dob' => Referral::find($val->patient_id) != null ? convert_date_from_db(Referral::find($val->patient_id)->dob) : '',
                'primary_rn' => $ref_source != null ? Nurse::find($ref_source->booked_rn)->name : '',
                'visit_date' => convert_date_from_db($val->visit_date),
                'visit_type' => Visit_type::find($val->visit_type)->description,
                'case' => $sch->case_type_id != null ? Case_type::find($sch->case_type_id)->description : '',
                'id' => $val->patient_id,
                'created_at' => convert_date_from_db($val->created_at),

            ];
        }

        return response()->json([
            'data' => $data,
            'draw' => intval($req->input('draw'))
        ]);
    }

    public function get_visit_date(Request $req)
    {
        $data = Scheduling::whereBetween('visit_date', [convert_date_to_db($req->startDate), convert_date_to_db($req->endDate)])->orderBy('nurse_id')->get();

        $html = '';

        foreach ($data as $val) {
            $html .= '<tr>
                <td>'.$val->visit_date.'</td>
                <td>'.Referral::find($val->patient_id)->name.'</td>
                <td>'.Visit_type::find($val->visit_type)->description.'</td>
                <td>'.Nurse::find($val->nurse_id)->name.'</td>
                <td>'.$val->eta.'</td>
                <td>'.$val->remarks.'</td>
                
            </tr>';
        }

        return response()->json($html);
    }


    public function billing_report(){

        return view('reports.billing_report');
    }


    public function get_md_billings_reports(Request $req){
        $md_records = Medical_record::where('scheduling_id', $req->id)->first();

        $sch  = Scheduling::find($req->id);

        $html = '<script>
            $(".kt_datepicker").flatpickr({
                dateFormat: "m-d-Y",
            });
    
            $(".kt_timepicker").flatpickr({
                enableTime: true,
        noCalendar: true,
        dateFormat: "H:i",
        allowInput: true
            });
            
           
            </script>';

        $html .= '<form action="javascript:void(0)" id="frmBilling" data-parsley-validate>
            <input type="hidden" class=" form-control form-control-solid" name="id" id="" value="' . $md_records->scheduling_id . '" readonly>
            <div class="row">
            <div class="col-md-4">
                <label for="">Patient Name</label>
                <input type="text" value="' . Referral::find($sch->patient_id)->name . '" class=" form-control form-control-solid" name="patient_name" id="" readonly>
            </div>
            <div class="col-md-4">
                <label for="">Date</label>
                <input type="text" class=" form-control form-control-solid kt_datepicker" name="" id="" readonly value="' . convert_date_from_db($sch->visit_date) . '">
            </div>
            <div class="col-md-4">
                <label for="">Visit Type</label>
                <input type="text" class=" form-control form-control-solid" name="" value="' . Visit_type::find($sch->visit_type)->description . '" id="" readonly>
            </div>
        </div>
        <div class="row mt-8">
            <div class="col-md-4">
                <label for="">Nurse</label>
                <input type="text" class=" form-control form-control-solid" name="" id="" value="' . Nurse::find($sch->nurse_id)->name . '" readonly>
            </div>
            <div class="col-md-4">
                <label for="">Client</label>
                <input type="text" class=" form-control form-control-solid" name="" id="" readonly value="' . $sch->client . '">
            </div>
        </div>
        <div class="row mt-8">
            <div class="col-md-3">
                <label for="">Time In</label>
                <input type="text" class=" form-control form-control-solid kt_timepicker" value="' . $md_records->time_in . '" name="time_in" id="time_in" readonly>
                <span class=" alert-danger time_in-error" id=""></span>
            </div>
            <div class="col-md-3">
                <label for="">Time Out</label>
                <input type="text" class=" form-control form-control-solid kt_timepicker" name="time_out" value="' . $md_records->time_out . '" id="time_out" readonly >
                <span class=" alert-danger time_out-error" id=""></span>
            </div>
            <div class="col-md-3">
                <label for="">Total Time</label>
                <input type="text" class=" form-control form-control-solid kt_timepicker" name="total_time" value="' . $md_records->total_time . '" id="total_time" readonly >
                <span class=" alert-danger total_time-error" id=""></span>
            </div>
            <div class="col-md-3">
                <label for="">Date Process</label>
                <input type="text" class="kt_datepicker form-control form-control-solid" name="date_process" value="' . convert_date_from_db($md_records->date_process) . '" id="" readonly>
                <span class=" alert-danger date_process-error" id=""></span>
            </div>
        </div>
        <div class="row mt-8">
            <div class="col-md-3">
                <label for="">Spec Rate</label>
                <input type="text" class="form-control form-control-solid" value="' . $md_records->spec_rate . '" name="spec_rate" id="" readonly>
                <span class=" alert-danger spec_rate-error" id=""></span>
            </div>
            <div class="col-md-3">
                <label for="">Missing Items On Notes</label>
                <textarea name="missing_item" id="" class=" readonly form-control form-control-solid">' . $md_records->missing_item . '</textarea>
                <span class=" alert-danger missing_item-error" id=""></span>
            </div>
            <div class="col-md-3">
                <label for="">Scheduling Remark</label>
                <textarea name="remarks" id="" class="form-control form-control-solid" readonly>' . $md_records->remarks . '</textarea>
                <span class=" alert-danger remarks-error" id=""></span>
            </div>
        </div>
        <div class="row mt-8">
            <div class="col-md-3">
                <div class="form-check form-check-custom form-check-solid">';
        if ($md_records->route_sheet == 1) {
            $html .= '<input name="route_sheet" disabled id="flexCheckDisabled" class="form-check-input" type="checkbox" value="1" id="" checked readonly/>';
        } else {
            $html .= '<input name="route_sheet" disabled id="flexCheckDisabled" class="form-check-input" type="checkbox" value="1" id="" readonly/>';
        }
        $html .= '<label class="form-check-label" for="">
                        Route Sheet
                    </label>
                </div>
            </div>
            <div class="col-md-3">
                <div class="form-check form-check-custom form-check-solid">';
        if ($md_records->note == 1) {
            $html .= '<input name="note"  id="flexCheckDisabled" class="form-check-input" type="checkbox" value="1" id="" readonly checked/>';
        } else {
            $html .= '<input name="note"  id="flexCheckDisabled" class="form-check-input" type="checkbox" readonly value="1" id=""/>';
        }
        $html .= '<label class="form-check-label" for="flexCheckDefault">
                        Note
                    </label>
                </div>
            </div>
        </div>
        <div class="row mt-8 ">
        <div class="col-md-12">
        <h5 class="mb-8 text-center">Billing</h5>
        </div>
      <div class="col-md-6">
      <div class="form-check form-check-custom form-check-solid">';
      if ($md_records->billed == 1) {
        $html .= '<input name="billed"  id="" class="form-check-input" type="checkbox" value="1" id="" checked/>';
      } else {
        $html .= '<input name="billed" id="" class="form-check-input" type="checkbox" value="1" id=""/>';
      }
          $html .= '<label class="form-check-label" for="">
              Billed
          </label>
      </div>
  </div>
  <div class="col-md-6">
    <div class="form-check form-check-custom form-check-solid">';
    if ($md_records->paid == 1) {
        $html .= '<input name="paid"  id="" class="form-check-input" type="checkbox" value="1" id="" checked/>';
    }else{
        $html .= '<input name="paid"  id="" class="form-check-input" type="checkbox" value="1" id="" />';
    }
        
       $html .='<label class="form-check-label" for="flexCheckDefault">
            Paid
        </label>
    </div>
</div>
        <div class="row mt-8">
          <div class="col-md-4">
              <label class="form-check-label" for="">Bill Rate</label>
              <input type="text" class="form-control form-control-solid" value="'.$md_records->bill_rate .'"
                name="bill_rate" id=""/>
              <span class="alert-danger bill_rate-error" id=""></span>
      </div>
      <div class="col-md-4">
              <label class="form-check-label" for="">Bill Date</label>
              <input
                type="text"
                class="form-control form-control-solid kt_datepicker"
                value="' . $md_records->bill_date . '"
                name="bill_date"
                id=""
              />
              <span class="alert-danger bill_date-error" id=""></span>
            </div>
            <div class="col-md-4">
              <label class="form-check-label" for="">Pay Date</label>
              <input
                type="text"
                class="form-control form-control-solid kt_datepicker"
                value="' . $md_records->pay_date . '"
                name="pay_date"
                id=""
              />
              <span class="alert-danger pay_date-error" id=""></span>
            </div>
          
      </div>
      <div class="row mt-8">
        <div class="col-md-6">
        <label>Remarks</label>
        <textarea name="billing_remarks" id="" class="form-control form-control-solid">' . $md_records->billing_remarks . '</textarea>
        </div>
      </div>
      </div>
      <div class="modal-footer mt-8">

      <div class="form-check form-check-custom form-check-solid">
    </div>
    </div>
      </form>';

        return response()->json($html);
    }


    public function patient_auth_report(){

        return view('reports.patient_auth_report');
    }

    public function view_patient_auth($id){
        $sch  = Scheduling::where('patient_id',$id)->get();
        $sch_single  = Scheduling::where('patient_id',$id)->first();

        $auth = Service_info::where('patient_id', $sch_single->patient_id)->first()->authorization;
        $number_of_visit = Scheduling::where('patient_id', $sch_single->patient_id)->count();

        return view('reports.view_patient_auth', compact('sch', 'auth', 'number_of_visit'));
    }

    public function specialty_infusion_nurse(){

        return view('reports.specialty_infusion_nurse');
    }

    public function specialty_infusion_rx(){

        return view('reports/specialty_infusion_rx');
    }


    public function specialty_infusion_patient_visit(){

        return view('reports/specialty_infusion_patient_visit');
    }


    public function weekly_visit_rx(){

        return view('reports/weekly_visit_rx');
    }
}
