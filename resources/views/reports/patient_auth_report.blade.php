@php
    use App\Models\{Nurse,Medical_record,Referral,Clients};
@endphp
@extends('layouts.app')

@section('page_header')
    <h1 class="page-heading d-flex text-dark fw-bold fs-3 flex-column justify-content-center my-0">
        Patient Authorization
    </h1>
@endsection
@section('body')
<div class="row mt-10">
    <div class="card shadow-sm">
        <div class="card-body">
            <form action="javascript:void(0)" id="frmDate" >
                <div class="row">
                    <div class="col-md-4">
                        <label for="">Start Date</label>
                        <input type="text" name="startDate" class="form-control kt_datepicker startDate" >
                    </div>
                    <div class="col-md-4">
                        <label for="">End Date</label>
                        <input type="text" name="endDate" class="form-control kt_datepicker endDate" >
                    </div>
                    <div class="col-md-6 mt-4">
                        <button type="submit" class="btn btn-primary" id="kt_sign_in_submit">
                            <span class="indicator-label">Search</span>
                            <span class="indicator-progress">Please wait...
                                <span class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
                        </button>
                    </div>
                </div>
            </form>
            <div class=" table-responsive">
                <table class=" table table-row-dashed table-row-gray-300 gy-7" id="myDatatable">
                    <thead>
                        <tr class="fw-semibold fs-6 text-muted">
                            <th style="visibility: hidden">ID</th>
                            <th>RN Name</th>
                            <th>Patient Name</th>
                            <th>Visit Type</th>
                            <th>Visit Date</th>
                            <th>Auth.</th>
                            <th>Visit Count</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody id="mdData" >
                        
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="exampleModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-fullscreen">
      <div class="modal-content">
        <div class="modal-header">
          <h1 class="modal-title fs-5" id="exampleModalLabel">Patient Medical Records</h1>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body" id="mdMdRecords">
            <div class=" table-responsive">
                <table class=" table table-row-dashed table-row-gray-300 gy-7" id="reportTB">
                    <thead>
                        <tr class="fw-semibold fs-6 text-muted">
                            <th style="visibility: hidden">ID</th>
                            <th>RN Name</th>
                            <th>Patient Name</th>
                            <th>Visit Type</th>
                            <th>Visit Date</th>
                        </tr>
                    </thead>
                    <tbody >
                        
                    </tbody>
                </table>
            </div>
        </div>
      </div>
    </div>
  </div>
@endsection
@section('scripts')
<script src="{{ asset('assets/js/self/auth_report.js') . env('VERSION') }}"></script>
<script>
    $('.subNavPatientRPT').addClass('hover show');
    $('#navAuthRPT').addClass('active')
</script>
@endsection