@php
    use App\Models\{Pump,Nurse,Referral_source,Status,Access_type,Language,Case_type,Service_type,Service_info,Referral, User,Visit_type,Order_type,Clients,Client_contact}
@endphp
@extends('layouts.app')

@section('page_header')
    <h1 class="page-heading d-flex text-dark fw-bold fs-3 flex-column justify-content-center my-0">
        Patients Details</h1>
@endsection

@section('body')
    <div class="row">
        <div class="card">
            <div class="card-body">
                <ul class="nav nav-tabs nav-line-tabs mb-5 fs-6">
                    <li class="nav-item">
                        <a class="nav-link active" data-bs-toggle="tab" href="#kt_tab_pane_1">Demographic Information</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" data-bs-toggle="tab" href="#kt_tab_pane_2">Service Information</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" data-bs-toggle="tab" href="#kt_tab_pane_3">Physician Information </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" data-bs-toggle="tab" href="#kt_tab_pane_4">Payor Information</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" data-bs-toggle="tab" href="#kt_tab_pane_5">Scheduling</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" data-bs-toggle="tab" href="#kt_tab_pane_6">Progress Note</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" data-bs-toggle="tab" href="#kt_tab_pane_7">Update</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" data-bs-toggle="tab" href="#kt_tab_pane_8">Onboarding</a>
                    </li>
                </ul>
                <div class="tab-content" id="myTabContent">
                    <div class="tab-pane fade show active" id="kt_tab_pane_1" role="tabpanel">
                        <form action="javascript:void(0)" id="frmDemo" data-parsley-validate>
                            <input type="hidden" name="patient_id" value="{{ $patient->id }}" id="">
                            
                            <div class="row">
                                <div class="col-md-6">
                                    <label for="">Patient name</label>
                                    <input type="text" name="name" value="{{ $patient->name }}" id="" class=" form-control" required>
                                    <span class=" alert-danger name-error" id=""></span>
                                </div>
                                <div class="col-md-6">
                                    <label for="">Primary Phone</label>
                                    <input type="tel" name="phone" value="{{ $patient->phone }}" id="" class=" form-control" required>
                                    <span class=" alert-danger phone-error" id=""></span>
                                </div>
                            </div>
                            <div class="row mt-8">
                                <div class="col-md-6">
                                    <label for="">MRN</label>
                                    <input type="text" value="{{ $patient->mrn }}" class=" form-control" name="mrn" id="" readonly>
                                    <span class=" alert-danger mrn-error" id=""></span>
                                </div>
                                <div class="col-md-6">
                                    <label for="">Alt Phone</label>
                                    <input type="tel" class=" form-control" name="alt_phone" value="{{ $patient->alt_phone }}" id="">
                                    <span class=" alert-danger alt_phone-error" id=""></span>
                                </div>
                            </div>
                            <div class="row mt-8">
                                <div class="col-md-3">
                                    <label for="">DOB</label>
                                    <input type="" class=" form-control kt_datepicker" name="dob" value="{{ convert_date_from_db($patient->dob) }}" id="birthdate">
                                    <span class=" alert-danger dob-error" id=""></span>
                                </div>
                                <div class="col-md-3">
                                    <label for="">Age</label>
                                    <input type="text" class=" form-control" name="" id="age" readonly>
                                    <span class=" alert-danger name-error" id=""></span>
                                </div>
                                <div class="col-md-3">
                                    <label for="">Status</label>
                                    <select name="status" id="" class="form-select" data-control="select2">
                                        <option value="{{ $patient->status }}">{{ Status::find($patient->status)->description }}</option>
                                        @foreach (Status::all() as $item)
                                        <option value="{{ $item->id }}">{{ $item->description }}</option>
                                        @endforeach
                                    </select>
                                    <span class=" alert-danger status-error" id=""></span>
                                </div>
                                <div class="col-md-3">
                                    <label for="">Referral Date</label>
                                    <input type="text" class=" form-control kt_datepicker" value="{{ convert_date_from_db($patient->ref_date) }}" name="ref_date" id="">
                                    <span class=" alert-danger ref_date-error" id=""></span>
                                </div>
                            </div>
                            <div class="row mt-8">
                                <div class="col-md-3">
                                    <label for="">Sex</label>
                                    <select name="gender" id="" class=" form-select" data-control="select2">
                                        <option value="{{ $patient->gender }}">{{ $patient->gender }}</option>
                                        <option value="male">Male</option>
                                        <option value="female">Female</option>
                                        <span class=" alert-danger gender-error" id=""></span>
                                    </select>
                                </div>
                                <div class="col-md-3">
                                    <label for="">Marital Status</label>
                                    <select name="marital_status" id="" class=" form-select" data-control="select2">
                                        <option value="{{ $patient->marital_status }}">{{ $patient->marital_status }}</option>
                                        <option value="Single">Single</option>
                                        <option value="Married">Married</option>
                                        <option value="Separated">Separated</option>
                                        <option value="Divorced">Divorced</option>
                                        <option value="Widowed">Widowed</option>
                                    </select>
                                    <span class=" alert-danger marital_status-error" id=""></span>
                                </div>
                                <div class="col-md-6">
                                    <label for="">Referral Source</label>
                                    <select name="ref_source_type_id" id="" class="ref_source form-select" data-control="select2">
                                        <option value="{{ $patient->ref_source_type_id }}">{{ Clients::find($patient->ref_source_type_id)->cname }}</option>
                                        @foreach (Clients::all() as $item)
                                        <option value="{{ $item->id }}">{{ $item->cname }}</option>
                                        @endforeach
                                    </select>
                                    <span class=" alert-danger ref_source_type_id-error" id=""></span>
                                </div>
                            </div>
                            <div class="row mt-8">
                                <div class="col-md-6">
                                    <label for="">Street Address</label>
                                    <input type="text" name="street_addr" value="{{ $patient->street_addr }}" class=" form-control" id="">
                                    <span class=" alert-danger street_addr-error" id=""></span>
                                </div>
                                <div class="col-md-3">
                                    <label for="">Referral Source Staff</label>
                                    <select class=" form-select ref_source_staff" name="ref_source_staff" id="" data-control="select2" required>
                                        <option value="{{$patient->ref_source_staff }}">{{ Client_contact::find($patient->ref_source_staff)->contact_person}}</option>
                                    </select>
                                </div>
                                <div class="col-md-3">
                                    <label for="">Language</label>
                                    <select name="language" id="" class="form-select" data-control="select2">
                                        <option value="{{ $patient->language }}">{{ Language::find($patient->language) != null ? Language::find($patient->language)->description : '' }}</option>
                                        @foreach (Language::all() as $item)
                                            <option value="{{ $item->id }}">{{ $item->description }}</option>
                                        @endforeach
                                    </select>
                                    <span class=" alert-danger language-error" id=""></span>
                                </div>
                            </div>
                            <div class="row mt-8">
                                <div class="col-md-6">
                                    <div class="row">
                                        <div class="col-md-4">
                                            <label for="">City</label>
                                            <input type="text" value="{{ $patient->city }}" class=" form-control" name="city" id="">
                                            <span class=" alert-danger city-error" id=""></span>
                                        </div>
                                        <div class="col-md-3">
                                            <label for="">State</label>
                                            <input type="text" class=" form-control" value="{{ $patient->state }}" name="state" id="">
                                            <span class=" alert-danger state-error" id=""></span>
                                        </div>
                                        <div class="col-md-3">
                                            <label for="">Zip</label>
                                            <input type="text" class="form-control" value="{{ $patient->zip }}" name="zip" id="">
                                            <span class=" alert-danger zip-error" id=""></span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <label for="">Emergency Contact</label>
                                    <input type="text" name="emerg_cont" value="{{ $patient->emerg_cont }}" id="" class=" form-control">
                                    <span class=" alert-danger emerg_cont-error" id=""></span>
                                </div>
                            </div>
                            <div class="row mt-8">
                                <div class="col-md-6">
                                    <label for="">Relation to Patient</label>
                                    <input type="text" name="emerg_relation_to_patient" class=" form-control" id="" value="{{ $patient->emerg_relation_to_patient }}">
                                    <span class=" alert-danger emerg_relation_to_patient-error" id=""></span>
                                </div>
                                <div class="col-md-6">
                                    <label for="">Emergency Contact Phone</label>
                                    <input type="text" name="emerg_phone" value="{{ $patient->emerg_phone }}" class=" form-control" id="">
                                    <span class=" alert-danger emerg_phone-error" id=""></span>
                                </div>
                            </div>
                            <div class="row mt-8">
                                <div class="col-md-6">
                                    <label for="">Allergies</label>
                                    <textarea name="allergies" id="" class=" form-control">{{ $patient->allergies }}</textarea>
                                    <span class=" alert-danger allergies-error" id=""></span>
                                </div>
                                <div class="col-md-6">
                                    <label for="">Remarks</label>
                                    <textarea name="remarks" id="" class=" form-control">{{ $patient->remarks }}</textarea>
                                    <span class=" alert-danger remarks-error" id=""></span>
                                </div>
                            </div>
                            <div class="row mt-8">
                                <div class="col-md-6">
                                    <label for="">Est. Delivery Time</label>
                                    <input type="text" class=" form-control" value="{{ $patient->est_delivery_time }}" name="est_delivery_time" id="">
                                    <span class=" alert-danger est_delivery_time-error" id=""></span>
                                </div>
                                <div class="col-md-6">
                                    <label for="">Staffer</label>
                                    <input type="text" class=" form-control" name="staff_for_patient_recorde" value="{{ Auth::user()->name }}" class=" form-control"
                                        id="" readonly>
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
                        </form>
                    </div>
                    <div class="tab-pane fade" id="kt_tab_pane_2" role="tabpanel">
                        <form action="javascript:void(0)" id="frmService">
                            <input type="hidden" value="{{ $patient->id }}" name="patient_id" id="">
                            <div class="row">
                                <div class="col-md-6 mt-8">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <label for="">Cert From</label>
                                            <input  name="cert_from" value="{{ convert_date_from_db($service->cert_from) }}"  id="cert_from" class=" form-control kt_datepicker">
                                            <span class=" alert-danger cert_from-error" id=""></span>
                                        </div>
                                        <div class="col-md-6">
                                            <label for="">Cert To</label>
                                            <input name="cert_to" id="cert_to" class=" form-control kt_datepicker" value="{{ convert_date_from_db($service->cert_to) }}" readonly>
                                            <span class=" alert-danger cert_to-error" id=""></span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6 mt-8">
                                    <label for="">Case Type</label>
                                    <select name="case_type_id" id="" class=" form-select" data-control="select2" required>
                                        <option value="{{ $service->case_type_id }}">{{ $service->case_type_id != null ? Case_type::find($service->case_type_id)->description : '' }}</option>
                                        @foreach (Case_type::all() as $item)
                                        <option value="{{ $item->id }}">{{ $item->description }}</option>
                                        @endforeach
                                    </select>
                                    <span class=" alert-danger case_type_id-error" id=""></span>
                                </div>
                            </div>
                            <div class="row mt-8">
                                <div class="col-md-6">
                                    <label for="">Service Type</label>
                                    <select name="service_type_id" id="" class=" form-control" data-control="select2">
                                        <option value="{{ $service->service_type_id }}">{{ $service->service_type_id != null ? Service_type::find($service->service_type_id)->description : '' }}</option>
                                        @foreach (Service_type::all() as $item)
                                        <option value="{{ $item->id }}">{{ $item->description }}</option>
                                        @endforeach
                                    </select>
                                    <span class=" alert-danger service_type_id-error" id=""></span>
                                </div>
                                <div class="col-md-6">
                                    <label for="">MD Orders 1</label>
                                    <input type="text" name="md_order_1" value="{{ $patient->md_order_1 }}" id="" class=" form-control">
                                    <span class=" alert-danger md_order_1-error" id=""></span>
                                </div>
                            </div>
                            <div class="row mt-8">
                                <div class="col-md-3">
                                    <label for="">SOC Date</label>
                                    <input type="text" name="soc_date" value="{{ convert_date_from_db($patient->soc_date) }}" class=" form-control kt_datepicker" id="">
                                    <span class=" alert-danger soc_date-error" id=""></span>
                                </div>
                                <div class="col-md-3">
                                    <label for="">Discharge date</label>
                                    <input type="text" name="discharge_date" value="{{ convert_date_from_db($service->discharge_date) }}" class=" form-control kt_datepicker" id="">
                                    <span class=" alert-danger discharge_date-error" id=""></span>
                                </div>
                                <div class="col-md-6">
                                    <label for="">MD Orders 2</label>
                                    <input type="text" name="md_order_2" value="{{ $patient->md_order_2 }}" id="" class=" form-control">
                                    <span class=" alert-danger md_order_2-error" id=""></span>
                                </div>
                            </div>
                            <div class="row mt-8">
                                <div class="col-md-6">
                                    <label for="">Duration</label>
                                    <input type="text" class=" form-control" name="duration" value="{{ $service->duration }}" id="">
                                    <span class=" alert-danger duration-error" id=""></span>
                                </div>
                                <div class="col-md-6">
                                    <label for="">MD Orders 3</label>
                                    <input type="text" class=" form-control" value="{{ $patient->md_order_3 }}" name="md_order_3" id="">
                                    <span class=" alert-danger md_order_3-error" id=""></span>
                                </div>
                            </div>
                            <div class="row mt-8">
                                <div class="col-md-3">
                                    <label for="">Authorization</label>
                                    <input type="number" name="authorization" value="{{ $service->authorization }}" class=" form-control" id="">
                                    <span class=" alert-danger authorization-error" id=""></span>
                                </div>
                                <div class=" col-md-3">
                                    <label for="">Contracted Lab</label>
                                    <input type="text" name="contracted_lab" value="{{ $service->contracted_lab }}" class=" form-control" id="">
                                    <span class=" alert-danger contracted_lab-error" id=""></span>
                                </div>
                                <div class="col-md-6">
                                    <label for="">Lab Order</label>
                                    <input type="text" class=" form-control" value="{{ $service->lab_orders }}" name="lab_orders" id="">
                                    <span class=" alert-danger lab_orders-error" id=""></span>
                                </div>
                            </div>
                            <div class="row mt-8">
                                <div class="col-md-3">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" value="1"
                                            id="" name="access_in_place" {{ $service->access_in_place == 1 ? 'checked' : '' }}>
                                        <label class="form-check-label" for="">
                                            Access in Place?
                                        </label>
                                        <span class=" alert-danger access_in_place-error" id=""></span>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <label for="">Date Placed</label>
                                    <input type="text" class=" form-control kt_datepicker" name="date_placed" value="{{ convert_date_from_db($service->date_placed) }}" id="">
                                    <span class=" alert-danger date_placed-error" id=""></span>
                                </div>
                                <div class="col-md-6">
                                    <label for="">Diagnosis 1</label>
                                    <textarea name="diagnosis_1" id="" class=" form-control">{{ $service->diagnosis_1 }}</textarea>
                                    <span class=" alert-danger diagnosis_1-error" id=""></span>
                                </div>
                            </div>
                            <div class="row mt-8">
                                <div class="col-md-3">
                                    <label for="">Access Type</label>
                                    <select name="access_type_id" class=" form-select" id="" data-control="select2">
                                        <option value="{{ $patient->access_type_id }}">{{ Access_type::find($patient->access_type_id)->description }}</option>
                                        @foreach (Access_type::all() as $item)
                                            <option value="{{ $item->id }}">{{ $item->description }}</option>
                                        @endforeach
                                    </select>
                                    <span class=" alert-danger access_type_id-error" id=""></span>
                                </div>
                                <div class="col-md-3">
                                    <label for="">Pump</label>
                                    <select name="pump_id" class=" form-select" id="" data-control="select2">
                                        <option value="{{ $patient->pump_id }}">{{ Pump::find($patient->pump_id)->description }}</option>
                                        @foreach (Pump::all() as $item)
                                            <option value="{{ $item->id }}">{{ $item->description }}</option>
                                        @endforeach
                                    </select>
                                    <span class=" alert-danger pump_id-error" id=""></span>
                                </div>
                                <div class="col-md-6">
                                    <label for="">Diagnosis 2</label>
                                    <textarea name="diagnosis_2" id="" class=" form-control">{{ $service->diagnosis_2 }}</textarea>
                                    <span class=" alert-danger diagnosis_2-error" id=""></span>
                                </div>
                            </div>
                            <div class="row mt-8">
                                <div class="col-md-6">
                                    <label for="">Primary RN</label>
                                    <select name="booked_rn" id="" class=" form-select" data-control="select2">
                                        <option value="{{ $patient->booked_rn }}">{{ Nurse::find($patient->booked_rn)->name }}</option>
                                    </select>
                                    <span class=" alert-danger booked_rn-error" id=""></span>
                                </div>
                                <div class="col-md-6">
                                    <label for="">Alternate RN</label>
                                    <select name="alternate_rn" id="" class=" form-select" data-control="select2">
                                        <option value="{{ $service->alternate_rn }}">{{$service->alternate_rn != null ? Nurse::find($service->alternate_rn)->name : ''}}</option>
                                        @foreach (Nurse::all() as $item)
                                            <option value="{{ $item->id }}">{{ $item->name }}</option>
                                        @endforeach
                                    </select>
                                    <span class=" alert-danger alternate-error" id=""></span>
                                </div>
                            </div>
                            <div class="mt-8">
                                <button type="submit" class="btn btn-primary" id="kt_sign_in_submit_serviceInfo">
                                    <span class="indicator-label">Save</span>
                                    <span class="indicator-progress">Please wait...
                                        <span class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
                                </button>
                            </div>
                        </form>
                    </div>
                    <div class="tab-pane fade" id="kt_tab_pane_3" role="tabpanel">
                        <form action="javascript:void(0)" id="frmPhyInfo">
                            <input type="hidden" value="{{ $patient->id }}" name="patient_id" id="">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="">
                                        <label for="">Referring MD</label>
                                        <input type="text" class=" form-control" name="referring_md" value="{{ $phys->referring_md }}" id="">
                                        <span class=" alert-danger referring_md-error" id=""></span>
                                    </div>
                                    <div class="mt-8">
                                        <label for="">NPI</label>
                                        <input type="text" class=" form-control" name="npi" value="{{ $phys->npi }}" id="">
                                        <span class=" alert-danger npi-error" id=""></span>
                                    </div>
                                    <div class="mt-8">
                                        <label for="">Street Address</label>
                                        <input type="text" class=" form-control" name="street_addr" value="{{ $phys->street_addr }}" id="">
                                        <span class=" alert-danger street_addr-error" id=""></span>
                                    </div>
                                    <div class="mt-8">
                                        <label for="">City</label>
                                        <input type="text" class=" form-control" name="city" value="{{ $phys->city }}" id="">
                                        <span class=" alert-danger city-error" id=""></span>
                                    </div>
                                    <div class="mt-8">
                                        <label for="">State</label>
                                        <input type="text" class=" form-control" name="state" value="{{ $phys->state }}" id="">
                                        <span class=" alert-danger state-error" id=""></span>
                                    </div>
                                    <div class="mt-8">
                                        <label for="">Zip</label>
                                        <input type="text" class=" form-control" name="zip" value="{{ $phys->zip }}" id="">
                                        <span class=" alert-danger zip-error" id=""></span>
                                    </div>
                                    <div class="mt-8">
                                        <label for="">Phone</label>
                                        <input type="text" class=" form-control" name="phone" value="{{ $phys->phone }}" id="">
                                        <span class=" alert-danger phone-error" id=""></span>
                                    </div>
                                    <div class="mt-8">
                                        <label for="">Fax</label>
                                        <input type="text" class=" form-control" name="fax" value="{{ $phys->fax }}" id="">
                                        <span class=" alert-danger fax-error" id=""></span>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="">
                                        <label for="">Alt Referring MD</label>
                                        <input type="text" class=" form-control" name="alt_referring_md" id="" value="{{ $phys->alt_referring_md }}">
                                        <span class=" alert-danger alt_referring_md-error" id=""></span>
                                    </div>
                                    <div class="mt-8">
                                        <label for="">Alt NPI</label>
                                        <input type="text" class=" form-control" name="alt_npi" id="" value="{{ $phys->alt_npi }}">
                                        <span class=" alert-danger alt_npi-error" id=""></span>
                                    </div>
                                    <div class="mt-8">
                                        <label for="">Alt Street Address</label>
                                        <input type="text" class=" form-control" name="alt_street_addr" id="" value="{{ $phys->alt_street_addr }}">
                                        <span class=" alert-danger alt_street_addr-error" id=""></span>
                                    </div> 
                                    <div class="mt-8">
                                        <label for="">Alt City</label>
                                        <input type="text" class=" form-control" name="alt_city" id="" value="{{ $phys->alt_city }}">
                                        <span class=" alert-danger alt_city-error" id=""></span>
                                    </div>
                                    <div class="mt-8">
                                        <label for="">Alt State</label>
                                        <input type="text" class=" form-control" name="alt_state" id="" value="{{ $phys->alt_state }}">
                                        <span class=" alert-danger alt_state-error" id=""></span>
                                    </div>
                                    <div class="mt-8">
                                        <label for="">Alt Zip</label>
                                        <input type="text" class=" form-control" name="alt_zip" id="" value="{{ $phys->alt_zip }}">
                                        <span class=" alert-danger alt_zip-error" id=""></span>
                                    </div>
                                    <div class="mt-8">
                                        <label for="">Alt Phone</label>
                                        <input type="text" class=" form-control" name="alt_phone" id="" value="{{ $phys->alt_phone }}">
                                        <span class=" alert-danger alt_phone-error" id=""></span>
                                    </div>
                                    <div class="mt-8">
                                        <label for="">Alt Fax</label>
                                        <input type="text" class=" form-control" name="alt_fax" id="" value="{{ $phys->alt_fax }}">
                                        <span class=" alert-danger alt_fax-error" id=""></span>
                                    </div>
                                </div>
                            </div>
                            <div class="mt-8">
                                <button type="submit" class="btn btn-primary" id="kt_sign_in_submit_phInfo">
                                    <span class="indicator-label">Save</span>
                                    <span class="indicator-progress">Please wait...
                                        <span class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
                                </button>
                            </div>
                        </form>
                    </div>
                    <div class="tab-pane fade" id="kt_tab_pane_4" role="tabpanel">
                        <form action="javascript:void(0)" id="frmPayor">
                            <input type="hidden" value="{{ $patient->id }}" name="patient_id" id="">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="mt-8">
                                        <label for="">Primary Payor</label>
                                        <input type="text" class=" form-control" name="payer" value="{{ $payer->payer }}" id="">
                                        <span class=" alert-danger alternate-error" id=""></span>
                                    </div>
                                    <div class="mt-8">
                                        <label for="">Primary Payor Type</label>
                                        <input type="text" class=" form-control" name="payer_type" value="{{ $payer->payer_type }}" id="">
                                        <span class=" alert-danger payer_type-error" id=""></span>
                                    </div>
                                    <div class="mt-8">
                                        <label for="">Policy </label>
                                        <input type="text" class=" form-control" name="policy" value="{{ $payer->policy }}" id="">
                                        <span class=" alert-danger policy-error" id=""></span>
                                    </div>
                                    <div class="mt-8">
                                        <label for="">Insurance Company Contact </label>
                                        <input type="text" class=" form-control" name="ins_company_contact" value="{{ $payer->ins_company_contact }}" id="">
                                        <span class=" alert-danger ins_company_contact-error" id=""></span>
                                    </div>
                                    <div class="mt-8">
                                        <label for="">Policy Owner </label>
                                        <input type="text" class=" form-control" name="policy_owner" value="{{ $payer->policy_owner }}" id="">
                                        <span class=" alert-danger policy_owner-error" id=""></span>
                                    </div>
                                </div>
                            </div>
                            <div class="mt-8">
                                <button type="submit" class="btn btn-primary" id="kt_sign_in_submit_payorInfo">
                                    <span class="indicator-label">Save</span>
                                    <span class="indicator-progress">Please wait...
                                        <span class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
                                </button>
                            </div>
                        </form>
                    </div>
                    <div class="tab-pane fade" id="kt_tab_pane_5" role="tabpanel">
                        <div class="row">
                                <div class="col-md-12">
                                <div class="float-end"><button class=" btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal" id="btnSch" data-authorization="{{ $service->authorization }}" data-sch="{{ $countSch }}"><i class="fa-solid fa-plus fa-xl"></i> Add Schedule</button></div>
                            </div>
                        </div>
                        <div class=" table-responsive">
                            <table class=" table table-row-dashed table-row-gray-300 gy-7" id="myDatatable">
                                <thead>
                                    <tr class="fw-semibold fs-6 text-muted">
                                        <th style="visibility: hidden">ID</th>
                                        <th>Visit Date</th>
                                        <th>Visit Type</th>
                                        <th>RN Name</th>
                                        <th>Client</th>
                                        <th>Staffer</th>
                                        <th>ETA</th>
                                        <th>Remarks</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="kt_tab_pane_6" role="tabpanel">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="float-end"><button class=" btn btn-primary" data-bs-toggle="modal" data-bs-target="#progressNoteModal"><i class="fa-solid fa-plus fa-xl"></i> Add Progrss Note</button></div>
                            </div>
                        </div>
                        <div class=" table-responsive">
                            <table class=" table table-row-dashed table-row-gray-300 gy-7" id="myDatatableProgress">
                                <thead>
                                    <tr class="fw-semibold fs-6 text-muted">
                                        <th style="visibility: hidden">ID</th>
                                        <th>MRN</th>
                                        <th>Nurse</th>
                                        <th>Report</th>
                                        <th>Reporter</th>
                                        <th>Report Date</th>
                                        <th>Staffer</th>
                                        <th>F/U Action</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    
                                </tbody>
                            </table>
                        </div>
                        
                    </div>
                    <div class="tab-pane fade" id="kt_tab_pane_7" role="tabpanel">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="float-end"><button class=" btn btn-primary" data-bs-toggle="modal" data-bs-target="#newOrderModal"><i class="fa-solid fa-plus fa-xl"></i> Add Update</button></div>
                            </div>
                        </div>
                        <div class=" table-responsive">
                            <table class=" table table-row-dashed table-row-gray-300 gy-7" id="myDatatableNewnote">
                                <thead>
                                    <tr class="fw-semibold fs-6 text-muted">
                                        <th style="visibility: hidden">ID</th>
                                        <th>Order Type</th>
                                        <th>New Order</th>
                                        <th>Start Date</th>
                                        <th>End Date</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="kt_tab_pane_8" role="tabpanel">
                        <form action="javascript:void(0)" id="frmOnboard">
                            <input type="hidden" value="{{ $patient->id }}" name="patient_id" id="">
                            <div class="row">
                                <div class="col-md-12"><h5>Complete the Onboarding Process Below</h5></div>
                                <div class="col-md-4 mt-8">
                                    <div class="form-check form-check-custom form-check-solid">
                                        @if ($board->ref_info != null)
                                        <input name="ref_info" class="form-check-input" type="checkbox" value="1" id="" checked/>
                                        @else 
                                        <input name="ref_info" class="form-check-input" type="checkbox" value="1" id=""/>
                                        @endif
                                        <label class="form-check-label" for="">
                                            Ref Info Saved?
                                        </label>
                                    </div>
                                </div>
                                <div class="col-md-4 mt-8">
                                    <div class="form-check form-check-custom form-check-solid">
                                        @if ($board->rx_order != null)
                                        <input name="rx_order" class="form-check-input" type="checkbox" value="1" id="" checked/>
                                        @else
                                        <input name="rx_order" class="form-check-input" type="checkbox" value="1" id=""/>
                                        @endif
                                        <label class="form-check-label" for="">
                                            Rx Order Received?
                                        </label>
                                    </div>
                                </div>
                                <div class="col-md-4 mt-8">
                                    <div class="form-check form-check-custom form-check-solid">
                                        @if ($board->loa_received != null)
                                        <input name="loa_received" class="form-check-input" type="checkbox" value="1" id="" checked/>
                                        @else
                                        <input name="loa_received" class="form-check-input" type="checkbox" value="1" id=""/>
                                        @endif
                                        <label class="form-check-label" for="">
                                            LOA Received?
                                        </label>
                                    </div>
                                </div>
                                <div class="col-md-4 mt-8">
                                    <div class="form-check form-check-custom form-check-solid">
                                        @if ($board->loa_extracted != null)
                                        <input name="loa_extracted" class="form-check-input" type="checkbox" value="1" id="" checked/>
                                        @else
                                        <input name="loa_extracted" class="form-check-input" type="checkbox" value="1" id=""/>
                                        @endif
                                        <label class="form-check-label" for="">
                                            LOA Extracted/Saved?
                                        </label>
                                    </div>
                                </div>
                                <div class="col-md-4 mt-8">
                                    <div class="form-check form-check-custom form-check-solid">
                                        @if ($board->date_entry != null)
                                        <input name="date_entry" class="form-check-input" type="checkbox" value="1" id="" checked/>
                                        @else
                                        <input name="date_entry" class="form-check-input" type="checkbox" value="1" id=""/>
                                        @endif
                                        <label class="form-check-label" for="">
                                            Date Entry Done?
                                        </label>
                                    </div>
                                </div>
                                <div class="col-md-4 mt-8">
                                    <div class="form-check form-check-custom form-check-solid">
                                        @if ($board->lab_form != null)
                                        <input name="lab_form" class="form-check-input" type="checkbox" value="1" id="" checked/>
                                        @else
                                        <input name="lab_form" class="form-check-input" type="checkbox" value="1" id=""/>
                                        @endif
                                        <label class="form-check-label" for="">
                                            Lab Form Created?
                                        </label>
                                    </div>
                                </div>
                                <div class="col-md-4 mt-8">
                                    <div class="form-check form-check-custom form-check-solid">
                                        @if ($board->order_emailed != null)
                                        <input name="order_emailed" class="form-check-input" type="checkbox" value="1" checked id=""/>
                                        @else
                                        <input name="order_emailed" class="form-check-input" type="checkbox" value="1" id=""/>
                                        @endif
                                        <label class="form-check-label" for="">
                                            Order Emailed?
                                        </label>
                                    </div>
                                </div>
                                <div class="col-md-4 mt-8">
                                    <div class="form-check form-check-custom form-check-solid">
                                        @if ($board->rn_informed != null)
                                        <input name="rn_informed" class="form-check-input" type="checkbox" value="1" checked id=""/>
                                        @else
                                        <input name="rn_informed" class="form-check-input" type="checkbox" value="1" id=""/>
                                        @endif
                                        <label class="form-check-label" for="">
                                            RN Informed?
                                        </label>
                                    </div>
                                </div>
                                <div class="col-md-4 mt-8">
                                    <div class="form-check form-check-custom form-check-solid">
                                        @if ($board->lab_form_emailed != null)
                                        <input name="lab_form_emailed" class="form-check-input" type="checkbox" value="1" checked id=""/>
                                        @else
                                        <input name="lab_form_emailed" class="form-check-input" type="checkbox" value="1" id=""/>
                                        @endif
                                        <label class="form-check-label" for="">
                                            Lab Form Emailed?
                                        </label>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12 mt-18">
                                    <h6>Contact the patient and discuss the following with the Patient. Check off each box as you complete each topic</h6>
                                </div>
                                <div class="row">
                                    <div class="col-md-4 mt-8">
                                        <div class="form-check form-check-custom form-check-solid">
                                            @if ($board->pt_contracted != null)
                                            <input name="pt_contracted" class="form-check-input" type="checkbox" value="1" checked id=""/>
                                            @else
                                            <input name="pt_contracted" class="form-check-input" type="checkbox" value="1" id=""/>
                                            @endif
                                            <label class="form-check-label" for="">
                                                Pt Contacted?
                                            </label>
                                        </div>
                                    </div>
                                    <div class="col-md-4 mt-8">
                                        <div class="form-check form-check-custom form-check-solid">
                                            @if ($board->pt_welcome)
                                            <input name="pt_welcome" class="form-check-input" type="checkbox" value="1" checked id=""/>
                                            @else
                                            <input name="pt_welcome" class="form-check-input" type="checkbox" value="1" id=""/>
                                            @endif
                                            <label class="form-check-label" for="">
                                                Pt Welcome to Service?
                                            </label>
                                        </div>
                                    </div>
                                    <div class="col-md-4 mt-8">
                                        <div class="form-check form-check-custom form-check-solid">
                                            @if ($board->addr_correct != null)
                                            <input name="addr_correct" class="form-check-input" type="checkbox" value="1" checked id=""/>
                                            @else
                                            <input name="addr_correct" class="form-check-input" type="checkbox" value="1" id=""/>
                                            @endif
                                            <label class="form-check-label" for="">
                                                Is Address Correct?
                                            </label>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-4 mt-8">
                                        <div class="form-check form-check-custom form-check-solid">
                                            @if ($board->phone_number_reliable != null)
                                            <input name="phone_number_reliable" class="form-check-input" type="checkbox" value="1" checked id=""/>
                                            @else
                                            <input name="phone_number_reliable" class="form-check-input" type="checkbox" value="1" id=""/>
                                            @endif
                                            <label class="form-check-label" for="">
                                                Is phone number the reliable?
                                            </label>
                                        </div>
                                    </div>
                                    <div class="col-md-4 mt-8">
                                        <div class="form-check form-check-custom form-check-solid">
                                            @if ($board->pt_teach_train != null)
                                            <input name="pt_teach_train" class="form-check-input" type="checkbox" value="1" checked id=""/>
                                            @else
                                            <input name="pt_teach_train" class="form-check-input" type="checkbox" value="1" id=""/>
                                            @endif
                                            <label class="form-check-label" for="">
                                                Pt Advised of Teach & Train?
                                            </label>
                                        </div>
                                    </div>
                                </div>
                                <div class="row mt-8">
                                    <div class="col-md-4">
                                        <label for="">Is there a Gate access Code?</label>
                                        <input name="get_access_code" value="{{ $board->get_access_code }}" type="text" class=" form-control form-control-solid">
                                    </div>
                                    <div class="col-md-4">
                                        <label for="">Where should the Nurse Park?</label>
                                        <input name="nurse_park" value="{{ $board->nurse_park }}" type="text" class=" form-control form-control-solid">
                                    </div>
                                    <div class="col-md-4">
                                        <label for="">Staffer</label>
                                        <input name="staffer" type="text" class=" form-control form-control-solid" value="{{ Auth::user()->name }}">
                                    </div>
                                </div>
                                <div class="col-md-12 mt-8">
                                    <label for="">Remarks</label>
                                    <textarea name="remarks" id="" class=" form-control form-control-solid">{{ $board->remarks }}</textarea>
                                </div>
                            </div>
                            <div class="mt-8">
                                <button type="submit" class="btn btn-primary" id="kt_sign_in_submit_onboarding">
                                    <span class="indicator-label">Save</span>
                                    <span class="indicator-progress">Please wait...
                                        <span class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true"
