<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class ExchangeRateSunat extends Model
{
    protected $table = 'exchange_rate_sunat';
    protected $primaryKey = 'id_exchange_rate';

    public static function GetByDate($bd,$date){
        return DB::connection($bd)->table('exchange_rate_sunat')
        ->select('exchange_rate_sunat.*')
        ->where('exchange_rate_sunat.state','<>', 9)
        ->where('exchange_rate_sunat.date','<=',$date)
        ->orderBy('exchange_rate_sunat.date','DESC')
        ->first();
    }

}
