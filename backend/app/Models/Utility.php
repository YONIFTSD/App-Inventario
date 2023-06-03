<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Utility extends Model
{
    
    protected $table = 'utilities';
    protected $primaryKey = 'id_utility';


    public static function ListAll($search){
        $search = urldecode($search);
        return DB::table('utilities')
        ->join('users','users.id_user','utilities.id_user')
        ->select('utilities.*','users.user')
        ->where('utilities.state','<>',9)
        ->where(function ($query) use ($search) {
            if(!empty($search) && $search != "all"){
                $query = $query->orWhere('utilities.year','like',"%$search%");
                $query = $query->orWhere('utilities.month','like',"%$search%");
            }
        })
        ->orderBy("utilities.id_utility","DESC")
        ->paginate(15);
    }


    public static function GetById($id_utility){
        return DB::table('utilities')
        ->join('users','users.id_user','utilities.id_user')
        ->select('utilities.*','users.user')
        ->where('utilities.id_utility',$id_utility)
        ->first();
    }

    public static function GetByMonth($year,$month){
        
        $response = DB::table('utilities')
        ->select('utilities.*')
        ->where('utilities.year',$year)
        ->where('utilities.month',$month)
        ->where('utilities.state',1)
        ->first();

        if ($response) {
            return $response;
        }else{
            $response = new Utility();
            $response->id_utility = '';
            $response->code = '';
            $response->date = '';
            $response->year = $year;
            $response->month = $month;
            $response->observation = '';
            $response->income_total_pen = 0;
            $response->income_total_usd = 0;
            $response->expense_total_pen = 0;
            $response->expense_total_usd = 0;
            $response->balance_total_pen = 0;
            $response->balance_total_usd = 0;
            return $response;

        }
    }











    public static function GetDailySettlementIncomeBusiness($id_business,$year,$month){
        try {
            set_time_limit(0);
            $business = Business::find($id_business);

            $counted = DB::connection($business->bd)->table("charges")
            ->join("sales", "sales.id_sale", "=", "charges.id_sale")
            ->select(
                "charges.coin",
                "charges.total",
                "sales.broadcast_date",
            )
            ->where("charges.state","<>",9)
            ->where("charges.state","<>",0)
            ->where("sales.state","<>",9)
            ->where("sales.state","<>",6)
            ->where("sales.payment_type","01")
            ->where("charges.payment_method","008")
            ->where("charges.cash",1)
            ->where(DB::raw("DATE_FORMAT(sales.broadcast_date, '%m')"),$month)
            ->where(DB::raw("DATE_FORMAT(sales.broadcast_date, '%Y')"),$year)
            ->get();
            
            $total['total_pen'] = 0;
            $total['total_usd'] = 0;
            
            foreach ($counted as $be) {

                $exchange_rate_sunat = ExchangeRateSunat::GetByDate($business->bd,$be->broadcast_date);
                $exchange_rate = $exchange_rate_sunat->venta;

                if($be->coin == 'PEN'){
                    $total['total_pen'] += $be->total;
                    $total['total_usd'] += $be->total / $exchange_rate;
                }else{
                    $total['total_pen'] += $be->total * $exchange_rate;
                    $total['total_usd'] += $be->total;
                }   
            }
         
            return $total;
        } catch (\Exception $e) {
           return $e;
        }  
    }

    public static function GetUtility($year,$month){
        try {
            $incomes = DB::table('incomes')
            ->join('business','business.id_business','incomes.id_business')
            ->select('incomes.*','business.name as business_name')
            ->where('incomes.state',1)
            ->where('incomes.year',$year)
            ->where('incomes.month',$month)
            ->orderBy("incomes.id_income","DESC")
            ->get();

            $expense = DB::table('expenses')
            ->join('type_expenses','type_expenses.id_type_expense','expenses.id_type_expense')
            ->select('expenses.*','type_expenses.name as type_expense_name')
            ->where('expenses.state','<>',9)
            ->where('expenses.year',$year)
            ->where('expenses.month',$month)
            ->orderBy("expenses.id_expense","DESC")
            ->get();

            $result['income_pen'] = 0;
            $result['income_usd'] = 0;
            $result['expense_pen'] = 0;
            $result['expense_usd'] = 0;
            $result['balance_pen'] = 0;
            $result['balance_usd'] = 0;
            $data_income = [];
            $data_expense = [];
            foreach ($incomes as $be) {
                array_push($data_income,array(
                    'id_income' => $be->id_income,
                    'year' => $be->year,
                    'month' => $be->month,
                    'description' => $be->business_name,
                    'total_usd' => $be->total_usd,
                    'total_pen' => $be->total_pen,
                ));
                $result['income_pen'] += $be->total_pen;
                $result['income_usd'] += $be->total_usd;
            }
            foreach ($expense as $be) {
                $total_usd =  $be->coin == "USD" ? $be->total : $be->total / $be->exchange_rate;
                $total_pen =  $be->coin == "PEN" ? $be->total : $be->total * $be->exchange_rate;
                
                $total_usd = number_format($total_usd,2,'.','');
                $total_pen = number_format($total_pen,2,'.','');
                array_push($data_expense,array(
                    'id_expense' => $be->id_expense,
                    'year' => $be->year,
                    'month' => $be->month,
                    'description' => $be->type_expense_name,
                    'total_usd' => $total_usd,
                    'total_pen' => $total_pen,
                ));
                $result['expense_pen'] += $total_pen;
                $result['expense_usd'] += $total_usd;
            }
            
            $result['balance_pen'] = $result['income_pen'] - $result['expense_pen'];
            $result['balance_usd'] = $result['income_usd'] - $result['expense_usd'];
        

            $result['income_pen'] = number_format($result['income_pen'],2,'.','');
            $result['income_usd'] = number_format($result['income_usd'],2,'.','');
            $result['expense_pen'] = number_format($result['expense_pen'],2,'.','');
            $result['expense_usd'] = number_format($result['expense_usd'],2,'.','');
            $result['balance_pen'] = number_format($result['balance_pen'],2,'.','');
            $result['balance_usd'] = number_format($result['balance_usd'],2,'.','');

            return array('incomes' => $data_income, 'expenses' => $data_expense, 'total' => $result);
            
        } catch (\Exception $e) {
           return $e;
        }  
    }

    public static function GetDailySettlement($id_business,$year,$month){
        try {
            set_time_limit(0);
            $business = Business::find($id_business);
            $report = DB::connection($business->bd)->table("charges")
            ->join("sales", "sales.id_sale", "=", "charges.id_sale")
            ->join("clients", "clients.id_client", "=", "charges.id_client")
            ->select(
                "charges.payment_method",
                "charges.coin",
                "charges.total",
                "charges.document",
                "charges.broadcast_date",
                "clients.name",
                "clients.document_number"
            )
            ->where("charges.state","<>",9)
            ->where("charges.state","<>",0)
            ->where("sales.state","<>",9)
            ->where("sales.state","<>",6)
            ->where("sales.payment_type","01")
            ->where("charges.cash",1)
            ->where(DB::raw("DATE_FORMAT(sales.broadcast_date, '%m')"),$month)
            ->where(DB::raw("DATE_FORMAT(sales.broadcast_date, '%Y')"),$year)
            ->orderby('sales.type_invoice','ASC')
            ->orderby('sales.serie','ASC')
            ->orderby('sales.number','ASC')
            ->get();
            
            $total = array(
            'counted_total_pen' => 0,'counted_total_usd' => 0 ,
            'credit_total_pen' => 0,'credit_total_usd' => 0 , 
            'total_pen' => 0, 'total_usd' => 0);
            foreach ($report as $be) {
                $exchange_rate_sunat = ExchangeRateSunat::GetByDate($business->bd,$be->broadcast_date);
                $exchange_rate = $exchange_rate_sunat->venta;
                if ($be->payment_method == "008") {
                    $total['counted_total_pen'] += $be->coin == "PEN" ? $be->total : $be->total * $exchange_rate;
                    $total['counted_total_usd'] += $be->coin == "USD" ? $be->total : $be->total / $exchange_rate;
                }else{
                    $total['credit_total_pen'] += $be->coin == "PEN" ? $be->total : $be->total * $exchange_rate;
                    $total['credit_total_usd'] += $be->coin == "USD" ? $be->total : $be->total / $exchange_rate;
                }
            }
            $total['total_pen'] += ($total['counted_total_pen'] + $total['credit_total_pen']);
            $total['total_usd'] += ($total['counted_total_usd'] + $total['credit_total_usd']);

            $total['counted_total_pen'] = number_format($total['counted_total_pen'],2,'.','');
            $total['counted_total_usd'] = number_format($total['counted_total_usd'],2,'.','');
            $total['credit_total_pen'] = number_format($total['credit_total_pen'],2,'.','');
            $total['credit_total_usd'] = number_format($total['credit_total_usd'],2,'.','');
            $total['total_pen'] = number_format($total['total_pen'],2,'.','');
            $total['total_usd'] = number_format($total['total_usd'],2,'.','');

            return $total;
        } catch (\Exception $e) {
           return $e;
        }  
    }

    public static function GetUtilityBusiness($id_business,$year,$month){
        try {
            set_time_limit(0);
            $business = Business::find($id_business);
            $report = DB::connection($business->bd)->table('sale_details')
            ->join('sales', 'sales.id_sale', '=', 'sale_details.id_sale')
            ->join('products', 'products.id_product', '=', 'sale_details.id_product')
            ->select('sale_details.*','sales.broadcast_date','sales.type_invoice','sales.serie','sales.number','sales.id_warehouse',
            'sales.coin','sales.state as state_sale', 
            'products.code','products.name','products.presentation','products.unit_measure')
            ->where('sales.state', '<>', 9)
            ->where('sales.state', '<>', 6)
            ->where(DB::raw("DATE_FORMAT(sales.broadcast_date, '%m')"),$month)
            ->where(DB::raw("DATE_FORMAT(sales.broadcast_date, '%Y')"),$year)
            ->orderBy('sales.type_invoice','ASC')
            ->orderBy('sales.serie','ASC')
            ->orderBy('sales.number','ASC')
            ->get();

            $total = array('total_price' => 0,'total_price_purchase' => 0 , 'total_utility_pen' => 0, 'total_utility_usd' => 0);
            foreach ($report as $be) {
                
                $price_shopping = Utility::AverageValueByProduct($business->bd,$be->id_warehouse,$be->id_product,$be->broadcast_date);

                $exchange_rate_sunat = ExchangeRateSunat::GetByDate($business->bd,$be->broadcast_date);
                $be->exchange_rate = $exchange_rate_sunat->venta;
                
                if ($be->coin == "PEN") {
                    $be->unit_price =  $be->unit_price;
                    $be->total_price = $be->total_price;
                    $be->unit_price_purchase =  $price_shopping['balance_unit_price'];
                    $be->total_price_purchase =  $be->unit_price_purchase * $be->quantity;
                }else{
                    $be->unit_price = $be->unit_price * $be->exchange_rate;
                    $be->total_price = $be->total_price * $be->exchange_rate;
                    $be->unit_price_purchase = $price_shopping['balance_unit_price'];
                    $be->total_price_purchase = $be->unit_price_purchase * $be->quantity;
                }
    
                $be->utility = $be->unit_price - $be->unit_price_purchase;
                $be->total_utility = $be->utility * $be->quantity;

                if ($be->type_invoice == "07") {
                    $be->unit_price = $be->unit_price * (-1);
                    $be->total_price = $be->total_price * (-1);
                    $be->unit_price_purchase = $be->unit_price_purchase * (-1);
                    $be->total_price_purchase = $be->total_price_purchase * (-1);
                    $be->utility = $be->utility * (-1);
                    $be->total_utility = $be->total_utility * (-1);
                }
            
                $be->unit_price = number_format($be->unit_price,2,'.','');
                $be->total_price = number_format($be->total_price,2,'.','');
                $be->unit_price_purchase = number_format($be->unit_price_purchase,2,'.','');
                $be->total_price_purchase = number_format($be->total_price_purchase,2,'.','');
                $be->utility = number_format($be->utility,2,'.','');
                $be->total_utility = number_format($be->total_utility,2,'.','');
                
                $total['total_price'] += $be->total_price;
                $total['total_price_purchase'] += $be->total_price_purchase;
                $total['total_utility_pen'] += $be->total_utility;
                $total['total_utility_usd'] += $be->total_utility / $be->exchange_rate;
            }
            
            $total['total_price'] = number_format($total['total_price'],2,'.','');
            $total['total_price_purchase'] = number_format($total['total_price_purchase'],2,'.','');
            $total['total_utility_pen'] = number_format($total['total_utility_pen'],2,'.','');
            $total['total_utility_usd'] = number_format($total['total_utility_usd'],2,'.','');
            return $total;
        } catch (\Exception $e) {
           return $e;
        }  
    }

    public static function AverageValueByProduct($bd,$id_warehouse,$id_product,$to){

        $initial = Utility::InitialKardexValued($bd,$id_warehouse,$id_product);
        $from = $initial['broadcast_date'];
        $from = date("Y-m-d",strtotime($from."+ 1 days"));
        $obj = Utility::KardexValued($bd,$id_warehouse,$from,$to,$id_product);
        $balance = $initial['quantity'];
        $balance_unit_price = $initial['unit_price'];
        $balance_total_price = $initial['total_price'];

        $unit_price = $balance_unit_price;
        foreach ($obj as $be) {
            $input = 0;
            $input_unit_price = 0;
            $input_total_price = 0;

            $output = 0;
            $output_unit_price = 0;
            $output_total_price = 0;
            
            if ($be->movement_type == 1) {

                if ($be->module != "Shopping") {
                    $shopping_detail = Utility::GetCostProductKardex($bd,$id_product,$be->broadcast_date);
                    if ($shopping_detail['unit_cost'] == 0) {
                        $shopping_detail['unit_cost'] = $balance_unit_price;
                    }
                    $input = $be->quantity;
                    $input_unit_price = $shopping_detail['unit_cost'];
                    $input_total_price = $input * $input_unit_price;
                    
                }else{
                    $input = $be->quantity;
                    $input_unit_price = $be->unit_price;
                    $input_total_price = $input * $input_unit_price;
                }
            }
            if ($be->movement_type == 2) {
                $output = $be->quantity;
                $output_unit_price = $balance_unit_price;
                $output_total_price = $output * $output_unit_price;
            }

            $balance = $balance + $input - $output;
            $balance_total_price = $balance_total_price + $input_total_price - $output_total_price;
            if (floatval($balance_total_price) > 0.05) {
                $balance_unit_price = $balance_total_price / $balance;
                if ($balance_unit_price != 0) {
                    $unit_price = $balance_unit_price;
                }
            }else{
                $balance_unit_price = 0;
            }
        }

        return array('balance' => $balance, 'balance_unit_price' => $unit_price, 'balance_total_price' => $balance_total_price );
    }

    public static function InitialKardexValued($bd,$id_warehouse,$id_product){
        $initial_kardex = DB::connection($bd)->table("kardex_movement")
            ->join("products", "products.id_product", "=", "kardex_movement.id_product")
            ->select(
                "kardex_movement.id_kardex_movement",
                "kardex_movement.broadcast_date",
                "kardex_movement.quantity",
                "kardex_movement.unit_price",
                "kardex_movement.total_price",
            )
            ->where("kardex_movement.state",1)
            ->where("kardex_movement.type_operation",'16')
            ->where("kardex_movement.id_warehouse",$id_warehouse)
            ->where("kardex_movement.id_product",$id_product)
            ->orderBy("kardex_movement.broadcast_date","DESC")
            ->first();

            if ($initial_kardex) {
                $response['id_kardex_movement'] = $initial_kardex->id_kardex_movement;
                $response['broadcast_date'] = $initial_kardex->broadcast_date;
                $response['quantity'] = $initial_kardex->quantity;
                $response['unit_price'] = $initial_kardex->unit_price;
                $response['total_price'] = $initial_kardex->total_price;
                return $response;
            }else{
                $response['id_kardex_movement'] = 0;
                $response['broadcast_date'] = '2021-01-01';
                $response['quantity'] = 0;
                $response['unit_price'] = 0;
                $response['total_price'] = 0;
                return $response;
            }
    }
    
    public static function KardexValued($bd,$id_warehouse,$from,$to,$id_product){
        
        return DB::connection($bd)->table("kardex_movement")
            ->join("products", "products.id_product", "=", "kardex_movement.id_product")
            ->select(
                "kardex_movement.id_kardex_movement",
                "kardex_movement.module",
                "kardex_movement.id_module",
                "kardex_movement.broadcast_date",
                "kardex_movement.type_operation",
                "kardex_movement.type_invoice",
                "kardex_movement.serie",
                "kardex_movement.number",
                "kardex_movement.quantity",
                "kardex_movement.unit_price",
                "kardex_movement.total_price",
                "kardex_movement.movement_type",
                "kardex_movement.internal_product"
            )
            ->where("kardex_movement.id_warehouse",$id_warehouse)
            // ->where(function ($query) use ($voucher_of_payment) {
            //     if (!empty($voucher_of_payment) && $voucher_of_payment != "all" ) {
            //         $query = $query->where('kardex_movement.internal_product',$voucher_of_payment);
            //     }
            // })
            ->whereBetween('kardex_movement.broadcast_date', [$from, $to])
            ->where("kardex_movement.id_product",$id_product)
            ->where("kardex_movement.type_operation",'<>',16)
            ->orderBy("kardex_movement.broadcast_date","ASC")
            ->orderBy("kardex_movement.movement_type","ASC")
            ->orderBy("kardex_movement.broadcast_date","ASC")
            ->orderBy("kardex_movement.serie","ASC")
            ->orderBy("kardex_movement.number","ASC")
            ->get();
    }

    public static function GetCostProductKardex($bd,$id_product,$broadcast_date){

        $cost = DB::connection($bd)->table('shopping_detail')
        ->join('shopping', 'shopping.id_shopping', '=', 'shopping_detail.id_shopping')
        ->select('shopping_detail.exchange_rate','shopping_detail.net_total_value','shopping_detail.unit_price','shopping_detail.unit_cost')
        ->where('shopping.state','<>', 9)
        ->where(function ($query) {
            $query = $query->orWhere('shopping.operation_type','02');
            $query = $query->orWhere('shopping.operation_type','03');
            $query = $query->orWhere('shopping.operation_type','18');
            $query = $query->orWhere('shopping.operation_type','28');
        })
        ->where('shopping.state','<>', 9)
        ->where('shopping_detail.id_product', $id_product)
        ->where('shopping.broadcast_date','<=', $broadcast_date)
        ->where('shopping_detail.unit_cost','>', 0)
        ->orderBy('shopping.broadcast_date','DESC')
        ->first();
        if ($cost) {
            $reponse['exchange_rate'] = $cost->exchange_rate;
            $reponse['net_total_value'] = $cost->net_total_value;
            $reponse['unit_price'] = $cost->unit_price;
            $reponse['unit_cost'] = $cost->unit_cost;
            return $reponse;
        }else{

            $kardex_default = Utility::InitialKardexValuedDefault($bd,$id_product);
            if ($kardex_default['unit_price'] > 0) {
                $reponse['exchange_rate'] = 1;
                $reponse['net_total_value'] = $kardex_default['unit_price'];
                $reponse['unit_price'] = $kardex_default['unit_price'];
                $reponse['unit_cost'] = $kardex_default['unit_price'];
                return $reponse;
            }
            $reponse['exchange_rate'] = 1;
            $reponse['net_total_value'] = 0;
            $reponse['unit_price'] = 0;
            $reponse['unit_cost'] = 0;
            return $reponse;
        }
        
    }

    public static function InitialKardexValuedDefault($bd,$id_product){
        
        $initial_kardex = DB::connection($bd)->table("kardex_movement")
            ->join("products", "products.id_product", "=", "kardex_movement.id_product")
            ->select(
                "kardex_movement.quantity",
                "kardex_movement.unit_price",
                "kardex_movement.total_price",
            )
            ->where("kardex_movement.state",1)
            ->where("kardex_movement.type_operation",'16')
            ->where("kardex_movement.unit_price",'>',0)
            ->where("kardex_movement.id_product",$id_product)
            ->orderBy("kardex_movement.broadcast_date","DESC")
            ->first();

            if ($initial_kardex) {
                $reponse['quantity'] = $initial_kardex->quantity;
                $reponse['unit_price'] = $initial_kardex->unit_price;
                $reponse['total_price'] = $initial_kardex->total_price;
                return $reponse;
            }else{
                $reponse['quantity'] = 0;
                $reponse['unit_price'] = 0;
                $reponse['total_price'] = 0;
                return $reponse;
            }
    }

}
