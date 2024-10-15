@php
    use App\Models\{Document};
@endphp
@extends('layouts.app')

@section('body')
<div class="row">
    <div class="col-md-12 mb-3">
       <a href="{{ url('settings/nurse') }}"> <i class="fa-solid fa-left-long fa-2xl"></i></a>
    </div>
    <div class="card">
        <div class="card-body">
            <div class="col-md-12">
                <div class="col-md-12">
                    <h5>Credential Tracking</h5>
                </div>
                <div class=" p-3">
                    <form action="javascript:void(0)" id="frmCred" data-parsley-validate>
                        <input type="hidden" name="nurse_id" value="{{ $nurse->id }}">
                        <div class="row">
                            <div class="col-md-4">
                                <label for="">RN Name</label>
                                <input type="text" class="form-control form-control-solid" name="rn_name"
                                    value="{{ $nurse->name }}" id="" required readonly>
                                    <span class=" alert-danger rn_name-error" id=""></span>
                            </div>
                            <div class="col-md-4">
                                <label for="">Document Name</label>
                                <select name="document_name" id="" class=" form-select" required>
                                    <option value="">Select Document</option>
                                    @foreach (Document::all() as $item)
                                    <option value="{{ $item->id }}">{{ $item->description }}</option>
                                    @endforeach
                                    
                                </select>
                                <span class=" alert-danger document_name-error" id=""></span>
                            </div>
                            <div class="col-md-4">
                                <label for="">Issue Date</label>
                                <input type="text" class=" form-control kt_datepicker"
                                    placeholder="mm-dd-yyyy" name="issue_date" id="">
                            </div>
                        </div>
                        <div class="row mt-8">
                            <div class="col-md-4">
                                <div class="form-check form-check-custom form-check-solid">
                                    <input class="form-check-input expires" type="checkbox" value="1"
                                        id="" name="expires"/>
                                    <label class="form-check-label" for="flexCheckDefault">
                                        Expires?
                                    </label>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <label for="">Expiry Date</label>
                                <input type="text" class=" form-control kt_datepicker expiry_date"
                                    placeholder="mm-dd-yyyy" name="expiry_date" id="">
                            </div>
                            <div class="col-md-4">
                                <label for="">Remarks</label>
                                <textarea name="remarks" id="" class=" form-control form-control-solid"></textarea>
                            </div>
                        </div>
                        <button type="submit" class="btn btn-primary" id="kt_sign_in_submit">
                            <span class="indicator-label">Save</span>
                            <span class="indicator-progress">Please wait...
                                <span class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
                        </button>
                    </form>
                </div>
                <div class=" table-responsive">
                    <div id="dateRangeHere"></div>
                    <table class=" table table-row-dashed table-row-gray-300 gy-7" id="myDatatable">
                        <thead>
                            <tr>
                                <th style="visibility: hidden">ID</th>
                                <th>RN Name</th>
                                <th>Document Name</th>
                                <th>Issue Date</th>
                                <th>Expires?</th>
                                <th>Expiry Date</th>
                                <th>Remarks</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                    </table>
                </div>
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
                    <h1 class="modal-title fs-5" id="exampleModalLabel">Edit Nurse</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body" id="mdEdit">
                    
                </div>
            </div>
        </div>
    </div>
@endsection
@section('scripts')
<script src="{{ asset('assets/js/self/credentials.js') . env('VERSION') }}"></script>
@endsection