<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Audit extends Model
{
    
    protected $table = 'audit';
    protected $primaryKey = 'id_audit';
   
    public static function ListAll($from,$to,$id_user,$search){
        $search = urldecode($search);
        return DB::table('audit')
        ->join('users','users.id_user','audit.id_user')
        ->select('audit.*','users.user')
        ->where('audit.state','<>',9)
        ->whereBetween('audit.registration_date',[$from,$to])
        ->where(function ($query) use ($search,$id_user) {
            if(!empty($search) && $search != "all"){
                $query = $query->orWhere('users.module','like',"%$search%");
                $query = $query->orWhere('audit.process','like',"%$search%");
                $query = $query->orWhere('audit.data','like',"%$search%");
            }
            if(!empty($id_user) && $id_user != "all"){
                $query = $query->orWhere('audit.id_user',$id_user);
            }
        })
        ->orderBy("audit.id_audit","DESC")
        ->paginate(30);
    }

    public static function GetById($id_audit){
        return DB::table('audit')
        ->join('users','users.id_user','audit.id_user')
        ->select('audit.*','users.user')
        ->where('audit.id_audit',$id_audit)
        ->first();
    }
}
