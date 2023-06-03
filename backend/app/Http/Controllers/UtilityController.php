<?php

namespace App\Http\Controllers;

use App\Models\Correlative;
use App\Models\Income;
use App\Models\Utility;
use App\Models\UtilityDetail;
use Illuminate\Http\Request;


class UtilityController extends Controller
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
            $result = Utility::ListAll($search);
            return response()->json(['status' => 200,'result' => $result]);
        } catch (\Exception $e){   
            return response()->json(['status' => 400,'message' => 'A ocurrido un error', 'result' => $e->getMessage()]);
        }
    }


    public function View($id_utility){
        try{
            $obj = Utility::GetById($id_utility);
            $utility_detail_income = UtilityDetail::ListAll($id_utility,'Income');
            $utility_detail_expense = UtilityDetail::ListAll($id_utility,'Expense');
            $obj->utility_detail_income = $utility_detail_income;
            $obj->utility_detail_expense = $utility_detail_expense;
            
            return response()->json(['status' => 200,'result' => $obj]);
        } catch (\Exception $e){   
            return response()->json(['status' => 400,'message' => 'A ocurrido un error', 'result' => $e->getMessage()]);
        }
    }

    public function Store(Request $request){
        try{
            $this->validate($request, [
                'id_user' => 'required',
                'code' => 'required',
                'year' => 'required',
                'month' => 'required',
                'balance_total_pen' => 'required',
                'balance_total_usd' => 'required',
            ]);

            $correlative = Correlative::GetByModule('ManagementUtility');
            $incomes = $request->utility_detail_income;
            $expenses = $request->utility_detail_expense;
            
            $validate = Utility::where('year',$request->year)->where('month',$request->month)->where('state',1)->count();
            if ($validate > 0) {
                return response()->json(['status' => 404,'message'=>'Ya se registro una utilidad en el mes seleccionado','result' => '']);
            }
            $obj = new Utility();
            $obj->id_user = $request->id_user;
            $obj->code = $correlative->number;
            $obj->date = date('Y-m-d');
            $obj->year = $request->year;
            $obj->month = $request->month;
            $obj->observation = $request->observation;
            $obj->income_total_pen = $request->income_total_pen;
            $obj->income_total_usd = $request->income_total_usd;
            $obj->expense_total_pen = $request->expense_total_pen;
            $obj->expense_total_usd = $request->expense_total_usd;
            $obj->balance_total_pen = $request->balance_total_pen;
            $obj->balance_total_usd = $request->balance_total_usd;
            $obj->state = $request->state;
            $obj->save();

            Correlative::Increase($correlative->id_correlative);

            for ($i=0; $i < count($incomes); $i++) { 
                $detail = new UtilityDetail();
                $detail->id_utility = $obj->id_utility;
                $detail->id_detail = $incomes[$i]['id_income'];
                $detail->type = 'Income';
                $detail->year = $incomes[$i]['year'];
                $detail->month = $incomes[$i]['month'];
                $detail->description = $incomes[$i]['description'];
                $detail->total_pen = $incomes[$i]['total_pen'];
                $detail->total_usd = $incomes[$i]['total_usd'];
                $detail->state = 1;
                $detail->save();
            }

            for ($i=0; $i < count($expenses); $i++) { 
                $detail = new UtilityDetail();
                $detail->id_utility = $obj->id_utility;
                $detail->id_detail = $expenses[$i]['id_expense'];
                $detail->type = 'Expense';
                $detail->year = $expenses[$i]['year'];
                $detail->month = $expenses[$i]['month'];
                $detail->description = $expenses[$i]['description'];
                $detail->total_pen = $expenses[$i]['total_pen'];
                $detail->total_usd = $expenses[$i]['total_usd'];
                $detail->state = 1;
                $detail->save();
            }


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


    public function Delete($id_utility){
        try{
        
            $obj = Utility::find($id_utility);
            $obj->state = 9;
            $obj->update();
            return response()->json(['status' => 200,'message'=>'Se ha eliminado correctamente la utilidad','result' => $obj]);
        } catch (\Exception $e){   
            return response()->json(['status' => 400,'message' => 'A ocurrido un error', 'result' => $e->getMessage()]);
        }
    }



    public function GetUtility(Request $request){
        try{
            set_time_limit(0);
            $income = Utility::GetUtility($request->year,$request->month);
            return response()->json(['status' => 200,'result' => $income]);
        } catch (\Exception $e){   
            return response()->json(['status' => 400,'message' => 'A ocurrido un error', 'result' => $e->getMessage()]);
        }
    }


    
    
    //
}