data-bs-backdrop="static" data-bs-keyboard="false">
<div class="modal-dialog modal-dialog-centered modal-lg">
    <div class="modal-content">
        <div class="modal-header">
            <h1 class="modal-title fs-5" id="exampleModalLabel">Add Schedule</h1>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
            <form action="javascript:void(0)" id="frmSchdule" data-parsley-validate>
                <input type="hidden" value="{{ $id }}" name="patient_id" id="">
                <div class="row mb-5">
                    <div class="col-md-6 fv-row">
                        <label class="fs-5 fw-semibold mb-2">Visit Date</label>
                        <input type="text" name="visit_date"
                            class="form-control kt_datepicker form-control-solid" id=""
                            placeholder="mm-dd-yyyy" value="" required/>
                            <span class=" alert-danger visit_date-error" id=""></span>
                    </div>
                    <div class="col-md-6 fv-row">
                        <label class="fs-5 fw-semibold mb-2">Patient Name</label>
                        <input type="text" class="form-control form-control-solid" placeholder=""
                            name="" value="{{ Referral::find($id)->name }}" readonly />
                            
                    </div>
                </div>
                <div class="row mb-5">
                    <div class="col-md-6 fv-row">
                        <label class="fs-5 fw-semibold mb-2">Visit Type</label>
                        <select name="visit_type" class=" form-select" id="" data-control="select2">
                            @foreach (Visit_type::all() as $item)
                                <option value="{{ $item->id }}">{{ $item->description }}</option>
                            @endforeach
                        </select>
                        <span class=" alert-danger visit_type-error" id=""></span>
                    </div>
                    <div class="col-md-6 fv-row">
                        <label class="fs-5 fw-semibold mb-2">RN</label>
                        <select name="nurse_id" class=" form-select" id="" data-control="select2" required>
                            @foreach (Nurse::all() as $item)
                                <option value="{{ $item->id }}">{{ $item->name }}</option>
                            @endforeach
                        </select>
                        <span class=" alert-danger nurse_id-error" id=""></span>
                    </div>
                </div>
                <div class="row mb-5">
                    <div class="col-md-6 fv-row">
                        <label class="fs-5 fw-semibold mb-2">Client</label>
                        <select name="client" id="" data-control="select2"
                                    data-dropdown-parent="#exampleModal" class=" form-select ref_source" required>
                                    <option value="">Select Referral Source</option>
                                    @foreach (Clients::all() as $item)
                                        <option value="{{ $item->id }}">{{ $item->cname }}</option>
                                    @endforeach
                        </select>
                        <span class=" alert-danger client-error" id=""></span>
                    </div>
                    <div class="col-md-6 fv-row">
                        <label class="fs-5 fw-semibold mb-2">Staffer</label>
                        <input type="text" class="form-control form-control-solid" placeholder=""
                            name="staffer" value="{{ Auth::user()->name }}" readonly />
                            <span class=" alert-danger staffer-error" id=""></span>
                    </div>
                </div>
                <div class="row mb-5">
                    <div class="col-md-6 fv-row">
                        <label class="fs-5 fw-semibold mb-2">ETA</label>
                        <textarea name="eta" id="" class="form-control form-control-solid"></textarea>
                        <span class=" alert-danger eta-error" id=""></span>
                    </div>
                    <div class="col-md-6 fv-row">
                        <label class="fs-5 fw-semibold mb-2">Remarks</label>
                        <textarea name="remarks" id="" class="form-control form-control-solid"></textarea>
                        <span class=" alert-danger remarks-error" id=""></span>
                    </div>
                </div>
                <div class="mt-8">
                    <button type="submit" class="btn btn-primary" id="kt_sign_in_submit_sch">
                        <span class="indicator-label">Save</span>
                        <span class="indicator-progress">Please wait...
                            <span class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
