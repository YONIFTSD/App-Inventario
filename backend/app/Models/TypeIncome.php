<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class TypeIncome extends Model
{
    
    protected $table = 'type_income_management';
    protected $primaryKey = 'id_type_income';

    public static function ListAll($search){
        $search = urldecode($search);
        return DB::table('type_income_management')
        ->select('type_income_management.*')
        ->where('type_income_management.state','<>',9)
        ->where(function ($query) use ($search) {
            if(!empty($search) && $search != "all"){
                $query = $query->orWhere('type_income_management.name','like',"%$search%");
            }
        })
        ->orderBy("type_income_management.id_type_income","DESC")
        ->paginate(15);
    }

    public static function GetById($id_type_income){
        return DB::table('type_income_management')
        ->select('type_income_management.*')
        ->where('type_income_management.id_type_income',$id_type_income)
        ->first();
    }
  
}
