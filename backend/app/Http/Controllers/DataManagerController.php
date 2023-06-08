<?php

namespace App\Http\Controllers;

use App\Models\Business;
use App\Models\Correlative;
use App\Models\ExchangeRateSunat;
use App\Models\Serie;
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


    public function GetSeries($type_invoice){
        try{
            $obj = Serie::GetSeries($type_invoice);
            return response()->json(['status' => 200,'result' => $obj]);
        } catch (\Exception $e){
            return response()->json(['status' => 400,'message' => 'A ocurrido un error', 'result' => $e->getMessage()]);
        }
    }

    public function GetSeriesById($id_serie){
        try{
            $obj = Serie::find($id_serie);
            return response()->json(['status' => 200,'result' => $obj]);
        } catch (\Exception $e){
            return response()->json(['status' => 400,'message' => 'A ocurrido un error', 'result' => $e->getMessage()]);
        }
    }

}
