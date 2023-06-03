<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class TypeExpense extends Model
{
    
    protected $table = 'type_expenses';
    protected $primaryKey = 'id_type_expense';

    public static function ListAll($search){
        $search = urldecode($search);
        return DB::table('type_expenses')
        ->select('type_expenses.*')
        ->where('type_expenses.state','<>',9)
        ->where(function ($query) use ($search) {
            if(!empty($search) && $search != "all"){
                $query = $query->orWhere('type_expenses.name','like',"%$search%");
            }
        })
        ->orderBy("type_expenses.id_type_expense","DESC")
        ->paginate(15);
    }

    public static function GetById($id_type_expense){
        return DB::table('type_expenses')
        ->select('type_expenses.*')
        ->where('type_expenses.id_type_expense',$id_type_expense)
        ->first();
    }
  
}
