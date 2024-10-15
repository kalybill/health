@extends('layouts.app')

@section('page_header')
    <h1 class="page-heading d-flex text-dark fw-bold fs-3 flex-column justify-content-center my-0">
        Clients
    </h1>
@endsection

@section('body')
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-body">
                <form action="javascript:void" id="frmUpdtClient" data-parsley-validate>
                    <input type="hidden" name="id" id="" value="{{ $client->id }}">
                    <div class="row">
                        <div class="col-md-4">
                            <label for="">Company Name</label>
                            <input type="text" class=" form-control form-control-solid" value="{{ $client->cname }}" name="cname" id="" required>
                        </div>
                        <div class="col-md-4">
                            <label for="">Main Phone</label>
                            <input type="tel" class=" form-control form-control-solid" value="{{ $client->main_phone }}" name="main_phone" id="">
                        </div>
                        <div class="col-md-4">
                            <label for="">Address</label>
                            <input type="text" class=" form-control form-control-solid" value="{{ $client->addr }}" name="addr" id="">
                        </div>
                    </div>
                    <div class="row mt-8">
                        <div class="col-md-4">
                            <label for="">Fax</label>
                            <input type="tel" class=" form-control form-control-solid" value="{{ $client->fax }}" name="fax" id="">
                        </div>
                        <div class="col-md-4">
                            <label for="">Email Address</label>
                            <input type="text" class=" form-control form-control-solid" value="{{ $client->email }}" name="email" id="">
                        </div>
                        <div class="col-md-4">
                            <label for="">Contact Person</label>
                            <input type="text" class=" form-control form-control-solid" value="{{ $client->contact_person }}" name="contact_person" id="">
                        </div>
                    </div>
                    <div class="row mt-8">
                        <div class="col-md-4">
                            <label for="">City</label>
                            <input type="text" class=" form-control form-control-solid" value="{{ $client->city }}" name="city" id="">
                        </div>
                        <div class="col-md-4">
                            <label for="">State</label>
                            <input type="text" class=" form-control form-control-solid" value="{{ $client->state }}" name="state" id="">
                        </div>
                        <div class="col-md-4">
                            <label for="">Zip code</label>
                            <input type="text" class=" form-control form-control-solid" value="{{ $client->zip }}" name="zip_code" id="">
                        </div>
                    </div>
                    <div class="row mt-8">
                        <div class="col-md-4">
                            <label for="">Title</label>
                            <input type="text" class=" form-control form-control-solid" value="{{ $client->title }}" name="title" id="">
                        </div>
                        <div class="col-md-4">
                            <label for="">Remark</label>
                            <textarea name="remarks" id="" class=" form-control form-control-solid">{{ $client->remarks }}</textarea>
                        </div>
                    </div>
                        <button type="submit" class="btn btn-primary" id="kt_sign_in_submit">
                            <span class="indicator-label">Save</span>
                            <span class="indicator-progress">Please wait...
                                <span class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
                        </button>
                </form>
            </div>
        </div>
    </div>
</div>
<div class="row mt-8">
    <div class="col-md-12 mb-8">
        <div class="float-end"><button class=" btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal"><i class="fa-solid fa-plus fa-xl"></i> New Client</button></div>
    </div>
    <div class="card shadow-sm">
        <div class="card-body">
            <div class=" table-responsive">
                <table class=" table table-row-dashed table-row-gray-300 gy-7" id="myDatatable">
                    <thead>
                        <tr class="fw-semibold fs-6 text-muted">
                            <th style="visibility: hidden">ID</th>
                            <th>Title</th>
                            <th>Contact Person</th>
                            <th>Phone</th>
                            <th>Work Phone</th>
                            <th>Email</th>
                            <th>Fax</th>
                            <th>DoB</th>
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

<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true"
        data-bs-backdrop="static" data-bs-keyboard="false">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">Edit Nurse</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body" id="mdEdit">
                    <form action="javascript:void(0)" id="frmAddClientsContact" data-parsley-validate>
                        <input type="hidden" name="id" id="" value="{{ $client->id }}">
                        <div class="row">
                            <div class="col-md-4">
                                <label for="">Company</label>
                                <input type="text" name="client_id" id="" class=" form-control form-control-solid" value="{{ $client->cname }}" required readonly>
                            </div>
                            <div class="col-md-4">
                                <label for="">Cell Phone</label>
                                <input type="tel" name="phone" id="" class=" form-control form-control-solid">
                            </div>
                            <div class="col-md-4">
                                <label for="">Email</label>
                                <input type="email" name="email" id="" class=" form-control form-control-solid">
                            </div>
                        </div>
                        <div class="row mt-8">
                            <div class="col-md-4">
                                <label for="">Conatact Name</label>
                                <input type="text" name="contact_person" id="" class=" form-control form-control-solid">
                            </div>
                            <div class="col-md-4">
                                <label for="">Work Phone</label>
                                <input type="tel" name="work_phone" id="" class=" form-control form-control-solid">
                            </div>
                            <div class="col-md-4">
                                <label for="">Birthday</label>
                                <input type="date" name="dob" id=""  class=" form-control form-control-solid kt_datepicker">
                            </div>
                        </div>
                        <div class="row mt-8">
                            <div class="col-md-4">
                                <label for="">Title</label>
                                <input type="text" name="title" id="" class=" form-control form-control-solid">
                            </div>
                            <div class="col-md-4">
                                <label for="">Fax</label>
                                <input type="tel" name="fax" id="" class=" form-control form-control-solid">
                            </div>
                        </div>
                        <div class="mt-8">
                            <button type="submit" class="btn btn-primary" id="kt_sign_in_submit">
                                <span class="indicator-label">Save</span>
                                <span class="indicator-progress">Please wait...
                                    <span class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('scripts')
<script src="{{ asset('assets/js/self/edit_clients.js') . env('VERSION') }}"></script>
@endsection