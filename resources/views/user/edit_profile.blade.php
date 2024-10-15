@extends('layouts.app')

@section('page_header')
    <h1 class="page-heading d-flex text-dark fw-bold fs-3 flex-column justify-content-center my-0">
        Edit Profile
    </h1>
@endsection

@section('body')
    <div class="row mt-10">
        <div class="card shadow-sm">
            <div class="card-body">
                <form action="javascript:void(0)" data-parsley-validate id="frmUptChangePass">
                    <div class="row">
                        <div class="row mt-7">
                            <div class="col-md-6">
                                <label for="">Change Password</label>
                                <input type="password" class=" form-control" name="password" id="" required>
                                <span class=" alert-danger password-error" id=""></span>
                            </div>

                        </div>
                    </div>
                        <button type="submit" class="btn btn-primary mt-7" id="kt_sign_in_update">
                            <span class="indicator-label">Update</span>
                            <span class="indicator-progress">Please wait...
                                <span class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
                        </button>
                </form>
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
