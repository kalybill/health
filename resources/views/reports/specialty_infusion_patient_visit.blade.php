@extends('layouts.app')

@section('page_header')
    <h1 class="page-heading d-flex text-dark fw-bold fs-3 flex-column justify-content-center my-0">
        Specialty Infusion Patient Visit Schedule
    </h1>
@endsection
@section('body')
<div class="row mt-10">
    <div class="card shadow-sm">
        <div class="card-body">
            {{-- <form action="javascript:void(0)" id="frmDate" >
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
            </form> --}}
            <div class=" table-responsive">
                <div class="date-range-selector"></div>
                <table class=" table table-row-dashed table-row-gray-300 gy-7" id="myDatatable">
                    <thead>
                        <tr class="fw-semibold fs-6 text-muted">
                            <th style="visibility: hidden">ID</th>
                            <th>Ref Source</th>
                            <th>Patient Name</th>
                            <th>DOB</th>
                            <th>Visit Date</th>
                            <th>Visit Type</th>
                            <th>Primary RN</th>
                            <th>Case Type</th>
                            <th>Created At</th>
                            
                        </tr>
                    </thead>
                    <tbody id="mdData" >
                        
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
@section('scripts')
<script src="{{ asset('assets/js/self/specialty_inf_patient_visit.js') . env('VERSION') }}"></script>
<script>
    $('.subNavPatientRPT').addClass('hover show');
    $('#navSpeialtyInPatVisit').addClass('active')
</script>
@endsection