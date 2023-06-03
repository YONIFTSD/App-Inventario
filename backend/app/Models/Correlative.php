<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Correlative extends Model
{
    
    protected $table = 'correlatives';
    protected $primaryKey = 'id_correlative';


    //Listar Registros
    public static function GetByModule($module){
        
        return DB::table('correlatives')
        ->select('correlatives.id_correlative','correlatives.number')
        ->where('correlatives.module', $module)
        ->where('correlatives.state', 1)
        ->first();

    }

    

    public static function Increase($id_correlative){
        
        $obj = Correlative::find($id_correlative,['id_correlative','num','number']);
        $obj->num = $obj->num + 1; 
        $obj->number = str_pad($obj->num, 8, "0", STR_PAD_LEFT); 
        $obj->save();

        return true;

    }
    public static function Decrease($id_correlative){
        
        $obj = Correlative::find($id_correlative,['id_correlative','num','number']);
        $obj->num = $obj->num - 1; 
        $obj->number = str_pad($obj->num, 8, "0", STR_PAD_LEFT); 
        $obj->save();
        return true;
    }
    
  
}
