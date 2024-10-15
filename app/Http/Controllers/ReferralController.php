<?php

namespace App\Http\Controllers;

use App\Models\Pump;
use App\Models\User;
use App\Models\Nurse;
use App\Models\Status;
use App\Models\Md_order;
use App\Models\Referral;
use App\Models\Access_type;
use App\Models\Client_contact;
use App\Models\Clients;
use App\Models\Onboarding;
use App\Models\Payer_info;
use App\Models\Physician_info;
use App\Models\Potential_rn;
use Illuminate\Http\Request;
use App\Models\Referral_source;
use App\Models\Scheduling;
use App\Models\Service_info;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class ReferralController extends Controller
{
    public function index()
    {

        return view('referral.index');
    }

    public function dt_referrals(Request $req)
    {
        $referrals = Referral::all();

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
                'status' => Status::find($val->status)->description,
                'id' => $val->id,
            ];
        }

        return response()->json([
            'data' => $data,
            'draw' => intval($req->input('draw'))
        ]);
    }

    public function save_referrals(Request $req)
    {

        $rules = [
            'name' => 'required',
            // 'mrn' => 'required|unique:referrals',

            'ref_date' => 'required',
            'soc_date' => 'required',
            'access_type_id' => 'required',
            'pump_id' => 'required',
            'ref_source_type_id' => 'required',
            'ref_source_staff' => 'required',
            'potential_rn_1' => 'required',
            'md_order_1' => 'required',
            'booked_rn' => 'required',
        ];

        $validator = Validator::make($req->all(), $rules);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()]);
        }


        DB::beginTransaction();

        $referral = new Referral();
        $service_infos = new Service_info();
        $physician_info = new Physician_info();
        $payer = new Payer_info();
        $board = new Onboarding();

        try {
            $referral->name = $req->name;
            $referral->mrn = generateID('P');
            $referral->street_addr = $req->street_addr;
            $referral->ref_date = convert_date_to_db($req->ref_date);
            $referral->soc_date = convert_date_to_db($req->soc_date);
            $referral->access_type_id = $req->access_type_id;
            $referral->pump_id = $req->pump_id;
            $referral->ref_source_type_id = $req->ref_source_type_id;
            $referral->ref_source_staff = $req->ref_source_staff;
            $referral->booked_rn = $req->booked_rn;
            $referral->state = $req->state;
            $referral->zip = $req->zip;
            $referral->city = $req->city;
            $referral->status = $req->status;
            $referral->reason = $req->reason;
            $referral->md_order_1 = $req->md_order_1;
            $referral->md_order_2 = $req->md_order_2;
            $referral->md_order_3 = $req->md_order_3;
            $referral->potential_rn_1 = $req->potential_rn_1;
            $referral->potential_rn_2 = $req->potential_rn_2;
            $referral->potential_rn_3 = $req->potential_rn_3;
            // $referral->address = $req->address;
            $referral->staff = Auth::user()->id;



            $referral->save();

            $physician_info->patient_id = $referral->id;
            $service_infos->patient_id = $referral->id;
            $payer->patient_id = $referral->id;
            $board->patient_id = $referral->id;

            $physician_info->save();
            $service_infos->save();
            $payer->save();
            $board->save();

            DB::commit();

            return response()->json(['success' => "Added Successfully"]);
        } catch (\Exception $ex) {
            Log::channel('custom')->error($ex->getMessage());

            DB::rollBack();

            return response()->json(['logginError' => "Error Occured. Contact System Admin"]);
        }
    }
    


    public function update_referrals(Request $req)
    {

        DB::beginTransaction();

        $referral =  Referral::find($req->id);

        $rules = array();

        try {
            if ($referral->mrn != $req->mrn) {
                $rules = [
                    'name' => 'required',
                    // 'mrn' => 'required|unique:referrals',

                    'ref_date' => 'required',
                    'soc_date' => 'required',
                    'access_type_id' => 'required',
                    'pump_id' => 'required',
                    'ref_source_type_id' => 'required',
                    'ref_source_staff' => 'required',
                    'potential_rn_1' => 'required',
                    'md_order_1' => 'required',
                    'booked_rn' => 'required',
                ];
            } else {
                $rules = [
                    'name' => 'required',

                    'ref_date' => 'required',
                    'soc_date' => 'required',
                    'access_type_id' => 'required',
                    'pump_id' => 'required',
                    'ref_source_type_id' => 'required',
                    'ref_source_staff' => 'required',
                    'potential_rn_1' => 'required',
                    'md_order_1' => 'required',
                    'booked_rn' => 'required',
                ];
            }

            $validator = Validator::make($req->all(), $rules);

            if ($validator->fails()) {
                return response()->json(['errors' => $validator->errors()]);
            }
            $referral->name = $req->name;
            // $referral->mrn = $req->mrn;
            // $referral->address = convert_date_to_db($req->address);
            $referral->ref_date = convert_date_to_db($req->ref_date);
            $referral->soc_date = convert_date_to_db($req->soc_date);
            $referral->access_type_id = $req->access_type_id;
            $referral->pump_id = $req->pump_id;
            $referral->ref_source_type_id = $req->ref_source_type_id;
            $referral->ref_source_staff = $req->ref_source_staff;
            $referral->booked_rn = $req->booked_rn;
            $referral->state = $req->state;
            $referral->street_addr = $req->street_addr;
            $referral->zip = $req->zip;
            $referral->city = $req->city;
            $referral->status = $req->status;
            $referral->reason = $req->reason;
            $referral->md_order_1 = $req->md_order_1;
            $referral->md_order_2 = $req->md_order_2;
            $referral->md_order_3 = $req->md_order_3;
            $referral->potential_rn_1 = $req->potential_rn_1;
            $referral->potential_rn_2 = $req->potential_rn_2;
            $referral->potential_rn_3 = $req->potential_rn_3;
            $referral->staff = Auth::user()->id;


            $referral->update();

            DB::commit();

            return response()->json(['success' => "Added Successfully"]);
        } catch (\Exception $ex) {
            Log::channel('custom')->error($ex->getMessage());

            DB::rollBack();

            return response()->json(['logginError' => "Error Occured. Contact System Admin"]);
        }
    }


    public function edit_referrals(Request $req)
    {
        $data = Referral::find($req->id);

        $html = "<script>
        
        </script>";
        $html .= '<form action="javascript:void(0)" id="frmUpReferral" data-parsley-validate>
        <input type="hidden" class="" value="' . $data->id . '" name="id">
        <div class="row">
            <div class="col-md-8">
                <label for="">Name</label>
                <input type="text" class=" form-control" value="' . $data->name . '" name="name"  id=""
                    required>
                    <span class=" alert-danger name-error" id=""></span>
            </div>
            <div class="col-md-4">
                <label for="">MRN</label>
                <input type="text" class=" form-control" value="' . $data->mrn . '" name="mrn" id="" readonly>
                <span class=" alert-danger mrn-error" id=""></span>
            </div>
        </div>
        <div class="row mt-8">
        <div class="col-md-3">
        <label for="">Address</label>
        <input type="text" value="'.$data->street_addr.'" class=" form-control" name="street_addr" id="">
        <span class=" alert-danger street_addr-error" id=""></span>
    </div>
                            <div class="col-md-3">
                                <label for="">City</label>
                                <input type="text" value="' . $data->city . '" class=" form-control" name="city" id="">
                                <span class=" alert-danger city-error" id=""></span>
                            </div>
                            <div class="col-md-3">
                                <label for="">State</label>
                                <input type="text" class=" form-control" value="' . $data->state . '" name="state" id="">
                                <span class=" alert-danger state-error" id=""></span>
                            </div>
                            <div class="col-md-3">
                                <label for="">Zip</label>
                                <input type="text" class="form-control" value="' . $data->zip . '" name="zip"
                                    id="">
                                <span class=" alert-danger zip-error" id=""></span>
                            </div>
                        </div>
        <div class="row mt-8">
            <div class="col-md-12">
                <label for="">MD Order 1</label>
                <input type="text" name="md_order_1" class="form-control" value="' . $data->md_order_1 . '" id="">
            </div>
        </div>
        <div class="row mt-8">
            <div class="col-md-12">
                <label for="">MD Order 2</label>
                <input type="text" name="md_order_2" class="form-control" value="' . $data->md_order_2 . '" id="">
            </div>
        </div>
        <div class="row mt-8">
            <div class="col-md-12">
                <label for="">MD Order 3</label>
                <input type="text" name="md_order_3" class="form-control" value="' . $data->md_order_3 . '" id="">
            </div>
        </div>
        <div class="row mt-8">
            <div class="col-md-6">
                <label for="">Refferal Date</label>
                <input type="text" class=" form-control kt_datepicker" value="' . convert_date_from_db($data->ref_date) . '" name="ref_date" id="" required>
                <span class=" alert-danger ref_date-error" id=""></span>
            </div>
            <div class="col-md-6">
                <label for="">SOC Date</label>
                <input type="text" class=" form-control kt_datepicker" value="' . convert_date_from_db($data->soc_date) . '" name="soc_date" id="" required>
                <span class=" alert-danger soc_date-error" id=""></span>
            </div>
        </div>
        <div class="row mt-8">
            <div class="col-md-4">
                <label for="">Access Type</label>
                <select name="access_type_id" id="" class=" form-select" data-control="select2" data-dropdown-parent="#mdEdit" required>
                    <option value=' . $data->access_type_id . '>' . Access_type::find($data->access_type_id)->description . '</option>';
        foreach (Access_type::all() as $item) {
            $html .= '<option value=' . $item->id . '>' . $item->description . '</option>';
        }
        $html .= '</select>
                <span class=" alert-danger access_type_id-error" id=""></span>
            </div>
            <div class="col-md-4">
                <label for="">Pumps</label>
                <select name="pump_id" id="" class=" form-select" data-control="select2" data-dropdown-parent="#mdEdit" required>
                <option value=' . $data->pump_id . '>' .Pump::find($data->pump_id)->description. '</option>';
        foreach (Pump::all() as $item) {
            $html .= '<option value=' . $item->id . '>' . $item->description . '</option>';
        }
        $html .= '</select>
                <span class=" alert-danger pump_id-error" id=""></span>
            </div>
            <div class="col-md-4">
                <label for="">Referral Source</label>
                <select name="ref_source_type_id" id="" class=" form-select ref_source" data-control="select2" data-dropdown-parent="#mdEdit">
                <option value=' . $data->ref_source_type_id . '>' . Clients::find($data->ref_source_type_id)->cname . '</option>';
        foreach (Clients::all() as $item) {
            $html .= '<option value=' . $item->id . '>' . $item->cname . '</option>';
        }
        $html .= '</select>
                <span class=" alert-danger ref_source_type_id-error" id=""></span>
            </div>
        </div>
        <div class="row mt-8">
            <div class="col-md-6">
                <label for="">Referral Source Staff</label>
                <select class=" form-select ref_source_staff" name="ref_source_staff" id="" data-control="select2" required>
                <option value="' . $data->ref_source_staff . '">' . Client_contact::find($data->ref_source_staff)->contact_person . '</option>
            </select>
                    <span class=" alert-danger ref_source_staff-error" id=""></span>
            </div>
        </div>
        <div class="row mt-8">
                            <div class="col-md-4">
                                <label for="">Potential RN (Registered Nurse) 1</label>
                                <select name="potential_rn_1" id="" class=" form-select select2-input"
                                    data-control="select2" tabindex="-1" data-dropdown-parent="#mdEdit">
                                    <option value=' . $data->potential_rn_1 . '>' . Nurse::find($data->potential_rn_1)->name . '</option>';
        foreach (Nurse::all() as $item) {
            $html .= '<option value="' . $item->id . '">
                                                                        ' . $item->name . '</option>';
        }
        $html .= '</select>
        <span class=" alert-danger potential_rn_1-error" id=""></span>
                            </div>
                            <div class="col-md-4">
                                <label for="">Potential RN (Registered Nurse) 2</label>
                                <select name="potential_rn_2" id="" class=" form-select select2-input"
                                    data-control="select2" tabindex="-1" data-dropdown-parent="#mdEdit">
                                    <option value=' . ($data->potential_rn_2 != null ? Nurse::find($data->potential_rn_2)->id : '') . '>' . ($data->potential_rn_2 != null ? Nurse::find($data->potential_rn_2)->name : '') . '</option>';
        foreach (Nurse::all() as $item) {
            $html .= '<option value="' . $item->id . '">
                                                                        ' . $item->name . '</option>';
        }
        $html .= '</select>
                            </div>
                            <div class="col-md-4">
                                <label for="">Potential RN (Registered Nurse) 3</label>
                                <select name="potential_rn_3" id="" class=" form-select"
                                    data-control="select2" tabindex="-1" data-dropdown-parent="#mdEdit">
                                    <option value=' . ($data->potential_rn_3 != null ? Nurse::find($data->potential_rn_3)->id : '') . '>' . ($data->potential_rn_3 != null ? Nurse::find($data->potential_rn_3)->name : '') . '</option>';
        foreach (Nurse::all() as $item) {
            $html .= '<option value="' . $item->id . '">
                                                                        ' . $item->name . '</option>';
        }
        $html .= '</select>
                            </div>
                        </div>   
        
        <div class="row mt-8">
            <div class="col-md-6">
                <label for="">Status</label>
                <select name="status" id="" class=" form-select">
                <option value=' . $data->status . '>' . Status::find($data->status)->description . '</option>';
        foreach (Status::all() as $item) {
            $html .= '<option value=' . $item->id . '>' . $item->description . '</option>';
        }
        $html .= '</select>
                <span class=" alert-danger status-error" id=""></span>
            </div>
        </div>
        <div class="row mt-8">
            <div class="col-md-12">
                <label for="">Reason</label>
                <textarea name="reason" id="" class=" form-control">' . $data->reason . '</textarea>
                <span class=" alert-danger reason-error" id=""></span>
            </div>
        </div>
        <div class="row mt-8">
            <div class="col-md-6">
                <label for="">RN Booked</label>
                <select name="booked_rn" id="" class=" form-select" data-control="select2" data-dropdown-parent="#mdEdit" required>
                    <option value="' . $data->booked_rn . '">' . Nurse::find($data->booked_rn)->name . '</option>';
        foreach (Nurse::all() as $item) {
            $html .= '<option value=' . $item->id . '>' . $item->name . '
                        </option>';
        }
        $html .= '</select>
                <span class=" alert-danger booked_rn-error" id=""></span>
            </div>
            <div class="col-md-6">
                <label for="">Staff</label>
                <input type="text" class=" form-control" value="' . User::find($data->staff)->name . '" name="staff" id=""
                    value="{{ Auth::user()->name }}">
                    <span class=" alert-danger staff-error" id=""></span>
            </div>
        </div>
        <div class="modal-footer mt-3">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            <button type="submit" class="btn btn-primary" id="kt_sign_in_submit">
                <span class="indicator-label">Save</span>
                <span class="indicator-progress">Please wait...
                    <span class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
            </button>
        </div>
    </form>';

        return response()->json($html);
    }


    public function find_single_referral(Request $req)
    {
        $data = Referral::find($req->id);

        return response()->json($data);
    }

    public function delete(Request $req)
    {
        $delete = Referral::find($req->id);
        $delete_sc = Scheduling::where('patient_id', $req->id)->delete();

        $delete->delete();



        return response()->json(['msg' => 'Deleted Successfully']);
    }

    public function get_clients(Request $req)
    {
        $clients = Client_contact::where('client_id', $req->id)->get();
        $html = '';
        
            $html .= ' <select class=" form-select " name="ref_source_staff" id="" data-control="select2" required>
            <option value="">Select Referral Source</option>';
            foreach ($clients as $key) {
            $html .= '<option value="' . $key->id . '">' . $key->contact_person . '</option>';
        }
        $html .= ' </select>';
           
       

        return response()->json($html);
    }
}


function generateID($prefix, $padding = 4) {
     // Retrieve the last inserted MRN
     $lastMRN = Referral::orderBy('mrn', 'desc')->value('mrn');

     // Extract the numeric part of the MRN and increment it
     $number = (int)substr($lastMRN, 1) + 1;
 
     // Generate the new ID with zero-padding
     $paddedNumber = str_pad($number, $padding, '0', STR_PAD_LEFT);
     $id = $prefix . $paddedNumber;
 
     return $id;
}
