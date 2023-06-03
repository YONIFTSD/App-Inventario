<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class AccountReceivablePayment extends Model
{
    
    protected $table = 'accounts_receivable_payment';
    protected $primaryKey = 'id_account_receivable_payment';
   
    public static function ListAll($id_account_receivable){
        return DB::table('accounts_receivable_payment')
        ->join('users','users.id_user','accounts_receivable_payment.id_user')
        ->select('accounts_receivable_payment.*','users.user')
        ->where('accounts_receivable_payment.state','<>',9)
        ->where('accounts_receivable_payment.id_account_receivable',$id_account_receivable)
        ->orderBy("accounts_receivable_payment.id_account_receivable_payment","DESC")
        ->get();
    }

    public static function GetById($id_account_receivable_payment){
        return DB::table('accounts_receivable_payment')
        ->select('accounts_receivable_payment.*')
        ->where('accounts_receivable_payment.id_account_receivable_payment',$id_account_receivable_payment)
        ->first();
    }

    public static function TotalIncome($year,$month,$coin){
        $result = DB::table('accounts_receivable_payment')
        ->join('accounts_receivable','accounts_receivable.id_account_receivable','accounts_receivable_payment.id_account_receivable')
        ->join('users','users.id_user','accounts_receivable_payment.id_user')
        ->select('accounts_receivable_payment.*','users.user','accounts_receivable.exchange_rate','accounts_receivable.coin')
        ->where('accounts_receivable_payment.state',1)
        ->where('accounts_receivable.state','<>',9)
        ->where(DB::raw("DATE_FORMAT(accounts_receivable_payment.payment_date, '%m')"),$month)
        ->where(DB::raw("DATE_FORMAT(accounts_receivable_payment.payment_date, '%Y')"),$year)
        ->orderBy("accounts_receivable_payment.id_account_receivable_payment","DESC")
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


    public static function MonthIncome($year,$month){
        $result = DB::table('accounts_receivable_payment')
        ->join('accounts_receivable','accounts_receivable.id_account_receivable','accounts_receivable_payment.id_account_receivable')
        ->join('clients','clients.id_client','accounts_receivable.id_client')
        ->join('users','users.id_user','accounts_receivable_payment.id_user')
        ->select('accounts_receivable_payment.*','users.user','accounts_receivable.exchange_rate','accounts_receivable.coin','clients.name')
        ->where('accounts_receivable_payment.state',1)
        ->where('accounts_receivable.state','<>',9)
        ->where(DB::raw("DATE_FORMAT(accounts_receivable_payment.payment_date, '%m')"),$month)
        ->where(DB::raw("DATE_FORMAT(accounts_receivable_payment.payment_date, '%Y')"),$year)
        ->orderBy("accounts_receivable_payment.id_account_receivable_payment","DESC")
        ->get();
        return $result;
    }

}
