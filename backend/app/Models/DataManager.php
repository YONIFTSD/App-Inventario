<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class DataManager extends Model
{

    public static function TypeInvoice($code){
        $name = '';
        switch ($code) {
            case 'NV': $name = "Nota de Venta"; break;
            case '03': $name = "Boleta de Venta"; break;
            case '01': $name = "Factura"; break;
            case 'NE': $name = "Nota de Entrada"; break;
            default: break;
        }
        return $name;
    }


    public static function TypeOperation($code){
        $name = '';
        switch ($code) {
            case '01': $name = "Venta Nacional"; break;
            case '03': $name = "Bonificación"; break;
            case '02': $name = "Compra Nacional"; break;
            case '04': $name = "Importación"; break;
            case '05': $name = "Ajuste Por Diferencia de Inventario"; break;
            default: break;
        }
        return $name;
    }


}
