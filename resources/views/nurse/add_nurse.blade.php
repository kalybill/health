@extends('layouts.app')

@section('page_header')
    <h1 class="page-heading d-flex text-dark fw-bold fs-3 flex-column justify-content-center my-0">
        Add Nurse</h1>
@endsection

@section('body')
<div class="col-md-12 mb-3">
    <a href="{{ url('settings/nurse') }}"> <i class="fa-solid fa-left-long fa-2xl"></i></a>
 </div>
    <ul class="nav nav-tabs nav-line-tabs mb-5 fs-6">
        <li class="nav-item">
            <a class="nav-link active" data-bs-toggle="tab" href="#kt_tab_pane_1">Nurse’s Personal Details</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" data-bs-toggle="tab" href="#kt_tab_pane_2">Work Information</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" data-bs-toggle="tab" href="#kt_tab_pane_3">Tracking Onboarding Process</a>
        </li>
        {{-- <li class="nav-item">
            <a class="nav-link" data-bs-toggle="tab" href="#kt_tab_pane_4">Geographic Area</a>
        </li> --}}
        {{-- <li class="nav-item">
            <a class="nav-link" data-bs-toggle="tab" href="#kt_tab_pane_4">Credential Tracking</a>
        </li> --}}
    </ul>
    <div class="tab-content" id="myTabContent">
        <div class="tab-pane fade show active" id="kt_tab_pane_1" role="tabpanel">
            <div class="card">
                <div class="card-body">
                    <form action="javascript:void(0)" id="frmAddNurse">
                        <div class="col-md-12">
                            <div class="col-md-12">
                
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <label for="">Name</label>
                                    <input type="text" class="form-control-solid form-control" name="name"
                                        id="" required>
                                    <span class=" alert-danger name-error" id=""></span>
                                </div>
                                <div class="col-md-6">
                                    <label for="">Phone</label>
                                    <input type="tel" class="form-control-solid form-control" name="telephone"
                                        id="" required>
                                    <span class=" alert-danger telephone-error" id=""></span>
                                </div>
                            </div>
                            <div class="row mt-8">
                                <div class="col-md-6">
                                    <label for="">Company Name</label>
                                    <input type="text" class="form-control-solid form-control" name="company_name"
                                        id="" required>
                                    <span class=" alert-danger company_name-error" id=""></span>
                                </div>
                                <div class="col-md-6">
                                    <label for="">Alt Phone</label>
                                    <input type="text" class="form-control-solid form-control" name="alt_phone"
                                        id="" required>
                                    <span class=" alert-danger alt_phone-error" id=""></span>
                                </div>
                            </div>
                            <div class="row mt-8">
                                <div class="col-md-6">
                                    <label for="">Address</label>
                                    <input type="text" class="form-control-solid form-control" name="address"
                                        id="" required>
                                    <span class=" alert-danger address-error" id=""></span>
                                </div>
                                <div class="col-md-6">
                                    <label for="">Work Phone</label>
                                    <input type="text" class="form-control-solid form-control" name="work_phone"
                                        id="" required>
                                    <span class=" alert-danger work_phone-error" id=""></span>
                                </div>
                            </div>
                            <div class="row mt-8">
                                <div class="col-md-6">
                                    <label for="">City</label>
                                    <input type="text" class="form-control-solid form-control" name="city"
                                        id="" required>
                                    <span class=" alert-danger city-error" id=""></span>
                                </div>
                                <div class="col-md-6">
                                    <label for="">Email</label>
                                    <input type="email" class="form-control-solid form-control" name="email"
                                        id="" required>
                                    <span class=" alert-danger email-error" id=""></span>
                                </div>
                            </div>
                            <div class="row mt-8">
                                <div class="col-md-6">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <label for="">State</label>
                                            <input type="text" class="form-control-solid form-control" name="state"
                                                id="" required>
                                            <span class=" alert-danger state-error" id=""></span>
                                        </div>
                                        <div class="col-md-6">
                                            <label for="">Zip</label>
                                            <input type="text" class="form-control-solid form-control" name="zip"
                                                id="" required>
                                            <span class=" alert-danger zip-error" id=""></span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <label for="">DoB</label>
                                            <input type="text" class=" form-control kt_datepicker form-control-solid"
                                                name="dob" id="" required>
                                            <span class=" alert-danger dob-error" id=""></span>
                                        </div>
                                        <div class="col-md-6">
                                            <label for="">Status</label>
                                            <select name="status" id="" class=" form-select">
                                                <option value="Pending">Pending</option>
                                                <option value="Active">Active</option>
                                                <option value="Inactive">Inactive</option>
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
                        <button type="submit" class="btn btn-primary" id="kt_sign_in_submit">
                            <span class="indicator-label">Save</span>
                            <span class="indicator-progress">Please wait...
                                <span class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
                        </button>
                    </form>
                </div>
            </div>

        </div>
        <div class="tab-pane fade" id="kt_tab_pane_2" role="tabpanel">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body">
                        <form action="javascript:void(0)">
                            <div class="row">
                                <div class="col-md-6">
                                    <label for="">Discipline</label>
                                    <select name="discipline" id="" class="form-select">
                                        <option value="">Registered Nurse</option>
                                        <option value="">Lic Voc Nurse</option>
                                    </select>
                                    <span class=" alert-danger discipline-error" id=""></span>
                                </div>
                                <div class="col-md-6 ">
                                    <label for="">Specialty</label>
                                    <input type="text" class=" form-control form-control-solid" name="specialty"
                                        id="">
                                    <span class=" alert-danger specialty-error" id=""></span>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6 mt-8">
                                    <label for="">Education Level</label>
                                    <select name="education" class=" form-select" id="" class=" form-select">
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
                                        id="">
                                    <span class=" alert-danger current_job-error" id=""></span>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6 mt-8">
                                    <label for="">Current Shift</label>
                                    <input type="text" class=" form-control form-control-solid" name="current_shift"
                                        id="">
                                    <span class=" alert-danger current_shift-error" id=""></span>
                                </div>
                                <div class="col-md-6 mt-8">
                                    <label for="">Coverage Area</label>
                                    <input type="text" class=" form-control form-control-solid" name="coverage_area"
                                        id="">
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
                                        id="">
                                    <span class=" alert-danger referral_src-error" id=""></span>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12 mt-8">
                                    <label for="">Remark</label>
                                    <textarea name="remark" id="" class=" form-control form-control-solid"></textarea>
                                    <span class=" alert-danger remark-error" id=""></span>
                                </div>
                            </div>
                            <button class="mt-8 btn btn-primary">Save</button>
                        </form>
                    </div>
                </div>


            </div>
        </div>
        <div class="tab-pane fade" id="kt_tab_pane_3" role="tabpanel">
            <div class="row mt-8">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-body">
                            <form action="javascript:void(0)">
                                <div class="col-md-12 mt-8 mb-8">
                                    <label for="">Application Date</label>
                                    <input type="text" class=" form-control kt_datepicker" name="application_date"
                                        id="" placeholder="mm-dd-yyyy">
                                    <span class=" alert-danger application_date-error" id=""></span>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-check form-check-custom form-check-solid">
                                            <input class="form-check-input CHKrn_contracted" type="checkbox" value="1"
                                                id="" name="" />
                                            <label class="form-check-label" for="flexCheckDefault">
                                                RN contracted
                                            </label>
                                        </div>
                                        <input type="date" class="form-control kt_datepicker mt-4 rn_contracted"
                                            name="rn_contracted" id="" placeholder="mm-dd-yyyy">
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-check form-check-custom form-check-solid">
                                            <input class="form-check-input CHKprescreen_interview" type="checkbox"
                                                value="1" id="" name="" />
                                            <label class="form-check-label" for="flexCheckDefault">
                                                Prescreen Interview
                                            </label>
                                        </div>
                                        <input type="date" class="form-control kt_datepicker mt-4 prescreen_interview"
                                            name="prescreen_interview" id="" placeholder="mm-dd-yyyy">
                                    </div>
                                </div>
                                <div class="row mt-8">
                                    <div class="col-md-6">
                                        <div class="form-check form-check-custom form-check-solid">
                                            <input class="form-check-input CHKapplication" type="checkbox" value="1"
                                                id="" />
                                            <label class="form-check-label" for="flexCheckDefault">
                                                Application
                                            </label>
                                        </div>
                                        <input type="date" class="form-control kt_datepicker mt-4 application"
                                            name="application" id="" placeholder="mm-dd-yyyy">
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-check form-check-custom form-check-solid">
                                            <input class="form-check-input CHKall_documents_submitted" type="checkbox"
                                                value="1" id="" />
                                            <label class="form-check-label" for="flexCheckDefault">
                                                All Documents Submitted
                                            </label>
                                        </div>
                                        <input type="date" class="form-control kt_datepicker mt-4 all_documents_submitted"
                                            name="all_documents_submitted" id="" placeholder="mm-dd-yyyy">
                                    </div>
                                </div>
                                <div class="row mt-8">
                                    <div class="col-md-6">
                                        <div class="form-check form-check-custom form-check-solid">
                                            <input class="form-check-input CHKbackground_check_completed" type="checkbox"
                                                value="1" id="" />
                                            <label class="form-check-label" for="flexCheckDefault">
                                                Background Check Completed
                                            </label>
                                        </div>
                                        <input type="date"
                                            class="form-control kt_datepicker mt-4 background_check_completed"
                                            name="background_check_completed" id="" placeholder="mm-dd-yyyy">
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-check form-check-custom form-check-solid">
                                            <input class="form-check-input CHKfile_created" type="checkbox" value="1"
                                                id="" />
                                            <label class="form-check-label" for="flexCheckDefault">
                                                File Created
                                            </label>
                                        </div>
                                        <input type="date" class="form-control kt_datepicker mt-4 file_created"
                                            name="file_created" id="" placeholder="mm-dd-yyyy">
                                    </div>
                                </div>
                                <div class="row mt-8">
                                    <div class="col-md-6">
                                        <div class="form-check form-check-custom form-check-solid">
                                            <input class="form-check-input CHKref_check_completed" type="checkbox"
                                                value="1" id="" />
                                            <label class="form-check-label" for="flexCheckDefault">
                                                Ref. Check Completed
                                            </label>
                                        </div>
                                        <input type="date" class="form-control kt_datepicker mt-4 ref_check_completed"
                                            name="ref_check_completed" id="" placeholder="mm-dd-yyyy">
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-check form-check-custom form-check-solid">
                                            <input class="form-check-input CHKorientation" type="checkbox" value="1"
                                                id="" />
                                            <label class="form-check-label" for="flexCheckDefault">
                                                Orientation
                                            </label>
                                        </div>
                                        <input type="date" class="form-control kt_datepicker mt-4 orientation"
                                            name="orientation" id="" placeholder="mm-dd-yyyy">
                                    </div>
                                </div>
                                <div class="row mt-8">
                                    <div class="col-md-6">
                                        <div class="form-check form-check-custom form-check-solid">
                                            <input class="form-check-input CHKcontract_signed" type="checkbox" value="1"
                                                id="" />
                                            <label class="form-check-label" for="flexCheckDefault">
                                                Contract Signed
                                            </label>
                                        </div>
                                        <input type="date" class="form-control kt_datepicker mt-4 contract_signed"
                                            name="contract_signed" id="" placeholder="mm-dd-yyyy">
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-check form-check-custom form-check-solid">
                                            <input class="form-check-input CHKshadowed" type="checkbox" value="1"
                                                id="" />
                                            <label class="form-check-label" for="flexCheckDefault">
                                                Shadowed
                                            </label>
                                        </div>
                                        <input type="date" class="form-control kt_datepicker mt-4 shadowed"
                                            name="shadowed" id="" placeholder="mm-dd-yyyy">
                                    </div>
                                </div>
                                <div class="row mt-8">
                                    <div class="col-md-6">
                                        <div class="form-check form-check-custom form-check-solid">
                                            <input class="form-check-input CHKfirst_visit" type="checkbox" value="1"
                                                id="" />
                                            <label class="form-check-label" for="flexCheckDefault">
                                                1st Visit
                                            </label>
                                        </div>
                                        <input type="date" class="form-control kt_datepicker mt-4 first_visit"
                                            name="first_visit" id="" placeholder="mm-dd-yyyy">
                                    </div>
    
                                </div>
                                <button class="mt-8 btn btn-primary">Save</button>
                            </form>
                        </div>

                    </div>
                </div>
            </div>

        </div>
        <div class="tab-pane fade" id="kt_tab_pane_4" role="tabpanel">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body">
                        <div class=" p-3">
                            <form action="javascript:void(0)" data-parsley-validate>
                                <input type="text" name="nurse_id">
                                <div class="row">
                                    <div class="mb-0">
                                        <label class="form-label">Geographic Area</label>
                                        <input class="form-control form-control-solid" value="" name="area" id="kt_tagify_2"/>
                                    </div> 
                                    
                                </div>
                                
                                <div class="">
                                    <button class="btn btn-primary">Save</button>
                                </div>
                                
                            </form>
                        </div>
                        
                    </div>
                </div>
                
            </div>
        </div>
    </div>
@endsection
@section('scripts')
    <script src="{{ asset('assets/js/self/nurse.js') . env('VERSION') }}"></script>
    <script>
        $('#navNurse').addClass('active')
    </script>
@endsection
