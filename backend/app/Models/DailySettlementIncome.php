<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class DailySettlementIncome extends Model
{
    
    protected $table = 'daily_settlement_incomes';
    protected $primaryKey = 'id_income';
   
    public static function ListAll($from,$to,$search){
        $search = urldecode($search);
        return DB::table('daily_settlement_incomes')
        ->join('business','business.id_business','daily_settlement_incomes.id_business')
        ->join('users','users.id_user','daily_settlement_incomes.id_user')
        ->select('daily_settlement_incomes.*','business.name as business_name','users.user')
        ->where('daily_settlement_incomes.state','<>',9)
        ->whereBetween('daily_settlement_incomes.date',[$from,$to])
        ->where(function ($query) use ($search) {
            if(!empty($search) && $search != "all"){
                $query = $query->orWhere('business.name','like',"%$search%");
                $query = $query->orWhere('daily_settlement_incomes.code','like',"%$search%");
                $query = $query->orWhere('daily_settlement_incomes.date','like',"%$search%");
            }
        })
        ->orderBy("daily_settlement_incomes.id_income","DESC")
        ->paginate(15);
    }

    public static function GetById($id_income){
        return DB::table('daily_settlement_incomes')
        ->join('business','business.id_business','daily_settlement_incomes.id_business')
        ->join('users','users.id_user','daily_settlement_incomes.id_user')
        ->select('daily_settlement_incomes.*','business.name as business_name','users.user')
        ->where('daily_settlement_incomes.id_income',$id_income)
        ->first();
    }

    public static function TotalIncome($year,$month,$coin){

        $result = DB::table('daily_settlement_incomes')
        ->join('business','business.id_business','daily_settlement_incomes.id_business')
        ->join('users','users.id_user','daily_settlement_incomes.id_user')
        ->select('daily_settlement_incomes.*','business.name as business_name','users.user')
        ->where('daily_settlement_incomes.state',1)
        ->where('daily_settlement_incomes.year',$year)
        ->where('daily_settlement_incomes.month',$month)
        ->orderBy("daily_settlement_incomes.id_income","DESC")
        ->get();

        $total = 0;
        foreach ($result as $be) {
            if ($coin == "PEN") {
                $total += $be->counted_total_pen;
            }
            if ($coin == "USD") {
                $total += $be->counted_total_usd;
            }
        }

        return $total;
    }

    public static function MonthIncome($year,$month){

        $result = DB::table('daily_settlement_incomes')
        ->join('business','business.id_business','daily_settlement_incomes.id_business')
        ->join('users','users.id_user','daily_settlement_incomes.id_user')
        ->select('daily_settlement_incomes.*','business.name as business_name','users.user')
        ->where('daily_settlement_incomes.state',1)
        ->where('daily_settlement_incomes.year',$year)
        ->where('daily_settlement_incomes.month',$month)
        ->orderBy("daily_settlement_incomes.id_income","DESC")
        ->get();
        $incomes = array();
        $index = 1;
        foreach ($result as $be) {
            array_push($incomes, array(
                'index' => $index,
                'type' => 1,
                'year' => $be->year,
                'description' => $be->business_name,
                'month' => $be->month,
                'total_pen' => $be->total_pen,
                'total_usd' => $be->total_usd,
            ));


            array_push($incomes, array(
                'index' => '',
                'type' => 2,
                'year' => '',
                'description' => "Venta en Efectivo",
                'month' => '',
                'total_pen' => $be->counted_total_pen,
                'total_usd' => $be->counted_total_usd,
            ));

            array_push($incomes, array(
                'index' => '',
                'type' => 3,
                'year' => '',
                'description' =>"Venta en Tarjeta",
                'month' => '',
                'total_pen' => $be->credit_total_pen,
                'total_usd' => $be->credit_total_usd,
            ));
            $index++;
        }

        return $incomes;
    }

}
