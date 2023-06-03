<?php

namespace App\Http\Controllers;

use App\Models\Business;
use App\Models\PrivilegeZone;
use App\Models\User;
use App\Models\ZonePrivilege;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AuthenticateController extends Controller
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

    public function Login(Request $request)
    {
        
        if ($request->isJson()) {

            $this->validate($request, [
                'email' => 'required',
                'password' => 'required'
            ]);

            try{

                $user = User::where('email', $request->email)->where('state',1)->first();
            
                if ($user && Hash::check($request->password, $user->password)) {
                    $userPermissions = array();

                    $privileges_zone = PrivilegeZone::GetByUserType($user->id_user_type);                    
                    foreach ($privileges_zone as $privilege) {
                        $name_privilege = $privilege->module;
                        switch ($privilege->id_privilege) {
                            case '1': $name_privilege .= "List"; break;
                            case '2': $name_privilege .= "Add"; break;
                            case '3': $name_privilege .= "Edit"; break;
                            case '4': $name_privilege .= "Delete"; break;
                            case '5': $name_privilege .= "View"; break;
                        }
                        array_push($userPermissions,$name_privilege);
                    }
                   
                    $business = Business::GetBusiness();
                    return response()->json(['status' => 200, 'message' => 'Bienvenido al sistema','result' => ['user' => $user, 'userPermissions' => $userPermissions, 'business' => $business]]);
                }
                return response()->json(['status' => 404, 'message' => 'datos incorrectos']);

            } catch (\Exception $e){   
                return $e;
                return response()->json(['status' => 400,'message' => 'A ocurrido un error', 'result' => $e->getMessage()]);
            }
        }
        return response()->json(['status' => 400,'message' => 'El recurso de destino no admite el formato de datos solicitado']);
    }

    //
}
