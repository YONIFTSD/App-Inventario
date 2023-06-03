<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UserController extends Controller
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
            $result = User::ListAll($search);
            return response()->json(['status' => 200,'result' => $result]);
        } catch (\Exception $e){   
            return response()->json(['status' => 400,'message' => 'A ocurrido un error', 'result' => $e->getMessage()]);
        }
    }

    public function View($id_user){
        try{
            $obj = User::GetById($id_user);
            $obj->password = '';
            return response()->json(['status' => 200,'result' => $obj]);
        } catch (\Exception $e){   
            return response()->json(['status' => 400,'message' => 'A ocurrido un error', 'result' => $e->getMessage()]);
        }
    }

    public function Store(Request $request){
        try{
            $this->validate($request, [
                'id_user_type' => 'required',
                'name' => 'required',
                'user' => 'required',
                'email' => 'required',
                'password' => 'required',
                'state' => 'required',
            ]);

            $obj = new User();
            $obj->id_user_type = $request->id_user_type;
            $obj->name = ucwords($request->name);
            $obj->last_name = ucwords($request->last_name);
            $obj->user = ucwords($request->user);
            $obj->email = $request->email;
            $obj->password = Hash::make($request->password);
            $obj->phone = $request->phone;
            $obj->state = $request->state;
            $obj->api_token =  Str::random(60);
            // $obj->remember_token = $request->remember_token;
            $obj->save();

            return response()->json(['status' => 201,'message'=>'Se ha registrado correctamente el usuario','result' => $obj]);
        } catch (\Exception $e){   
            return response()->json(['status' => 400,'message' => 'A ocurrido un error', 'result' => $e->getMessage()]);
        }
    }

    public function Update(Request $request){
        try{
            $this->validate($request, [
                'id_user' => 'required',
                'id_user_type' => 'required',
                'name' => 'required',
                'user' => 'required',
                'email' => 'required',
                'state' => 'required',
            ]);

            $obj = User::find($request->id_user);
            $obj->id_user_type = $request->id_user_type;
            $obj->name = ucwords($request->name);
            $obj->user = ucwords($request->user);
            $obj->email = $request->email;
            if (!Empty($obj->password)) {
                $obj->password = Hash::make($request->password);
            }
            $obj->phone = $request->phone;
            $obj->state = $request->state;
            $obj->update();

            return response()->json(['status' => 200,'message'=>'Se ha modificado correctamente el usuario','result' => $obj]);
        } catch (\Exception $e){   
            return response()->json(['status' => 400,'message' => 'A ocurrido un error', 'result' => $e->getMessage()]);
        }
    }


    public function Delete($id_user){
        try{
        
            $obj = User::find($id_user);
            $obj->state = 9;
            $obj->update();
            return response()->json(['status' => 200,'message'=>'Se ha eliminado correctamente el usuario','result' => $obj]);
        } catch (\Exception $e){   
            return response()->json(['status' => 400,'message' => 'A ocurrido un error', 'result' => $e->getMessage()]);
        }
    }

    
    //
}
