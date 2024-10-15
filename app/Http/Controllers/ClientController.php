<?php

namespace App\Http\Controllers;

use GuzzleHttp\Client;
use App\Models\Clients;
use Illuminate\Http\Request;
use App\Models\Client_contact;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class ClientController extends Controller
{
    public function index(){

        return view('clients.index');
    }


    public function save_client(Request $req){
        $rules = [
            'cname' => 'required',
        ];

        $validator = Validator::make($req->all(), $rules);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()]);
        }

        try {
            $client = new Clients();
            $client->cname = $req->cname;
            $client->addr = $req->addr;
            $client->city = $req->city;
            $client->state = $req->state;
            $client->zip_code = $req->zip_code;
            $client->main_phone = $req->main_phone;
            $client->fax = $req->fax;
            $client->email = $req->email;
            $client->contact_person = $req->contact_person;
            $client->title = $req->title;
            $client->remarks = $req->remarks;

            $client->save();
            return response()->json(['success' => "Created Successfully"]);
        } catch (\Exception $ex) {
            Log::channel('custom')->error($ex->getMessage());
            return response()->json(['logginError' => "Error Occured. Contact System Admin"]);
        }
    }


    public function update_client(Request $req){
        $rules = [
            'cname' => 'required',
        ];

        $validator = Validator::make($req->all(), $rules);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()]);
        }

        try {
            $client = Clients::find($req->id);
            $client->cname = $req->cname;
            $client->addr = $req->addr;
            $client->city = $req->city;
            $client->state = $req->state;
            $client->zip_code = $req->zip_code;
            $client->main_phone = $req->main_phone;
            $client->fax = $req->fax;
            $client->email = $req->email;
            $client->contact_person = $req->contact_person;
            $client->title = $req->title;
            $client->remarks = $req->remarks;

            $client->update();
            return response()->json(['success' => "Created Successfully"]);
        } catch (\Exception $ex) {
            Log::channel('custom')->error($ex->getMessage());
            return response()->json(['logginError' => "Error Occured. Contact System Admin"]);
        }
    }


    public function dt_clients(Request $req){
        $clients = Clients::all();

        $data = [];

        foreach ($clients as $val){
            $data[] = [
                'cname' => $val->cname,
                'addr' => $val->addr,
                'city' => $val->city,
                'state' => $val->state,
                'zip_code' => $val->zip_code,
                'main_phone' => $val->main_phone,
                'fax' => $val->fax,
                'email' => $val->email,
                'contact_person' => $val->contact_person,
                'title' => $val->title,
                'remarks' => $val->remarks,
                'id' => $val->id,
            ];

        }

        return response()->json([
            'data' => $data,
            'draw' => intval($req->input('draw'))
        ]);
    }


    public function dt_clients_contact(Request $req, $id){
        
        $clients = Client_contact::where('client_id', $id)->get();

        $data = [];

        foreach ($clients as $val){
            $data[] = [
                'phone' => $val->phone,
                'email' => $val->email,
                'contact_person' => $val->contact_person,
                'work_phone' => $val->work_phone,
                'dob' => $val->dob,
                'title' => $val->title,
                'fax' => $val->fax,
                'id' => $val->id,
            ];

        }

        return response()->json([
            'data' => $data,
            'draw' => intval($req->input('draw'))
        ]);
    }

    public function edit_clients($id){
        $client = Clients::find($id);
        return view('clients.edit_clients',compact('client'));
    }


    public function save_contact_client(Request $req){
        $rules = [
            'client_id' => 'required',
        ];

        $validator = Validator::make($req->all(), $rules);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()]);
        }

        try {
            $client = new Client_contact();

            $client->client_id = $req->id;
            $client->phone = $req->phone;
            $client->email = $req->email;
            $client->contact_person = $req->contact_person;
            $client->work_phone = $req->work_phone;
            $client->dob = convert_date_to_db($req->dob);
            $client->title = $req->title;
            $client->fax = $req->fax;

            $client->save();
            return response()->json(['success' => "Created Successfully"]);
        } catch (\Exception $ex) {
            Log::channel('custom')->error($ex->getMessage());
            return response()->json(['logginError' => "Error Occured. Contact System Admin"]);
        }
    }
}
