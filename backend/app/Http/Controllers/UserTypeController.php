<?php

namespace App\Http\Controllers;

use App\Models\Privilege;
use App\Models\PrivilegeZone;
use App\Models\User;
use App\Models\UserType;
use App\Models\Zone;
use Illuminate\Http\Request;


class UserTypeController extends Controller
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
            $result = UserType::ListAll($search);
            return response()->json(['status' => 200,'result' => $result]);
        } catch (\Exception $e){   
            return response()->json(['status' => 400,'message' => 'A ocurrido un error', 'result' => $e->getMessage()]);
        }
    }

    public function ListActives(){
        try{
            $result = UserType::where('state',1)->get();
            return response()->json(['status' => 200,'result' => $result]);
        } catch (\Exception $e){   
            return response()->json(['status' => 400,'message' => 'A ocurrido un error', 'result' => $e->getMessage()]);
        }
    }

    public function View($id_user_type){
        try{
            $obj = UserType::GetById($id_user_type);
            $result = array();
            $zones = Zone::where('state',1)->orderBy('group','asc')->orderBy('name','asc')->get();
            foreach ($zones as $zone) {
                $mprivileges = array();
                $privileges = Privilege::where('state',1)->get();
                foreach ($privileges as $privilege) {
                    array_push($mprivileges,array(                        
                        'id_privilege' => $privilege->id_privilege,
                        'id_zone' => $zone->id_zone,
                        'name' => $privilege->name,
                        'state' => PrivilegeZone::GetPrivilegeByUserAndModule($obj->id_user_type,$zone->id_zone,$privilege->id_privilege),
                    ));
                }
                array_push($result,array(
                    'id_zone' => $zone->id_zone,
                    'name' => $zone->name,
                    'module' => $zone->module,
                    'group' => $zone->group,
                    'checked_all' => false,
                    'privileges' => $mprivileges,
                ));
            }


            return response()->json(['status' => 200,'result' => ['user_type' => $obj,'zone_privileges' => $result]]);
        } catch (\Exception $e){   
            return response()->json(['status' => 400,'message' => 'A ocurrido un error', 'result' => $e->getMessage()]);
        }
    }

    public function Store(Request $request){
        try{
            $this->validate($request, [
                'name' => 'required',
                'state' => 'required',
                'zone_privileges' => 'required',
            ]);

            $zone_privileges = $request->zone_privileges;
            $obj = new UserType();
            $obj->name = ucwords($request->name);
            $obj->state = $request->state;
            $obj->save();

            for ($i=0; $i < count($zone_privileges) ; $i++) { 
                for ($l=0; $l < count($zone_privileges[$i]['privileges']) ; $l++) { 
                    if ($zone_privileges[$i]['privileges'][$l]['state']) {
                        $privilege = new PrivilegeZone();
                        $privilege->id_user_type = $obj->id_user_type;
                        $privilege->id_zone = $zone_privileges[$i]['id_zone'];
                        $privilege->id_privilege = $zone_privileges[$i]['privileges'][$l]['id_privilege'];
                        $privilege->state = 1;
                        $privilege->save();
                    }
                }
            }

            return response()->json(['status' => 201,'message'=>'Se ha registrado correctamente el tipo de usuario','result' => $obj]);
        } catch (\Exception $e){   
            return response()->json(['status' => 400,'message' => 'A ocurrido un error', 'result' => $e->getMessage()]);
        }
    }

    public function Update(Request $request){
        try{
            $this->validate($request, [
                'name' => 'required',
                'state' => 'required',
                'zone_privileges' => 'required',
            ]);

            $zone_privileges = $request->zone_privileges;

            $obj = UserType::find($request->id_user_type);
            $obj->name = $request->name;
            $obj->state = $request->state;
            $obj->update();


            PrivilegeZone::where('id_user_type',$obj->id_user_type)->delete();

            for ($i=0; $i < count($zone_privileges) ; $i++) { 
                for ($l=0; $l < count($zone_privileges[$i]['privileges']) ; $l++) { 
                    if ($zone_privileges[$i]['privileges'][$l]['state']) {
                        $privilege = new PrivilegeZone();
                        $privilege->id_user_type = $obj->id_user_type;
                        $privilege->id_zone = $zone_privileges[$i]['id_zone'];
                        $privilege->id_privilege = $zone_privileges[$i]['privileges'][$l]['id_privilege'];
                        $privilege->state = 1;
                        $privilege->save();
                    }
                }
            }
            

            return response()->json(['status' => 200,'message'=>'Se ha modificado correctamente el tipo de usuario','result' => $obj]);
        } catch (\Exception $e){   
            return response()->json(['status' => 400,'message' => 'A ocurrido un error', 'result' => $e->getMessage()]);
        }
    }

    public function Delete($id_user_type){
        try{
        
            $obj = UserType::find($id_user_type);
            $obj->state = 9;
            $obj->update();
            return response()->json(['status' => 200,'message'=>'Se ha eliminado correctamente el tipo de usuario','result' => $obj]);
        } catch (\Exception $e){   
            return response()->json(['status' => 400,'message' => 'A ocurrido un error', 'result' => $e->getMessage()]);
        }
    }


    public function GetZonePrivilege(){
        try{
            $result = array();
            $zones = Zone::where('state',1)->orderBy('group','asc')->orderBy('name','asc')->get();
            foreach ($zones as $zone) {
                $mprivileges = array();
                $privileges = Privilege::where('state',1)->get();
                foreach ($privileges as $privilege) {
                    array_push($mprivileges,array(                        
                        'id_privilege' => $privilege->id_privilege,
                        'id_zone' => $zone->id_zone,
                        'name' => $privilege->name,
                        'state' => false,
                    ));
                }
                array_push($result,array(
                    'id_zone' => $zone->id_zone,
                    'name' => $zone->name,
                    'module' => $zone->module,
                    'group' => $zone->group,
                    'checked_all' => false,
                    'privileges' => $mprivileges,
                ));
            }
         
            return response()->json(['status' => 200,'result' => $result]);
        } catch (\Exception $e){   
            return response()->json(['status' => 400,'message' => 'A ocurrido un error', 'result' => $e->getMessage()]);
        }
    }

    
    //
}
