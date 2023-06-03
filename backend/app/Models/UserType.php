<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class UserType extends Model
{
    
    protected $table = 'user_type';
    protected $primaryKey = 'id_user_type';

    public static function ListAll($search){
        $search = urldecode($search);
        return DB::table('user_type')
        ->select('user_type.*')
        ->where('user_type.state','<>',9)
        ->where(function ($query) use ($search) {
            if(!empty($search) && $search != "all"){
                $query = $query->orWhere('user_type.name','like',"%$search%");
            }
        })
        ->orderBy("user_type.id_user_type","DESC")
        ->paginate(15);
    }

    public static function GetById($id_user_type){
        return DB::table('user_type')
        ->select('user_type.*')
        ->where('user_type.id_user_type',$id_user_type)
        ->first();
    }
  
}
