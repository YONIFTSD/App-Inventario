<?php

namespace App\Http\Controllers;


use App\Models\TypeExpense;
use App\Models\TypeIncome;
use Illuminate\Http\Request;

class TypeIncomeController extends Controller
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
            $result = TypeIncome::ListAll($search);
            return response()->json(['status' => 200,'result' => $result]);
        } catch (\Exception $e){   
            return response()->json(['status' => 400,'message' => 'A ocurrido un error', 'result' => $e->getMessage()]);
        }
    }

    public function ListActive(){
        try{
            $result = TypeIncome::where('state',1)->get();
            return response()->json(['status' => 200,'result' => $result]);
        } catch (\Exception $e){   
            return response()->json(['status' => 400,'message' => 'A ocurrido un error', 'result' => $e->getMessage()]);
        }
    }


    public function View($id_type_income){
        try{
            $obj = TypeIncome::GetById($id_type_income);
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

            $obj = new TypeIncome();
            $obj->name = $request->name;
            $obj->description = $request->description;
            $obj->state = $request->state;
            $obj->save();

            return response()->json(['status' => 201,'message'=>'Se ha registrado correctamente el tipo de ingreso','result' => $obj]);
        } catch (\Exception $e){   
            return response()->json(['status' => 400,'message' => 'A ocurrido un error', 'result' => $e->getMessage()]);
        }
    }

    public function Update(Request $request){
        try{
            $this->validate($request, [
                'id_type_income' => 'required',
                'name' => 'required',
            ]);

            $obj = TypeIncome::find($request->id_type_income);
            $obj->name = $request->name;
            $obj->description = $request->description;
            $obj->state = $request->state;
            $obj->update();

            return response()->json(['status' => 200,'message'=>'Se ha modificado correctamente el tipo de ingreso','result' => $obj]);
        } catch (\Exception $e){   
            return response()->json(['status' => 400,'message' => 'A ocurrido un error', 'result' => $e->getMessage()]);
        }
    }


    public function Delete($id_type_income){
        try{
        
            $obj = TypeIncome::find($id_type_income);
            $obj->state = 9;
            $obj->update();
            return response()->json(['status' => 200,'message'=>'Se ha eliminado correctamente el tipo de ingreso','result' => $obj]);
        } catch (\Exception $e){   
            return response()->json(['status' => 400,'message' => 'A ocurrido un error', 'result' => $e->getMessage()]);
        }
    }

    
    //
}
