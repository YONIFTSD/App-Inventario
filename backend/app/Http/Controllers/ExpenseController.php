<?php

namespace App\Http\Controllers;

use App\Models\Correlative;
use App\Models\Expense;
use App\Models\TypeExpense;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class ExpenseController extends Controller
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


    public function ListAll($from,$to,$search){
        try{
            $result = Expense::ListAll($from,$to,$search);
            return response()->json(['status' => 200,'result' => $result]);
        } catch (\Exception $e){   
            return response()->json(['status' => 400,'message' => 'A ocurrido un error', 'result' => $e->getMessage()]);
        }
    }


    public function View($id_expense){
        try{
            $obj = Expense::GetById($id_expense);
            return response()->json(['status' => 200,'result' => $obj]);
        } catch (\Exception $e){   
            return response()->json(['status' => 400,'message' => 'A ocurrido un error', 'result' => $e->getMessage()]);
        }
    }

    public function Store(Request $request){
        try{
            $this->validate($request, [
                'id_type_expense' => 'required',
                'id_user' => 'required',
                'code' => 'required',
                'year' => 'required',
                'month' => 'required',
                'payment_method' => 'required',
                'coin' => 'required',
                'exchange_rate' => 'required',
                'total' => 'required',
                'state' => 'required',
            ]);

            $correlative = Correlative::GetByModule('Expense');

            $obj = new Expense();
            $obj->id_type_expense = $request->id_type_expense;
            $obj->id_user = $request->id_user;
            $obj->code = $correlative->number;
            $obj->date = date('Y-m-d');
            $obj->year = $request->year;
            $obj->month = $request->month;
            $obj->payment_method = $request->payment_method;
            $obj->observation = $request->observation;
            $obj->coin = $request->coin;
            $obj->exchange_rate = $request->exchange_rate;
            $obj->total = $request->total;
            $obj->state = $request->state;
            $obj->save();

            Correlative::Increase($correlative->id_correlative);

            return response()->json(['status' => 201,'message'=>'Se ha registrado correctamente el egreso','result' => $obj]);
        } catch (\Exception $e){   
            return response()->json(['status' => 400,'message' => 'A ocurrido un error', 'result' => $e->getMessage()]);
        }
    }

    public function Update(Request $request){
        try{
            $this->validate($request, [
                'id_type_expense' => 'required',
                'id_user' => 'required',
                'code' => 'required',
                'year' => 'required',
                'month' => 'required',
                'payment_method' => 'required',
                'coin' => 'required',
                'exchange_rate' => 'required',
                'total' => 'required',
                'state' => 'required',
            ]);

            $obj = Expense::find($request->id_expense);
            $obj->id_type_expense = $request->id_type_expense;
            $obj->id_user = $request->id_user;
            // $obj->date = $request->date;
            $obj->year = $request->year;
            $obj->month = $request->month;
            $obj->payment_method = $request->payment_method;
            $obj->observation = $request->observation;
            $obj->coin = $request->coin;
            $obj->exchange_rate = $request->exchange_rate;
            $obj->total = $request->total;
            $obj->state = $request->state;
            $obj->update();

            return response()->json(['status' => 200,'message'=>'Se ha modificado correctamente el egreso','result' => $obj]);
        } catch (\Exception $e){   
            return response()->json(['status' => 400,'message' => 'A ocurrido un error', 'result' => $e->getMessage()]);
        }
    }


    public function Delete($id_expense){
        try{
        
            $obj = Expense::find($id_expense);
            $obj->state = 9;
            $obj->update();
            return response()->json(['status' => 200,'message'=>'Se ha eliminado correctamente el egreso','result' => $obj]);
        } catch (\Exception $e){   
            return response()->json(['status' => 400,'message' => 'A ocurrido un error', 'result' => $e->getMessage()]);
        }
    }

    
    //
}
