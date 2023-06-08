<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Purchase extends Model
{

    protected $table = 'purchases';
    protected $primaryKey = 'id_purchase';

    public static function ListAll($from,$to,$search){
        $search = urldecode($search);
        return DB::table('purchases')
        ->join('providers','providers.id_provider','purchases.id_provider')
        ->select('purchases.*','providers.name as provider_name','providers.document_number as provider_document_number')
        ->where('purchases.state','<>',9)
        ->whereBetween('purchases.broadcast_date',[$from,$to])
        ->where(function ($query) use ($search) {
            if(!empty($search) && $search != "all"){
                $query = $query->orWhere('providers.name','like',"%$search%");
                $query = $query->orWhere('providers.document_number','like',"%$search%");
                $query = $query->orWhere('purchases.serie','like',"%$search%");
                $query = $query->orWhere('purchases.number','like',"%$search%");
            }
        })
        ->orderBy("purchases.id_purchase","DESC")
        ->paginate(15);
    }


    public static function GetById($id_purchase){
        return DB::table('purchases')
        ->select('purchases.*')
        ->where('purchases.id_purchase',$id_purchase)
        ->first();
    }



}
