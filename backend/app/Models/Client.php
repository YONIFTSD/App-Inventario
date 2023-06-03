<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Client extends Model
{
    
    protected $table = 'clients';
    protected $primaryKey = 'id_client';
   
    public static function ListAll($search){
        $search = urldecode($search);
        return DB::table('clients')
        ->select('clients.*')
        ->where('clients.state','<>',9)
        ->where(function ($query) use ($search) {
            if(!empty($search) && $search != "all"){
                $query = $query->orWhere('clients.document_number','like',"%$search%");
                $query = $query->orWhere('clients.name','like',"%$search%");
                $query = $query->orWhere('clients.email','like',"%$search%");
                $query = $query->orWhere('clients.phone','like',"%$search%");
            }
        })
        ->orderBy("clients.id_client","DESC")
        ->paginate(15);
    }

    public static function GetById($id_client){
        return DB::table('clients')
        ->select('clients.*')
        ->where('clients.id_client',$id_client)
        ->first();
    }

    public static function SearchSelect($search){
        $search = urldecode($search);
        return DB::table('clients')
        ->select('clients.id_client','clients.document_number','clients.name')
        ->where(function ($query) use ($search) {
            if(!empty($search)){
                $query = $query->orWhere('clients.document_number','like',"%$search%");
                $query = $query->orWhere('clients.name','like',"%$search%");
            }
        })
        ->where('state',1)
        ->limit(10)
        ->get();
    }

}
