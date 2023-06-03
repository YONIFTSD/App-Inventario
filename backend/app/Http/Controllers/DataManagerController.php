<?php

namespace App\Http\Controllers;

use App\Models\Business;
use App\Models\Correlative;
use App\Models\ExchangeRateSunat;
use App\Models\TypeExpense;

class DataManagerController extends Controller
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


    public function ListTypeExpenses(){
        try{
            $obj = TypeExpense::where('state',1)->get();
            return response()->json(['status' => 200,'result' => $obj]);
        } catch (\Exception $e){   
            return response()->json(['status' => 400,'message' => 'A ocurrido un error', 'result' => $e->getMessage()]);
        }
    }

    public function ListBusiness(){
        try{
            $obj = Business::GetBusiness();
            return response()->json(['status' => 200,'result' => $obj]);
        } catch (\Exception $e){   
            return response()->json(['status' => 400,'message' => 'A ocurrido un error', 'result' => $e->getMessage()]);
        }
    }

    public function GetCorrelativeByModule($module){
        try{
            $obj = Correlative::GetByModule($module);
            return response()->json(['status' => 200,'result' => $obj]);
        } catch (\Exception $e){   
            return response()->json(['status' => 400,'message' => 'A ocurrido un error', 'result' => $e->getMessage()]);
        }
    }

    public function GetExchangeRate($date){
        try{
            $business = Business::find(1,['bd']);
            $obj = ExchangeRateSunat::GetByDate($business->bd,$date);
            return response()->json(['status' => 200,'result' => $obj]);
        } catch (\Exception $e){   
            return response()->json(['status' => 400,'message' => 'A ocurrido un error', 'result' => $e->getMessage()]);
        }
    }

    



    
    //
}
