<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Serie extends Model
{

    protected $table = 'series';
    protected $primaryKey = 'id_serie';


    //Listar Registros
    public static function GetSeries($type_invoice){

        return DB::table('series')
        ->select('series.*')
        ->where('series.type_invoice', $type_invoice)
        ->where('series.state', 1)
        ->get();

    }



    public static function Increase($id_serie){

        $obj = Serie::find($id_serie,['id_serie','num','number']);
        $obj->num = $obj->num + 1;
        $obj->number = str_pad($obj->num, 8, "0", STR_PAD_LEFT);
        $obj->save();

        return true;

    }
    public static function Decrease($id_serie){

        $obj = Serie::find($id_serie,['id_serie','num','number']);
        $obj->num = $obj->num - 1;
        $obj->number = str_pad($obj->num, 8, "0", STR_PAD_LEFT);
        $obj->save();
        return true;
    }


}
