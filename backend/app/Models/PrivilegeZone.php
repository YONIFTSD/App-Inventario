<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class PrivilegeZone extends Model
{
    
    protected $table = 'privileges_zones';
    protected $primaryKey = 'id_privilege_zone';

    public static function GetPrivilegeByUserAndModule($id_user_type,$id_zone,$id_privilege){
        $result = DB::table('privileges_zones')
        ->select('privileges_zones.*')
        ->where('privileges_zones.id_user_type',$id_user_type)
        ->where('privileges_zones.id_zone',$id_zone)
        ->where('privileges_zones.id_privilege',$id_privilege)
        ->where('privileges_zones.state',1)
        ->first();

        if ($result) {
            return true;
        }
        return false;
    }

    public static function GetByUserType($id_user_type){
        $result = DB::table('privileges_zones')
        ->join('zones', 'zones.id_zone','privileges_zones.id_zone')
        ->select('privileges_zones.*','zones.module')
        ->where('privileges_zones.id_user_type',$id_user_type)
        ->where('privileges_zones.state',1)
        ->get();
        return $result;
    }

    public static function ValidatePrivilegeZone($id_user_type,$module,$role){
        $result = DB::table('privileges_zones')
        ->join('zones', 'zones.id_zone','privileges_zones.id_zone')
        ->join('privileges', 'privileges.id_privilege','privileges_zones.id_privilege')
        ->select('privileges_zones.*','zones.module')
        ->where('privileges_zones.id_user_type',$id_user_type)
        ->where('zones.module',$module)
        ->where('privileges.role',$role)
        ->where('privileges_zones.state',1)
        ->first();

        if ($result) {
            return true;
        }
        return false;
    }
    
}
