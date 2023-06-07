<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Product extends Model
{

    protected $table = 'products';
    protected $primaryKey = 'id_product';

    public static function ListAll($search){
        $search = urldecode($search);
        return DB::table('products')
        ->join('categories','categories.id_category','products.id_category')
        ->select('products.*','categories.name as category_name')
        ->where('products.state','<>',9)
        ->where(function ($query) use ($search) {
            if(!empty($search) && $search != "all"){
                $query = $query->orWhere('categories.name','like',"%$search%");
                $query = $query->orWhere('products.name','like',"%$search%");
                $query = $query->orWhere('products.code','like',"%$search%");
            }
        })
        ->orderBy("products.id_product","DESC")
        ->paginate(15);
    }

    public static function Search($search){
        $search = urldecode($search);
        return DB::table('products')
        ->join('categories','categories.id_category','products.id_category')
        ->select('products.*','categories.name as category_name')
        ->where('products.state','<>',9)
        ->where(function ($query) use ($search) {
            if(!empty($search) && $search != "all"){
                $query = $query->orWhere('categories.name','like',"%$search%");
                $query = $query->orWhere('products.name','like',"%$search%");
                $query = $query->orWhere('products.code','like',"%$search%");
            }
        })
        ->orderBy("products.id_product","DESC")
        ->limit(15)
        ->get();
    }

    public static function GetById($id_product){
        return DB::table('products')
        ->select('products.*')
        ->where('products.id_product',$id_product)
        ->first();
    }



}
