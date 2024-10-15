@php
    use App\Models\{Referral, User,Visit_type,Nurse,Order_type};
@endphp
@extends('layouts.app')

@section('page_header')
    <h1 class="page-heading d-flex text-dark fw-bold fs-3 flex-column justify-content-center my-0">
        Schedules & Progress & Report/New Orders</h1>
    <h4 class=" mt-6">Name : {{ Referral::find($id)->name }}</h4>
    <h4 class=" mt-6">MRN : {{ Referral::find($id)->mrn }}</h4>
@endsection
@section('body')
    <div class="row">
        <div class="card">
            <div class="card-body">
                <ul class="nav nav-tabs nav-line-tabs mb-5 fs-6">
                    <li class="nav-item">
                        <a class="nav-link active" data-bs-toggle="tab" href="#kt_tab_pane_1">Scheduling</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" data-bs-toggle="tab" href="#kt_tab_pane_2">Progress Note</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" data-bs-toggle="tab" href="#kt_tab_pane_3">New Order </a>
                    </li>
                </ul>
                <div class="tab-content" id="myTabContent">
                    <div class="tab-pane fade show active" id="kt_tab_pane_1" role="tabpanel">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="float-end"><button class=" btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal"><i class="fa-solid fa-plus fa-xl"></i> Add Schedule</button></div>
                            </div>
                        </div>
                        <div class=" table-responsive">
                            <table class=" table table-row-dashed table-row-gray-300 gy-7" id="myDatatable">
                                <thead>
                                    <tr class="fw-semibold fs-6 text-muted">
                                        <th style="visibility: hidden">ID</th>
                                        <th>Visit Date</th>
                                        <th>Visit Type</th>
                                        <th>RN Name</th>
                                        <th>Client</th>
                                        <th>Staffer</th>
                                        <th>ETA</th>
                                        <th>Remarks</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="kt_tab_pane_2" role="tabpanel">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="float-end"><button class=" btn btn-primary" data-bs-toggle="modal" data-bs-target="#progressNoteModal"><i class="fa-solid fa-plus fa-xl"></i> Add Progrss Note</button></div>
                            </div>
                        </div>
                        <div class=" table-responsive">
                            <table class=" table table-row-dashed table-row-gray-300 gy-7" id="myDatatableProgress">
                                <thead>
                                    <tr class="fw-semibold fs-6 text-muted">
                                        <th style="visibility: hidden">ID</th>
                                        <th>MRN</th>
                                        <th>Nurse</th>
                                        <th>Report</th>
                                        <th>Reporter</th>
                                        <th>Report Date</th>
                                        <th>Staffer</th>
                                        <th>F/U Action</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    
                                </tbody>
                            </table>
                        </div>
                        
                    </div>
                    <div class="tab-pane fade" id="kt_tab_pane_3" role="tabpanel">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="float-end"><button class=" btn btn-primary" data-bs-toggle="modal" data-bs-target="#newOrderModal"><i class="fa-solid fa-plus fa-xl"></i> Add New Order</button></div>
                            </div>
                        </div>
                        <div class=" table-responsive">
                            <table class=" table table-row-dashed table-row-gray-300 gy-7" id="myDatatableNewnote">
                                <thead>
                                    <tr class="fw-semibold fs-6 text-muted">
                                        <th style="visibility: hidden">ID</th>
                                        <th>Order Type</th>
                                        <th>New Order</th>
                                        <th>Start Date</th>
                                        <th>End Date</th>
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
        </div>
    </div>


    {{-- Modal Section --}}
