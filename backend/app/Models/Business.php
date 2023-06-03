<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Business extends Model
{
    
    protected $table = 'business';
    protected $primaryKey = 'id_business';

    public static function GetBusiness(){
        return DB::table('business')
            ->select('business.*')
            ->where('business.state',1)
            ->get();
    }


    public static function GetBusinessInfo(){
        return DB::table('business')
            ->select('business.*')
            ->where('business.state',1)
            ->first();
    }
  
}
