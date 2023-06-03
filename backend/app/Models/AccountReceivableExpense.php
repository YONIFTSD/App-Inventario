<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class AccountReceivableExpense extends Model
{
    
    protected $table = 'accounts_receivable_expenses';
    protected $primaryKey = 'id_expense';
   
    public static function ListAll($from,$to,$search){
        $search = urldecode($search);
        return DB::table('accounts_receivable_expenses')
        ->join('users','users.id_user','accounts_receivable_expenses.id_user')
        ->select('accounts_receivable_expenses.*','users.user')
        ->where('accounts_receivable_expenses.state','<>',9)
        ->whereBetween('accounts_receivable_expenses.date',[$from,$to])
        ->where(function ($query) use ($search) {
            if(!empty($search) && $search != "all"){
                $query = $query->orWhere('accounts_receivable_expenses.description','like',"%$search%");
                $query = $query->orWhere('accounts_receivable_expenses.code','like',"%$search%");
                $query = $query->orWhere('accounts_receivable_expenses.date','like',"%$search%");
            }
        })
        ->orderBy("accounts_receivable_expenses.id_expense","DESC")
        ->paginate(15);
    }

    public static function GetById($id_expense){
        return DB::table('accounts_receivable_expenses')
        ->join('users','users.id_user','accounts_receivable_expenses.id_user')
        ->select('accounts_receivable_expenses.*','users.user')
        ->where('accounts_receivable_expenses.id_expense',$id_expense)
        ->first();
    }




    public static function TotalExpense($year,$month,$coin){

        $result = DB::table('accounts_receivable_expenses')
        ->join('users','users.id_user','accounts_receivable_expenses.id_user')
        ->select('accounts_receivable_expenses.*','users.user')
        ->where('accounts_receivable_expenses.state',1)
        ->where('accounts_receivable_expenses.year',$year)
        ->where('accounts_receivable_expenses.month',$month)
        ->orderBy("accounts_receivable_expenses.id_expense","DESC")
        ->get();

        $total = 0;
        foreach ($result as $be) {
            if ($coin == "PEN") {
                if ($be->coin == "USD") {
                    $be->total = $be->total * $be->exchange_rate;
                }
            }
            if ($coin == "USD") {
                if ($be->coin == "PEN") {
                    $be->total = $be->total / $be->exchange_rate;
                }
            }

            $total += $be->total;
        }

        return $total;

    }


    public static function MonthExpense($year,$month){

        $result = DB::table('accounts_receivable_expenses')
        ->join('users','users.id_user','accounts_receivable_expenses.id_user')
        ->select('accounts_receivable_expenses.*','users.user')
        ->where('accounts_receivable_expenses.state',1)
        ->where('accounts_receivable_expenses.year',$year)
        ->where('accounts_receivable_expenses.month',$month)
        ->orderBy("accounts_receivable_expenses.id_expense","DESC")
        ->get();

        return $result;

    }

}
