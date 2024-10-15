@php
    use App\Models\{Nurse,Medical_record};
@endphp
@extends('layouts.app')

@section('page_header')
    <h1 class="page-heading d-flex text-dark fw-bold fs-3 flex-column justify-content-center my-0">
        Outstanding Note/RS Reports (Nurses)
    </h1>
@endsection

@section('body')
<div class="row mt-10">
    <div class="card shadow-sm">
        <div class="card-body">
            {{-- <form action="javascript:void(0)" id="frmNurse">
                <div class="row">
                    <div class="col-md-6">
                        <label for="">Search By Nurse</label>
                        <select name="id" id="" class="form-select" data-control="select2">
                            <option value="">Select Nurse</option>
                            @foreach (Medical_record::where('nurse_id', '!=', null)->get() as $item)
                            <option value="{{ $item->nurse_id }}">{{ Nurse::find($item->nurse_id)->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-6 mt-5">
                        <button type="submit" class="btn btn-primary" id="kt_sign_in_submit">
                            <span class="indicator-label">Search</span>
                            <span class="indicator-progress">Please wait...
                                <span class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
                        </button>
                    </div>
                </div>
            </form> --}}
            <div class=" table-responsive">
                <table class=" table table-row-dashed table-row-gray-300 gy-7" id="myDatatable">
                    <thead>
                        <tr class="fw-semibold fs-6 text-muted">
                            <th style="visibility: hidden">ID</th>
                            <th>RN Name</th>
                            <th>Patient Name</th>
                            <th>Visit Date</th>
                            <th>Visit Type</th>
                            <th>Remarks</th>
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
<script src="{{ asset('assets/js/self/out_by_nurse.js') . env('VERSION') }}"></script>
<script>
    $('.subNavMDRPT').addClass('hover show');
    $('#navOutByNurse').addClass('active')
</script>
@endsection
