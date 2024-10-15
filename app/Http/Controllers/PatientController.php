<?php

namespace App\Http\Controllers;

use App\Models\Pump;
use App\Models\User;
use App\Models\Nurse;
use App\Models\Status;
use App\Models\Referral;
use App\Models\New_order;
use App\Models\Payer_info;
use App\Models\Scheduling;
use App\Models\Visit_type;
use App\Models\Access_type;
use App\Models\Clients;
use App\Models\Onboarding;
use App\Models\Order_type;
use App\Models\Service_info;
use Illuminate\Http\Request;
use App\Models\Progress_note;
use App\Models\Physician_info;
use App\Models\Referral_source;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class PatientController extends Controller
{
    public function index()
    {
        $patients = Referral::all();

        return view('patients.index', compact('patients'));
    }

    public function edit_patient($id)
    {
        $patient = Referral::find($id);
        $service = Service_info::where('patient_id', $id)->first();
        $phys = Physician_info::where('patient_id', $id)->first();
        $payer = Payer_info::where('patient_id', $id)->first();
        $board = Onboarding::where('patient_id', $id)->first();
        

        $schedules = Scheduling::where('patient_id',$id)->first() != null ? Scheduling::where('patient_id',$id)->first() : null;

        $countSch = Scheduling::where('patient_id',$id)->first() != null ? Scheduling::where('patient_id',$id)->count() : null;
        
        $order = New_order::where('patient_id',$id)->first() != null ? New_order::where('patient_id',$id)->first() : null;
        $progress = Progress_note::where('patient_id',$id)->first() != null ? Progress_note::where('patient_id',$id)->first() : null;

        
        return view('patients/edit_patient', compact('patient', 'service', 'phys', 'payer', 'id', 'schedules', 'order', 'progress', 'countSch', 'board'));
    }

    public function save_patient(Request $req)
    {

        DB::beginTransaction();

        $patient = Referral::find($req->patient_id);

        $rules = array();

        if ($patient->mrn != $req->mrn) {
            $rules = [
                'name' => 'required',
                'phone' => 'required',
                'mrn' => 'required|unique:referrals',

            ];
        } else {
            $rules = [
                'name' => 'required',
                'phone' => 'required',
            ];
        }

        $validator = Validator::make($req->all(), $rules);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()]);
        }

        try {

            $patient->name = $req->name;
            $patient->phone = $req->phone;
            $patient->mrn = $req->mrn;
            $patient->alt_phone = $req->alt_phone;
            $patient->dob = convert_date_to_db($req->dob);
            $patient->status = $req->status;
            $patient->ref_date = convert_date_to_db($req->ref_date);
            $patient->gender = $req->gender;
            $patient->marital_status = $req->marital_status;
            $patient->ref_source_type_id = $req->ref_source_type_id;
            $patient->street_addr = $req->street_addr;
            $patient->ref_source_staff = $req->ref_source_staff;
            $patient->language = $req->language;
            $patient->city = $req->city;
            $patient->state = $req->state;
            $patient->zip = $req->zip;
            $patient->emerg_cont = $req->emerg_cont;
            $patient->emerg_relation_to_patient = $req->emerg_relation_to_patient;
            $patient->emerg_phone = $req->emerg_phone;
            $patient->allergies = $req->allergies;
            $patient->remarks = $req->remarks;
            $patient->est_delivery_time = $req->est_delivery_time;
            $patient->staff_for_patient_recorde = $req->staff_for_patient_recorde;

            $patient->update();

            DB::commit();

            return response()->json(['success' => "Added Successfully"]);
        } catch (\Exception $ex) {
            Log::channel('custom')->error($ex->getMessage());

            DB::rollBack();

            return response()->json(['logginError' => "Error Occured. Contact System Admin"]);
        }
    }


    public function save_service(Request $req)
    {
        $rules = [
            'diagnosis_1' => 'required',

        ];

        $validator = Validator::make($req->all(), $rules);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()]);
        }

        DB::beginTransaction();

        $patient = Service_info::where('patient_id', $req->patient_id)->first();
        $ref = Referral::find($req->patient_id);

        try {

            $patient->cert_from = convert_date_to_db($req->cert_from);
            $patient->cert_to = convert_date_to_db($req->cert_to);
            $patient->discharge_date = convert_date_to_db($req->discharge_date);
            $patient->duration = $req->duration;
            $patient->authorization = $req->authorization;
            $patient->diagnosis_3 = $req->diagnosis_3;
            $patient->diagnosis_2 = $req->diagnosis_2;
            $patient->diagnosis_1 = $req->diagnosis_1;
            $patient->service_type_id = $req->service_type_id;
            $patient->case_type_id = $req->case_type_id;
            $patient->contracted_lab = $req->contracted_lab;
            $patient->access_in_place = $req->access_in_place;
            $patient->date_placed = convert_date_to_db($req->date_placed);
            $patient->alternate_rn = $req->alternate_rn;
            $patient->lab_orders = $req->lab_orders;
            $patient->soc_report = $req->soc_report;
            $patient->pt_feedback_on_rn = $req->pt_feedback_on_rn;

            $ref->md_order_1 = $req->md_order_1;
            $ref->md_order_2 = $req->md_order_2;
            $ref->md_order_3 = $req->md_order_3;
            $ref->soc_date = convert_date_to_db($req->soc_date);
            $ref->access_type_id = $req->access_type_id;
            $ref->pump_id = $req->pump_id;
            $ref->booked_rn = $req->booked_rn;

            $patient->update();
            $ref->update();

            DB::commit();

            return response()->json(['success' => "Added Successfully"]);
        } catch (\Exception $ex) {
            Log::channel('custom')->error($ex->getMessage());

            DB::rollBack();

            return response()->json(['logginError' => "Error Occured. Contact System Admin"]);
        }
    }



    public function save_phyinfo(Request $req)
    {
        $rules = [
            'referring_md' => 'required',

        ];

        $validator = Validator::make($req->all(), $rules);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()]);
        }

        DB::beginTransaction();

        $phyInfo = Physician_info::where('patient_id', $req->patient_id)->first();
        try {

            $phyInfo->referring_md = $req->referring_md;
            $phyInfo->npi = $req->npi;
            $phyInfo->street_addr = $req->street_addr;
            $phyInfo->city = $req->city;
            $phyInfo->state = $req->state;
            $phyInfo->zip = $req->zip;
            $phyInfo->phone = $req->phone;
            $phyInfo->fax = $req->fax;
            $phyInfo->alt_referring_md = $req->alt_referring_md;
            $phyInfo->alt_npi = $req->alt_npi;
            $phyInfo->alt_street_addr = $req->alt_street_addr;
            $phyInfo->alt_city = $req->alt_city;
            $phyInfo->alt_state = $req->alt_state;
            $phyInfo->alt_zip = $req->alt_zip;
            $phyInfo->alt_phone = $req->alt_phone;
            $phyInfo->alt_fax = $req->alt_fax;


            $phyInfo->update();

            DB::commit();

            return response()->json(['success' => "Added Successfully"]);
        } catch (\Exception $ex) {
            Log::channel('custom')->error($ex->getMessage());

            DB::rollBack();

            return response()->json(['logginError' => "Error Occured. Contact System Admin"]);
        }
    }


    public function save_payor(Request $req)
    {
        $rules = [
            'payer' => 'required',

        ];

        $validator = Validator::make($req->all(), $rules);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()]);
        }

        DB::beginTransaction();

        $payor = Payer_info::where('patient_id', $req->patient_id)->first();
        try {

            $payor->payer = $req->payer;
            $payor->payer_type = $req->payer_type;
            $payor->policy = $req->policy;
            $payor->ins_company_contact = $req->ins_company_contact;
            $payor->policy_owner = $req->policy_owner;

            $payor->update();

            DB::commit();

            return response()->json(['success' => "Added Successfully"]);
        } catch (\Exception $ex) {
            Log::channel('custom')->error($ex->getMessage());

            DB::rollBack();

            return response()->json(['logginError' => "Error Occured. Contact System Admin"]);
        }
    }

    public function discharge(){
        return view('patients.discharge');
    }

    public function long_term(){
        return view('patients.long_term');
    }

    public function specialty_infusion(){
        return view('patients.specialty_infusion');
    }


    public function dt_patient(Request $req)
    {
        $referrals = Referral::where('status', '!=',[5,6])->get();

        $data = [];

        foreach ($referrals as $val) {
            $data[] = [
                'name' => $val->name,
                'mrn' => $val->mrn,
                'access_type' => Access_type::find($val->access_type_id) != null ? Access_type::find($val->access_type_id)->description : '',
                'pump' => Pump::find($val->pump_id)->description,
                'ref_src' => Clients::find($val->ref_source_type_id)->cname,
                'ref_date' => convert_date_from_db($val->ref_date),
                'soc_date' => convert_date_from_db($val->soc_date),
                'is_new' => $val->is_new == 1 ? 'Pending Referral' : 'Inpatient',
                'status' => Status::find($val->status)->description,
                'id' => $val->id,
            ];
        }

        return response()->json([
            'data' => $data,
            'draw' => intval($req->input('draw'))
        ]);
    }

    public function dt_patient_discharged(Request $req)
    {
        $referrals = Referral::where('status', [5,6])->get();

        $data = [];

        foreach ($referrals as $val) {
            $data[] = [
                'name' => $val->name,
                'mrn' => $val->mrn,
                'access_type' => Access_type::find($val->access_type_id)->description,
                'pump' => Pump::find($val->pump_id)->description,
                'ref_src' => Clients::find($val->ref_source_type_id)->cname,
                'ref_date' => convert_date_from_db($val->ref_date),
                'soc_date' => convert_date_from_db($val->soc_date),
                'is_new' => $val->is_new == 1 ? 'Pending Referral' : 'Inpatient',
                'status' => Status::find($val->status)->description,
                'id' => $val->id,
            ];
        }

        return response()->json([
            'data' => $data,
            'draw' => intval($req->input('draw'))
        ]);
    }


    public function dt_long_term(Request $req)
    {
        $sch = Service_info::where('case_type_id', 4)->get();
        //$referrals = Referral::where('case_type_id', 1)->get();

        $data = [];

        foreach ($sch as $key) {
            $patient = Referral::where('id',$key->patient_id)->get();
            foreach ($patient as $val) {
                $data[] = [
                    'name' => $val->name,
                    'mrn' => $val->mrn,
                    'access_type' => Access_type::find($val->access_type_id)->description,
                    'pump' => Pump::find($val->pump_id)->description,
                    'ref_src' => Clients::find($val->ref_source_type_id)->cname,
                    'ref_date' => convert_date_from_db($val->ref_date),
                    'soc_date' => convert_date_from_db($val->soc_date),
                    'is_new' => $val->is_new == 1 ? 'Pending Referral' : 'Inpatient',
                    'status' => Status::find($val->status)->description,
                    'id' => $val->id,
                ];
            }
            
        }

        return response()->json([
            'data' => $data,
            'draw' => intval($req->input('draw'))
        ]);
    }


    public function dt_specialty_infusion(Request $req)
    {
        $sch = Service_info::where('case_type_id', 6)->get();
        //$referrals = Referral::where('case_type_id', 1)->get();

        $data = [];

        foreach ($sch as $key) {
            $patient = Referral::where('id',$key->patient_id)->get();
            foreach ($patient as $val) {
                $data[] = [
                    'name' => $val->name,
                    'mrn' => $val->mrn,
                    'access_type' => Access_type::find($val->access_type_id)->description,
                    'pump' => Pump::find($val->pump_id)->description,
                    'ref_src' => Clients::find($val->ref_source_type_id)->cname,
                    'ref_date' => convert_date_from_db($val->ref_date),
                    'soc_date' => convert_date_from_db($val->soc_date),
                    'is_new' => $val->is_new == 1 ? 'Pending Referral' : 'Inpatient',
                    'status' => Status::find($val->status)->description,
                    'id' => $val->id,
                ];
            }
            
        }

        return response()->json([
            'data' => $data,
            'draw' => intval($req->input('draw'))
        ]);
    }

    public function schedules()
    {

        return view('patients.schedules');
    }

    public function dt_schedules(Request $req)
    {
        $referrals = Referral::all();

        $data = [];

        foreach ($referrals as $val) {
            $data[] = [
                'name' => $val->name,
                'mrn' => $val->mrn,
                'access_type' => Access_type::find($val->access_type_id)->description,
                'pump' => Pump::find($val->pump_id)->description,
                'ref_src' => Clients::find($val->ref_source_type_id)->cname,
                'ref_date' => convert_date_to_db($val->ref_date),
                'soc_date' => convert_date_to_db($val->soc_date),
                'is_new' => $val->is_new == 1 ? 'Pending Referral' : 'Patient',
                'status' => Status::find($val->status)->description,
                'id' => $val->id,
            ];
        }

        return response()->json([
            'data' => $data,
            'draw' => intval($req->input('draw'))
        ]);
    }

    public function edit_schedules($id)
    {
        $schedules = Scheduling::where('patient_id',$id)->first() != null ? Scheduling::where('patient_id',$id)->first() : null;
        $order = New_order::where('patient_id',$id)->first() != null ? New_order::where('patient_id',$id)->first() : null;
        $progress = Progress_note::where('patient_id',$id)->first() != null ? Progress_note::where('patient_id',$id)->first() : null;
        return view('patients.edit_schedules', compact('id', 'schedules', 'order', 'progress'));
    }

    public function save_schedule(Request $req)
    {
        $rules = [
            'visit_date' => 'required',
            // 'visit_type' => 'required',
        ];

        $validator = Validator::make($req->all(), $rules);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()]);
        }
        
        
        try {
            
            DB::beginTransaction();
                $newSch = new Scheduling();
                $patient = Referral::find($req->patient_id);
                

                $newSch->patient_id = $req->patient_id;
                $newSch->visit_date = convert_date_to_db($req->visit_date);
                $newSch->visit_type = $req->visit_type;
                $newSch->nurse_id = $req->nurse_id;
                $newSch->client = $req->client;
                $newSch->staffer = $req->staffer;
                $newSch->eta = $req->eta;
                $newSch->remarks = $req->remarks;

                $patient->is_new = 0;

                $newSch->save();
                $patient->update();

                DB::commit();

                return response()->json(['success' => "Added Successfully"]);
            
        } catch (\Exception $ex) {
            DB::rollBack();
            Log::channel('custom')->error($ex->getMessage());
            return response()->json(['logginError' => "Error Occured. Contact System Admin"]);
        }
    }


    public function save_progressnote(Request $req)
    {
        $rules = [
            'nurse_id' => 'required',
            // 'visit_type' => 'required',
        ];

        $validator = Validator::make($req->all(), $rules);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()]);
        }
        
        
        try {
                $progress = new Progress_note();

                $progress->report_date = convert_date_to_db($req->report_date);
                $progress->patient_id = $req->patient_id;
                $progress->nurse_id = $req->nurse_id;
                $progress->report = $req->report;
                $progress->reporter = $req->reporter;
                $progress->staffer = Auth::user()->name;
                $progress->fu_action = $req->fu_action;

                $progress->save();

                return response()->json(['success' => "Added Successfully"]);
        } catch (\Exception $ex) {
            Log::channel('custom')->error($ex->getMessage());
            return response()->json(['logginError' => "Error Occured. Contact System Admin"]);
        }
    }


    public function update_progressnote(Request $req)
    {
        $rules = [
            'nurse_id' => 'required',
            // 'visit_type' => 'required',
        ];

        $validator = Validator::make($req->all(), $rules);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()]);
        }
        
        
        try {
                $progress = Progress_note::find($req->id);

                $progress->report_date = convert_date_to_db($req->report_date);
                $progress->nurse_id = $req->nurse_id;
                $progress->report = $req->report;
                $progress->reporter = $req->reporter;
                $progress->staffer = Auth::user()->name;
                $progress->fu_action = $req->fu_action;

                $progress->update();

                return response()->json(['success' => "Added Successfully"]);
        } catch (\Exception $ex) {
            Log::channel('custom')->error($ex->getMessage());
            return response()->json(['logginError' => "Error Occured. Contact System Admin"]);
        }
    }


    public function save_neworder(Request $req)
    {
        $rules = [
            'new_order' => 'required',
            // 'visit_type' => 'required',
        ];

        $validator = Validator::make($req->all(), $rules);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()]);
        }
        
        
        try {
                $order = new New_order();

                $order->start_date = convert_date_to_db($req->start_date);
                $order->end_date = convert_date_to_db($req->end_date);
                $order->order_type = $req->order_type;
                $order->new_order = $req->new_order;
                $order->patient_id = $req->patient_id;

                $order->save();

                return response()->json(['success' => "Added Successfully"]);
        } catch (\Exception $ex) {
            Log::channel('custom')->error($ex->getMessage());
            return response()->json(['logginError' => "Error Occured. Contact System Admin"]);
        }
    }

    
    public function update_neworder(Request $req)
    {
        $rules = [
            'new_order' => 'required',
            // 'visit_type' => 'required',
        ];

        $validator = Validator::make($req->all(), $rules);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()]);
        }
        
        
        try {
                $order = New_order::find($req->id);

                $order->start_date = convert_date_to_db($req->start_date);
                $order->end_date = convert_date_to_db($req->end_date);
                $order->order_type = $req->order_type;
                $order->new_order = $req->new_order;

                $order->update();

                return response()->json(['success' => "Added Successfully"]);
        } catch (\Exception $ex) {
            Log::channel('custom')->error($ex->getMessage());
            return response()->json(['logginError' => "Error Occured. Contact System Admin"]);
        }
    }


    public function dt_scheduling(Request $req, $id){
        $sched = Scheduling::where('patient_id',$id)->get();

        $data = [];

        foreach ($sched as $val) {
            $data[] = [
                'visit_date' => convert_date_from_db($val->visit_date),
                'visit_type' => Visit_type::find($val->visit_type)->description,
                'nurse_id' => Nurse::find($val->nurse_id)->name,
                'client' => Clients::find($val->client)->cname,
                'staffer' => $val->staffer,
                'eta' => $val->eta,
                'remarks' => $val->remarks,
                'id' => $val->id,
            ];
        }

        return response()->json([
            'data' => $data,
            'draw' => intval($req->input('draw'))
        ]);
    }


    public function dt_progress(Request $req, $id){
        $progress = Progress_note::where('patient_id',$id)->get();

        $data = [];

        foreach ($progress as $val) {
            $data[] = [
                'mrn' =>Referral::find($val->patient_id)->mrn,
                'nurse_id' => Nurse::find($val->nurse_id)->name,
                'report' => $val->report,
                'reporter' => $val->reporter,
                'staffer' => $val->staffer,
                'report_date' => convert_date_from_db($val->report_date),
                'fu_action' => $val->fu_action,
                'id' => $val->id,
            ];
        }

        return response()->json([
            'data' => $data,
            'draw' => intval($req->input('draw'))
        ]);
    }


    public function dt_addnote(Request $req, $id){
        $newNote = New_order::where('patient_id',$id)->get();

        $data = [];

        foreach ($newNote as $val) {
            $data[] = [
                'order_type' => Order_type::find($val->order_type)->description,
                'new_order' => $val->new_order,
                'start_date' => convert_date_from_db($val->start_date),
                'end_date' => convert_date_from_db($val->end_date),
                'id' => $val->id,
            ];
        }

        return response()->json([
            'data' => $data,
            'draw' => intval($req->input('draw'))
        ]);
    }


    public function edit_schedule(Request $req){
        $data = Scheduling::find($req->id);
        
        
        $html = '<form action="javascript:void(0)" id="frmUpdtSchdule" data-parsley-validate>
        <input type="hidden" value='.$req->id.' name="id" id="">
        <div class="row mb-5">
            <div class="col-md-6 fv-row">
                <label class="fs-5 fw-semibold mb-2">Visit Date</label>
                <input type="text" name="visit_date" class="form-control kt_datepicker form-control-solid" id="" placeholder="mm-dd-yyyy" value="'.convert_date_from_db($data->visit_date).'" required/>
                <span class=" alert-danger visit_date-error" id=""></span>
            </div>
            <div class="col-md-6 fv-row">
                <label class="fs-5 fw-semibold mb-2">Patient Name</label>
                <input type="text" class="form-control form-control-solid" placeholder=""
                    name="" value="'.Referral::find($data->patient_id)->name.'" readonly />
                    
            </div>
        </div>
        <div class="row mb-5">
            <div class="col-md-6 fv-row">
                <label class="fs-5 fw-semibold mb-2">Visit Type</label>
                <select name="visit_type" class=" form-select" id="" data-control="select2">
                <option value='.$data->visit_type.'>'.Visit_type::find($data->visit_type)->description.'</option>';
                    foreach (Visit_type::all() as $item){
                        $html .= '<option value="'.$item->id .'"> '.$item->description.'</option>';
                    }
                $html .= '</select>
                <span class=" alert-danger visit_type-error" id=""></span>
            </div>
            <div class="col-md-6 fv-row">
                <label class="fs-5 fw-semibold mb-2">RN</label>
                <select name="nurse_id" class=" form-select" id="" data-control="select2">
                <option value='.$data->nurse_id.'>'.Nurse::find($data->nurse_id)->name.'</option>';
                    foreach (Nurse::all() as $item){
                        $html .= '<option value='.$item->id.'> '.$item->name.'</option>';
                    }
                $html .= '</select>
                <span class=" alert-danger nurse_id-error" id=""></span>
            </div>
        </div>
        <div class="row mb-5">
            <div class="col-md-6 fv-row">
                <label class="fs-5 fw-semibold mb-2">Client</label>
                <select name="client" id="" data-control="select2"
                                    data-dropdown-parent="#exampleModal" class=" form-select ref_source">
                                    <option value="'.$data->client.'">'.Clients::find($data->client)->cname.'</option>';
                                    foreach (Clients::all() as $item){
                                        $html .='<option value="'.$item->id.'">'.$item->cname.'</option>';
                }
                        $html .='</select>
                <span class=" alert-danger client-error" id=""></span>
            </div>
            <div class="col-md-6 fv-row">
                <label class="fs-5 fw-semibold mb-2">Staffer</label>
                <input type="text" class="form-control form-control-solid" placeholder=""
                    name="staffer" value="'.Auth::user()->name.'" readonly />
                    <span class=" alert-danger staffer-error" id=""></span>
            </div>
        </div>
        <div class="row mb-5">
            <div class="col-md-6 fv-row">
                <label class="fs-5 fw-semibold mb-2">ETA</label>
                <textarea name="eta" id="" class="form-control form-control-solid">'.$data->eta.'</textarea>
                <span class=" alert-danger eta-error" id=""></span>
            </div>
            <div class="col-md-6 fv-row">
                <label class="fs-5 fw-semibold mb-2">Remarks</label>
                <textarea name="remarks" id="" class="form-control form-control-solid">'.$data->remarks.'</textarea>
                <span class=" alert-danger remarks-error" id=""></span>
            </div>
        </div>
        <div class="mt-8">
            <button type="submit" class="btn btn-primary" id="kt_sign_in_submit">
                <span class="indicator-label">Save</span>
                <span class="indicator-progress">Please wait...
                    <span class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
            </button>
        </div>
    </form>';

    return response()->json($html);
    }




    public function edit_progress(Request $req){
        $data = Progress_note::find($req->id);
        
        $html = '<form action="javascript:void(0)" id="frmUpdtProgress">
        <input type="hidden" value="'.$req->id.'" name="id" id="">
        <div class="row mb-5">
            <div class="col-md-6 fv-row">
                <label class="fs-5 fw-semibold mb-2">MRN</label>
                <input type="text" class="form-control form-control-solid" id="" readonly
                    value="'.Referral::find($data->patient_id)->mrn.'" />
            </div>
            <div class="col-md-6 fv-row">
                <label class="fs-5 fw-semibold mb-2">Nurse</label>
                <select name="nurse_id" class=" form-select" id="" data-control="select2">
                <option value='.$data->nurse_id.'>'.Nurse::find($data->nurse_id)->name.'</option>';
                    foreach (Nurse::all() as $item){
                        $html .= '<option value='.$item->id.'>'.$item->name.'</option>';
                    }
                $html .= '</select>
                <span class=" alert-danger nurse_id-error" id=""></span>
            </div>
        </div>
        <div class="row mb-5">
            <div class="col-md-6 fv-row">
                <label class="fs-5 fw-semibold mb-2">Report</label>
                <textarea name="report" id="" class="form-control form-control-solid">'.$data->report.'</textarea>
                <span class=" alert-danger report-error" id=""></span>
            </div>
            <div class="col-md-6 fv-row">
                <label class="fs-5 fw-semibold mb-2">Reporter</label>
                <textarea name="reporter" id="" class="form-control form-control-solid">'.$data->reporter.'</textarea>
                <span class=" alert-danger reporter-error" id=""></span>
            </div>
        </div>
        <div class="row mb-5">
            <div class="col-md-6 fv-row">
                <label class="fs-5 fw-semibold mb-2">Report Date</label>
                <input type="text" class="form-control form-control-solid kt_datepicker"
                    name="report_date" id="report_date" value="'.convert_date_from_db($data->report_date).'" placeholder="mm-dd-yyyy">
                    <span class=" alert-danger report_date-error" id=""></span>
            </div>
            <div class="col-md-6 fv-row">
                <label class="fs-5 fw-semibold mb-2">Staffer</label>
                <input type="text" class="form-control form-control-solid"
                    name="staffer" id="" value="'.$data->staffer.'" readonly>
                    <span class=" alert-danger staffer-error" id=""></span>
            </div>
        </div>
        <div class="row mb-5">
            <div class="col-md-6 fv-row">
                <label for="" class="fs-5 fw-semibold mb-2">F/U Action</label>
                <textarea name="fu_action" id="" class=" form-control form-control-solid">'.$data->fu_action.'</textarea>
                <span class=" alert-danger fu_action-error" id=""></span>
            </div>
        </div>
        <div class="mt-8">
            <button type="submit" class="btn btn-primary" id="kt_sign_in_submit">
                <span class="indicator-label">Save</span>
                <span class="indicator-progress">Please wait...
                    <span class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
            </button>
        </div>
    </form>';

    return response()->json($html);
    }


    public function edit_note(Request $req){
        $data = New_order::find($req->id);

        $html = ' <form action="javascript:void(0)" id="frmUpdtNewNote">
        <input type="hidden" value="'.$req->id.'" name="id" id="">
        <div class="row mb-5">
            <div class="col-md-6 fv-row">
                <label class="fs-5 fw-semibold mb-2">Order Type</label>
                <select name="order_type" id="" class="form-select" data-control="select2">
                <option value='.$data->order_type.'>'.Order_type::find($data->order_type)->description.'</option>';
                    foreach (Order_type::all() as $item){
                        $html .='<option value="{{ $item->id }}">{{ $item->description }}</option>';
                }
                $html .='</select>
                <span class=" alert-danger order_type-error" id=""></span>
            </div>
            <div class="col-md-6 fv-row">
                <label class="fs-5 fw-semibold mb-2">New Order</label>
                <textarea name="new_order" id="" class=" form-control form-control-solid">'.$data->new_order.'</textarea>
                <span class=" alert-danger new_order-error" id=""></span>
            </div>
        </div>
        <div class="row mb-5">
            <div class="col-md-6 fv-row">
                <label class="fs-5 fw-semibold mb-2">Start Date</label>
                <input type="text" name="start_date" value='.convert_date_from_db($data->start_date).'
                    class=" form-control form-control-solid" id="start_date"
                    placeholder="mm-dd-yyyy">
                    <span class=" alert-danger start_date-error" id=""></span>
            </div>
            <div class="col-md-6 fv-row">
                <label class="fs-5 fw-semibold mb-2">End Date</label>
                <input type="text" name="end_date" value='.convert_date_from_db($data->end_date).'
                    class=" form-control form-control-solid" id="end_date"
                    placeholder="mm-dd-yyyy">
                    <span class=" alert-danger end_date-error" id=""></span>
            </div>
        </div>
        <div class="mt-8">
            <button type="submit" class="btn btn-primary" id="kt_sign_in_submit">
                <span class="indicator-label">Save</span>
                <span class="indicator-progress">Please wait...
                    <span class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
            </button>
        </div>
    </form>';

    return response()->json($html);
    }



    public function update_schedule(Request $req){
        
        $rules = [
            'visit_date' => 'required',
            // 'visit_type' => 'required',
        ];

        $validator = Validator::make($req->all(), $rules);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()]);
        }
        
        
        try {
            
                $newSch = Scheduling::find($req->id);

                $newSch->visit_date = convert_date_to_db($req->visit_date);
                $newSch->visit_type = $req->visit_type;
                $newSch->nurse_id = $req->nurse_id;
                $newSch->client = $req->client;
                $newSch->staffer = $req->staffer;
                $newSch->eta = $req->eta;
                $newSch->remarks = $req->remarks;

                $newSch->update();

                return response()->json(['success' => "Added Successfully"]);
            
        } catch (\Exception $ex) {
            Log::channel('custom')->error($ex->getMessage());
            return response()->json(['logginError' => "Error Occured. Contact System Admin"]);
        }
    }


    public function find_single_referral(Request $req)
    {
        $data = Referral::find($req->id);

        return response()->json($data);
    }

    public function delete(Request $req)
    {
        $delete = Referral::find($req->id);

        $delete->delete();

        return response()->json(['msg' => 'Deleted Successfully']);
    }


    public function delete_schedule(Request $req)
    {
        $delete = Scheduling::find($req->id);

        $delete->delete();

        return response()->json(['msg' => 'Deleted Successfully']);
    }


    public function delete_progress(Request $req)
    {
        $delete = Progress_note::find($req->id);

        $delete->delete();

        return response()->json(['msg' => 'Deleted Successfully']);
    }


    public function delete_new(Request $req)
    {
        $delete = New_order::find($req->id);

        $delete->delete();

        return response()->json(['msg' => 'Deleted Successfully']);
    }


    public function save_onboarding(Request $req){
        $rules = [
            'staffer' => 'required',
        ];

        $validator = Validator::make($req->all(), $rules);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()]);
        }

        $board = Onboarding::where('patient_id',$req->patient_id)->first();
        try {
            $board->patient_id = $req->patient_id;
            $board->ref_info = $req->ref_info;
            $board->rx_order = $req->rx_order;
            $board->loa_received = $req->loa_received;
            $board->loa_extracted = $req->loa_extracted;
            $board->date_entry = $req->date_entry;
            $board->lab_form = $req->lab_form;
            $board->order_emailed = $req->order_emailed;
            $board->rn_informed = $req->rn_informed;
            $board->lab_form_emailed = $req->lab_form_emailed;
            $board->pt_contracted = $req->pt_contracted;
            $board->pt_welcome = $req->pt_welcome;
            $board->addr_correct = $req->addr_correct;
            $board->phone_number_reliable = $req->phone_number_reliable;
            $board->get_access_code = $req->get_access_code;
            $board->nurse_park = $req->nurse_park;
            $board->pt_teach_train = $req->pt_teach_train;
            $board->staffer = Auth::user()->id;
            $board->remarks = $req->remarks;

            $board->update();
            return response()->json(['success' => "Created Successfully"]);
        } catch (\Exception $ex) {
            Log::channel('custom')->error($ex->getMessage());
            return response()->json(['logginError' => "Error Occured. Contact System Admin"]);
        }
    }


    



}