</div>


<div class="modal fade" id="editSchedule" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true"
data-bs-backdrop="static" data-bs-keyboard="false">
<div class="modal-dialog modal-dialog-centered modal-lg">
    <div class="modal-content">
        <div class="modal-header">
            <h1 class="modal-title fs-5" id="exampleModalLabel">Add Schedule</h1>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body" id="mdSchd">
            
        </div>
    </div>
</div>
</div>



{{-- Progress Note --}}
<div class="modal fade" id="progressNoteModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true"
data-bs-backdrop="static" data-bs-keyboard="false">
<div class="modal-dialog modal-dialog-centered modal-lg">
    <div class="modal-content">
        <div class="modal-header">
            <h1 class="modal-title fs-5" id="exampleModalLabel">Add Progress Note</h1>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
            <form action="javascript:void(0)" id="frmProgress">
                <input type="hidden" value="{{ $id }}" name="patient_id" id="">
                <div class="row mb-5">
                    <div class="col-md-6 fv-row">
                        <label class="fs-5 fw-semibold mb-2">MRN</label>
                        <input type="text" class="form-control form-control-solid" id="" readonly
                            value="{{ Referral::find($id)->mrn }}" />
                            
                    </div>
                    <div class="col-md-6 fv-row">
                        <label class="fs-5 fw-semibold mb-2">Nurse</label>
                        <select name="nurse_id" class=" form-select" id="" data-control="select2">
                            @foreach (Nurse::all() as $item)
                                <option value="{{ $item->id }}">{{ $item->name }}</option>
                            @endforeach
                        </select>
                        <span class=" alert-danger nurse_id-error" id=""></span>
                    </div>
                </div>
                <div class="row mb-5">
                    <div class="col-md-6 fv-row">
                        <label class="fs-5 fw-semibold mb-2">Report</label>
                        <textarea name="report" id="" class="form-control form-control-solid"></textarea>
                        <span class=" alert-danger report-error" id=""></span>
                    </div>
                    <div class="col-md-6 fv-row">
                        <label class="fs-5 fw-semibold mb-2">Reporter</label>
                        <textarea name="reporter" id="" class="form-control form-control-solid"></textarea>
                        <span class=" alert-danger reporter-error" id=""></span>
                    </div>
                </div>
                <div class="row mb-5">
                    <div class="col-md-6 fv-row">
                        <label class="fs-5 fw-semibold mb-2">Report Date</label>
                        <input type="text" class="form-control form-control-solid kt_datepickerReportDate"
                            name="report_date" id="" value="" placeholder="mm-dd-yyyy" readonly>
                            <span class=" alert-danger report_date-error" id=""></span>
                    </div>
                    <div class="col-md-6 fv-row">
                        <label class="fs-5 fw-semibold mb-2">Staffer</label>
                        <input type="text" class="form-control form-control-solid"
                            name="staffer" id="" value="{{ $progress != null ? $progress->staffer : '' }}" readonly>
                            <span class=" alert-danger staffer-error" id=""></span>
                    </div>
                </div>
                <div class="row mb-5">
                    <div class="col-md-6 fv-row">
                        <label for="" class="fs-5 fw-semibold mb-2">F/U Action</label>
                        <textarea name="fu_action" id="" class=" form-control form-control-solid"></textarea>
                        <span class=" alert-danger fu_action-error" id=""></span>
                    </div>
                </div>
                <div class="mt-8">
                    <button type="submit" class="btn btn-primary" id="kt_sign_in_submit_progressNote">
                        <span class="indicator-label">Save</span>
                        <span class="indicator-progress">Please wait...
                            <span class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
