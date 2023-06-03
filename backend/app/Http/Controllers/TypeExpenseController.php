<?php

namespace App\Http\Controllers;

use App\Models\Correlative;
use App\Models\Expense;
use App\Models\TypeExpense;
use Illuminate\Http\Request;

class TypeExpenseController extends Controller
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
            $result = TypeExpense::ListAll($search);
            return response()->json(['status' => 200,'result' => $result]);
        } catch (\Exception $e){   
            return response()->json(['status' => 400,'message' => 'A ocurrido un error', 'result' => $e->getMessage()]);
        }
    }


    public function View($id_type_expense){
        try{
            $obj = TypeExpense::GetById($id_type_expense);
            return response()->json(['status' => 200,'result' => $obj]);
        } catch (\Exception $e){   
            return response()->json(['status' => 400,'message' => 'A ocurrido un error', 'result' => $e->getMessage()]);
        }
    }

    public function Store(Request $request){
        try{
            $this->validate($request, [
                'name' => 'required',
            ]);

            $obj = new TypeExpense();
            $obj->name = $request->name;
            $obj->description = $request->description;
            $obj->state = $request->state;
            $obj->save();

            return response()->json(['status' => 201,'message'=>'Se ha registrado correctamente el tipo de gasto','result' => $obj]);
        } catch (\Exception $e){   
            return response()->json(['status' => 400,'message' => 'A ocurrido un error', 'result' => $e->getMessage()]);
        }
    }

    public function Update(Request $request){
        try{
            $this->validate($request, [
                'id_type_expense' => 'required',
                'name' => 'required',
            ]);

            $obj = TypeExpense::find($request->id_type_expense);
            $obj->name = $request->name;
            $obj->description = $request->description;
            $obj->state = $request->state;
            $obj->update();

            return response()->json(['status' => 200,'message'=>'Se ha modificado correctamente el tipo de gasto','result' => $obj]);
        } catch (\Exception $e){   
            return response()->json(['status' => 400,'message' => 'A ocurrido un error', 'result' => $e->getMessage()]);
        }
    }


    public function Delete($id_type_expense){
        try{
        
            $obj = TypeExpense::find($id_type_expense);
            $obj->state = 9;
            $obj->update();
            return response()->json(['status' => 200,'message'=>'Se ha eliminado correctamente el tipo de gasto','result' => $obj]);
        } catch (\Exception $e){   
            return response()->json(['status' => 400,'message' => 'A ocurrido un error', 'result' => $e->getMessage()]);
        }
    }

    
    //
}
