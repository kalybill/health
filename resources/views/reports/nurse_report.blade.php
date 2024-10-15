@extends('layouts.app')

@section('page_header')
    <h1 class="page-heading d-flex text-dark fw-bold fs-3 flex-column justify-content-center my-0">
        Nures' Reports
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
                <table class=" table table-row-dashed table-row-gray-300 gy-7" id="myDatatable">
                    <thead>
                        <tr class="fw-semibold fs-6 text-muted">
                            <th style="visibility: hidden">ID</th>
                            <th>RN Name</th>
                            <th>Patient Name</th>
                            <th>Process Date</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        
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
          
        </div>
      </div>
    </div>
  </div>
@endsection
@section('scripts')
<script src="{{ asset('assets/js/self/nursereport.js') . env('VERSION') }}"></script>
<script>
    $('.subNavMDRPT').addClass('hover show');
    $('#navNurseRpt').addClass('active')
</script>
@endsection
