<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class ManagementIncome extends Model
{
    
    protected $table = 'management_incomes';
    protected $primaryKey = 'id_income';
   
    public static function ListAll($from,$to,$search){
        $search = urldecode($search);
        return DB::table('management_incomes')
        ->join('type_income_management','type_income_management.id_type_income','management_incomes.id_type_income')
        ->join('users','users.id_user','management_incomes.id_user')
        ->select('management_incomes.*','type_income_management.name as description','users.user')
        ->where('management_incomes.state','<>',9)
        ->whereBetween('management_incomes.date',[$from,$to])
        ->where(function ($query) use ($search) {
            if(!empty($search) && $search != "all"){
                $query = $query->orWhere('type_income_management.name','like',"%$search%");
                $query = $query->orWhere('management_incomes.code','like',"%$search%");
                $query = $query->orWhere('management_incomes.date','like',"%$search%");
            }
        })
        ->orderBy("management_incomes.id_income","DESC")
        ->paginate(15);
    }

    public static function GetById($id_income){
        return DB::table('management_incomes')
        ->join('users','users.id_user','management_incomes.id_user')
        ->select('management_incomes.*','users.user')
        ->where('management_incomes.id_income',$id_income)
        ->first();
    }


    public static function TotalIncome($year,$month,$coin){

        $result = DB::table('management_incomes')
        ->join('type_income_management','type_income_management.id_type_income','management_incomes.id_type_income')
        ->join('users','users.id_user','management_incomes.id_user')
        ->select('management_incomes.*','type_income_management.name as description','users.user')
        ->where('management_incomes.state',1)
        ->where('management_incomes.year',$year)
        ->where('management_incomes.month',$month)
        ->orderBy("management_incomes.id_income","DESC")
        ->get();

        $total = 0;
        foreach ($result as $be) {
            if ($coin == "PEN") {
                $total += $be->total_pen;
            }
            if ($coin == "USD") {
                $total += $be->total_usd;
            }
        }

        return $total;
    }


    public static function MonthIncome($year,$month){

        $result = DB::table('management_incomes')
        ->join('type_income_management','type_income_management.id_type_income','management_incomes.id_type_income')
        ->join('users','users.id_user','management_incomes.id_user')
        ->select('management_incomes.*','type_income_management.name as description','users.user')
        ->where('management_incomes.state',1)
        ->where('management_incomes.year',$year)
        ->where('management_incomes.month',$month)
        ->orderBy("management_incomes.id_income","DESC")
        ->get();

        return $result;
    }


    public static function GetBalanceByMonth($year,$month){

        $total_balance_pen = 0;
        $total_balance_usd = 0;
        
        $date = Carbon::parse($year."-".$month);
        $date = $date->subMonth();
        //PEN
        $total_income = DailySettlementIncome::TotalIncome($date->format('Y'), $date->format('m'),'PEN');
        $total_expense = DailySettlementExpense::TotalExpense($date->format('Y'), $date->format('m'),'PEN');
        $total_utility = $total_income - $total_expense;
        $total_balance_pen += $total_utility;
  
        //USD
        $total_income = DailySettlementIncome::TotalIncome($date->format('Y'), $date->format('m'),'USD');
        $total_expense = DailySettlementExpense::TotalExpense($date->format('Y'), $date->format('m'),'USD');
        $total_utility = $total_income - $total_expense;
        $total_balance_usd += $total_utility;
          
        $total_balance_pen = number_format($total_balance_pen,2,'.','');
        $total_balance_usd = number_format($total_balance_usd,2,'.','');
        return array('total_balance_pen' => $total_balance_pen, 'total_balance_usd' => $total_balance_usd);

    
    }
}
