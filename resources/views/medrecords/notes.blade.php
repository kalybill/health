@php
    use App\Models\{Referral};
@endphp
@extends('layouts.app')

@section('page_header')
    <h1 class="page-heading d-flex text-dark fw-bold fs-3 flex-column justify-content-center my-0">
        Medical Records</h1>
@endsection
@section('body')
<div class="row">
    <div class="card">
     <div class="card-body">
        <div class=" table-responsive">
          <div class="date-range-selector"></div>
            <table class=" table table-row-dashed table-row-gray-300 gy-7" id="myDatatable">
                <thead>
                    <tr class="fw-semibold fs-6 text-muted">
                        <th style="visibility: hidden">ID</th>
                        <th>Patient</th>
                        <th>Date</th>
                        <th>Visit Type</th>
                        <th>Nurse</th>
                        <th>Client</th>
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
<script src="{{ asset('assets/js/self/notes.js') . env('VERSION') }}"></script>
<script>
    $('#navNotes').addClass('active')
</script>
@endsection