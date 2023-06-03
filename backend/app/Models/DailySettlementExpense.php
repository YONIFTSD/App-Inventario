<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class DailySettlementExpense extends Model
{
    
    protected $table = 'daily_settlement_expenses';
    protected $primaryKey = 'id_expense';
   
    public static function ListAll($from,$to,$search){
        $search = urldecode($search);
        return DB::table('daily_settlement_expenses')
        ->join('users','users.id_user','daily_settlement_expenses.id_user')
        ->select('daily_settlement_expenses.*','users.user')
        ->where('daily_settlement_expenses.state','<>',9)
        ->whereBetween('daily_settlement_expenses.date',[$from,$to])
        ->where(function ($query) use ($search) {
            if(!empty($search) && $search != "all"){
                $query = $query->orWhere('daily_settlement_expenses.description','like',"%$search%");
                $query = $query->orWhere('daily_settlement_expenses.code','like',"%$search%");
                $query = $query->orWhere('daily_settlement_expenses.date','like',"%$search%");
            }
        })
        ->orderBy("daily_settlement_expenses.id_expense","DESC")
        ->paginate(15);
    }

    public static function GetById($id_expense){
        return DB::table('daily_settlement_expenses')
        ->join('users','users.id_user','daily_settlement_expenses.id_user')
        ->select('daily_settlement_expenses.*','users.user')
        ->where('daily_settlement_expenses.id_expense',$id_expense)
        ->first();
    }

    public static function TotalExpense($year,$month,$coin){
        
        $result = DB::table('daily_settlement_expenses')
        ->join('users','users.id_user','daily_settlement_expenses.id_user')
        ->select('daily_settlement_expenses.*','users.user')
        ->where('daily_settlement_expenses.state',1)
        ->where('daily_settlement_expenses.year',$year)
        ->where('daily_settlement_expenses.month',$month)
        ->orderBy("daily_settlement_expenses.id_expense","DESC")
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
        
        $result = DB::table('daily_settlement_expenses')
        ->join('users','users.id_user','daily_settlement_expenses.id_user')
        ->select('daily_settlement_expenses.*','users.user')
        ->where('daily_settlement_expenses.state',1)
        ->where('daily_settlement_expenses.year',$year)
        ->where('daily_settlement_expenses.month',$month)
        ->orderBy("daily_settlement_expenses.id_expense","DESC")
        ->get();
        return $result;
    }
}
