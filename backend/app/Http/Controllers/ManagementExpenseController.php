<?php

namespace App\Http\Controllers;

use App\Models\Correlative;
use App\Models\Expense;
use App\Models\ManagementExpense;
use Illuminate\Http\Request;


class ManagementExpenseController extends Controller
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
            $result = ManagementExpense::ListAll($from,$to,$search);
            return response()->json(['status' => 200,'result' => $result]);
        } catch (\Exception $e){   
            return response()->json(['status' => 400,'message' => 'A ocurrido un error', 'result' => $e->getMessage()]);
        }
    }


    public function View($id_expense){
        try{
            $obj = ManagementExpense::GetById($id_expense);
            return response()->json(['status' => 200,'result' => $obj]);
        } catch (\Exception $e){   
            return response()->json(['status' => 400,'message' => 'A ocurrido un error', 'result' => $e->getMessage()]);
        }
    }

    public function Store(Request $request){
        try{
            $this->validate($request, [
                'description' => 'required',
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

            $correlative = Correlative::GetByModule('ManagementExpense');

            $obj = new ManagementExpense();
            $obj->description = $request->description;
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

            return response()->json(['status' => 201,'message'=>'Se ha registrado correctamente el egreso gerencial','result' => $obj]);
        } catch (\Exception $e){   
            return response()->json(['status' => 400,'message' => 'A ocurrido un error', 'result' => $e->getMessage()]);
        }
    }

    public function Update(Request $request){
        try{
            $this->validate($request, [
                'description' => 'required',
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

            $obj = ManagementExpense::find($request->id_expense);
            $obj->description = $request->description;
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

            return response()->json(['status' => 200,'message'=>'Se ha modificado correctamente el egreso gerencial','result' => $obj]);
        } catch (\Exception $e){   
            return response()->json(['status' => 400,'message' => 'A ocurrido un error', 'result' => $e->getMessage()]);
        }
    }


    public function Delete($id_expense){
        try{
        
            $obj = ManagementExpense::find($id_expense);
            $obj->state = 9;
            $obj->update();
            return response()->json(['status' => 200,'message'=>'Se ha eliminado correctamente el egreso gerencial','result' => $obj]);
        } catch (\Exception $e){   
            return response()->json(['status' => 400,'message' => 'A ocurrido un error', 'result' => $e->getMessage()]);
        }
    }

    
    //
}
