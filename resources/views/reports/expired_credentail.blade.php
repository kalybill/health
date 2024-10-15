@extends('layouts.app')

@section('page_header')
    <h1 class="page-heading d-flex text-dark fw-bold fs-3 flex-column justify-content-center my-0">
        Expired Credentials
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
                            <th>RN Name</th>
                            <th>Document Name</th>
                            <th>Expiry Date</th>
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
@endsection
@section('scripts')
<script src="{{ asset('assets/js/self/credential_exp.js') . env('VERSION') }}"></script>
<script>
    $('#navCredentialExp').addClass('active')
</script>
@endsection
