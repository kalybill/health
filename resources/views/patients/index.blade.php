@php
    use App\Models\{Referral,Service_info};
@endphp
@extends('layouts.app')

@section('body')
<div class="row">
    <div class="col-md-3">
        <!--begin::Alert-->
        <div class="alert alert-primary d-flex align-items-center p-5">
            <!--begin::Icon-->
            <span class="svg-icon svg-icon-2hx svg-icon-primary me-3">
                <i class="fa-solid fa-circle-half-stroke fa-lg"></i>
            </span>
            <!--end::Icon-->

            <!--begin::Wrapper-->
            <div class="d-flex flex-column">
                <!--begin::Title-->
                <h4 class="mb-1 text-dark text-muted">Active Patient</h4>
                <!--end::Title-->
                <!--begin::Content-->
                <span><h5>{{ Referral::referrals_count(4) }}</h5></span>
                <!--end::Content-->
            </div>
            <!--end::Wrapper-->
        </div>
        <!--end::Alert-->
    </div>
    <div class="col-md-3">
        <!--begin::Alert-->
        <div class="alert alert-success d-flex align-items-center p-5">
            <!--begin::Icon-->
            <span class="svg-icon svg-icon-2hx svg-icon-primary me-3">
                <i class="fa-solid fa-share fa-lg"></i>
            </span>
            <!--end::Icon-->

            <!--begin::Wrapper-->
            <div class="d-flex flex-column">
                <!--begin::Title-->
                <h4 class="mb-1 text-dark text-muted">Long term Patients</h4>
                <!--end::Title-->
                <!--begin::Content-->
               <a href="{{ url('patient/long-term') }}"> <span><h5>{{ Service_info::cast_type_count(4) }}</h5></span></a>
                <!--end::Content-->
            </div>
            <!--end::Wrapper-->
        </div>
        <!--end::Alert-->
    </div>
    <div class="col-md-3">
        <!--begin::Alert-->
        <div class="alert alert-info d-flex align-items-center p-5">
            <!--begin::Icon-->
            <span class="svg-icon svg-icon-2hx svg-icon-primary me-3">
                <i class="fa-solid fa-rotate"></i>
            </span>
            <!--end::Icon-->

            <!--begin::Wrapper-->
            <div class="d-flex flex-column">
                <!--begin::Title-->
                <h4 class="mb-1 text-dark text-muted">Specialty Infusion Patients</h4>
                <!--end::Title-->
                <!--begin::Content-->
                <a href="{{ url('patient/specialty-infusion') }}"><span><h5>{{ Service_info::cast_type_count(6) }}</h5></span></a>
                <!--end::Content-->
            </div>
            <!--end::Wrapper-->
        </div>
        <!--end::Alert-->
    </div>
    <div class="col-md-3">
        <!--begin::Alert-->
        <div class="alert alert-warning d-flex align-items-center p-5">
            <!--begin::Icon-->
            <span class="svg-icon svg-icon-2hx svg-icon-primary me-3">
                <i class="fa-regular fa-compass fa-lg"></i>
            </span>
            <!--end::Icon-->

            <!--begin::Wrapper-->
            <div class="d-flex flex-column">
                <!--begin::Title-->
                <h4 class="mb-1 text-dark text-muted">Discharged Patients</h4>
                <!--end::Title-->
                <!--begin::Content-->
                <span><h5>{{ Referral::referrals_count(5) }}</h5></span>
                <!--end::Content-->
            </div>
            <!--end::Wrapper-->
        </div>
        <!--end::Alert-->
    </div>
</div>
<div class="row mt-10">
    <div class="card shadow-sm">
        <div class="card-body">
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
            <div class=" table-responsive">
                <div id="dateRangeHere"></div>
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
                            <th>Referral Status</th>
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
@endsection
@section('scripts')
<script src="{{ asset('assets/js/self/patient.js') . env('VERSION') }}"></script>
<script>
    $('#navPatient').addClass('active')
</script>
@endsection