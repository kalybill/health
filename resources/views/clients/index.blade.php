@extends('layouts.app')

@section('page_header')
    <h1 class="page-heading d-flex text-dark fw-bold fs-3 flex-column justify-content-center my-0">
        Clients
    </h1>
@endsection

@section('body')
<div class="row">
    <div class="col-md-12">
        <div class="float-end"><button class=" btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal"><i class="fa-solid fa-plus fa-xl"></i> New Client</button></div>
    </div>
</div>

<div class="row mt-10">
    <div class="card shadow-sm">
        <div class="card-body">
            <div class=" table-responsive">
                <table class=" table table-row-dashed table-row-gray-300 gy-7" id="myDatatable">
                    <thead>
                        <tr class="fw-semibold fs-6 text-muted">
                            <th style="visibility: hidden">ID</th>
                            <th>Company Name</th>
                            <th>Phone</th>
                            <th>Email</th>
                            <th>Title</th>
                            <th>Contact Person</th>
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
                    <h1 class="modal-title fs-5" id="exampleModalLabel">Add Client</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="javascript:void" id="frmClient" data-parsley-validate>
                        <div class="row">
                            <div class="col-md-6">
                                <label for="">Company Name</label>
                                <input type="text" class=" form-control form-control-solid" name="cname" id="" required>
                            </div>
                            <div class="col-md-6">
                                <label for="">Main Phone</label>
                                <input type="tel" class=" form-control form-control-solid" name="main_phone" id="">
                            </div>
                        </div>
                        <div class="row mt-8">
                            <div class="col-md-6">
                                <label for="">Address</label>
                                <input type="text" class=" form-control form-control-solid" name="addr" id="">
                            </div>
                            <div class="col-md-6">
                                <label for="">Fax</label>
                                <input type="tel" class=" form-control form-control-solid" name="fax" id="">
                            </div>
                        </div>
                        <div class="row mt-8">
                            <div class="col-md-4">
                                <label for="">City</label>
                                <input type="text" class=" form-control form-control-solid" name="city" id="">
                            </div>
                            <div class="col-md-4">
                                <label for="">State</label>
                                <input type="text" class=" form-control form-control-solid" name="state" id="">
                            </div>
                            <div class="col-md-4">
                                <label for="">Zip code</label>
                                <input type="text" class=" form-control form-control-solid" name="zip_code" id="">
                            </div>
                        </div>
                        <div class="row mt-8">
                            <div class="col-md-6 ">
                                <label for="">Email Address</label>
                                <input type="text" class=" form-control form-control-solid" name="email" id="">
                            </div>
                            <div class="col-md-6 ">
                                <label for="">Contact Person</label>
                                <input type="text" class=" form-control form-control-solid" name="contact_person" id="">
                            </div>
                        </div>
                        <div class="row mt-8">
                            <div class="col-md-6 ">
                                <label for="">Title</label>
                                <input type="text" class=" form-control form-control-solid" name="title" id="">
                            </div>
                            <div class="col-md-6 ">
                                <label for="">Remark</label>
                                <textarea name="remarks" id="" class=" form-control form-control-solid"></textarea>
                            </div>
                        </div>
                        <div class="modal-footer mt-3">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
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
    <script src="{{ asset('assets/js/self/client.js') . env('VERSION') }}"></script>
    <script>
        $('#navClient').addClass('active')
    </script>
@endsection