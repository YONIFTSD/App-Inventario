<?php

namespace App\Http\Controllers;

use App\Models\AccountReceivable;
use App\Models\AccountReceivablePayment;
use App\Models\Utility;
use Illuminate\Http\Request;


class AccountReceivablePaymentController extends Controller
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


    public function ListAll($id_account_receivable){
        try{
            $result = AccountReceivablePayment::ListAll($id_account_receivable);
            return response()->json(['status' => 200,'result' => $result]);
        } catch (\Exception $e){   
            return response()->json(['status' => 400,'message' => 'A ocurrido un error', 'result' => $e->getMessage()]);
        }
    }


    public function View($id_account_receivable_payment){
        try{
            $obj = AccountReceivablePayment::GetById($id_account_receivable_payment);
            return response()->json(['status' => 200,'result' => $obj]);
        } catch (\Exception $e){   
            return response()->json(['status' => 400,'message' => 'A ocurrido un error', 'result' => $e->getMessage()]);
        }
    }

    public function Store(Request $request){
        try{
            $this->validate($request, [
                'id_account_receivable' => 'required',
                'id_user' => 'required',
                'payment_method' => 'required',
                'payment_date' => 'required',
                'total' => 'required',
                'state' => 'required',
            ]);

            $account = AccountReceivable::find($request->id_account_receivable);
            if($account->state != 1){
                return response()->json(['status' => 400,'message' => 'Esta cuenta ya no puede registrar pagos']);
            }

            if ($request->total > $account->balance){ 
                return response()->json(['status' => 400,'message' => 'El total de la cuenta no puede ser mayor al saldo']);
            }

            $obj = new AccountReceivablePayment();
            $obj->id_account_receivable = $request->id_account_receivable;
            $obj->id_user = $request->id_user;
            $obj->reference = $request->reference;
            $obj->payment_method = $request->payment_method;
            $obj->payment_date = $request->payment_date;
            $obj->total = $request->total;
            $obj->state = $request->state;
            $obj->save();

            $account->total_paid = $account->total_paid + $request->total;
            $account->balance = $account->balance - $request->total;
            $account->state = $account->balance == 0 ? 2 : 1;
            $account->update();

            return response()->json(['status' => 201,'message'=>'Se ha registrado correctamente el pago','result' => $obj]);
        } catch (\Exception $e){   
            return response()->json(['status' => 400,'message' => 'A ocurrido un error', 'result' => $e->getMessage()]);
        }
    }

    public function Update(Request $request){
        try{
            $this->validate($request, [
                'id_account_receivable_payment' => 'required',
                'id_account_receivable' => 'required',
                'id_user' => 'required',
                'payment_method' => 'required',
                'payment_date' => 'required',
                'total' => 'required',
                'state' => 'required',
            ]);

            $obj = AccountReceivablePayment::find($request->id_account_receivable_payment);
            $obj_old = AccountReceivablePayment::find($request->id_account_receivable_payment);

            $account = AccountReceivable::find($obj->id_account_receivable);
            if($account->state == 9){
                return response()->json(['status' => 400,'message' => 'Esta cuenta ya no puede registrar pagos']);
            }

            $account->total_paid = $account->total_paid - $obj->total;
            $account->balance = $account->balance + $obj->total;
            $account->state = $account->balance == 0 ? 2 : 1;
            $account->update();



            if ($request->total > $account->balance){ 
                $account->total_paid = $account->total_paid + $obj_old->total;
                $account->balance = $account->balance - $obj_old->total;
                $account->state = $account->balance == 0 ? 2 : 1;
                $account->update();
                return response()->json(['status' => 400,'message' => 'El total de la cuenta no puede ser mayor al saldo']);
            }

            $obj->id_user = $request->id_user;
            $obj->reference = $request->reference;
            $obj->payment_method = $request->payment_method;
            $obj->payment_date = $request->payment_date;
            $obj->total = $request->total;
            $obj->update();

            $account->total_paid = $account->total_paid + $request->total;
            $account->balance = $account->balance - $request->total;
            $account->state = $account->balance == 0 ? 2 : 1;
            $account->update();

            return response()->json(['status' => 200,'message'=>'Se ha modificado correctamente el pago','result' => $obj]);
        } catch (\Exception $e){   
            return response()->json(['status' => 400,'message' => 'A ocurrido un error', 'result' => $e->getMessage()]);
        }
    }


    public function Delete($id_account_receivable_payment){
        try{
        
            $obj = AccountReceivablePayment::find($id_account_receivable_payment);
            $obj->state = 9;
            $obj->update();


            $account = AccountReceivable::find($obj->id_account_receivable);
            $account->total_paid = $account->total_paid - $obj->total;
            $account->balance = $account->balance + $obj->total;
            $account->state = $account->balance == 0 ? 2 : 1;
            $account->update();

            return response()->json(['status' => 200,'message'=>'Se ha eliminado correctamente el pago','result' => $obj]);
        } catch (\Exception $e){   
            return response()->json(['status' => 400,'message' => 'A ocurrido un error', 'result' => $e->getMessage()]);
        }
    }


 

}
