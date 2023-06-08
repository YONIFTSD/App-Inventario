<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Sale extends Model
{

    protected $table = 'sales';
    protected $primaryKey = 'id_sale';

    public static function ListAll($from,$to,$search){
        $search = urldecode($search);
        return DB::table('sales')
        ->join('clients','clients.id_client','sales.id_client')
        ->select('sales.*','clients.name as client_name','clients.document_number as client_document_number')
        ->where('sales.state','<>',9)
        ->whereBetween('sales.broadcast_date',[$from,$to])
        ->where(function ($query) use ($search) {
            if(!empty($search) && $search != "all"){
                $query = $query->orWhere('clients.name','like',"%$search%");
                $query = $query->orWhere('clients.document_number','like',"%$search%");
                $query = $query->orWhere('sales.serie','like',"%$search%");
                $query = $query->orWhere('sales.number','like',"%$search%");
            }
        })
        ->orderBy("sales.id_sale","DESC")
        ->paginate(15);
    }


    public static function GetById($id_sale){
        return DB::table('sales')
        ->select('sales.*')
        ->where('sales.id_sale',$id_sale)
        ->first();
    }



}
