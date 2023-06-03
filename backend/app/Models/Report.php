<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Report extends Model
{


    public static function UtilityDailySettlement($from,$to,$coin){
        
        $income = array();
        $expense = array();
        $balance = array();
        $balance_final = array();
        $total_balance = 0;
        $title = array();
    
        $from = Carbon::parse($from);
        $to = Carbon::parse($to);
        $months = $to->floatDiffInMonths($from);
        for ($i=1; $i <= $months + 1; $i++) {    
            array_push($title, DataManager::NameMonth($from->format('m')));

            $total_income = DailySettlementIncome::TotalIncome($from->format('Y'), $from->format('m'),$coin);
            $total_expense = DailySettlementExpense::TotalExpense($from->format('Y'), $from->format('m'),$coin);
            
            $total_utility = $total_income - $total_expense;
            $total_balance += $total_utility;
            array_push($income,number_format($total_income,2,'.',''));
            array_push($expense,number_format($total_expense,2,'.',''));
            array_push($balance,number_format($total_utility,2,'.',''));
            array_push($balance_final,number_format($total_balance,2,'.',''));

            $from = $from->addMonth();

        }
        
        return array('title' => $title, 'income' => $income,'expense' => $expense, 'balance' => $balance, 'balance_final' => $balance_final);

    
    }

    public static function UtilityManagement($from,$to,$coin){

        $income = array();
        $expense = array();
        $balance = array();
        $balance_final = array();
        $total_balance = 0;
        $title = array();
    
        $from = Carbon::parse($from);
        $to = Carbon::parse($to);
        $months = $to->floatDiffInMonths($from);
        for ($i=1; $i <= $months + 1; $i++) {    
            array_push($title, DataManager::NameMonth($from->format('m')));

            $total_income = ManagementIncome::TotalIncome($from->format('Y'), $from->format('m'),$coin);
            $total_expense = ManagementExpense::TotalExpense($from->format('Y'), $from->format('m'),$coin);
            
            $total_utility = $total_income - $total_expense;
            $total_balance += $total_utility;
            array_push($income,number_format($total_income,2,'.',''));
            array_push($expense,number_format($total_expense,2,'.',''));
            array_push($balance,number_format($total_utility,2,'.',''));
            array_push($balance_final,number_format($total_balance,2,'.',''));

            $from = $from->addMonth();

        }
        
        return array('title' => $title, 'income' => $income,'expense' => $expense, 'balance' => $balance, 'balance_final' => $balance_final);

    
    }

    public static function UtilityAccountReceivable($from,$to,$coin){
        
        $income = array();
        $expense = array();
        $balance = array();
        $balance_final = array();
        $total_balance = 0;
        $title = array();
    
        $from = Carbon::parse($from);
        $to = Carbon::parse($to);
        $months = $to->floatDiffInMonths($from);
        for ($i=1; $i <= $months + 1; $i++) {    
            array_push($title, DataManager::NameMonth($from->format('m')));

            $total_income = AccountReceivablePayment::TotalIncome($from->format('Y'), $from->format('m'),$coin);
            $total_expense = AccountReceivableExpense::TotalExpense($from->format('Y'), $from->format('m'),$coin);
            
            $total_utility = $total_income - $total_expense;
            $total_balance += $total_utility;
            array_push($income,number_format($total_income,2,'.',''));
            array_push($expense,number_format($total_expense,2,'.',''));
            array_push($balance,number_format($total_utility,2,'.',''));
            array_push($balance_final,number_format($total_balance,2,'.',''));

            $from = $from->addMonth();

        }
        
        return array('title' => $title, 'income' => $income,'expense' => $expense, 'balance' => $balance, 'balance_final' => $balance_final);

    
    }

    public static function Utility($from,$to,$coin){

        $income = array();
        $expense = array();
        $balance = array();
        $balance_final = array();
        $total_balance = 0;
        $title = array();
    
        $from = Carbon::parse($from);
        $to = Carbon::parse($to);
        $months = $to->floatDiffInMonths($from);
        for ($i=1; $i <= $months + 1; $i++) {    
            array_push($title, DataManager::NameMonth($from->format('m')));

            $total_income = Income::TotalIncome($from->format('Y'), $from->format('m'),$coin);
            $total_expense = Expense::TotalExpense($from->format('Y'), $from->format('m'),$coin);
            
            $total_utility = $total_income - $total_expense;
            $total_balance += $total_utility;
            array_push($income,number_format($total_income,2,'.',''));
            array_push($expense,number_format($total_expense,2,'.',''));
            array_push($balance,number_format($total_utility,2,'.',''));
            array_push($balance_final,number_format($total_balance,2,'.',''));

            $from = $from->addMonth();

        }
        
        return array('title' => $title, 'income' => $income,'expense' => $expense, 'balance' => $balance, 'balance_final' => $balance_final);

    
    }
    



    public static function MonthUtilityDailySettlement($month){
        
        $total['income_pen'] = 0;
        $total['income_usd'] = 0;
        $total['income_counted_pen'] = 0;
        $total['income_counted_usd'] = 0;
        $total['expense_pen'] = 0;
        $total['expense_usd'] = 0;
        $total['income_counted_pen'] = 0;
        $total['income_counted_usd'] = 0;
        $total['balance_pen'] = 0;
        $total['balance_usd'] = 0;
        
        

        $detail_income = array();
        $detail_expense = array();
        $date = Carbon::parse($month);
        $incomes = DailySettlementIncome::MonthIncome($date->format('Y'), $date->format('m'));

        for ($i=0; $i < count($incomes); $i++) { 
            if ($incomes[$i]['type'] == 1) {
                $total['income_pen'] += $incomes[$i]['total_pen'];
                $total['income_usd'] += $incomes[$i]['total_usd'];
            }
            if ($incomes[$i]['type'] == 2) {
                $total['income_counted_pen'] += $incomes[$i]['total_pen'];
                $total['income_counted_usd'] += $incomes[$i]['total_usd'];
            }
            array_push($detail_income,array(
                'index' => $incomes[$i]['index'],
                'type' => $incomes[$i]['type'],
                'year' => $incomes[$i]['year'],
                'month' => DataManager::NameMonth($incomes[$i]['month']),
                'description' => $incomes[$i]['description'],
                'total_usd' => $incomes[$i]['total_usd'],
                'total_pen' => $incomes[$i]['total_pen'],
            ));
        }

        $expenses = DailySettlementExpense::MonthExpense($date->format('Y'), $date->format('m'));
        foreach ($expenses as $be) {
            $total_pen =  $be->coin == "PEN" ? $be->total :  $be->total * $be->exchange_rate;
            $total_usd =  $be->coin == "USD" ? $be->total :  $be->total / $be->exchange_rate;
            $total['expense_pen'] += $total_pen;
            $total['expense_usd'] += $total_usd;
            array_push($detail_expense,array(
                'year' => $be->year,
                'month' => DataManager::NameMonth($be->month),
                'description' => $be->description,
                'total_usd' => number_format($total_usd,2,'.',''),
                'total_pen' => number_format($total_pen,2,'.',''),
            ));
        }

        $total['balance_pen'] = $total['income_counted_pen'] - $total['expense_pen'];
        $total['balance_usd'] = $total['income_counted_usd'] - $total['expense_usd'];

        $total['income_pen'] = number_format($total['income_pen'],2,'.','');
        $total['income_usd'] = number_format($total['income_usd'],2,'.','');
        $total['income_counted_pen'] = number_format($total['income_counted_pen'],2,'.','');
        $total['income_counted_usd'] = number_format($total['income_counted_usd'],2,'.','');
        $total['expense_pen'] = number_format($total['expense_pen'],2,'.','');
        $total['expense_usd'] = number_format($total['expense_usd'],2,'.','');
        $total['balance_pen'] = number_format($total['balance_pen'],2,'.','');
        $total['balance_usd'] = number_format($total['balance_usd'],2,'.','');

        return array('total' => $total, 'detail_income' => $detail_income, 'detail_expense' => $detail_expense);


       
    
    }

    public static function MonthUtilityManagement($month){
        
        $total['income_pen'] = 0;
        $total['income_usd'] = 0;
        $total['expense_pen'] = 0;
        $total['expense_usd'] = 0;
        $total['balance_pen'] = 0;
        $total['balance_usd'] = 0;

        $detail_income = array();
        $detail_expense = array();
        $date = Carbon::parse($month);

        $date_accumalted = Carbon::parse($month);
        $date_accumalted = $date_accumalted->subMonth();
        $date_accumalted = $date_accumalted->format('Y')."-".$date_accumalted->format('m');
        
        $accumulated_pen = Report::UtilityManagementAccumulated($date_accumalted,'PEN');
        $accumulated_usd = Report::UtilityManagementAccumulated($date_accumalted,'USD');
    
        //saldo anterior
        array_push($detail_income,array(
            'year' => '',
            'month' => '',
            'description' => 'Saldo Acumulado',
            'total_usd' => number_format($accumulated_usd,2,'.',''),
            'total_pen' => number_format($accumulated_pen,2,'.',''),
        ));
        $total['income_pen'] += $accumulated_pen;
        $total['income_usd'] += $accumulated_usd;

        $incomes = ManagementIncome::MonthIncome($date->format('Y'), $date->format('m'));
        foreach ($incomes as $be) {
            $total_pen =  $be->total_pen;
            $total_usd =  $be->total_usd;

            $total['income_pen'] += $total_pen;
            $total['income_usd'] += $total_usd;
            array_push($detail_income,array(
                'year' => $be->year,
                'month' => DataManager::NameMonth($be->month),
                'description' => $be->description,
                'total_usd' => number_format($total_usd,2,'.',''),
                'total_pen' => number_format($total_pen,2,'.',''),
            ));
        }

        $expenses = ManagementExpense::MonthExpense($date->format('Y'), $date->format('m'));
        foreach ($expenses as $be) {
            $total_pen =  $be->coin == "PEN" ? $be->total :  $be->total * $be->exchange_rate;
            $total_usd =  $be->coin == "USD" ? $be->total :  $be->total / $be->exchange_rate;
            $total['expense_pen'] += $total_pen;
            $total['expense_usd'] += $total_usd;
            array_push($detail_expense,array(
                'year' => $be->year,
                'month' => DataManager::NameMonth($be->month),
                'description' => $be->description,
                'total_usd' => number_format($total_usd,2,'.',''),
                'total_pen' => number_format($total_pen,2,'.',''),
            ));
        }

        $total['balance_pen'] = $total['income_pen'] - $total['expense_pen'];
        $total['balance_usd'] = $total['income_usd'] - $total['expense_usd'];

        $total['income_pen'] = number_format($total['income_pen'],2,'.','');
        $total['income_usd'] = number_format($total['income_usd'],2,'.','');
        $total['expense_pen'] = number_format($total['expense_pen'],2,'.','');
        $total['expense_usd'] = number_format($total['expense_usd'],2,'.','');
        $total['balance_pen'] = number_format($total['balance_pen'],2,'.','');
        $total['balance_usd'] = number_format($total['balance_usd'],2,'.','');

        return array('total' => $total, 'detail_income' => $detail_income, 'detail_expense' => $detail_expense);


       
    
    }

    public static function MonthUtilityAccountReceivable($month){
        
        $total['income_pen'] = 0;
        $total['income_usd'] = 0;
        $total['expense_pen'] = 0;
        $total['expense_usd'] = 0;
        $total['balance_pen'] = 0;
        $total['balance_usd'] = 0;

        $detail_income = array();
        $detail_expense = array();
        $date = Carbon::parse($month);

        
        $date_accumalted = Carbon::parse($month);
        $date_accumalted = $date_accumalted->subMonth();
        $date_accumalted = $date_accumalted->format('Y')."-".$date_accumalted->format('m');
        
        $accumulated_pen = Report::UtilityAccountReceivableAccumulated($date_accumalted,'PEN');
        $accumulated_usd = Report::UtilityAccountReceivableAccumulated($date_accumalted,'USD');
    
        //saldo anterior
        array_push($detail_income,array(
            'year' => '',
            'month' => '',
            'description' => 'Saldo Acumulado',
            'total_usd' => number_format($accumulated_usd,2,'.',''),
            'total_pen' => number_format($accumulated_pen,2,'.',''),
        ));
        $total['income_pen'] += $accumulated_pen;
        $total['income_usd'] += $accumulated_usd;





        $incomes = AccountReceivablePayment::MonthIncome($date->format('Y'), $date->format('m'));
        foreach ($incomes as $be) {
            $total_pen =  $be->coin == "PEN" ? $be->total :  $be->total * $be->exchange_rate;
            $total_usd =  $be->coin == "USD" ? $be->total :  $be->total / $be->exchange_rate;

            $total['income_pen'] += $total_pen;
            $total['income_usd'] += $total_usd;
            $payment_date = Carbon::parse($be->payment_date);
            array_push($detail_income,array(
                'year' => $payment_date->format('Y'),
                'month' => DataManager::NameMonth($payment_date->format('m')),
                'description' => $be->name,
                'total_usd' => number_format($total_usd,2,',',''),
                'total_pen' => number_format($total_pen,2,',',''),
            ));
            
        }

        $expenses = AccountReceivableExpense::MonthExpense($date->format('Y'), $date->format('m'));
        foreach ($expenses as $be) {
            $total_pen =  $be->coin == "PEN" ? $be->total :  $be->total * $be->exchange_rate;
            $total_usd =  $be->coin == "USD" ? $be->total :  $be->total / $be->exchange_rate;
            $total['expense_pen'] += $total_pen;
            $total['expense_usd'] += $total_usd;
            array_push($detail_expense,array(
                'year' => $be->year,
                'month' => DataManager::NameMonth($be->month),
                'description' => $be->description,
                'total_usd' => number_format($total_usd,2,'.',''),
                'total_pen' => number_format($total_pen,2,'.',''),
            ));
        }

        $total['balance_pen'] = $total['income_pen'] - $total['expense_pen'];
        $total['balance_usd'] = $total['income_usd'] - $total['expense_usd'];

        $total['income_pen'] = number_format($total['income_pen'],2,'.','');
        $total['income_usd'] = number_format($total['income_usd'],2,'.','');
        $total['expense_pen'] = number_format($total['expense_pen'],2,'.','');
        $total['expense_usd'] = number_format($total['expense_usd'],2,'.','');
        $total['balance_pen'] = number_format($total['balance_pen'],2,'.','');
        $total['balance_usd'] = number_format($total['balance_usd'],2,'.','');

        return array('total' => $total, 'detail_income' => $detail_income, 'detail_expense' => $detail_expense);


       
    
    }


    public static function MonthUtility($month){
        
        $total['income_pen'] = 0;
        $total['income_usd'] = 0;
        $total['expense_pen'] = 0;
        $total['expense_usd'] = 0;
        $total['balance_pen'] = 0;
        $total['balance_usd'] = 0;

        $detail_income = array();
        $detail_expense = array();
        $date = Carbon::parse($month);
        $incomes = Income::MonthIncome($date->format('Y'), $date->format('m'));
        foreach ($incomes as $be) {
            $total['income_pen'] += $be->total_pen;
            $total['income_usd'] += $be->total_usd;
            array_push($detail_income,array(
                'year' => $be->year,
                'month' => DataManager::NameMonth($be->month),
                'description' => $be->description,
                'total_usd' => $be->total_usd,
                'total_pen' => $be->total_pen,
            ));
        }

        $expenses = Expense::MonthExpense($date->format('Y'), $date->format('m'));
        foreach ($expenses as $be) {
            $total_pen =  $be->coin == "PEN" ? $be->total :  $be->total * $be->exchange_rate;
            $total_usd =  $be->coin == "USD" ? $be->total :  $be->total / $be->exchange_rate;
            $total['expense_pen'] += $total_pen;
            $total['expense_usd'] += $total_usd;
            array_push($detail_expense,array(
                'year' => $be->year,
                'month' => DataManager::NameMonth($be->month),
                'description' => $be->type_expense_name,
                'total_usd' => number_format($total_usd,2,'.',''),
                'total_pen' => number_format($total_pen,2,'.',''),
            ));
        }

        $total['balance_pen'] = $total['income_pen'] - $total['expense_pen'];
        $total['balance_usd'] = $total['income_usd'] - $total['expense_usd'];

        $total['income_pen'] = number_format($total['income_pen'],2,'.','');
        $total['income_usd'] = number_format($total['income_usd'],2,'.','');
        $total['expense_pen'] = number_format($total['expense_pen'],2,'.','');
        $total['expense_usd'] = number_format($total['expense_usd'],2,'.','');
        $total['balance_pen'] = number_format($total['balance_pen'],2,'.','');
        $total['balance_usd'] = number_format($total['balance_usd'],2,'.','');

        return array('total' => $total, 'detail_income' => $detail_income, 'detail_expense' => $detail_expense);


       
    
    }





    public static function UtilityManagementAccumulated($to,$coin){

  
        $total_balance = 0;
      
        
        $from = Carbon::parse('2022-01');
        $to = Carbon::parse($to);
        $months = $to->floatDiffInMonths($from);
        for ($i=1; $i <= $months + 1; $i++) {    
            $total_income = ManagementIncome::TotalIncome($from->format('Y'), $from->format('m'),$coin);
            $total_expense = ManagementExpense::TotalExpense($from->format('Y'), $from->format('m'),$coin);
            $total_utility = $total_income - $total_expense;
            $total_balance += $total_utility;
            $from = $from->addMonth();
        }
      
        return $total_balance;

    
    }

    public static function UtilityAccountReceivableAccumulated($to,$coin){

  
        $total_balance = 0;
      
        
        $from = Carbon::parse('2022-01');
        $to = Carbon::parse($to);
        $months = $to->floatDiffInMonths($from);
        for ($i=1; $i <= $months + 1; $i++) {    
            $total_income = AccountReceivablePayment::TotalIncome($from->format('Y'), $from->format('m'),$coin);
            $total_expense = AccountReceivableExpense::TotalExpense($from->format('Y'), $from->format('m'),$coin);
            $total_utility = $total_income - $total_expense;
            $total_balance += $total_utility;
            $from = $from->addMonth();
        }
      
        return $total_balance;

    
    }
}
