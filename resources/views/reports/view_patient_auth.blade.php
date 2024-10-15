@php
    use App\Models\{Referral,Client_contact,Clients};
@endphp
@extends('layouts.app')

@section('page_header')
    <h1 class="page-heading d-flex text-dark fw-bold fs-3 flex-column justify-content-center my-0">
        Patient Authorization
    </h1>
@endsection
@section('body')
<div class="card">
    <div class="card-body">
        <div class=" table-responsive">
            <div class="row">
                <div class="col-md-6">
                    <h4>Authorization</h4>
                    <h3 class=" alert alert-success">{{ $auth }}</h3>
                </div>
                <div class="col-md-6">
                    <h4>Visit Counts</h4>
                    @if ($auth < $number_of_visit)
                    <h3 class=" alert alert-danger">{{ $number_of_visit  }}</h3>
                    @else
                    <h3 class=" alert alert-info">{{ $number_of_visit  }}</h3>
                    @endif
                    
                </div>
            </div>
            <table class=" table table-row-dashed table-row-gray-300 gy-7" id="myDatatable">
                <thead>
                    <tr class="fw-semibold fs-6 text-muted">
                        <th>Pt Name</th>
                        <th>DOB</th>
                        <th>Visit Date</th>
                        <th>Company</th>
                        <th>Coordinator</th>
                        <th>Md Orders</th>
                        <th>SOC Date</th>
                        <th>End Date</th>
                    </tr>
                </thead>
                <tbody>
                    
                    @foreach ($sch as $item)
                    @php
                        $patient = Referral::find($item->patient_id);
                        $client = Clients::find($item->client);
                        $client_contact = Client_contact::find($patient->ref_source_staff);
                    @endphp
                        <tr>
                            <td>{{ $patient->name }}</td>
                            <td>{{ $patient->dob }}</td>
                            <td>{{ $item->visit_date }}</td>
                            <td>{{ $client->cname }}</td>
                            <td>{{$client_contact->contact_person }}</td>
                            <td><div class="row">
                                <div class="col-md-4">{{ $patient->md_order_1 }}</div>
                                <div class="col-md-4">{{ $patient->md_order_2}}</div>
                                <div class="col-md-4">{{ $patient->md_order_3 }}</div>
                                </div>
                            </td>
                            <td>{{ $item->soc_date }}</td>
                            <td></td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

@endsection
@section('scripts')
<script>
    $('.subNavPatientRPT').addClass('hover show');
    $('#navAuthRPT').addClass('active')
</script>
@endsection