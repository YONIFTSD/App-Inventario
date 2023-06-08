<?php

namespace App\Http\Controllers;

use App\Models\Client;
use App\Models\Correlative;
use App\Models\DailySettlementIncome;
use App\Models\Utility;
use Illuminate\Http\Request;


class ClientController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }


    public function ListAll($search){
        try{
            $result = Client::ListAll($search);
            return response()->json(['status' => 200,'result' => $result]);
        } catch (\Exception $e){
            return response()->json(['status' => 400,'message' => 'A ocurrido un error', 'result' => $e->getMessage()]);
        }
    }


    public function View($id_client){
        try{
            $obj = Client::GetById($id_client);
            return response()->json(['status' => 200,'result' => $obj]);
        } catch (\Exception $e){
            return response()->json(['status' => 400,'message' => 'A ocurrido un error', 'result' => $e->getMessage()]);
        }
    }

    public function ListActives(){
        try{
            $obj = Client::where('state',1)->get(['id_client','name', 'document_number']);
            return response()->json(['status' => 200,'result' => $obj]);
        } catch (\Exception $e){
            return response()->json(['status' => 400,'message' => 'A ocurrido un error', 'result' => $e->getMessage()]);
        }
    }

    public function SearchSelect(Request $request){
        try{
            $obj = Client::SearchSelect($request->search);
            $result = array();
            foreach ($obj as $be) {
                array_push($result,array(
                    'id' => $be->id_client,
                    'text' => $be->name.' - '.$be->document_number,
                ));
            }
            return $result;
        } catch (\Exception $e){
            return response()->json(['status' => 400,'message' => 'A ocurrido un error', 'result' => $e->getMessage()]);
        }
    }

    public function Store(Request $request){
        try{
            $this->validate($request, [
                'name' => 'required',
                'state' => 'required',
            ]);

            $obj = new Client();
            $obj->document_type = $request->document_type;
            $obj->document_number = $request->document_number;
            $obj->name = $request->name;
            $obj->email = $request->email;
            $obj->phone = $request->phone;
            $obj->state = $request->state;
            $obj->save();

            return response()->json(['status' => 201,'message'=>'Se ha registrado correctamente el cliente','result' => $obj]);
        } catch (\Exception $e){
            return response()->json(['status' => 400,'message' => 'A ocurrido un error', 'result' => $e->getMessage()]);
        }
    }

    public function Update(Request $request){
        try{
            $this->validate($request, [
                'id_client' => 'required',
                'name' => 'required',
                'state' => 'required',
            ]);

            $obj = Client::find($request->id_client);
            $obj->document_type = $request->document_type;
            $obj->document_number = $request->document_number;
            $obj->name = $request->name;
            $obj->email = $request->email;
            $obj->phone = $request->phone;
            $obj->state = $request->state;
            $obj->update();

            return response()->json(['status' => 200,'message'=>'Se ha modificado correctamente el cliente','result' => $obj]);
        } catch (\Exception $e){
            return response()->json(['status' => 400,'message' => 'A ocurrido un error', 'result' => $e->getMessage()]);
        }
    }


    public function Delete($id_client){
        try{

            $obj = Client::find($id_client);
            $obj->state = 9;
            $obj->update();
            return response()->json(['status' => 200,'message'=>'Se ha eliminado correctamente el client','result' => $obj]);
        } catch (\Exception $e){
            return response()->json(['status' => 400,'message' => 'A ocurrido un error', 'result' => $e->getMessage()]);
        }
    }


    public function GetIncomeBusiness(Request $request){
        try{
            set_time_limit(0);
            $income = Utility::GetUtilityBusiness($request->id_business,$request->year,$request->month);
            return response()->json(['status' => 200,'result' => $income]);
        } catch (\Exception $e){
            return response()->json(['status' => 400,'message' => 'A ocurrido un error', 'result' => $e->getMessage()]);
        }
    }



    //
}
