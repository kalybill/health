<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    public function index()
    {

        return view('user.index');
    }

    public function save_user(Request $req)
    {
        $rules = [
            'name' => 'required',
        ];

        $validator = Validator::make($req->all(), $rules);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()]);
        }

        $user = new User();

        try {
            $user->name = $req->name;
            $user->email = $req->email;
            $user->role = $req->role;
            $user->password = Hash::make($req->password);

            $user->save();

            return response()->json(['success' => "Added Successfully"]);
        } catch (\Exception $ex) {
            Log::channel('custom')->error($ex->getMessage());
            return response()->json(['logginError' => "Error Occured. Contact System Admin"]);
        }
    }


    public function dt_user(Request $req)
    {
        $user = User::all();

        $data = [];

        foreach ($user as $val) {
            $data[] = [
                'name' => $val->name,
                'email' => $val->email,
                'role' => $val->role == 1 ? "Admin" : "Front Desk",
                'id' => $val->id,
            ];
        }

        return response()->json([
            'data' => $data,
            'draw' => intval($req->input('draw'))
        ]);
    }


    public function edit_user(Request $req)
    {
        $data = User::find($req->id);
        $role = $data->role == 1 ? "Admin" : "Front Desk";

        $html = '<form action="javascript:void(0)" data-parsley-validate id="frmUptAccessType">
        <input type="hidden" value="' . $data->id . '" name="id" required>
        <div class="row">
         <div class="col-md-6">
             <label for="">Name</label>
             <input type="text" class=" form-control" value="' . $data->name . '" name="name" id="" required>
             <span class=" alert-danger name-error" id=""></span>
         </div>
         <div class="col-md-6">
         <label for="">Email</label>
         <input type="text" class=" form-control" value="' . $data->email . '" name="email" id="" required>
         <span class=" alert-danger email-error" id=""></span>
     </div>
     <div class="row mt-7">
     <div class="col-md-6">
     <label for="">Password</label>
     <input type="password" class=" form-control"  name="password" id="">
     <span class=" alert-danger password-error" id=""></span>
     </div>
     <div class="col-md-6">
                    <label for="">Access Type</label>
                   <select class=" form-control" name="role" id="" required>
                    <option value="' . $data->role . '">' . $role . '</option>
                    <option value="1">Admin</option>
                    <option value="2">Front Desk</option>
                   </select>
                    <span class=" alert-danger password-error" id=""></span>
                </div>
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
            'name' => 'required',
        ];

        $validator = Validator::make($req->all(), $rules);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()]);
        }

        $data = User::find($req->id);

        try {
            $data->name = $req->name;
            $data->email = $req->email;
            $data->role = $req->role;

            if ($req->password != null) {
                $data->password = Hash::make($req->password);
            }


            $data->update();

            return response()->json(['success' => "Updated Successfully"]);
        } catch (\Exception $ex) {
            Log::channel('custom')->error($ex->getMessage());
            return response()->json(['logginError' => "Error Occured. Contact System Admin"]);
        }
    }


    public function find_single_item(Request $req)
    {
        $data = User::find($req->id);

        return response()->json($data);
    }

    public function delete(Request $req)
    {
        $delete = User::find($req->id);

        $delete->delete();

        return response()->json(['msg' => 'Deleted Successfully']);
    }

    public function edit_profile()
    {

        return view('user.edit_profile');
    }

    public function save_profile(Request $req)
    {
        $rules = [
            'password' => 'required',
        ];

        $validator = Validator::make($req->all(), $rules);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()]);
        }

        $data = User::find(Auth::user()->id);

        try {
            $data->password = Hash::make($req->password);

            $data->update();

            return response()->json(['success' => "Updated Successfully"]);
        } catch (\Exception $ex) {
            Log::channel('custom')->error($ex->getMessage());
            return response()->json(['logginError' => "Error Occured. Contact System Admin"]);
        }
    }
}
