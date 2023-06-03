<?php

namespace App\Http\Controllers;

use App\Models\Audit;
use Illuminate\Http\Request;
class AuditController extends Controller
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


    public function Store(Request $request){
        try{
            $audit = new Audit();
            $audit->id_user = $request->id_user;
            $audit->registration_date = date('Y-m-d H:i:s');
            $audit->module = $request->module;
            $audit->process = $request->process;
            $audit->data = json_encode($request->data);
            $audit->ip = isset($request->ip) ? $request->ip:'';
            $audit->url = isset($request->url) ? $request->url:'';
            $audit->state = 1;
            $audit->save();
            return response()->json(['status' => 200,'result' => $audit]);
        } catch (\Exception $e){   
            return response()->json(['status' => 400,'message' => 'A ocurrido un error', 'result' => $e->getMessage()]);
        }
    }


   
    
    
    //
}
