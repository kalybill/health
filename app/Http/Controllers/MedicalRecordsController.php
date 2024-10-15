<?php

namespace App\Http\Controllers;

use App\Models\Nurse;
use App\Models\Clients;
use App\Models\Referral;
use App\Models\Scheduling;
use App\Models\Visit_type;
use Illuminate\Http\Request;
use App\Models\Medical_record;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class MedicalRecordsController extends Controller
{
    public function notes()
    {
        $sched = Scheduling::all();
        return view('medrecords.notes', compact('sched'));
    }


    public function untransferred_visit()
    {
        $sched = Scheduling::all();
        return view('medrecords.untransferred_visit');
    }

    public function untransferred_visit_no_process_date()
    {
        $sched = Scheduling::all();
        return view('medrecords.untransferred_visit_no_process_date');
    }


    public function dt_notes(Request $req)
    {
        $sched = Scheduling::where('billed', '=', null)->get();

        $data = [];

        foreach ($sched as $val) {
            $data[] = [
                'name' => Referral::where('id', $val->patient_id)->first() != null ? Referral::where('id', $val->patient_id)->first()->name : '',
                'date' => convert_date_from_db($val->visit_date),
                'visit_type' => Visit_type::find($val->visit_type)->description,
                'nurse' => Nurse::find($val->nurse_id)->name,
                'client' => Clients::find($val->client)->cname, //Clients::find($val->client)
                'id' => $val->id,
            ];
        }

        return response()->json([
            'data' => $data,
            'draw' => intval($req->input('draw'))
        ]);
    }

    public function dt_untransfeered(Request $req)
    {
        $sched = Medical_record::where('send_to_bill', '=', null)->where('date_process', '!=', null)->get();

        $data = [];

        foreach ($sched as $val) {
            $data[] = [
                'name' => Referral::where('id', $val->patient_id)->first()->name,
                'date' => convert_date_from_db($val->visit_date),
                'visit_type' => Visit_type::find($val->visit_type)->description,
                'nurse' => Nurse::find($val->nurse_id)->name,
                'client' => Clients::find($val->client)->cname, //Clients::find($val->client)
                'id' => $val->scheduling_id,
            ];
        }

        return response()->json([
            'data' => $data,
            'draw' => intval($req->input('draw'))
        ]);
    }

    public function dt_untransfeered_no_date(Request $req)
    {
        $sched = Medical_record::where('send_to_bill', '=', null)->where('date_process', '=', null)->get();

        $data = [];

        foreach ($sched as $val) {
            $data[] = [
                'name' => Referral::where('id', $val->patient_id)->first()->name,
                'date' => convert_date_from_db($val->visit_date),
                'visit_type' => Visit_type::find($val->visit_type)->description,
                'nurse' => Nurse::find($val->nurse_id)->name,
                'client' => Clients::find($val->client)->cname,
                'id' => $val->scheduling_id,
            ];
        }

        return response()->json([
            'data' => $data,
            'draw' => intval($req->input('draw'))
        ]);
    }


    public function get_md_records(Request $req)
    {
        $md_records = Medical_record::where('scheduling_id', $req->id)->first();

        $sch  = Scheduling::find($req->id);


        // if ($md_records == null) {
            $html = '<script>
            $(".kt_datepicker").flatpickr({
                dateFormat: "m-d-Y",
            });
    
            $(".kt_timepicker").flatpickr({
                enableTime: true,
        noCalendar: true,
        dateFormat: "H:i",
            });
            
            </script>';

            $html .= '<form action="javascript:void(0)" id="frmSaveMdRecord" data-parsley-validate>
            <input type="hidden" class=" form-control form-control-solid" name="id" id="" value="' . $req->id . '" readonly>
            <div class="row">
            <div class="col-md-4">
                <label for="">Patient Name</label>
                <input type="text" value="' . Referral::find($sch->patient_id)->name . '" class=" form-control form-control-solid" name="patient_name" id="" readonly>
            </div>
            <div class="col-md-4">
                <label for="">Date</label>
                <input type="text" class=" form-control form-control-solid" name="" id=""  value="' . convert_date_from_db($sch->visit_date) . '" readonly>
            </div>
            <div class="col-md-4">
                <label for="">Visit Type</label>
                <input type="text" class=" form-control form-control-solid" name="" value="' . Visit_type::find($sch->visit_type)->description . '" id="" readonly>
            </div>
        </div>
        <div class="row mt-8">
            <div class="col-md-4">
                <label for="">Nurse</label>
                <input type="text" class=" form-control form-control-solid" name="" id="" value="' . Nurse::find($sch->nurse_id)->name . '" readonly>
            </div>
            <div class="col-md-4">
                <label for="">Client</label>
                <input type="text" class=" form-control form-control-solid" name="" id="" readonly value="' . Clients::find($sch->client)->cname . '">
            </div>
            <div class="col-md-4">
                <label for="">Mileage</label>
                <input type="text" class=" form-control form-control-solid" name="mileage" id="" value="' . ($md_records != null ? $md_records->mileage : '') . '">
            </div>
        </div>
        <div class="row mt-8">
            <div class="col-md-3">
                <label for="">Time In</label>
                <input type="text" class=" form-control form-control-solid kt_timepicker" value="' . ($md_records != null ? $md_records->time_in : '') . '" name="time_in" id="time_in" readonly>
                <span class=" alert-danger time_in-error" id=""></span>
            </div>
            <div class="col-md-3">
                <label for="">Time Out</label>
                <input type="text" class=" form-control form-control-solid kt_timepicker" name="time_out" value="' . ($md_records != null ? $md_records->time_out : '') . '" id="time_out" readonly >
                <span class=" alert-danger time_out-error" id=""></span>
            </div>
            <div class="col-md-3">
                <label for="">Total Time</label>
                <input type="text" class=" form-control form-control-solid kt_timepicker" name="total_time" value="' . ($md_records != null ? $md_records->total_time : '') . '" id="total_time" readonly >
                <span class=" alert-danger total_time-error" id=""></span>
            </div>
            <div class="col-md-3">
                <label for="">Date Process</label>
                <input type="text" class="form-control form-control-solid" name="date_process" value="' . ($md_records != null ? convert_date_from_db($md_records->date_process) : '') . '" id="" readonly>
                <span class=" alert-danger date_process-error" id=""></span>
            </div>
        </div>
        <div class="row mt-8">
            <div class="col-md-3">
                <label for="">Spec Rate</label>
                <input type="text" class="form-control form-control-solid" value="' . ($md_records != null ? $md_records->spec_rate : '') . '" name="spec_rate" id="" readonly>
                <span class=" alert-danger spec_rate-error" id=""></span>
            </div>
            <div class="col-md-3">
                <label for="">Missing Items On Notes</label>
                <textarea name="missing_item" id="" class=" readonly form-control form-control-solid">' . ($md_records != null ? $md_records->missing_item : '') . '</textarea>
                <span class=" alert-danger missing_item-error" id=""></span>
            </div>
            <div class="col-md-3">
                <label for="">Scheduling Remark</label>
                <textarea name="remarks" id="" class="form-control form-control-solid" readonly>' . ($md_records != null ? $md_records->remarks : '') . '</textarea>
                <span class=" alert-danger remarks-error" id=""></span>
            </div>
        </div>
        <div class="row mt-8">
            <div class="col-md-3">
                <div class="form-check form-check-custom form-check-solid">';
            if ($md_records) {
                $html .= '<input name="route_sheet" disabled id="flexCheckDisabled" class="form-check-input" type="checkbox" value="1" id="" checked readonly/>';
            } else {
                $html .= '<input name="route_sheet" disabled id="flexCheckDisabled" class="form-check-input" type="checkbox" value="1" id="" readonly/>';
            }
            $html .= '<label class="form-check-label" for="">
                        Route Sheet
                    </label>
                </div>
            </div>
            <div class="col-md-3">
                <div class="form-check form-check-custom form-check-solid">';
            if ($md_records) {
                $html .= '<input name="note"  id="flexCheckDisabled" class="form-check-input" type="checkbox" value="1" id="" readonly checked/>';
            } else {
                $html .= '<input name="note"  id="flexCheckDisabled" class="form-check-input" type="checkbox" readonly value="1" id=""/>';
            }
            $html .= '<label class="form-check-label" for="flexCheckDefault">
                        Note
                    </label>
                </div>
            </div>
        </div>
        <div class="row mt-8 ">
        <div class="col-md-12">
        <h5 class="mb-8 text-center">Billing</h5>
        </div>
      <div class="col-md-6">
      <div class="form-check form-check-custom form-check-solid">';
            if ($md_records) {
                $html .= '<input name="billed"  id="" class="form-check-input" type="checkbox" value="1" checked/>';
            } else {
                $html .= '<input name="billed" id="" class="form-check-input" type="checkbox" value="1" />';
            }
            $html .= '<label class="form-check-label" for="">
              Billed
          </label>
      </div>
  </div>
  <div class="col-md-6">
    <div class="form-check form-check-custom form-check-solid">';
            if ($md_records) {
                $html .= '<input name="paid"  id="" class="form-check-input" type="checkbox" value="1" id="" checked/>';
            } else {
                $html .= '<input name="paid"  id="" class="form-check-input" type="checkbox" value="1" id="" />';
            }

            $html .= '<label class="form-check-label" for="flexCheckDefault">
            Paid
        </label>
    </div>
</div>
        <div class="row mt-8">
          <div class="col-md-4">
              <label class="form-check-label" for="">Bill Rate</label>
              <input type="text" class="form-control form-control-solid" value="' . ($md_records != null ? $md_records->bill_rate : '') . '"
                name="bill_rate" id=""/>
              <span class="alert-danger bill_rate-error" id=""></span>
      </div>
      <div class="col-md-4">
              <label class="form-check-label" for="">Bill Date</label>
              <input
                type="text"
                class="form-control form-control-solid kt_datepicker"
                value="' . ($md_records != null ? convert_date_from_db($md_records->bill_date) : '') . '"
                name="bill_date"
                id=""
              />
              <span class="alert-danger bill_date-error" id=""></span>
            </div>
            <div class="col-md-4">
              <label class="form-check-label" for="">Date Paid</label>
              <input
                type="text"
                class="form-control form-control-solid kt_datepicker"
                value="' . ($md_records != null ? convert_date_from_db($md_records->pay_date) : '') . '"
                name="pay_date"
                id=""
              />
              <span class="alert-danger pay_date-error" id=""></span>
            </div>
          
      </div>
      <div class="row mt-8">
  <div class="col-md-12">
  <h5 class="text-center">Pay Period</h5>
  </div>
  <div class="col-md-6">
          <label class="form-check-label" for="">Start</label>
          <input
            type="text"
            class="form-control form-control-solid kt_datepicker"
            value="' . ($md_records != null ? convert_date_from_db($md_records->pay_period_1) : '') . '"
            name="pay_period_1"
            id=""
          />
          <span class="alert-danger pay_date-error" id=""></span>
        </div>
        <div class="col-md-6">
          <label class="form-check-label" for="">End</label>
          <input
            type="text"
            class="form-control form-control-solid kt_datepicker"
            value="' . ($md_records != null ? convert_date_from_db($md_records->pay_period_2) : '') . '"
            name="pay_period_2"
            id=""
          />
          <span class="alert-danger pay_date-error" id=""></span>
        </div>
  </div>
      <div class="row mt-8">
        <div class="col-md-6">
        <label>Remarks</label>
        <textarea name="billing_remarks" id="" class="form-control form-control-solid">' . ($md_records != null ? $md_records->billing_remarks : '') . '</textarea>
        </div>
      </div>
      </div>
      <div class="modal-footer mt-8">
      <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
      <button type="submit" class="btn btn-primary" id="kt_sign_in_submit">
                            <span class="indicator-label">Save</span>
                            <span class="indicator-progress">Please wait...
                                <span class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
                        </button>
      <div class="form-check form-check-custom form-check-solid">
    </div>
    </div>
      </form>';

            return response()->json($html);
        // }
    }


    public function save_record(Request $req)
    {
        $rules = [
            'patient_name' => 'required',
            'total_time' => 'required',
            'time_in' => 'required',
            'time_out' => 'required',
        ];

        $validator = Validator::make($req->all(), $rules);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()]);
        }

        $scheduling_id = Medical_record::where('scheduling_id', $req->id)->first();

        try {
            if ($scheduling_id == null) {
                DB::beginTransaction();
                $med_recd = new Medical_record();
                $sch = Scheduling::find($req->id);
                $med_recd->scheduling_id = $req->id;
                $med_recd->time_in = $req->time_in;
                $med_recd->time_out = $req->time_out;
                $med_recd->total_time = $req->total_time;
                $med_recd->date_process = convert_date_to_db($req->date_process);
                $med_recd->spec_rate = $req->spec_rate;
                $med_recd->route_sheet = $req->route_sheet;
                $med_recd->note = $req->note;
                $med_recd->mileage = $req->mileage;
                $med_recd->missing_item = $req->missing_item;
                $med_recd->remarks = $req->remarks;
                $med_recd->send_to_bill = $req->send_to_bill;
                $med_recd->patient_id = $sch->patient_id;
                $med_recd->visit_type = $sch->visit_type;
                $med_recd->nurse_id = $sch->nurse_id;
                $med_recd->client = $sch->client;
                $sch->billed = $req->send_to_bill;

                $med_recd->save();
                $sch->update();

                DB::commit();

                return response()->json(['success' => "Updated Successfully"]);
            } elseif ($scheduling_id != null) {
                DB::beginTransaction();
                $med_recd = Medical_record::where('scheduling_id', $req->id)->first();
                
                $sch = Scheduling::find($req->id);
                $med_recd->scheduling_id = $req->id;
                $med_recd->time_in = $req->time_in;
                $med_recd->time_out = $req->time_out;
                $med_recd->total_time = $req->total_time;
                $med_recd->date_process = convert_date_to_db($req->date_process);
                $med_recd->spec_rate = $req->spec_rate;
                $med_recd->route_sheet = $req->route_sheet;
                $med_recd->note = $req->note;
                $med_recd->mileage = $req->mileage;
                $med_recd->missing_item = $req->missing_item;
                $med_recd->remarks = $req->remarks;
                $med_recd->send_to_bill = $req->send_to_bill;
                $med_recd->patient_id = $sch->patient_id;
                $med_recd->visit_type = $sch->visit_type;
                $med_recd->nurse_id = $sch->nurse_id;
                $med_recd->client = $sch->client;
                $sch->billed = $req->send_to_bill;


                //Billing
                $med_recd->bill_rate = $req->bill_rate;
                $med_recd->bill_date = convert_date_to_db($req->bill_date);
                $med_recd->pay_date = convert_date_to_db($req->pay_date);
                $med_recd->pay_period_1 = convert_date_to_db($req->pay_period_1);
                $med_recd->pay_period_2 = convert_date_to_db($req->pay_period_2);
                $med_recd->billed = $req->billed;
                $med_recd->paid = $req->paid;
                $med_recd->billing_remarks = $req->billing_remarks;

                $med_recd->update();
                $sch->update();

                DB::commit();
                return response()->json(['success' => "Updated Successfully"]);
            }
        } catch (\Exception $ex) {
            DB::rollBack();
            Log::channel('custom')->error($ex->getMessage());
            return response()->json(['logginError' => "Error Occured. Contact System Admin"]);
        }
    }


    public function billing()
    {

        return view('medrecords.billing');
    }

    public function dt_billing(Request $req)
    {
        $md_rec = Medical_record::where('send_to_bill', 1)->get();

        $data = [];

        foreach ($md_rec as $val) {
            $data[] = [
                'pay_period_1' => convert_date_from_db($val->pay_period_1),
                'pay_period_2' => convert_date_from_db($val->pay_period_2),
                'name' => Referral::where('id', $val->patient_id)->first()->name,
                'visit_type' => Visit_type::find($val->visit_type)->description,
                'nurse' => Nurse::find($val->nurse_id)->name,
                'client' => Clients::find($val->client)->cname,
                'date_process' => $val->date_process,
                'id' => $val->scheduling_id,
            ];
        }

        return response()->json([
            'data' => $data,
            'draw' => intval($req->input('draw'))
        ]);
    }


    public function get_md_billings(Request $req)
    {
        $md_records = Medical_record::where('scheduling_id', $req->id)->first();

        $sch  = Scheduling::find($req->id);

        $html = '<script>
            $(".kt_datepicker").flatpickr({
                dateFormat: "m-d-Y",
            allowInput: true,
            });
    
            $(".kt_timepicker").flatpickr({
                enableTime: true,
        noCalendar: true,
        dateFormat: "H:i",
        allowInput: true
            });
            
           
            </script>';

        $html .= '<form action="javascript:void(0)" id="frmBilling" data-parsley-validate>
            <input type="hidden" class=" form-control form-control-solid" name="id" id="" value="' . $md_records->scheduling_id . '" readonly>
            <div class="row">
            <div class="col-md-4">
                <label for="">Patient Name</label>
                <input type="text" value="' . Referral::find($sch->patient_id)->name . '" class=" form-control form-control-solid" name="patient_name" id="" readonly>
            </div>
            <div class="col-md-4">
                <label for="">Date</label>
                <input type="text" class=" form-control form-control-solid" name="" id=""  value="' . convert_date_from_db($sch->visit_date) . '" readonly>
            </div>
            <div class="col-md-4">
                <label for="">Visit Type</label>
                <input type="text" class=" form-control form-control-solid" name="" value="' . Visit_type::find($sch->visit_type)->description . '" id="" readonly>
            </div>
        </div>
        <div class="row mt-8">
            <div class="col-md-4">
                <label for="">Nurse</label>
                <input type="text" class=" form-control form-control-solid" name="" id="" value="' . Nurse::find($sch->nurse_id)->name . '" readonly>
            </div>
            <div class="col-md-4">
                <label for="">Client</label>
                <input type="text" class=" form-control form-control-solid" name="" id="" readonly value="' . $sch->client . '">
            </div>
            <div class="col-md-4">
                <label for="">Mileage</label>
                <input type="text" class=" form-control form-control-solid" name="mileage" id="" value="' . $md_records->mileage . '">
            </div>
        </div>
        <div class="row mt-8">
            <div class="col-md-3">
                <label for="">Time In</label>
                <input type="text" class=" form-control form-control-solid kt_timepicker" value="' . $md_records->time_in . '" name="time_in" id="time_in" readonly>
                <span class=" alert-danger time_in-error" id=""></span>
            </div>
            <div class="col-md-3">
                <label for="">Time Out</label>
                <input type="text" class=" form-control form-control-solid kt_timepicker" name="time_out" value="' . $md_records->time_out . '" id="time_out" readonly >
                <span class=" alert-danger time_out-error" id=""></span>
            </div>
            <div class="col-md-3">
                <label for="">Total Time</label>
                <input type="text" class=" form-control form-control-solid kt_timepicker" name="total_time" value="' . $md_records->total_time . '" id="total_time" readonly >
                <span class=" alert-danger total_time-error" id=""></span>
            </div>
            <div class="col-md-3">
                <label for="">Date Process</label>
                <input type="text" class="form-control form-control-solid" name="date_process" value="' . convert_date_from_db($md_records->date_process) . '" id="" readonly>
                <span class=" alert-danger date_process-error" id=""></span>
            </div>
        </div>
        <div class="row mt-8">
            <div class="col-md-3">
                <label for="">Spec Rate</label>
                <input type="text" class="form-control form-control-solid" value="' . $md_records->spec_rate . '" name="spec_rate" id="" readonly>
                <span class=" alert-danger spec_rate-error" id=""></span>
            </div>
            <div class="col-md-3">
                <label for="">Missing Items On Notes</label>
                <textarea name="missing_item" id="" class=" readonly form-control form-control-solid">' . $md_records->missing_item . '</textarea>
                <span class=" alert-danger missing_item-error" id=""></span>
            </div>
            <div class="col-md-3">
                <label for="">Scheduling Remark</label>
                <textarea name="remarks" id="" class="form-control form-control-solid" readonly>' . $md_records->remarks . '</textarea>
                <span class=" alert-danger remarks-error" id=""></span>
            </div>
        </div>
        <div class="row mt-8">
            <div class="col-md-3">
                <div class="form-check form-check-custom form-check-solid">';
        if ($md_records->route_sheet == 1) {
            $html .= '<input name="route_sheet" disabled id="flexCheckDisabled" class="form-check-input" type="checkbox" value="1" id="" checked readonly/>';
        } else {
            $html .= '<input name="route_sheet" disabled id="flexCheckDisabled" class="form-check-input" type="checkbox" value="1" id="" readonly/>';
        }
        $html .= '<label class="form-check-label" for="">
                        Route Sheet
                    </label>
                </div>
            </div>
            <div class="col-md-3">
                <div class="form-check form-check-custom form-check-solid">';
        if ($md_records->note == 1) {
            $html .= '<input name="note"  id="flexCheckDisabled" class="form-check-input" type="checkbox" value="1" id="" readonly checked/>';
        } else {
            $html .= '<input name="note"  id="flexCheckDisabled" class="form-check-input" type="checkbox" readonly value="1" id=""/>';
        }
        $html .= '<label class="form-check-label" for="flexCheckDefault">
                        Note
                    </label>
                </div>
            </div>
        </div>
        <div class="row mt-8 ">
        <div class="col-md-12">
        <h5 class="mb-8 text-center">Billing</h5>
        </div>
      <div class="col-md-6">
      <div class="form-check form-check-custom form-check-solid">';
        if ($md_records->billed == 1) {
            $html .= '<input name="billed"  id="" class="form-check-input" type="checkbox" value="1" id="" checked/>';
        } else {
            $html .= '<input name="billed" id="" class="form-check-input" type="checkbox" value="1" id=""/>';
        }
        $html .= '<label class="form-check-label" for="">
              Billed
          </label>
      </div>
  </div>
  <div class="col-md-6">
    <div class="form-check form-check-custom form-check-solid">';
        if ($md_records->paid == 1) {
            $html .= '<input name="paid"  id="" class="form-check-input" type="checkbox" value="1" id="" checked/>';
        } else {
            $html .= '<input name="paid"  id="" class="form-check-input" type="checkbox" value="1" id="" />';
        }

        $html .= '<label class="form-check-label" for="flexCheckDefault">
            Paid
        </label>
    </div>
</div>
        <div class="row mt-8">
          <div class="col-md-4">
              <label class="form-check-label" for="">Bill Rate</label>
              <input type="text" class="form-control form-control-solid" value="' . $md_records->bill_rate . '"
                name="bill_rate" id=""/>
              <span class="alert-danger bill_rate-error" id=""></span>
      </div>
      <div class="col-md-4">
              <label class="form-check-label" for="">Bill Date</label>
              <input
                type="text"
                class="form-control form-control-solid kt_datepicker"
                value="' . convert_date_from_db($md_records->bill_date) . '"
                name="bill_date"
                id=""
              />
              <span class="alert-danger bill_date-error" id=""></span>
            </div>
            <div class="col-md-4">
              <label class="form-check-label" for="">Date Paid</label>
              <input
                type="text"
                class="form-control form-control-solid kt_datepicker"
                value="' . convert_date_from_db($md_records->pay_date) . '"
                name="pay_date"
                id=""
              />
              <span class="alert-danger pay_date-error" id=""></span>
            </div>
          
      </div>
      <div class="row mt-8">
  <div class="col-md-12">
  <h5 class="text-center">Pay Period</h5>
  </div>
  <div class="col-md-6">
          <label class="form-check-label" for="">Start</label>
          <input
            type="text"
            class="form-control form-control-solid kt_datepicker"
            value="' . convert_date_from_db($md_records->pay_period_1) . '"
            name="pay_period_1"
            id=""
          />
          <span class="alert-danger pay_date-error" id=""></span>
        </div>
        <div class="col-md-6">
          <label class="form-check-label" for="">End</label>
          <input
            type="text"
            class="form-control form-control-solid kt_datepicker"
            value="' . convert_date_from_db($md_records->pay_period_2) . '"
            name="pay_period_2"
            id=""
          />
          <span class="alert-danger pay_date-error" id=""></span>
        </div>
  </div>
      <div class="row mt-8">
        <div class="col-md-6">
        <label>Remarks</label>
        <textarea name="billing_remarks" id="" class="form-control form-control-solid">' . $md_records->billing_remarks . '</textarea>
        </div>
      </div>
      </div>
      <div class="modal-footer mt-8">
      <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
      <button type="submit" class="btn btn-primary sendToBill">Save</button>
      <div class="form-check form-check-custom form-check-solid">
    </div>
    </div>
      </form>';

        return response()->json($html);
    }



    public function save_billing(Request $req)
    {
        $rules = [
            'bill_rate' => 'required',
        ];

        $validator = Validator::make($req->all(), $rules);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()]);
        }

        try {
            $md_rec = Medical_record::where('scheduling_id', $req->id)->first();
            $md_rec->bill_rate = $req->bill_rate;
            $md_rec->bill_date = convert_date_to_db($req->bill_date);
            $md_rec->pay_date = convert_date_to_db($req->pay_date);
            $md_rec->pay_period_1 = convert_date_to_db($req->pay_period_1);
            $md_rec->pay_period_2 = convert_date_to_db($req->pay_period_2);
            $md_rec->billed = $req->billed;
            $md_rec->paid = $req->paid;
            $md_rec->billing_remarks = $req->billing_remarks;

            $md_rec->update();
            return response()->json(['success' => "Updated Successfully"]);
        } catch (\Exception $ex) {
            Log::channel('custom')->error($ex->getMessage());
            return response()->json(['logginError' => "Error Occured. Contact System Admin"]);
        }
    }
}