<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true"
data-bs-backdrop="static" data-bs-keyboard="false">
<div class="modal-dialog modal-dialog-centered modal-lg">
    <div class="modal-content">
        <div class="modal-header">
            <h1 class="modal-title fs-5" id="exampleModalLabel">Add Schedule</h1>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
            <form action="javascript:void(0)" id="frmSchdule" data-parsley-validate>
                <input type="hidden" value="{{ $id }}" name="patient_id" id="">
                <div class="row mb-5">
                    <div class="col-md-6 fv-row">
                        <label class="fs-5 fw-semibold mb-2">Visit Date</label>
                        <input type="date" name="visit_date"
                            class="form-control kt_datepicker form-control-solid" id=""
                            placeholder="mm-dd-yyyy" value="" required/>
                            <span class=" alert-danger visit_date-error" id=""></span>
                    </div>
                    <div class="col-md-6 fv-row">
                        <label class="fs-5 fw-semibold mb-2">Patient Name</label>
                        <input type="text" class="form-control form-control-solid" placeholder=""
                            name="" value="{{ Referral::find($id)->name }}" readonly />
                            
                    </div>
                </div>
                <div class="row mb-5">
                    <div class="col-md-6 fv-row">
                        <label class="fs-5 fw-semibold mb-2">Visit Type</label>
                        <select name="visit_type" class=" form-select" id="" data-control="select2">
                            @foreach (Visit_type::all() as $item)
                                <option value="{{ $item->id }}">{{ $item->description }}</option>
                            @endforeach
                        </select>
                        <span class=" alert-danger visit_type-error" id=""></span>
                    </div>
                    <div class="col-md-6 fv-row">
                        <label class="fs-5 fw-semibold mb-2">RN</label>
                        <select name="nurse_id" class=" form-select" id="" data-control="select2">
                            @foreach (Nurse::all() as $item)
                                <option value="{{ $item->id }}">{{ $item->name }}</option>
                            @endforeach
                        </select>
                        <span class=" alert-danger nurse_id-error" id=""></span>
                    </div>
                </div>
                <div class="row mb-5">
                    <div class="col-md-6 fv-row">
                        <label class="fs-5 fw-semibold mb-2">Client</label>
                        <input type="text" class="form-control form-control-solid" value="" name="client" id="">
                        <span class=" alert-danger client-error" id=""></span>
                    </div>
                    <div class="col-md-6 fv-row">
                        <label class="fs-5 fw-semibold mb-2">Staffer</label>
                        <input type="text" class="form-control form-control-solid" placeholder=""
                            name="staffer" value="{{ Auth::user()->name }}" readonly />
                            <span class=" alert-danger staffer-error" id=""></span>
                    </div>
                </div>
                <div class="row mb-5">
                    <div class="col-md-6 fv-row">
                        <label class="fs-5 fw-semibold mb-2">ETA</label>
                        <textarea name="eta" id="" class="form-control form-control-solid"></textarea>
                        <span class=" alert-danger eta-error" id=""></span>
                    </div>
                    <div class="col-md-6 fv-row">
                        <label class="fs-5 fw-semibold mb-2">Remarks</label>
                        <textarea name="remarks" id="" class="form-control form-control-solid"></textarea>
                        <span class=" alert-danger remarks-error" id=""></span>
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


<div class="modal fade" id="editSchedule" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true"
data-bs-backdrop="static" data-bs-keyboard="false">
<div class="modal-dialog modal-dialog-centered modal-lg">
    <div class="modal-content">
        <div class="modal-header">
            <h1 class="modal-title fs-5" id="exampleModalLabel">Add Schedule</h1>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body" id="mdSchd">
            
        </div>
    </div>
</div>
</div>



{{-- Progress Note --}}
<div class="modal fade" id="progressNoteModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true"
data-bs-backdrop="static" data-bs-keyboard="false">
<div class="modal-dialog modal-dialog-centered modal-lg">
    <div class="modal-content">
        <div class="modal-header">
            <h1 class="modal-title fs-5" id="exampleModalLabel">Add Progress Note</h1>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
            <form action="javascript:void(0)" id="frmProgress">
                <input type="hidden" value="{{ $id }}" name="patient_id" id="">
                <div class="row mb-5">
                    <div class="col-md-6 fv-row">
                        <label class="fs-5 fw-semibold mb-2">MRN</label>
                        <input type="text" class="form-control form-control-solid" id="" readonly
                            value="{{ Referral::find($id)->mrn }}" />
                            
                    </div>
                    <div class="col-md-6 fv-row">
                        <label class="fs-5 fw-semibold mb-2">Nurse</label>
                        <select name="nurse_id" class=" form-select" id="" data-control="select2">
                            @foreach (Nurse::all() as $item)
                                <option value="{{ $item->id }}">{{ $item->name }}</option>
                            @endforeach
                        </select>
                        <span class=" alert-danger nurse_id-error" id=""></span>
                    </div>
                </div>
                <div class="row mb-5">
                    <div class="col-md-6 fv-row">
                        <label class="fs-5 fw-semibold mb-2">Report</label>
                        <textarea name="report" id="" class="form-control form-control-solid"></textarea>
                        <span class=" alert-danger report-error" id=""></span>
                    </div>
                    <div class="col-md-6 fv-row">
                        <label class="fs-5 fw-semibold mb-2">Reporter</label>
                        <textarea name="reporter" id="" class="form-control form-control-solid"></textarea>
                        <span class=" alert-danger reporter-error" id=""></span>
                    </div>
                </div>
                <div class="row mb-5">
                    <div class="col-md-6 fv-row">
                        <label class="fs-5 fw-semibold mb-2">Report Date</label>
                        <input type="date" class="form-control form-control-solid kt_datepicker"
                            name="report_date" id="" value="" placeholder="mm-dd-yyyy">
                            <span class=" alert-danger report_date-error" id=""></span>
                    </div>
                    <div class="col-md-6 fv-row">
                        <label class="fs-5 fw-semibold mb-2">Staffer</label>
                        <input type="text" class="form-control form-control-solid"
                            name="staffer" id="" value="{{ $progress != null ? $progress->staffer : '' }}" readonly>
                            <span class=" alert-danger staffer-error" id=""></span>
                    </div>
                </div>
                <div class="row mb-5">
                    <div class="col-md-6 fv-row">
                        <label for="" class="fs-5 fw-semibold mb-2">F/U Action</label>
                        <textarea name="fu_action" id="" class=" form-control form-control-solid"></textarea>
                        <span class=" alert-danger fu_action-error" id=""></span>
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


