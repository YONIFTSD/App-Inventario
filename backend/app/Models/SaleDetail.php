<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class SaleDetail extends Model
{

    protected $table = 'sales_detail';
    protected $primaryKey = 'id_sale_detail';

    public static function ListAll($id_sale){
        return DB::table('sales_detail')
        ->join('products','products.id_product','sales_detail.id_product')
        ->join('categories','categories.id_category','products.id_category')
        ->select('sales_detail.*','products.code','products.name','products.igv','categories.name as category_name')
        ->where('sales_detail.state','<>',9)
        ->where('sales_detail.id_sale',$id_sale)
        ->orderBy("sales_detail.id_sale_detail","DESC")
        ->get();
    }

}
