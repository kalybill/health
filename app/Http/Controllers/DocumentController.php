<?php

namespace App\Http\Controllers;

use App\Models\Document;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class DocumentController extends Controller
{
    public function index()
    {

        return view('settings.document');
    }


    public function save_document(Request $req)
    {
        $rules = [
            'description' => 'required',
        ];

        $validator = Validator::make($req->all(), $rules);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()]);
        }

        $access_type = new Document();

        try {
            $access_type->description = $req->description;

            $access_type->save();

            return response()->json(['success' => "Added Successfully"]);
        } catch (\Exception $ex) {
            Log::channel('custom')->error($ex->getMessage());
            return response()->json(['logginError' => "Error Occured. Contact System Admin"]);
        }
    }


    public function dt_document(Request $req)
    {
        $access = Document::all();

        $data = [];

        foreach ($access as $val) {
            $data[] = [
                'description' => $val->description,
                'id' => $val->id,
            ];
        }

        return response()->json([
            'data' => $data,
            'draw' => intval($req->input('draw'))
        ]);
    }


    public function edit_document(Request $req)
    {
        $data = Document::find($req->id);

        $html = '<form action="javascript:void(0)" data-parsley-validate id="frmUptAccessType">
        <input type="hidden" value="' . $data->id . '" name="id" required>
        <div class="row">
         <div class="col-md-12">
             <label for="">Access Type</label>
             <input type="text" class=" form-control" value="' . $data->description . '" name="description" id="" required>
             <span class=" alert-danger description-error" id=""></span>
         </div>
        </div>
         <div class="modal-footer mt-3">
             <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
             <button type="submit" class="btn btn-primary" id="kt_sign_in_update">
                 <span class="indicator-label">Update</span>
                 <span class="indicator-progress">Please wait...
                     <span class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
             </button>
         </div>
     </form>';

        return response()->json($html);
    }

    public function save_update(Request $req)
    {
        $rules = [
            'description' => 'required',
        ];

        $validator = Validator::make($req->all(), $rules);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()]);
        }

        $data = Document::find($req->id);

        try {
            $data->description = $req->description;

            $data->update();

            return response()->json(['success' => "Updated Successfully"]);
        } catch (\Exception $ex) {
            Log::channel('custom')->error($ex->getMessage());
            return response()->json(['logginError' => "Error Occured. Contact System Admin"]);
        }
    }


    public function find_single_item(Request $req)
    {
        $data = Document::find($req->id);

        return response()->json($data);
    }

    public function delete(Request $req)
    {
        $delete = Document::find($req->id);

        $delete->delete();

        return response()->json(['msg' => 'Deleted Successfully']);
    }
}
