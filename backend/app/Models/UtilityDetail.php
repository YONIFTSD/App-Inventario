<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class UtilityDetail extends Model
{
    protected $table = 'utilities_detail';
    protected $primaryKey = 'id_utility_detail';
   
    public static function ListAll($id_utility,$type){
        return DB::table('utilities_detail')
        ->select('utilities_detail.*')
        ->where('utilities_detail.type',$type)
        ->where('utilities_detail.id_utility',$id_utility)
        ->get();
    }

}
