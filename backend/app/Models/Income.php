<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Income extends Model
{
    
    protected $table = 'incomes';
    protected $primaryKey = 'id_income';
   
    public static function ListAll($from,$to,$search){
        $search = urldecode($search);
        return DB::table('incomes')
        ->join('business','business.id_business','incomes.id_business')
        ->join('users','users.id_user','incomes.id_user')
        ->select('incomes.*','business.name as business_name','users.user')
        ->where('incomes.state','<>',9)
        ->whereBetween('incomes.date',[$from,$to])
        ->where(function ($query) use ($search) {
            if(!empty($search) && $search != "all"){
                $query = $query->orWhere('business.name','like',"%$search%");
                $query = $query->orWhere('incomes.code','like',"%$search%");
                $query = $query->orWhere('incomes.date','like',"%$search%");
            }
        })
        ->orderBy("incomes.id_income","DESC")
        ->paginate(15);
    }

    public static function GetById($id_income){
        return DB::table('incomes')
        ->join('business','business.id_business','incomes.id_business')
        ->join('users','users.id_user','incomes.id_user')
        ->select('incomes.*','business.name as business_name','users.user')
        ->where('incomes.id_income',$id_income)
        ->first();
    }


    public static function TotalIncome($year,$month,$coin){
        
        $result = DB::table('incomes')
        ->join('business','business.id_business','incomes.id_business')
        ->join('users','users.id_user','incomes.id_user')
        ->select('incomes.*','business.name as business_name','users.user')
        ->where('incomes.state',1)
        ->where('incomes.year',$year)
        ->where('incomes.month',$month)
        ->orderBy("incomes.id_income","DESC")
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
        
        $result = DB::table('incomes')
        ->join('business','business.id_business','incomes.id_business')
        ->join('users','users.id_user','incomes.id_user')
        ->select('incomes.*','business.name as description','users.user')
        ->where('incomes.state',1)
        ->where('incomes.year',$year)
        ->where('incomes.month',$month)
        ->orderBy("incomes.id_income","DESC")
        ->get();

        return $result;
    }

}
