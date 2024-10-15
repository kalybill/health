@php
    use App\Models\Referral;
@endphp
@extends('layouts.app')
@section('page_header')
    <h1 class="page-heading d-flex text-dark fw-bold fs-3 flex-column justify-content-center my-0">
        Schedules & Progress & Report/New Orders
    </h1>
@endsection
@section('body')
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
@endsection
@section('scripts')
<script src="{{ asset('assets/js/self/schedules.js') . env('VERSION') }}"></script>
<script>
    $('#navSchedules').addClass('active')
</script>
@endsection