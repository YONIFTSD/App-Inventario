<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Zone extends Model
{
    
    protected $table = 'zones';
    protected $primaryKey = 'id_zone';

    public static function ListAll($search){
        $search = urldecode($search);
        return DB::table('zones')
        ->select('zones.*')
        ->where('zones.state','<>',9)
        ->where(function ($query) use ($search) {
            if(!empty($search) && $search != "all"){
                $query = $query->orWhere('zones.name','like',"%$search%");
            }
        })
        ->orderBy("zones.id_zone","DESC")
        ->paginate(15);
    }

    public static function GetById($id_zone){
        return DB::table('zones')
        ->select('zones.*')
        ->where('zones.id_zone',$id_zone)
        ->first();
    }
  
}
