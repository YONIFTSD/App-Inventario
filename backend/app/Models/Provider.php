<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Provider extends Model
{

    protected $table = 'providers';
    protected $primaryKey = 'id_provider';

    public static function ListAll($search){
        $search = urldecode($search);
        return DB::table('providers')
        ->select('providers.*')
        ->where('providers.state','<>',9)
        ->where(function ($query) use ($search) {
            if(!empty($search) && $search != "all"){
                $query = $query->orWhere('providers.document_number','like',"%$search%");
                $query = $query->orWhere('providers.name','like',"%$search%");
                $query = $query->orWhere('providers.email','like',"%$search%");
                $query = $query->orWhere('providers.phone','like',"%$search%");
            }
        })
        ->orderBy("providers.id_provider","DESC")
        ->paginate(15);
    }

    public static function GetById($id_provider){
        return DB::table('providers')
        ->select('providers.*')
        ->where('providers.id_provider',$id_provider)
        ->first();
    }

    public static function SearchSelect($search){
        $search = urldecode($search);
        return DB::table('providers')
        ->select('providers.id_provider','providers.document_number','providers.name')
        ->where(function ($query) use ($search) {
            if(!empty($search)){
                $query = $query->orWhere('providers.document_number','like',"%$search%");
                $query = $query->orWhere('providers.name','like',"%$search%");
            }
        })
        ->where('state',1)
        ->limit(10)
        ->get();
    }

}
