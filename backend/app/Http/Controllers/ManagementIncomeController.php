<?php

namespace App\Http\Controllers;

use App\Models\Business;
use App\Models\Correlative;
use App\Models\ExchangeRateSunat;
use App\Models\ManagementIncome;
use Illuminate\Http\Request;

class ManagementIncomeController extends Controller
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
            $result = ManagementIncome::ListAll($from,$to,$search);
            return response()->json(['status' => 200,'result' => $result]);
        } catch (\Exception $e){   
            return response()->json(['status' => 400,'message' => 'A ocurrido un error', 'result' => $e->getMessage()]);
        }
    }


    public function View($id_income){
        try{
            $obj = ManagementIncome::GetById($id_income);
            return response()->json(['status' => 200,'result' => $obj]);
        } catch (\Exception $e){   
            return response()->json(['status' => 400,'message' => 'A ocurrido un error', 'result' => $e->getMessage()]);
        }
    }

    public function Store(Request $request){
        try{
            $this->validate($request, [
                'id_user' => 'required',
                'id_type_income' => 'required',
                'code' => 'required',
                'year' => 'required',
                'month' => 'required',
                'payment_method' => 'required',
                'total_usd' => 'required',
                'total_pen' => 'required',
                'state' => 'required',
            ]);

            $business = Business::find(1);
            $exchange_rate = ExchangeRateSunat::GetByDate($business->bd,date('Y-m-d'));
            $correlative = Correlative::GetByModule('ManagementIncome');




            $obj = new ManagementIncome();
            $obj->id_type_income = $request->id_type_income;
            $obj->id_user = $request->id_user;
            $obj->code = $correlative->number;
            $obj->date = date('Y-m-d');
            $obj->year = $request->year;
            $obj->month = $request->month;
            $obj->payment_method = $request->payment_method;
            $obj->observation = $request->observation;
            $obj->total_pen = $request->total_pen == 0 ? $request->total_usd * $exchange_rate->venta : $request->total_pen;
            $obj->total_usd = $request->total_usd == 0 ? $request->total_pen / $exchange_rate->venta : $request->total_usd;
            $obj->state = $request->state;
            $obj->save();

            Correlative::Increase($correlative->id_correlative);

            return response()->json(['status' => 201,'message'=>'Se ha registrado correctamente el ingreso gerencial','result' => $obj]);
        } catch (\Exception $e){   
            return $e;
            return response()->json(['status' => 400,'message' => 'A ocurrido un error', 'result' => $e->getMessage()]);
        }
    }

    public function Update(Request $request){
        try{
            $this->validate($request, [
                'id_type_income' => 'required',
                'id_user' => 'required',
                'code' => 'required',
                'year' => 'required',
                'month' => 'required',
                'payment_method' => 'required',
                'total_usd' => 'required',
                'total_pen' => 'required',
                'state' => 'required',
            ]);

            $obj = ManagementIncome::find($request->id_income);
            $obj->id_type_income = $request->id_type_income;
            $obj->id_user = $request->id_user;
            // $obj->date = $request->date;
            $obj->year = $request->year;
            $obj->month = $request->month;
            $obj->payment_method = $request->payment_method;
            $obj->observation = $request->observation;
            $obj->total_pen = $request->total_pen;
            $obj->total_usd = $request->total_usd;
            $obj->state = $request->state;
            $obj->update();

            return response()->json(['status' => 200,'message'=>'Se ha modificado correctamente el ingreso gerencial','result' => $obj]);
        } catch (\Exception $e){   
            return response()->json(['status' => 400,'message' => 'A ocurrido un error', 'result' => $e->getMessage()]);
        }
    }


    public function Delete($id_income){
        try{
        
            $obj = ManagementIncome::find($id_income);
            $obj->state = 9;
            $obj->update();
            return response()->json(['status' => 200,'message'=>'Se ha eliminado correctamente el ingreso gerencial','result' => $obj]);
        } catch (\Exception $e){   
            return response()->json(['status' => 400,'message' => 'A ocurrido un error', 'result' => $e->getMessage()]);
        }
    }

    public function GetBalanceByMonth(Request $request){
        try{
        
            $obj = ManagementIncome::GetBalanceByMonth($request->year,$request->month);
            
            return response()->json(['status' => 200,'message'=>'','result' => $obj]);
        } catch (\Exception $e){   
            return response()->json(['status' => 400,'message' => 'A ocurrido un error', 'result' => $e->getMessage()]);
        }
    }


    
    
    //
}
