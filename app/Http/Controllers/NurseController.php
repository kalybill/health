<?php

namespace App\Http\Controllers;

use App\Models\Credential_tracking;
use App\Models\Document;
use App\Models\Nurse;
use App\Models\Nurse_geographical;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class NurseController extends Controller
{
    public function index()
    {

        return view('nurse.index');
    }

    public function nurses_list(){
        $nurses = Nurse::all();
        return response()->json($nurses);
    }


    public function save_nurse(Request $req)
    {
        $rules = [
            'name' => 'required',
        ];

        $validator = Validator::make($req->all(), $rules);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()]);
        }

        $nurse = new Nurse();

        try {
            $nurse->name = $req->name;
            $nurse->telephone = $req->telephone;
            $nurse->email = $req->email;
            $nurse->email = $req->email;
            $nurse->company_name = $req->company_name;
            $nurse->alt_phone = $req->alt_phone;
            $nurse->address = $req->address;
            $nurse->work_phone = $req->work_phone;
            $nurse->city = $req->city;
            $nurse->state = $req->state;
            $nurse->zip = $req->zip;
            $nurse->dob = convert_date_to_db($req->dob);
            $nurse->status = $req->status;
            $nurse->discipline = $req->discipline;
            $nurse->specialty = $req->specialty;
            $nurse->education = $req->education;
            $nurse->current_job = $req->current_job;
            $nurse->current_shift = $req->current_shift;
            $nurse->coverage_area = $req->coverage_area;
            $nurse->recruiter = $req->recruiter;
            $nurse->recruiter_src = $req->recruiter_src;
            $nurse->remark = $req->remark;
            $nurse->application_date = convert_date_to_db($req->application_date);
            $nurse->rn_contracted = convert_date_to_db($req->rn_contracted);
            $nurse->prescreen_interview = convert_date_to_db($req->prescreen_interview);
            $nurse->application = convert_date_to_db($req->application);
            $nurse->all_documents_submitted = convert_date_to_db($req->all_documents_submitted);
            $nurse->background_check_completed = ($req->background_check_completed);
            $nurse->ref_check_completed = convert_date_to_db($req->ref_check_completed);
            $nurse->orientation = convert_date_to_db($req->orientation);
            $nurse->contract_signed = convert_date_to_db($req->contract_signed);
            $nurse->shadowed = convert_date_to_db($req->shadowed);
            $nurse->first_visit = convert_date_to_db($req->first_visit);

            $nurse->save();

            return response()->json(['success' => "Added Successfully"]);
        } catch (\Exception $ex) {
            Log::channel('custom')->error($ex->getMessage());
            return response()->json(['logginError' => "Error Occured. Contact System Admin"]);
        }
    }


    public function dt_nurse(Request $req)
    {
        $nurse = Nurse::all();

        $data = [];

        foreach ($nurse as $val) {
            $data[] = [
                'name' => $val->name,

                'telephone' => $val->telephone,
                'email' => $val->email,
                'id' => $val->id,
            ];
        }

        return response()->json([
            'data' => $data,
            'draw' => intval($req->input('draw'))
        ]);
    }


    public function edit_nurse(Request $req)
    {
        $data = Nurse::find($req->id);

        $html = '<script>
        var input1 = document.querySelector("#kt_tagify_1");
var input2 = document.querySelector("#kt_tagify_2");

new Tagify(input1);
new Tagify(input2);

        $(".CHKrn_contracted").click(function () { 
        
            if ($(".CHKrn_contracted").is(":checked")) {
               $(".rn_contracted").prop("required", true)
            } else {
                $(".rn_contracted").prop("required", false)
                $(".rn_contracted").val("")
            }
        });
        $(".CHKprescreen_interview").click(function () { 
            if ($(".CHKprescreen_interview").is(":checked")) {
               $(".prescreen_interview").prop("required", true)
            } else {
                $(".prescreen_interview").prop("required", false)
                $(".prescreen_interview").val("")
            }
        });
        $(".CHKapplication").click(function () { 
            if ($(".CHKapplication").is(":checked")) {
               $(".application").prop("required", true)
            } else {
                $(".application").prop("required", false)
                $(".application").val("")
            }
        });
        $(".CHKall_documents_submitted").click(function () { 
            if ($(".CHKall_documents_submitted").is(":checked")) {
               $(".all_documents_submitted").prop("required", true)
            } else {
                $(".all_documents_submitted").prop("required", false)
                $(".all_documents_submitted").val("")
            }
        });
        $(".CHKbackground_check_completed").click(function () { 
            if ($(".CHKbackground_check_completed").is(":checked")) {
               $(".background_check_completed").prop("required", true)
            } else {
                $(".background_check_completed").prop("required", false)
                $(".background_check_completed").val("")
            }
        });
        $(".CHKfile_created").click(function () { 
            if ($(".CHKfile_created").is(":checked")) {
               $(".file_created").prop("required", true)
            } else {
                $(".file_created").prop("required", false)
                $(".file_created").val("")
            }
        });
        $(".CHKref_check_completed").click(function () { 
            if ($(".CHKref_check_completed").is(":checked")) {
               $(".ref_check_completed").prop("required", true)
            } else {
                $(".ref_check_completed").prop("required", false)
                $(".ref_check_completed").val("")
            }
        });
        $(".CHKorientation").click(function () { 
            if ($(".CHKorientation").is(":checked")) {
               $(".orientation").prop("required", true)
            } else {
                $(".orientation").prop("required", false)
                $(".orientation").val("")
            }
        });
        $(".CHKcontract_signed").click(function () { 
            if ($(".CHKcontract_signed").is(":checked")) {
               $(".contract_signed").prop("required", true)
            } else {
                $(".contract_signed").prop("required", false)
                $(".contract_signed").val("")
            }
        });
        $(".CHKshadowed").click(function () { 
            if ($(".CHKshadowed").is(":checked")) {
               $(".shadowed").prop("required", true)
            } else {
                $(".shadowed").prop("required", false)
                $(".shadowed").val("")
            }
        });
        $(".CHKfirst_visit").click(function () { 
            if ($(".CHKfirst_visit").is(":checked")) {
               $(".first_visit").prop("required", true)
            } else {
                $(".first_visit").prop("required", false)
                $(".first_visit").val("")
            }
        });
        $(".kt_datepicker").flatpickr({
            dateFormat: "m-d-Y",
        });
        </script>';
        $html .= '<form action="javascript:void(0)" data-parsley-validate id="frmUptAccessType">
        <input type="hidden" value="' . $data->id . '" name="id" required>
        <div class="row">
                            <div class="col-md-6">
                                <div class="col-md-12">
                                    <h5>Nurse’s Personal Details</h5>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <label for="">Name</label>
                                        <input type="text" class="form-control-solid form-control" name="name"
                                            id="" required value="' . $data->name . '">
                                        <span class=" alert-danger name-error" id=""></span>
                                    </div>
                                    <div class="col-md-6">
                                        <label for="">Phone</label>
                                        <input type="tel" class="form-control-solid form-control" name="telephone"
                                            id="" required value="' . $data->telephone . '">
                                        <span class=" alert-danger telephone-error" id=""></span>
                                    </div>
                                </div>
                                <div class="row mt-8">
                                    <div class="col-md-6">
                                        <label for="">Company Name</label>
                                        <input type="text" class="form-control-solid form-control" name="company_name"
                                            id="" required value="' . $data->company_name . '">
                                        <span class=" alert-danger company_name-error" id=""></span>
                                    </div>
                                    <div class="col-md-6">
                                        <label for="">Alt Phone</label>
                                        <input type="text" class="form-control-solid form-control" name="alt_phone"
                                            id="" required value="' . $data->alt_phone . '">
                                        <span class=" alert-danger alt_phone-error" id=""></span>
                                    </div>
                                </div>
                                <div class="row mt-8">
                                    <div class="col-md-6">
                                        <label for="">Address</label>
                                        <input type="text" class="form-control-solid form-control" name="address"
                                            id="" required value="' . $data->address . '">
                                        <span class=" alert-danger address-error" id=""></span>
                                    </div>
                                    <div class="col-md-6">
                                        <label for="">Work Phone</label>
                                        <input type="text" class="form-control-solid form-control" name="work_phone"
                                            id="" required value="' . $data->work_phone . '">
                                        <span class=" alert-danger work_phone-error" id=""></span>
                                    </div>
                                </div>
                                <div class="row mt-8">
                                    <div class="col-md-6">
                                        <label for="">City</label>
                                        <input type="text" class="form-control-solid form-control" name="city"
                                            id="" required value="' . $data->city . '">
                                        <span class=" alert-danger city-error" id=""></span>
                                    </div>
                                    <div class="col-md-6">
                                        <label for="">Email</label>
                                        <input type="email" class="form-control-solid form-control" name="email"
                                            id="" required value="' . $data->email . '">
                                        <span class=" alert-danger email-error" id=""></span>
                                    </div>
                                </div>
                                <div class="row mt-8">
                                    <div class="col-md-6">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <label for="">State</label>
                                                <input type="text" class="form-control-solid form-control"
                                                    name="state" id="" required value="' . $data->state . '">
                                                <span class=" alert-danger state-error" id=""></span>
                                            </div>
                                            <div class="col-md-6">
                                                <label for="">Zip</label>
                                                <input type="text" class="form-control-solid form-control"
                                                    name="zip" id="" required value="' . $data->zip . '">
                                                <span class=" alert-danger zip-error" id=""></span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <label for="">DoB</label>
                                                <input type="text"
                                                    class=" form-control kt_datepicker form-control-solid" name="dob"
                                                    id="" required value="' . convert_date_from_db($data->dob) . '">
                                                <span class=" alert-danger dob-error" id=""></span>
                                            </div>
                                            <div class="col-md-6">
                                                <label for="">Status</label>
                                                <select name="status" id="" class=" form-select">
                                                    <option value="' . $data->status . '">' . $data->status . '</option>
                                                    <option value="Active">Active</option>
                                                    <option value="Inactive">Inactive</option>
                                                    <option value="Pending">Pending</option>
                                                    <option value="Resigned">Resigned</option>
                                                    <option value="Suspended">Suspended</option>
                                                    <option value="Terminated">Terminated</option>
                                                </select>
                                                <span class=" alert-danger status-error" id=""></span>
                                            </div>

                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="col 12">
                                    <h5>Work Information</h5>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <label for="">Discipline</label>
                                        <select name="discipline" id="" class="form-select">
                                            <option value=' . $data->discipline . '>' . $data->discipline . '</option>
                                            <option value="">Registered Nurse</option>
                                            <option value="">Lic Voc Nurse</option>
                                        </select>
                                        <span class=" alert-danger discipline-error" id=""></span>
                                    </div>
                                    <div class="col-md-6 ">
                                        <label for="">Specialty</label>
                                        <input type="text" class=" form-control form-control-solid" name="specialty"
                                            id="" value="' . $data->specialty . '">
                                            <span class=" alert-danger specialty-error" id=""></span>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6 mt-8">
                                        <label for="">Education Level</label>
                                        <select name="education" class=" form-select" id="" class=" form-select">
                                            <option value=' . $data->education . '>' . $data->education . '</option>
                                            <option value="Advance Practice (NP)">Advance Practice (NP)</option>
                                            <option value="Associate’s (AND)">Associate’s (AND)</option>
                                            <option value="Bachelor’s (BSN)">Bachelor’s (BSN)</option>
                                            <option value="Doctorate (Ph. D)">Doctorate (Ph. D)</option>
                                            <option value="Master’s (MSN)">Master’s (MSN)</option>
                                        </select>
                                        <span class=" alert-danger education-error" id=""></span>
                                    </div>
                                    <div class="col-md-6 mt-8">
                                        <label for="">Current Job</label>
                                        <input type="text" class=" form-control form-control-solid" name="current_job"
                                            id="" value="' . $data->current_job . '">
                                            <span class=" alert-danger current_job-error" id=""></span>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6 mt-8">
                                        <label for="">Current Shift</label>
                                        <input type="text" class=" form-control form-control-solid" name="current_shift"
                                            id="" value="' . $data->current_shift . '">
                                            <span class=" alert-danger current_shift-error" id=""></span>
                                    </div>
                                    <div class="col-md-6 mt-8">
                                        <label for="">Coverage Area</label>
                                        <input type="text" class=" form-control form-control-solid" name="coverage_area"
                                            id="" value="' . $data->coverage_area . '">
                                            <span class=" alert-danger coverage_area-error" id=""></span>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6 mt-8">
                                        <label for="">Recruiter</label>
                                        <select name="recruiter" id="" class=" form-select">
                                            <option value=""></option>
                                        </select>
                                        <span class=" alert-danger recruiter-error" id=""></span>
                                    </div>
                                    <div class="col-md-6 mt-8">
                                        <label for="">Referral Src</label>
                                        <input type="text" class=" form-control form-control-solid" name="referral_src"
                                            id="" value="' . $data->referral_src . '">
                                            <span class=" alert-danger referral_src-error" id=""></span>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12 mt-8">
                                        <label for="">Remark</label>
                                        <textarea name="remark" id="" class=" form-control form-control-solid">' . $data->remarks . '</textarea>
                                        <span class=" alert-danger remark-error" id=""></span>
                                    </div>
                                </div>

                            </div>
                        </div>
                        <div class="row mt-8">
                            <div class="col-md-6">
                                <div class="col-md-12">
                                    <h5>Tracking Onboarding Process</h5>
                                </div>
                                <div class="col-md-12 mt-8 mb-8">
                                    <label for="">Application Date</label>
                                    <input type="text" class=" form-control kt_datepicker" name="application_date"
                                        id="" placeholder="mm-dd-yyyy" value="' . convert_date_from_db($data->application_date) . '">
                                        <span class=" alert-danger application_date-error" id=""></span>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-check form-check-custom form-check-solid">';
        if ($data->rn_contracted != null) {
            $html .= '<input class="form-check-input CHKrn_contracted" type="checkbox" value="1"
                                            id="" name="" checked/>';
        } else {
            $html .= '<input class="form-check-input CHKrn_contracted" type="checkbox" value="1"
                                            id="" name=""/>';
        }
        $html .= '<label class="form-check-label" for="flexCheckDefault">
                                            Rn contracted
                                        </label>
                                    </div> 
                                    <input type="text" class="form-control kt_datepicker mt-4 rn_contracted" name="rn_contracted"
                                        id="" placeholder="mm-dd-yyyy" value=' . convert_date_from_db($data->rn_contracted) . '>  
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-check form-check-custom form-check-solid">';
        if ($data->prescreen_interview != null) {
            $html .= '<input class="form-check-input CHKprescreen_interview" type="checkbox" value="1"
                                            id="" name="" checked/>';
        } else {
            $html .= '<input class="form-check-input CHKprescreen_interview" type="checkbox" value="1"
                                            id="" name=""/>';
        }

        $html .= '<label class="form-check-label" for="flexCheckDefault">
                                                Prescreen Interview
                                            </label>
                                        </div>
                                        <input type="text" class="form-control kt_datepicker mt-4 prescreen_interview" name="prescreen_interview"
                                            id="" placeholder="mm-dd-yyyy" value=' . convert_date_from_db($data->prescreen_interview) . '>
                                    </div>
                                </div>
                                <div class="row mt-8">
                                    <div class="col-md-6">
                                        <div class="form-check form-check-custom form-check-solid">';
        if ($data->application != null) {
            $html .= '<input class="form-check-input CHKapplication" type="checkbox" value="1"
                                                id="" checked/>';
        } else {
            $html .= '<input class="form-check-input CHKapplication" type="checkbox" value="1"
                                            id=""/>';
        }

        $html .= '<label class="form-check-label" for="flexCheckDefault">
                                                Application
                                            </label>
                                        </div>
                                        <input type="text" class="form-control kt_datepicker mt-4 application" name="application"
                                            id="" placeholder="mm-dd-yyyy" value=' . convert_date_from_db($data->application) . '>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-check form-check-custom form-check-solid">';
        if ($data->all_documents_submitted != null) {
            $html .= '<input class="form-check-input CHKall_documents_submitted" type="checkbox" value="1"
                                                id="" checked/>';
        } else {
            $html .= '<input class="form-check-input CHKall_documents_submitted" type="checkbox" value="1"
                                            id=""/>';
        }

        $html .= '<label class="form-check-label" for="flexCheckDefault">
                                                All Documents Submitted
                                            </label>
                                        </div>
                                        <input type="text" class="form-control kt_datepicker mt-4 all_documents_submitted" name="all_documents_submitted"
                                            id="" placeholder="mm-dd-yyyy">
                                    </div>
                                </div>
                                <div class="row mt-8">
                                    <div class="col-md-6">
                                        <div class="form-check form-check-custom form-check-solid">';
        if ($data->background_check_completed != null) {
            $html .= '<input class="form-check-input CHKbackground_check_completed" type="checkbox" value="1"
                                            id="" checked/>';
        } else {
            $html .= '<input class="form-check-input CHKbackground_check_completed" type="checkbox" value="1"
                                            id=""/>';
        }
        $html .= '<label class="form-check-label" for="flexCheckDefault">
                                                Background Check Completed
                                            </label>
                                        </div>
                                        <input type="text" class="form-control kt_datepicker mt-4 background_check_completed" name="background_check_completed"
                                            id="" placeholder="mm-dd-yyyy">
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-check form-check-custom form-check-solid">';
        if ($data->file_created != null) {
            $html .= '<input class="form-check-input CHKfile_created" type="checkbox" value="1"
                                            id="" checked/>';
        } else {
            $html .= '<input class="form-check-input CHKfile_created" type="checkbox" value="1"
                                            id=""/>';
        }

        $html .= '<label class="form-check-label" for="flexCheckDefault">
                                                File Created
                                            </label>
                                        </div>
                                        <input type="text" class="form-control kt_datepicker mt-4 file_created" name="file_created"
                                            id="" placeholder="mm-dd-yyyy">
                                    </div>
                                </div>
                                <div class="row mt-8">
                                    <div class="col-md-6">
                                        <div class="form-check form-check-custom form-check-solid">';
        if ($data->ref_check_completed != null) {
            $html .= '<input class="form-check-input CHKref_check_completed" type="checkbox" value="1"
                                                id="" checked/>';
        } else {
            $html .= '<input class="form-check-input CHKref_check_completed" type="checkbox" value="1"
                                            id=""/>';
        }

        $html .= '<label class="form-check-label" for="flexCheckDefault">
                                                Ref. Check Completed
                                            </label>
                                        </div>
                                        <input type="text" class="form-control kt_datepicker mt-4 ref_check_completed" name="ref_check_completed"
                                            id="" placeholder="mm-dd-yyyy">
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-check form-check-custom form-check-solid">';
        if ($data->orientation != null) {
            $html .= '<input class="form-check-input CHKorientation" type="checkbox" value="1"
                                            id="" checked/>';
        } else {
            $html .= '<input class="form-check-input CHKorientation" type="checkbox" value="1"
                                            id=""/>';
        }
        $html .= '<label class="form-check-label" for="flexCheckDefault">
                                                Orientation
                                            </label>
                                        </div>
                                        <input type="text" class="form-control kt_datepicker mt-4 orientation" name="orientation"
                                            id="" placeholder="mm-dd-yyyy">
                                    </div>
                                </div>
                                <div class="row mt-8">
                                    <div class="col-md-6">
                                        <div class="form-check form-check-custom form-check-solid">';
        if ($data->contract_signed != null) {
            $html .= '<input class="form-check-input CHKcontract_signed" type="checkbox" value="1"
                                            id="" checked/>';
        } else {
            $html .= '<input class="form-check-input CHKcontract_signed" type="checkbox" value="1"
                                            id=""/>';
        }

        $html .= '<label class="form-check-label" for="flexCheckDefault">
                                                Contract Signed
                                            </label>
                                        </div>
                                        <input type="text" class="form-control kt_datepicker mt-4 contract_signed" name="contract_signed"
                                            id="" placeholder="mm-dd-yyyy">
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-check form-check-custom form-check-solid">';
        if ($data->shadowed != null) {
            $html .= '<input class="form-check-input CHKshadowed" type="checkbox" value="1"
                                                id="" checked/>';
        } else {
            $html .= '<input class="form-check-input CHKshadowed" type="checkbox" value="1"
                                            id=""/>';
        }

        $html .= '<label class="form-check-label" for="flexCheckDefault">
                                                Shadowed
                                            </label>
                                        </div>
                                        <input type="text" class="form-control kt_datepicker mt-4 shadowed" name="shadowed"
                                            id="" placeholder="mm-dd-yyyy">
                                    </div>
                                </div>
                                <div class="row mt-8">
                                    <div class="col-md-6">
                                        <div class="form-check form-check-custom form-check-solid">';
        if ($data->first_visit != null) {
            $html .= '<input class="form-check-input CHKfirst_visit" type="checkbox" value="1"
                                                id="" checked/>';
        } else {
            $html .= '<input class="form-check-input CHKfirst_visit" type="checkbox" value="1"
                                            id=""/>';
        }

        $html .= '<label class="form-check-label" for="flexCheckDefault">
                                                1st Visit
                                            </label>
                                        </div>
                                        <input type="text" class="form-control kt_datepicker mt-4 first_visit" name="first_visit"
                                            id="" placeholder="mm-dd-yyyy">
                                    </div>

                                </div>
                            </div>
        <div class="modal-footer mt-3">
             <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
             <button type="submit" class="btn btn-primary" id="kt_sign_in_update">
                 <span class="indicator-label">Update</span>
                 <span class="indicator-progress">Please wait...
                     <span class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
             </button>
         </div>
     </form>';

        return response()->json($html);
    }


    public function update_nurse(Request $req)
    {
        $rules = [
            'name' => 'required',
        ];

        $validator = Validator::make($req->all(), $rules);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()]);
        }

        $nurse = Nurse::find($req->id);

        try {
            $nurse->name = $req->name;
            $nurse->telephone = $req->telephone;
            $nurse->email = $req->email;
            $nurse->email = $req->email;
            $nurse->company_name = $req->company_name;
            $nurse->alt_phone = $req->alt_phone;
            $nurse->address = $req->address;
            $nurse->work_phone = $req->work_phone;
            $nurse->city = $req->city;
            $nurse->state = $req->state;
            $nurse->zip = $req->zip;
            $nurse->dob = convert_date_to_db($req->dob);
            $nurse->status = $req->status;
            $nurse->discipline = $req->discipline;
            $nurse->specialty = $req->specialty;
            $nurse->education = $req->education;
            $nurse->current_job = $req->current_job;
            $nurse->current_shift = $req->current_shift;
            $nurse->coverage_area = $req->coverage_area;
            $nurse->recruiter = $req->recruiter;
            $nurse->recruiter_src = $req->recruiter_src;
            $nurse->remark = $req->remark;
            $nurse->application_date = convert_date_to_db($req->application_date);
            $nurse->rn_contracted = convert_date_to_db($req->rn_contracted);
            $nurse->prescreen_interview = convert_date_to_db($req->prescreen_interview);
            $nurse->application = convert_date_to_db($req->application);
            $nurse->all_documents_submitted = convert_date_to_db($req->all_documents_submitted);
            $nurse->background_check_completed = ($req->background_check_completed);
            $nurse->ref_check_completed = convert_date_to_db($req->ref_check_completed);
            $nurse->orientation = convert_date_to_db($req->orientation);
            $nurse->contract_signed = convert_date_to_db($req->contract_signed);
            $nurse->shadowed = convert_date_to_db($req->shadowed);
            $nurse->first_visit = convert_date_to_db($req->first_visit);

           

    //         $tagValues = $req->input('area');
    //         $tags = explode(',', $tagValues);

    // foreach ($tags as $tagValue) {
    //     Nurse_geographical::create(['area' => $tagValue]);
    // }
    $nurse->update();
            return response()->json(['success' => "Updated Successfully"]);
        } catch (\Exception $ex) {
            Log::channel('custom')->error($ex->getMessage());
            return response()->json(['logginError' => "Error Occured. Contact System Admin"]);
        }
    }



    public function find_single_nurse(Request $req)
    {
        $nurse = Nurse::find($req->id);

        return response()->json($nurse);
    }

    public function delete(Request $req)
    {
        $delete = Nurse::find($req->id);

        $delete->delete();

        return response()->json(['msg' => 'Deleted Successfully']);
    }


    public function add_nurse()
    {

        return view('nurse.add_nurse');
    }

    public function credential_tracking($id)
    {
        $nurse = Nurse::find($id);

        return view('nurse.credential_tracking', compact('nurse'));
    }


    public function save_credential(Request $req)
    {
        $rules = [
            'rn_name' => 'required',
        ];

        $validator = Validator::make($req->all(), $rules);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()]);
        }

        try {
            $cred = new Credential_tracking();
            $cred->nurse_id = $req->nurse_id;
            $cred->document_name = $req->document_name;
            $cred->issue_date = convert_date_to_db($req->issue_date);
            $cred->expires = $req->expires;
            $cred->expiry_date = convert_date_to_db($req->expiry_date);
            $cred->remarks = $req->remarks;

            $cred->save();
            return response()->json(['success' => "Created Successfully"]);
        } catch (\Exception $ex) {
            Log::channel('custom')->error($ex->getMessage());
            return response()->json(['logginError' => "Error Occured. Contact System Admin"]);
        }
    }


    public function update_credential(Request $req)
    {
        $rules = [
            'rn_name' => 'required',
        ];

        $validator = Validator::make($req->all(), $rules);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()]);
        }

        try {
            $cred = Credential_tracking::find($req->credential_id);
            $cred->nurse_id = $req->nurse_id;
            $cred->document_name = $req->document_name;
            $cred->issue_date = convert_date_to_db($req->issue_date);
            $cred->expires = $req->expires;
            $cred->expiry_date = convert_date_to_db($req->expiry_date);
            $cred->remarks = $req->remarks;

            $cred->update();
            return response()->json(['success' => "Created Successfully"]);
        } catch (\Exception $ex) {
            Log::channel('custom')->error($ex->getMessage());
            return response()->json(['logginError' => "Error Occured. Contact System Admin"]);
        }
    }

    public function dt_credential_tracking(Request $req, $id)
    {
        $cred = Credential_tracking::where('nurse_id', $id)->get();

        $data = [];

        foreach ($cred as $val) {
            $data[] = [
                'rn_name' => Nurse::find($val->nurse_id)->name,
                'document_name' => Document::find($val->document_name)->description,
                'issue_date' => convert_date_from_db($val->issue_date),
                'expires' => $val->expires == 1 ? 'Yes' : 'No',
                'expiry_date' => convert_date_from_db($val->expiry_date),
                'remarks' => $val->remarks,
                'id' => $val->id,
            ];
        }

        return response()->json([
            'data' => $data,
            'draw' => intval($req->input('draw'))
        ]);
    }


    public function edit_credentails(Request $req)
    {
        $creden = Credential_tracking::find($req->id);
        $html = '<script>
        $(".kt_datepicker").flatpickr({
            dateFormat: "m-d-Y",
        });
                </script>';
        $html .= '<form action="javascript:void(0)" id="frmUpdateCred" data-parsley-validate>
        <input type="hidden" name="nurse_id" value="' . $creden->nurse_id . '">
        <input type="hidden" name="credential_id" value="' . $creden->id . '">
        <div class="row">
            <div class="col-md-4">
                <label for="">RN Name</label>
                <input type="text" class="form-control form-control-solid" name="rn_name"
                    value="' . Nurse::find($creden->nurse_id)->name . '" id="rn_name" required readonly>
                    <span class=" alert-danger rn_name-error" id=""></span>
            </div>
            <div class="col-md-4">
                <label for="">Document Name</label>
                <select name="document_name" id="document_name" class=" form-select" required>
                    <option value=' . $creden->document_name . '>' . Document::find($creden->document_name)->description . '</option>';
        foreach (Document::all() as $item) {
            $html .= '<option value=' . $item->id . '>' . $item->description . '</option>';
        }

        $html .= '</select>
                <span class=" alert-danger document_name-error" id=""></span>
            </div>
            <div class="col-md-4">
                <label for="">Issue Date</label>
                <input type="text" value="' . convert_date_from_db($creden->issue_date) . '" class=" form-control kt_datepicker"
                    placeholder="mm-dd-yyyy" name="issue_date" id="">
            </div>
        </div>
        <div class="row mt-8">
            <div class="col-md-4">
                <div class="form-check form-check-custom form-check-solid">';
        if ($creden->expires == 1) {
            $html .= '<input class="form-check-input expires" type="checkbox" value="1"
                    id="" name="expires" checked/>';
        } else {
            $html .= '<input class="form-check-input expires" type="checkbox" value="1"
                    id="" name="expires"/>';
        }

        $html .= '<label class="form-check-label" for="flexCheckDefault">
                        Expires?
                    </label>
                </div>
            </div>
            <div class="col-md-4">
                <label for="">Expiry Date</label>
                <input type="text" class=" form-control kt_datepicker expiry_date"
                    placeholder="mm-dd-yyyy" value=' . convert_date_from_db($creden->expiry_date) . ' name="expiry_date" id="" >
            </div>
            <div class="col-md-4">
                <label for="">Remarks</label>
                <textarea name="remarks" id="" class=" form-control form-control-solid">' . $creden->remarks . '</textarea>
            </div>
        </div>
        <button type="submit" class="btn btn-primary" id="kt_sign_in_submit">
            <span class="indicator-label">Save</span>
            <span class="indicator-progress">Please wait...
                <span class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
        </button>
    </form>';

        return response()->json($html);
    }


    public function geo_area($id){
        $nurse = Nurse::find($id);
        $nurse_area = Nurse_geographical::where('nurse_id', $id)->get();

        return view('nurse.geo_area', compact('nurse', 'nurse_area'));
    }


    public function save_area(Request $req){
        // $nurse = Nurse::find($req->nurse_id);

        $tagValues = $req->input('area');
        $tags = json_decode($tagValues, true);
    
        // Store the tags in the database
        foreach ($tags as $tag) {
            Nurse_geographical::create(['area' => $tag['value'], 'nurse_id' => $req->nurse_id]);
        }

        return response()->json(['success' => "Created Successfully"]);
    }

    
}
