@php
    use App\Models\{Status, Nurse, User, Referral_source, Pump, Access_type,Referral,Clients};
@endphp
@extends('layouts.app')

@section('page_header')
    <h1 class="page-heading d-flex text-dark fw-bold fs-3 flex-column justify-content-center my-0">
        Referrals (Patients)</h1>
@endsection

@section('body')
    <div class="row">
        <div class="col-md-6">
            <!--begin::Alert-->
            <div class="alert alert-primary d-flex align-items-center p-5">
                <!--begin::Icon-->
                <span class="svg-icon svg-icon-2hx svg-icon-primary me-3">
                    <i class="fa-regular fa-compass fa-lg"></i>
                </span>
                <!--end::Icon-->

                <!--begin::Wrapper-->
                <div class="d-flex flex-column">
                    <!--begin::Title-->
                    <h4 class="mb-1 text-dark text-muted">Total Referrals</h4>
                    <!--end::Title-->
                    <!--begin::Content-->
                    <span>
                        <h5>{{ Referral::all()->count() }}</h5>
                    </span>
                    <!--end::Content-->
                </div>
                <!--end::Wrapper-->
            </div>
            <!--end::Alert-->
        </div>
        <div class="col-md-6">
            <!--begin::Alert-->
            <div class="alert alert-success d-flex align-items-center p-5">
                <!--begin::Icon-->
                <span class="svg-icon svg-icon-2hx svg-icon-primary me-3">
                    <i class="fa-solid fa-rotate"></i>
                </span>
                <!--end::Icon-->

                <!--begin::Wrapper-->
                <div class="d-flex flex-column">
                    <!--begin::Title-->
                    <h4 class="mb-1 text-dark text-muted">Referrals For this month</h4>
                    <!--end::Title-->
                    <!--begin::Content-->
                    <span>
                        <h5>{{ Referral::referrals_month_count() }}</h5>
                    </span>
                    <!--end::Content-->
                </div>
                <!--end::Wrapper-->
            </div>
            <!--end::Alert-->
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="float-end"><button class=" btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal"><i class="fa-solid fa-plus fa-xl"></i> New Referrals</button></div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-5">
            <label for="">From</label>
            <input type="date" name="" id="" class="form-control kt_datepicker">
        </div>
        <div class="col-md-5">
            <label for="">To</label>
            <input type="date" name="" id="" class="form-control kt_datepicker">
        </div>
        <div class="col-md-2 mt-5">
            <button class=" btn btn-primary">Search</button>
        </div>
    </div>

    <div class="row mt-10">
        <div class="card shadow-sm">
            <div class="card-body">
                {{-- <div data-kt-docs-table-filter="payment_type">
                    <label>
                      <input type="radio" name="payment_type" value="all" checked /> All
                    </label>
                    <label>
                      <input type="radio" name="payment_type" value="credit" /> Credit
                    </label>
                    <label>
                      <input type="radio" name="payment_type" value="debit" /> Debit
                    </label>
                    <button type="button" data-kt-docs-table-filter="filter">Filter</button>
                  </div> --}}
                <div class=" table-responsive">
                    <table class=" table table-row-dashed table-row-gray-300 gy-7" id="myDatatable">
                        <thead>
                            <tr class="fw-semibold fs-6 text-muted">
                                <th style="visibility: hidden">ID</th>
                                <th>Name</th>
                                <th>MRN</th>
                                <th>Access Type</th>
                                <th>Pump</th>
                                <th>Ref. SRC</th>
                                <th>Ref. Date</th>
                                <th>SOC. Date</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>

                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>



    {{-- Modal Section --}}
    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true"
        data-bs-backdrop="static" data-bs-keyboard="false">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">Referral</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="javascript:void(0)" id="frmReferral" data-parsley-validate>
                        <div class="row">
                            <div class="col-md-8">
                                <label for="">Name</label>
                                <input type="text" class=" form-control" name="name" id="" id=""
                                    required>
                                <span class=" alert-danger name-error" id=""></span>
                            </div>
                            <div class="col-md-4">
                                <label for="">MRN</label>
                                <input type="text" class=" form-control" name="mrn" id="" readonly>
                                <span class=" alert-danger mrn-error" id=""></span>
                            </div>
                        </div>
                        <div class="row mt-8">
                            <div class="col-md-3">
                                <label for="">Address</label>
                                <input type="text" value="" class=" form-control" name="street_addr" id="">
                                <span class=" alert-danger address-error" id=""></span>
                            </div>
                            <div class="col-md-3">
                                <label for="">City</label>
                                <input type="text" value="" class=" form-control" name="city" id="">
                                <span class=" alert-danger city-error" id=""></span>
                            </div>
                            <div class="col-md-3">
                                <label for="">State</label>
                                <input type="text" class=" form-control" value="" name="state" id="">
                                <span class=" alert-danger state-error" id=""></span>
                            </div>
                            <div class="col-md-3">
                                <label for="">Zip</label>
                                <input type="text" class="form-control" value="" name="zip"
                                    id="">
                                <span class=" alert-danger zip-error" id=""></span>
                            </div>
                        </div>
                        <div class="row mt-8">
                            <div class="col-md-12">
                                <label for="">MD Order 1</label>
                                <input type="text" name="md_order_1" class=" form-control" id="">
                            </div>
                        </div>
                        <div class="row mt-8">
                            <div class="col-md-12">
                                <label for="">MD Order 2</label>
                                <input type="text" name="md_order_2" class=" form-control" id="">
                            </div>
                        </div>
                        <div class="row mt-8">
                            <div class="col-md-12">
                                <label for="">MD Order 3</label>
                                <input type="text" name="md_order_3" class=" form-control" id="">
                            </div>
                        </div>
                        <div class="row mt-8">
                            <div class="col-md-6">
                                <label for="">Referral Date</label>
                                <input class="kt_datepicker form-control" name="ref_date" id="" required>
                                <span class=" alert-danger ref_date-error" id=""></span>
                            </div>
                            <div class="col-md-6">
                                <label for="">SOC Date</label>
                                <input type="date" class="kt_datepicker form-control" name="soc_date" id="" required>
                                <span class=" alert-danger soc_date-error" id=""></span>
                            </div>
                        </div>
                        <div class="row mt-8">
                            <div class="col-md-4">
                                <label for="">Access Type</label>
                                <select name="access_type_id" id="" class="form-select" data-control="select2"
                                    data-dropdown-parent="#exampleModal" required>
                                    <option value="">Select Access Type</option>
                                    @foreach (Access_type::all() as $item)
                                        <option value="{{ $item->id }}">{{ $item->description }}</option>
                                    @endforeach
                                </select>
                                <span class=" alert-danger access_type_id-error" id=""></span>
                            </div>
                            <div class="col-md-4">
                                <label for="">Pumps</label>
                                <select name="pump_id" id="" class=" form-select" data-control="select2"
                                    data-dropdown-parent="#exampleModal" required>
                                    <option value="">Select Pump</option>
                                    @foreach (Pump::all() as $item)
                                        <option value="{{ $item->id }}">{{ $item->description }}</option>
                                    @endforeach
                                </select>
                                <span class=" alert-danger pump_id-error" id=""></span>
                            </div>
                            <div class="col-md-4">
                                <label for="">Referral Source</label>
                                <select name="ref_source_type_id" id="" data-control="select2"
                                    data-dropdown-parent="#exampleModal" class=" form-select ref_source">
                                    <option value="">Select Referral Source</option>
                                    @foreach (Clients::all() as $item)
                                        <option value="{{ $item->id }}">{{ $item->cname }}</option>
                                    @endforeach
                                </select>
                                <span class=" alert-danger ref_source_type_id-error" id=""></span>
                            </div>
                        </div>
                        <div class="row mt-8">
                            <div class="col-md-6 ref_source_staff">
                                <label for="">Referral Source Staff</label>
                               
                                <span class=" alert-danger ref_source_staff-error" id=""></span>
                            </div>
                        </div>
                        <div class="row mt-8">
                            <div class="col-md-4">
                                <label for="">Potential RN (Registered Nurse) 1</label>
                                <select name="potential_rn_1" id="" class=" form-select select2-input"
                                    data-control="select2" tabindex="-1" data-dropdown-parent="#exampleModal" required>
                                    <option value="">Select RN</option>
                                    @foreach (Nurse::all() as $item)
                                        <option value="{{ $item->id }}">
                                            {{ $item->name }}</option>
                                    @endforeach
                                </select>
                                <span class=" alert-danger potential_rn_1-error" id=""></span>
                            </div>
                            <div class="col-md-4">
                                <label for="">Potential RN (Registered Nurse) 2</label>
                                <select name="potential_rn_2" id="" class=" form-select select2-input"
                                    data-control="select2" tabindex="-1" data-dropdown-parent="#exampleModal">
                                    <option value="">Select RN</option>
                                    @foreach (Nurse::all() as $item)
                                        <option value="{{ $item->id }}">
                                            {{ $item->name }}</option>
                                    @endforeach
                                </select>
                                <span class=" alert-danger potential_rn_2-error" id=""></span>
                            </div>
                            <div class="col-md-4">
                                <label for="">Potential RN (Registered Nurse) 3</label>
                                <select name="potential_rn_3" id="" class=" form-select select2-input"
                                    data-control="select2" tabindex="-1" data-dropdown-parent="#exampleModal">
                                    <option value="">Select RN</option>
                                    @foreach (Nurse::all() as $item)
                                        <option value="{{ $item->id }}">
                                            {{ $item->name }}</option>
                                    @endforeach
                                </select>
                                <span class=" alert-danger potential_rn_3-error" id=""></span>
                            </div>
                        </div>
                        <div class="row mt-8">
                            <div class="col-md-6">
                                <label for="">Status</label>
                                <select name="status" id="" class=" form-select">
                                    @foreach (Status::all() as $item)
                                        <option value="{{ $item->id }}">{{ $item->description }}</option>
                                    @endforeach
                                </select>
                                <span class=" alert-danger status-error" id=""></span>
                            </div>
                        </div>
                        <div class="row mt-8">
                            <div class="col-md-12">
                                <label for="">Reason</label>
                                <textarea name="reason" id="" class=" form-control"></textarea>
                                <span class=" alert-danger reason-error" id=""></span>
                            </div>
                        </div>
                        <div class="row mt-8">
                            <div class="col-md-6">
                                <label for="">RN Booked</label>
                                <select name="booked_rn" id="" class=" form-select" data-control="select2"
                                    data-dropdown-parent="#exampleModal" required>
                                    <option value="">Select RN</option>
                                    @foreach (Nurse::all() as $item)
                                        <option value="{{ $item->id }}">{{ $item->name }}
                                        </option>
                                    @endforeach
                                </select>
                                <span class=" alert-danger potential_rn-error" id=""></span>
                            </div>
                            <div class="col-md-6">
                                <label for="">Staff</label>
                                <input type="text" class=" form-control" name="staff" id=""
                                    value="{{ Auth::user()->name }}" readonly>
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
                    </form>
                </div>
            </div>
        </div>
    </div>




    <div class="modal fade" id="mdEdit" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true"
        data-bs-backdrop="static" data-bs-keyboard="false">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">Edit Referrals</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body" id="mdBody">

                </div>
            </div>
        </div>
    </div>


    <div class="modal fade" id="delModal" tabindex="-1" data-bs-backdrop="static" data-bs-keyboard="false"
        aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">Delete Referral</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body" id="mdFormDel">
                    <form action="javascript:void(0)" id="frmDelete">
                        <div class="row text-center">
                            <div class="col-md-12 mb-4"><i class="fa-solid fa-triangle-exclamation fa-2xl"></i></div>
                            <p>Are you sure you want to delete <span id="delDescription" class="fw-bold"></span></p>
                            <input type="hidden" name="id" id="InputVal">
                            <div class="col-md-6">
                                <button id="btnDelete" class="btn btn-info" id="btnDel">Delete</button>
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
    <script src="{{ asset('assets/js/self/referrals.js'). env('VERSION') }}"></script>
@endsection
