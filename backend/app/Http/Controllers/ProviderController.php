<?php

namespace App\Http\Controllers;

use App\Models\Provider;
use Illuminate\Http\Request;


class ProviderController extends Controller
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
            $result = Provider::ListAll($search);
            return response()->json(['status' => 200,'result' => $result]);
        } catch (\Exception $e){
            return response()->json(['status' => 400,'message' => 'A ocurrido un error', 'result' => $e->getMessage()]);
        }
    }


    public function View($id_provider){
        try{
            $obj = Provider::GetById($id_provider);
            return response()->json(['status' => 200,'result' => $obj]);
        } catch (\Exception $e){
            return response()->json(['status' => 400,'message' => 'A ocurrido un error', 'result' => $e->getMessage()]);
        }
    }

    public function SearchSelect(Request $request){
        try{
            $obj = Provider::SearchSelect($request->search);
            $result = array();
            foreach ($obj as $be) {
                array_push($result,array(
                    'id' => $be->id_provider,
                    'text' => $be->name.' - '.$be->document_number,
                ));
            }
            return $result;
        } catch (\Exception $e){
            return response()->json(['status' => 400,'message' => 'A ocurrido un error', 'result' => $e->getMessage()]);
        }
    }

    public function Store(Request $request){
        try{
            $this->validate($request, [
                'name' => 'required',
                'state' => 'required',
            ]);

            $obj = new Provider();
            $obj->document_type = $request->document_type;
            $obj->document_number = $request->document_number;
            $obj->name = $request->name;
            $obj->email = $request->email;
            $obj->phone = $request->phone;
            $obj->state = $request->state;
            $obj->save();

            return response()->json(['status' => 201,'message'=>'Se ha registrado correctamente el cliente','result' => $obj]);
        } catch (\Exception $e){
            return response()->json(['status' => 400,'message' => 'A ocurrido un error', 'result' => $e->getMessage()]);
        }
    }

    public function Update(Request $request){
        try{
            $this->validate($request, [
                'id_provider' => 'required',
                'name' => 'required',
                'state' => 'required',
            ]);

            $obj = Provider::find($request->id_provider);
            $obj->document_type = $request->document_type;
            $obj->document_number = $request->document_number;
            $obj->name = $request->name;
            $obj->email = $request->email;
            $obj->phone = $request->phone;
            $obj->state = $request->state;
            $obj->update();

            return response()->json(['status' => 200,'message'=>'Se ha modificado correctamente el proveedor','result' => $obj]);
        } catch (\Exception $e){
            return response()->json(['status' => 400,'message' => 'A ocurrido un error', 'result' => $e->getMessage()]);
        }
    }


    public function Delete($id_provider){
        try{

            $obj = Provider::find($id_provider);
            $obj->state = 9;
            $obj->update();
            return response()->json(['status' => 200,'message'=>'Se ha eliminado correctamente el proveedor','result' => $obj]);
        } catch (\Exception $e){
            return response()->json(['status' => 400,'message' => 'A ocurrido un error', 'result' => $e->getMessage()]);
        }
    }
    //
}
