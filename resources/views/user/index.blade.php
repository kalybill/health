@extends('layouts.app')

@section('page_header')
    <h1 class="page-heading d-flex text-dark fw-bold fs-3 flex-column justify-content-center my-0">
        Users
    </h1>
@endsection

@section('body')
<div class="row">
    <div class="col-md-12">
        <div class="float-end"><button class=" btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal"><i class="fa-solid fa-plus fa-xl"></i> New User</button></div>
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
                            <th>Name</th>
                            <th>Email</th>
                            <th>Access Type</th>
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

{{-- Modal Section --}}
<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true"
data-bs-backdrop="static" data-bs-keyboard="false">
<div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
        <div class="modal-header">
            <h1 class="modal-title fs-5" id="exampleModalLabel">New Visit Type</h1>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
            <form action="javascript:void(0)" data-parsley-validate id="frmPump">
               <div class="row">
                <div class="col-md-6">
                    <label for="">Name</label>
                    <input type="text" class=" form-control" name="name" id="" required>
                            <span class=" alert-danger name-error" id=""></span>
                </div>
                <div class="col-md-6">
                    <label for="">Email</label>
                    <input type="email" class=" form-control" name="email" id="" required>
                            <span class=" alert-danger email-error" id=""></span>
                </div>
               </div>
               <div class="row mt-7">
                <div class="col-md-6">
                    <label for="">Password</label>
                    <input type="password" class=" form-control" name="password" id="" required>
                            <span class=" alert-danger password-error" id=""></span>
                </div>
                <div class="col-md-6">
                    <label for="">Access Type</label>
                   <select class=" form-select" name="role" id="" required>
                    <option value="">Select Role</option>
                    <option value="1">Admin</option>
                    <option value="2">Front Desk</option>
                   </select>
                    <span class=" alert-danger password-error" id=""></span>
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


<div class="modal fade" id="mdEdit" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true"
        data-bs-backdrop="static" data-bs-keyboard="false">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">Update User</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body" id="mdBody">
                    
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="delModal" tabindex="-1" data-bs-backdrop="static" data-bs-keyboard="false"
        aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">Delete Visit</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body" id="mdFormDel">
                    <form action="javascript:void(0)" id="frmDelete">
                        <div class="row text-center">
                            <div class="col-md-12 mb-4"><i class="fa-solid fa-triangle-exclamation fa-2xl"></i></div>
                            <p>Are you sure you want to delete <span id="delDescription" class="fw-bold"></span></p>
                            <input type="hidden" name="id" id="InputVal">
                            <div class="col-md-6">
                                <button id="btnDelete" class="btn btn-info" id="btnDel">Delete</button>
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
<script src="{{ asset('assets/js/self/user.js') }}"></script>
<script>
    $('#navUser').addClass('active')
</script>
@endsection