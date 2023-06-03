<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Expense extends Model
{
    
    protected $table = 'expenses';
    protected $primaryKey = 'id_expense';
   
    public static function ListAll($from,$to,$search){
        $search = urldecode($search);
        return DB::table('expenses')
        ->join('type_expenses','type_expenses.id_type_expense','expenses.id_type_expense')
        ->join('users','users.id_user','expenses.id_user')
        ->select('expenses.*','type_expenses.name as type_expense_name','users.user')
        ->where('expenses.state','<>',9)
        ->whereBetween('expenses.date',[$from,$to])
        ->where(function ($query) use ($search) {
            if(!empty($search) && $search != "all"){
                $query = $query->orWhere('type_expenses.name','like',"%$search%");
                $query = $query->orWhere('expenses.code','like',"%$search%");
                $query = $query->orWhere('expenses.date','like',"%$search%");
            }
        })
        ->orderBy("expenses.id_expense","DESC")
        ->paginate(15);
    }

    public static function GetById($id_expense){
        return DB::table('expenses')
        ->join('type_expenses','type_expenses.id_type_expense','expenses.id_type_expense')
        ->join('users','users.id_user','expenses.id_user')
        ->select('expenses.*','type_expenses.name as type_expense_name','users.user')
        ->where('expenses.id_expense',$id_expense)
        ->first();
    }


    public static function TotalExpense($year,$month,$coin){
        $result = DB::table('expenses')
        ->join('type_expenses','type_expenses.id_type_expense','expenses.id_type_expense')
        ->join('users','users.id_user','expenses.id_user')
        ->select('expenses.*','type_expenses.name as type_expense_name','users.user')
        ->where('expenses.state',1)
        ->where('expenses.year',$year)
        ->where('expenses.month',$month)
        ->orderBy("expenses.id_expense","DESC")
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
        $result = DB::table('expenses')
        ->join('type_expenses','type_expenses.id_type_expense','expenses.id_type_expense')
        ->join('users','users.id_user','expenses.id_user')
        ->select('expenses.*','type_expenses.name as type_expense_name','users.user')
        ->where('expenses.state',1)
        ->where('expenses.year',$year)
        ->where('expenses.month',$month)
        ->orderBy("expenses.id_expense","DESC")
        ->get();
        return $result;
    }
}
