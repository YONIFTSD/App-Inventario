<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Category extends Model
{

    protected $table = 'categories';
    protected $primaryKey = 'id_category';

    public static function ListAll($search){
        $search = urldecode($search);
        return DB::table('categories')
        ->select('categories.*')
        ->where('categories.state','<>',9)
        ->where(function ($query) use ($search) {
            if(!empty($search) && $search != "all"){
                $query = $query->orWhere('categories.name','like',"%$search%");
            }
        })
        ->orderBy("categories.id_category","DESC")
        ->paginate(15);
    }

    public static function GetById($id_category){
        return DB::table('categories')
        ->select('categories.*')
        ->where('categories.id_category',$id_category)
        ->first();
    }

}
