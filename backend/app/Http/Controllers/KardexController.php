<?php

namespace App\Http\Controllers;

use App\Models\KardexMovement;
use Illuminate\Http\Request;


class KardexController extends Controller
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


    public function GetMovementByProduct($id_product,$to){
        try{
            $result = KardexMovement::GetMovementByProduct($id_product,$to);
            return response()->json(['status' => 200,'result' => $result]);
        } catch (\Exception $e){
            return response()->json(['status' => 400,'message' => 'A ocurrido un error', 'result' => $e->getMessage()]);
        }
    }
}