</div>


<div class="modal fade" id="editProgrss" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true"
data-bs-backdrop="static" data-bs-keyboard="false">
<div class="modal-dialog modal-dialog-centered modal-lg">
    <div class="modal-content">
        <div class="modal-header">
            <h1 class="modal-title fs-5" id="exampleModalLabel">Add Schedule</h1>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body" id="mdProgrss">
            
        </div>
    </div>
</div>
</div>


{{-- New Order --}}
<div class="modal fade" id="newOrderModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true"
data-bs-backdrop="static" data-bs-keyboard="false">
<div class="modal-dialog modal-dialog-centered modal-lg">
    <div class="modal-content">
        <div class="modal-header">
            <h1 class="modal-title fs-5" id="exampleModalLabel">Add New Order</h1>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
            <form action="javascript:void(0)" id="frmNewNote" data-parsley-validate>
                <input type="hidden" value="{{ $id }}" name="patient_id" id="">
                <div class="row mb-5">
                    <div class="col-md-6 fv-row">
                        <label class="fs-5 fw-semibold mb-2">Order Type</label>
                        <select name="order_type" id="" class="form-select" data-control="select2">
                            @foreach (Order_type::all() as $item)
                                <option value="{{ $item->id }}">{{ $item->description }}</option>
                            @endforeach</option>
                        </select>
                        <span class=" alert-danger order_type-error" id=""></span>
                    </div>
                    <div class="col-md-6 fv-row">
                        <label class="fs-5 fw-semibold mb-2">New Order</label>
                        <textarea name="new_order" id="" class=" form-control form-control-solid"></textarea>
                        <span class=" alert-danger new_order-error" id=""></span>
                    </div>
                </div>
                <div class="row mb-5">
                    <div class="col-md-6 fv-row">
                        <label class="fs-5 fw-semibold mb-2">Start Date</label>
                        <input type="text" name="start_date" value=""
                            class=" form-control form-control-solid kt_datepicker" id=""
                            placeholder="mm-dd-yyyy">
                            <span class=" alert-danger start_date-error" id=""></span>
                    </div>
                    <div class="col-md-6 fv-row">
                        <label class="fs-5 fw-semibold mb-2">End Date</label>
                        <input type="text" name="end_date" value=""
                            class=" form-control form-control-solid kt_datepicker" id=""
                            placeholder="mm-dd-yyyy">
                            <span class=" alert-danger end_date-error" id=""></span>
                    </div>
                </div>
                <div class="mt-8">
                    <button type="submit" class="btn btn-primary" id="kt_sign_in_submit_newOrder">
                        <span class="indicator-label">Save</span>
                        <span class="indicator-progress">Please wait...
                            <span class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