<div class="modal fade" id="editProgrss" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true"
data-bs-backdrop="static" data-bs-keyboard="false">
<div class="modal-dialog modal-dialog-centered modal-lg">
    <div class="modal-content">
        <div class="modal-header">
            <h1 class="modal-title fs-5" id="exampleModalLabel">Add Schedule</h1>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body" id="mdProgrss">
            
        </div>
    </div>
</div>
</div>


{{-- New Order --}}
<div class="modal fade" id="newOrderModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true"
data-bs-backdrop="static" data-bs-keyboard="false">
<div class="modal-dialog modal-dialog-centered modal-lg">
    <div class="modal-content">
        <div class="modal-header">
            <h1 class="modal-title fs-5" id="exampleModalLabel">Add New Order</h1>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
            <form action="javascript:void(0)" id="frmNewNote">
                <input type="hidden" value="{{ $id }}" name="patient_id" id="">
                <div class="row mb-5">
                    <div class="col-md-6 fv-row">
                        <label class="fs-5 fw-semibold mb-2">Order Type</label>
                        <select name="order_type" id="" class="form-select" data-control="select2">
                            @foreach (Order_type::all() as $item)
                                <option value="{{ $item->id }}">{{ $item->description }}</option>
                            @endforeach</option>
                        </select>
                        <span class=" alert-danger order_type-error" id=""></span>
                    </div>
                    <div class="col-md-6 fv-row">
                        <label class="fs-5 fw-semibold mb-2">New Order</label>
                        <textarea name="new_order" id="" class=" form-control form-control-solid"></textarea>
                        <span class=" alert-danger new_order-error" id=""></span>
                    </div>
                </div>
                <div class="row mb-5">
                    <div class="col-md-6 fv-row">
                        <label class="fs-5 fw-semibold mb-2">Start Date</label>
                        <input type="date" name="start_date" value=""
                            class=" form-control form-control-solid kt_datepicker" id=""
                            placeholder="mm-dd-yyyy">
                            <span class=" alert-danger start_date-error" id=""></span>
                    </div>
                    <div class="col-md-6 fv-row">
                        <label class="fs-5 fw-semibold mb-2">End Date</label>
                        <input type="date" name="end_date" value=""
                            class=" form-control form-control-solid kt_datepicker" id=""
                            placeholder="mm-dd-yyyy">
                            <span class=" alert-danger end_date-error" id=""></span>
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


<div class="modal fade" id="editNote" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true"
data-bs-backdrop="static" data-bs-keyboard="false">
<div class="modal-dialog modal-dialog-centered modal-lg">
    <div class="modal-content">
        <div class="modal-header">
            <h1 class="modal-title fs-5" id="exampleModalLabel">Edit New Order</h1>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body" id="mdNote">
            
        </div>
    </div>
</div>
</div>




@endsection
@section('scripts')
<script src="{{ asset('assets/js/self/edit_schedule.js') . env('VERSION') }}"></script>
<script>
    $('#navSchedules').addClass('active')
</script>
@endsection
