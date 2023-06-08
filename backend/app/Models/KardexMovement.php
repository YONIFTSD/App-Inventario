<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class KardexMovement extends Model
{

    protected $table = 'kardex_movement';
    protected $primaryKey = 'id_kardex';

    public static function ListAll($search){
        $search = urldecode($search);
        return DB::table('purchases_detail')
        ->join('categories','categories.id_category','purchases_detail.id_category')
        ->select('purchases_detail.*','categories.name as category_name')
        ->where('purchases_detail.state','<>',9)
        ->where(function ($query) use ($search) {
            if(!empty($search) && $search != "all"){
                $query = $query->orWhere('categories.name','like',"%$search%");
                $query = $query->orWhere('purchases_detail.name','like',"%$search%");
                $query = $query->orWhere('purchases_detail.code','like',"%$search%");
            }
        })
        ->orderBy("purchases_detail.id_purchase_detail","DESC")
        ->paginate(15);
    }

    public static function Search($search){
        $search = urldecode($search);
        return DB::table('purchases_detail')
        ->join('categories','categories.id_category','purchases_detail.id_category')
        ->select('purchases_detail.*','categories.name as category_name')
        ->where('purchases_detail.state','<>',9)
        ->where(function ($query) use ($search) {
            if(!empty($search) && $search != "all"){
                $query = $query->orWhere('categories.name','like',"%$search%");
                $query = $query->orWhere('purchases_detail.name','like',"%$search%");
                $query = $query->orWhere('purchases_detail.code','like',"%$search%");
            }
        })
        ->orderBy("purchases_detail.id_purchase_detail","DESC")
        ->limit(15)
        ->get();
    }

    public static function GetById($id_purchase_detail){
        return DB::table('purchases_detail')
        ->select('purchases_detail.*')
        ->where('purchases_detail.id_purchase_detail',$id_purchase_detail)
        ->first();
    }



}
