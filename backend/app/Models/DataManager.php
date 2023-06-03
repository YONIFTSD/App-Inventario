<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class DataManager extends Model
{
    
    public static function NameMonth($code){
        $name = '';
        switch ($code) {
            case '01': $name = "Ene."; break;
            case '02': $name = "Feb."; break;
            case '03': $name = "Mar."; break;
            case '04': $name = "Abr."; break;
            case '05': $name = "May."; break;
            case '06': $name = "Jun."; break;
            case '07': $name = "Jul."; break;
            case '08': $name = "Ago."; break;
            case '09': $name = "Sep."; break;
            case '10': $name = "Oct."; break;
            case '11': $name = "Nov."; break;
            case '12': $name = "Dic."; break;
            default: break;
        }
        return $name;
    }
   
  
}
