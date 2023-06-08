<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class PurchaseDetail extends Model
{

    protected $table = 'purchases_detail';
    protected $primaryKey = 'id_purchase_detail';

    public static function ListAll($id_purchase){
        return DB::table('purchases_detail')
        ->join('products','products.id_product','purchases_detail.id_product')
        ->join('categories','categories.id_category','products.id_category')
        ->select('purchases_detail.*','products.code','products.name','products.igv','categories.name as category_name')
        ->where('purchases_detail.state','<>',9)
        ->where('purchases_detail.id_purchase',$id_purchase)
        ->orderBy("purchases_detail.id_purchase_detail","DESC")
        ->get();
    }

}
