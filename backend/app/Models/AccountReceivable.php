<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class AccountReceivable extends Model
{
    
    protected $table = 'accounts_receivable';
    protected $primaryKey = 'id_account_receivable';
   
    public static function ListAll($state,$search){
        $search = urldecode($search);
        return DB::table('accounts_receivable')
        ->join('clients','clients.id_client','accounts_receivable.id_client')
        ->join('users','users.id_user','accounts_receivable.id_user')
        ->select('accounts_receivable.*','clients.document_number','clients.name','users.user')
        ->where('accounts_receivable.state','<>',9)
        // ->whereBetween('accounts_receivable.broadcast_date',[$from,$to])
        ->where(function ($query) use ($search,$state) {
            if(!empty($search) && $search != "all"){
                $query = $query->orWhere('clients.document_number','like',"%$search%");
                $query = $query->orWhere('clients.name','like',"%$search%");
                $query = $query->orWhere('accounts_receivable.reference','like',"%$search%");
                $query = $query->orWhere('accounts_receivable.total','like',"%$search%");
                $query = $query->orWhere('accounts_receivable.broadcast_date','like',"%$search%");
            }
            if(!empty($state) && $state != "all"){
                $query = $query->where('accounts_receivable.state',$state);
            }
        })
        ->orderBy("accounts_receivable.expirate_date","DESC")
        ->paginate(15);
    }

    public static function GetById($id_account_receivable){
        return DB::table('accounts_receivable')
        ->join('clients','clients.id_client','accounts_receivable.id_client')
        ->join('users','users.id_user','accounts_receivable.id_user')
        ->select('accounts_receivable.*','clients.document_number','clients.name','users.user')
        ->where('accounts_receivable.id_account_receivable',$id_account_receivable)
        ->first();
    }

}