</div>


<div class="modal fade" id="editNote" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true"
data-bs-backdrop="static" data-bs-keyboard="false">
<div class="modal-dialog modal-dialog-centered modal-lg">
    <div class="modal-content">
        <div class="modal-header">
            <h1 class="modal-title fs-5" id="exampleModalLabel">Edit Progress Note</h1>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body" id="mdNote">
            
        </div>
    </div>
</div>
</div>


<div class="modal fade" id="delModal" tabindex="-1" data-bs-backdrop="static" data-bs-keyboard="false"
        aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">Delete Access Type</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body" id="mdFormDel">
                    <form action="javascript:void(0)" id="frmDelete">
                        <div class="row text-center">
                            <div class="col-md-12 mb-4"><i class="fa-solid fa-triangle-exclamation fa-2xl"></i></div>
                            <p>Are you sure you want to delete <span id="delDescription" class="fw-bold"></span></p>
                            <input type="hidden" name="id" id="InputVal">
                            <div class="col-md-6">
                                <button id="btnDelete" class="btn btn-info">Delete</button>
                            </div>
                            <div class="col-md-6">
                                <button class="btn btn-danger" data-bs-dismiss="modal">Cancel</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>


<div class="modal fade" id="progressModal" tabindex="-1" data-bs-backdrop="static" data-bs-keyboard="false"
        aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">Delete Access Type</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body" id="mdFormDel">
                    <form action="javascript:void(0)" id="frmDelete">
                        <div class="row text-center">
                            <div class="col-md-12 mb-4"><i class="fa-solid fa-triangle-exclamation fa-2xl"></i></div>
                            <p>Are you sure you want to delete <span id="delDescription" class="fw-bold"></span></p>
                            <input type="hidden" name="id" id="InputValProg">
                            <div class="col-md-6">
                                <button id="btnDeleteProgrs" class="btn btn-info">Delete</button>
                            </div>
                            <div class="col-md-6">
                                <button class="btn btn-danger" data-bs-dismiss="modal">Cancel</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>


<div class="modal fade" id="noteModal" tabindex="-1" data-bs-backdrop="static" data-bs-keyboard="false"
        aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">Delete Access Type</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body" id="mdFormDel">
                    <form action="javascript:void(0)" id="frmDelete">
                        <div class="row text-center">
                            <div class="col-md-12 mb-4"><i class="fa-solid fa-triangle-exclamation fa-2xl"></i></div>
                            <p>Are you sure you want to delete <span id="delDescription" class="fw-bold"></span></p>
                            <input type="hidden" name="id" id="InputValNew">
                            <div class="col-md-6">
                                <button id="btnDeleteNew" class="btn btn-info">Delete</button>
                            </div>
                            <div class="col-md-6">
                                <button class="btn btn-danger" data-bs-dismiss="modal">Cancel</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('scripts')
<script src="{{ asset('assets/js/self/edit_patient.js') . env('VERSION') }}"></script>
<script src="{{ asset('assets/js/self/edit_schedule.js') . env('VERSION') }}"></script>
<script src="{{ asset('assets/js/self/onboarding.js') . env('VERSION') }}"></script>
@endsection
