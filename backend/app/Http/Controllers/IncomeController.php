<?php

namespace App\Http\Controllers;

use App\Models\Correlative;
use App\Models\Expense;
use App\Models\Income;
use App\Models\Utility;
use Illuminate\Http\Request;


class IncomeController extends Controller
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
            $result = Income::ListAll($from,$to,$search);
            return response()->json(['status' => 200,'result' => $result]);
        } catch (\Exception $e){   
            return response()->json(['status' => 400,'message' => 'A ocurrido un error', 'result' => $e->getMessage()]);
        }
    }


    public function View($id_income){
        try{
            $obj = Income::GetById($id_income);
            return response()->json(['status' => 200,'result' => $obj]);
        } catch (\Exception $e){   
            return response()->json(['status' => 400,'message' => 'A ocurrido un error', 'result' => $e->getMessage()]);
        }
    }

    public function Store(Request $request){
        try{
            $this->validate($request, [
                'id_business' => 'required',
                'id_user' => 'required',
                'code' => 'required',
                'year' => 'required',
                'month' => 'required',
                'total_pen' => 'required',
                'total_usd' => 'required',
            ]);

            $correlative = Correlative::GetByModule('Income');
            
            $validate = Income::where('id_business',$request->id_business)->where('year',$request->year)->where('month',$request->month)->where('state',1)->count();
            if ($validate > 0) {
                return response()->json(['status' => 404,'message'=>'Ya se registro un ingrese en el mes seleccionado','result' => '']);
            }
            $obj = new Income();
            $obj->id_business = $request->id_business;
            $obj->id_user = $request->id_user;
            $obj->code = $correlative->number;
            $obj->date = date('Y-m-d');
            $obj->year = $request->year;
            $obj->month = $request->month;
            $obj->observation = $request->observation;
            $obj->total_pen = $request->total_pen;
            $obj->total_usd = $request->total_usd;
            $obj->state = $request->state;
            $obj->save();

            Correlative::Increase($correlative->id_correlative);

            return response()->json(['status' => 201,'message'=>'Se ha registrado correctamente el ingreso','result' => $obj]);
        } catch (\Exception $e){   
            return response()->json(['status' => 400,'message' => 'A ocurrido un error', 'result' => $e->getMessage()]);
        }
    }

    public function Update(Request $request){
        try{
            $this->validate($request, [
                'id_business' => 'required',
                'id_user' => 'required',
                'code' => 'required',
                'year' => 'required',
                'month' => 'required',
                'total_pen' => 'required',
                'total_usd' => 'required',
            ]);

            $obj = Income::find($request->id_income);
            // $obj->id_business = $request->id_business;
            $obj->id_user = $request->id_user;
            $obj->year = $request->year;
            $obj->month = $request->month;
            $obj->observation = $request->observation;
            $obj->total_pen = $request->total_pen;
            $obj->total_usd = $request->total_usd;
            $obj->state = $request->state;
            $obj->update();

            return response()->json(['status' => 200,'message'=>'Se ha modificado correctamente el ingreso','result' => $obj]);
        } catch (\Exception $e){   
            return response()->json(['status' => 400,'message' => 'A ocurrido un error', 'result' => $e->getMessage()]);
        }
    }


    public function Delete($id_income){
        try{
        
            $obj = Income::find($id_income);
            $obj->state = 9;
            $obj->update();
            return response()->json(['status' => 200,'message'=>'Se ha eliminado correctamente el ingreso','result' => $obj]);
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
