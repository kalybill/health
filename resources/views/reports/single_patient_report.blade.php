@php
    use App\Models\{Nurse,Medical_record,Referral,Clients};
@endphp
@extends('layouts.app')

@section('page_header')
    <h1 class="page-heading d-flex text-dark fw-bold fs-3 flex-column justify-content-center my-0">
        Outstanding Note/RS Reports (Patient)
    </h1>
@endsection

@section('body')
<div class="row mt-10">
    <div class="card shadow-sm">
        <div class="card-body">
            <div class=" table-responsive">
                <table class=" table table-row-dashed table-row-gray-300 gy-7" id="myDatatable">
                    <thead>
                        <tr class="fw-semibold fs-6 text-muted">
                            <th style="visibility: hidden">ID</th>
                            <th>Patient Name</th>
                            <th>Client</th>
                            <th>Process Date</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($data as $item)
                            <tr>
                                <td></td>
                                <td>{{ Referral::find($item->patient_id)->name }}</td>
                                <td>{{ Clients::find($item->client)->cname }}</td>
                                <td>{{ convert_date_from_db($item->date_process) }}</td>
                                <td><button class="btn btn-primary" data-id="{{ $item->scheduling_id }}" data-bs-toggle="modal" data-bs-target="#exampleModal" id="btnView"><i class="fa-solid fa-pen-to-square fa-xl" style="color: #00D100;"></i></a>View</button></td>
                            </tr>
                        @endforeach
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
<script src="{{ asset('assets/js/self/single_nurse_report.js') . env('VERSION') }}"></script>
<script>
    $('.subNavMDRPT').addClass('hover show');
    $('#navOutByPhama').addClass('active')
</script>
@endsection
