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
                    <form action="javascript:void(0)" id="frmArea" data-parsley-validate>
                        <input type="hidden" name="nurse_id" value="{{ $nurse->id }}">
                        
                        <div class="mb-0">
                            <label class="form-label">Add Geographical Area</label>
                            <input class="form-control form-control-solid" name="area" value="" id="kt_tagify_2"/>
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
                                <th>Area</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($nurse_area as $item)
                                <tr>
                                    <td>{{ $item->area }}</td>
                                    <td></td>
                                </tr>
                            @endforeach
                        </tbody>
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
<script src="{{ asset('assets/js/self/geo_area.blade.js') . env('VERSION') }}"></script>
@endsection