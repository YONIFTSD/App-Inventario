<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class KardexMovement extends Model
{

    protected $table = 'kardex_movement';
    protected $primaryKey = 'id_kardex';

    public static function GetMovementByProduct($id_product,$to){
        $from = "2023-01-01";
        $movements = DB::table('kardex_movement')
        ->join('products','products.id_product','kardex_movement.id_product')
        ->select('kardex_movement.*','products.name as product_name','products.name as product_code')
        ->where('kardex_movement.state','<>',9)
        ->where("kardex_movement.id_product",$id_product)
        ->whereBetween('kardex_movement.broadcast_date',[$from,$to])
        ->orderBy("kardex_movement.broadcast_date","ASC")
        ->orderBy("kardex_movement.movement_type","ASC")
        ->get();

        $kardex = array();
        $balance_quantity = 0;
        $balance_unit_price = 0;
        $balance_total_price = 0;

        foreach ($movements as $be) {
            $input_quantity = 0;
            $input_unit_price = 0;
            $input_total_price = 0;

            $output_quantity = 0;
            $output_unit_price = 0;
            $output_total_price = 0;


            if ($be->movement_type == 'Input') {
                $input_quantity = $be->quantity;
                $input_unit_price = $be->unit_price;
                $input_total_price = $be->total_price;
            }else if($be->movement_type == 'Output'){
                $output_quantity = $be->quantity;
                $output_unit_price = $be->unit_price;
                $output_total_price = $be->total_price;
            }

            $balance_quantity =  $balance_quantity + $input_quantity - $output_quantity;
            $balance_total_price = $balance_total_price + $input_total_price - $output_total_price;
            $balance_unit_price = $balance_total_price / $balance_quantity;

            array_push($kardex,array(
                'id_kardex' => $be->id_kardex,
                'module' => $be->module,
                'id_module' => $be->id_module,
                'id_product' => $be->id_product,
                'broadcast_date' => $be->broadcast_date,
                'type_operation' => DataManager::TypeOperation($be->type_operation),
                'type_invoice' => DataManager::TypeInvoice($be->type_invoice),
                'serie' => $be->serie,
                'number' => $be->number,
                'input_quantity' => number_format($input_quantity,2,'.',''),
                'input_unit_price' => number_format($input_unit_price,2,'.',''),
                'input_total_price' => number_format($input_total_price,2,'.',''),
                'output_quantity' => number_format($output_quantity,2,'.',''),
                'output_unit_price' => number_format($output_unit_price,2,'.',''),
                'output_total_price' => number_format($output_total_price,2,'.',''),
                'balance_quantity' => number_format($balance_quantity,2,'.',''),
                'balance_unit_price' => number_format($balance_unit_price,2,'.',''),
                'balance_total_price' => number_format($balance_total_price,2,'.',''),
            ));
        }

        return $kardex;
    }
}
