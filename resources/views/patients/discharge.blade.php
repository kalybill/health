@php
    use App\Models\{Referral,Service_info};
@endphp
@extends('layouts.app')

@section('body')
<div class="row mt-10">
    <div class="card shadow-sm">
        <div class="card-body">
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
<script src="{{ asset('assets/js/self/patient_discharged.js') . env('VERSION') }}"></script>
<script>
    $('#navDischarged').addClass('active')
</script>
@endsection