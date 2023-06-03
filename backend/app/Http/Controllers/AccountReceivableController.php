<?php

namespace App\Http\Controllers;

use App\Models\AccountReceivable;
use App\Models\Audit;
use App\Models\Client;
use App\Models\Utility;
use Illuminate\Http\Request;


class AccountReceivableController extends Controller
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


    public function ListAll($state,$search){
        try{
            $result = AccountReceivable::ListAll($state,$search);   
            return response()->json(['status' => 200,'result' => $result]);
        } catch (\Exception $e){  
            return response()->json(['status' => 400,'message' => 'A ocurrido un error', 'result' => $e->getMessage()]);
        }
    }


    public function View($id_account_receivable){
        try{
            $obj = AccountReceivable::GetById($id_account_receivable);
            return response()->json(['status' => 200,'result' => $obj]);
        } catch (\Exception $e){   
            return response()->json(['status' => 400,'message' => 'A ocurrido un error', 'result' => $e->getMessage()]);
        }
    }

    public function Store(Request $request){
        try{
            $this->validate($request, [
                'id_client' => 'required',
                'broadcast_date' => 'required',
                'expirate_date' => 'required',
                'coin' => 'required',
                'exchange_rate' => 'required',
                'total' => 'required',
                'state' => 'required',
            ]);


            $obj = new AccountReceivable();
            $obj->id_client = $request->id_client;
            $obj->id_user = $request->id_user;
            $obj->reference = $request->reference;
            $obj->observation = $request->observation;
            $obj->broadcast_date = $request->broadcast_date;
            $obj->expirate_date = $request->expirate_date;
            $obj->coin = $request->coin;
            $obj->exchange_rate = $request->exchange_rate;
            $obj->total = $request->total;
            $obj->total_paid = 0;
            $obj->balance = $request->total;
            $obj->state = $request->state;
            $obj->save();
            return response()->json(['status' => 201,'message'=>'Se ha registrado correctamente la cuenta por pagar','result' => $obj]);
        } catch (\Exception $e){   
            return response()->json(['status' => 400,'message' => 'A ocurrido un error', 'result' => $e->getMessage()]);
        }
    }

    public function Update(Request $request){
        try{
            $this->validate($request, [
                'id_client' => 'required',
                'broadcast_date' => 'required',
                'expirate_date' => 'required',
                'coin' => 'required',
                'exchange_rate' => 'required',
                'total' => 'required',
                'state' => 'required',
            ]);

            $obj = AccountReceivable::find($request->id_account_receivable);

            if ($obj->state != 1 || $obj->total_paid > 0) {
                return response()->json(['status' => 400,'message' => 'La cuenta por pagar ya cuenta con pagos registrados']);
            }
            $obj->id_client = $request->id_client;
            $obj->reference = $request->reference;
            $obj->observation = $request->observation;
            $obj->broadcast_date = $request->broadcast_date;
            $obj->expirate_date = $request->expirate_date;
            $obj->coin = $request->coin;
            $obj->exchange_rate = $request->exchange_rate;
            $obj->total = $request->total;
            $obj->total_paid = 0;
            $obj->balance = $request->total;
            // $obj->state = $request->state;
            $obj->update();

            return response()->json(['status' => 200,'message'=>'Se ha modificado correctamente el cliente','result' => $obj]);
        } catch (\Exception $e){   
            return response()->json(['status' => 400,'message' => 'A ocurrido un error', 'result' => $e->getMessage()]);
        }
    }


    public function Delete($id_account_receivable){
        try{
        
            $obj = AccountReceivable::find($id_account_receivable);
            $obj->state = 9;
            $obj->update();
            return response()->json(['status' => 200,'message'=>'Se ha eliminado correctamente la cuenta por pagar','result' => $obj]);
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
