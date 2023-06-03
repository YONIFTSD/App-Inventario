<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class ManagementExpense extends Model
{
    
    protected $table = 'management_expenses';
    protected $primaryKey = 'id_expense';
   
    public static function ListAll($from,$to,$search){
        $search = urldecode($search);
        return DB::table('management_expenses')
        ->join('users','users.id_user','management_expenses.id_user')
        ->select('management_expenses.*','users.user')
        ->where('management_expenses.state','<>',9)
        ->whereBetween('management_expenses.date',[$from,$to])
        ->where(function ($query) use ($search) {
            if(!empty($search) && $search != "all"){
                $query = $query->orWhere('management_expenses.description','like',"%$search%");
                $query = $query->orWhere('management_expenses.code','like',"%$search%");
                $query = $query->orWhere('management_expenses.date','like',"%$search%");
            }
        })
        ->orderBy("management_expenses.id_expense","DESC")
        ->paginate(15);
    }

    public static function GetById($id_expense){
        return DB::table('management_expenses')
        ->join('users','users.id_user','management_expenses.id_user')
        ->select('management_expenses.*','users.user')
        ->where('management_expenses.id_expense',$id_expense)
        ->first();
    }


    public static function TotalExpense($year,$month,$coin){
        $result =  DB::table('management_expenses')
        ->join('users','users.id_user','management_expenses.id_user')
        ->select('management_expenses.*','users.user')
        ->where('management_expenses.state',1)
        ->where('management_expenses.year',$year)
        ->where('management_expenses.month',$month)
        ->orderBy("management_expenses.id_expense","DESC")
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
        $result =  DB::table('management_expenses')
        ->join('users','users.id_user','management_expenses.id_user')
        ->select('management_expenses.*','users.user')
        ->where('management_expenses.state',1)
        ->where('management_expenses.year',$year)
        ->where('management_expenses.month',$month)
        ->orderBy("management_expenses.id_expense","DESC")
        ->get();
        return $result;
    }

}
