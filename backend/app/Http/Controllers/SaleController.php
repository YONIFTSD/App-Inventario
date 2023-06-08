<?php

namespace App\Http\Controllers;

use App\Models\KardexMovement;
use App\Models\Product;
use App\Models\Sale;
use App\Models\SaleDetail;
use App\Models\Serie;
use Illuminate\Http\Request;


class SaleController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }


    public function ListAll($from,$to,$search){
        try{
            $result = Sale::ListAll($from,$to,$search);
            return response()->json(['status' => 200,'result' => $result]);
        } catch (\Exception $e){
            return response()->json(['status' => 400,'message' => 'A ocurrido un error', 'result' => $e->getMessage()]);
        }
    }

    public function View($id_sale){
        try{
            $obj = Sale::GetById($id_sale);
            $detail = SaleDetail::ListAll($id_sale);
            return response()->json(['status' => 200,'result' => [
                'sale' => $obj,
                'sale_detail' => $detail,
            ]]);
        } catch (\Exception $e){
            return response()->json(['status' => 400,'message' => 'A ocurrido un error', 'result' => $e->getMessage()]);
        }
    }

    public function Store(Request $request){
        try{
            $this->validate($request, [
                'id_client' => 'required',
                'type_invoice' => 'required',
                'total' => 'required',
                'sale_detail' => 'required',
                'state' => 'required',
            ]);

            $serie = Serie::find($request->id_serie);

            $obj = new Sale();
            $obj->id_client = $request->id_client;
            $obj->id_user = $request->id_user;
            $obj->id_serie = $request->id_serie;
            $obj->type_invoice = $request->type_invoice;
            $obj->serie = $serie->serie;
            $obj->number = $serie->number;
            $obj->broadcast_date = $request->broadcast_date;
            $obj->coin = $request->coin;
            $obj->type_operation = $request->type_operation;
            $obj->observation = $request->observation;
            $obj->taxed_operation = $request->taxed_operation;
            $obj->exonerated_operation = $request->exonerated_operation;
            $obj->unaffected_operation = $request->unaffected_operation;
            $obj->igv = $request->igv;
            $obj->total = $request->total;
            $obj->state = $request->state;
            $obj->save();

            Serie::Increase($serie->id_serie);

            $sale_detail = $request->sale_detail;
            foreach ($sale_detail as $be) {

                $detail = new SaleDetail();
                $detail->id_sale = $obj->id_sale;
                $detail->id_product = $be['id_product'];
                $detail->quantity = $be['quantity'];
                $detail->unit_price = $be['unit_price'];
                $detail->total_price = $be['total_price'];
                $detail->state = 1;
                $detail->save();

                $kardex = new KardexMovement();
                $kardex->module = 'Sale';
                $kardex->id_module = $obj->id_sale;
                $kardex->id_product = $be['id_product'];
                $kardex->broadcast_date = $obj->broadcast_date;
                $kardex->type_operation = $obj->type_operation;
                $kardex->type_invoice = $obj->type_invoice;
                $kardex->serie = $obj->serie;
                $kardex->number = $obj->number;
                $kardex->quantity = $be['quantity'];
                $kardex->unit_price = $be['unit_price'];
                $kardex->total_price = $be['total_price'];
                $kardex->movement_type = 'Output';
                $kardex->state = 1;
                $kardex->save();

                $product = Product::find($be['id_product']);
                $product->stock = $product->stock - $be['quantity'];
                $product->update();

            }

            return response()->json(['status' => 201,'message'=>'Se ha registrado correctamente la venta','result' => $obj]);
        } catch (\Exception $e){
            return $e;
            return response()->json(['status' => 400,'message' => 'A ocurrido un error', 'result' => $e->getMessage()]);
        }
    }

    public function Update(Request $request){
        try{
            $this->validate($request, [
                'id_client' => 'required',
                'type_invoice' => 'required',
                'total' => 'required',
                'sale_detail' => 'required',
                'state' => 'required',
            ]);

            $obj = Sale::find($request->id_sale);
            $obj->id_client = $request->id_client;
            /*
            $obj->type_invoice = $request->type_invoice;
            $obj->serie = $request->serie;
            $obj->number = $request->number;
            */
            $obj->broadcast_date = $request->broadcast_date;
            $obj->coin = $request->coin;
            $obj->type_operation = $request->type_operation;
            $obj->observation = $request->observation;
            $obj->taxed_operation = $request->taxed_operation;
            $obj->exonerated_operation = $request->exonerated_operation;
            $obj->unaffected_operation = $request->unaffected_operation;
            $obj->igv = $request->igv;
            $obj->total = $request->total;
            $obj->state = $request->state;
            $obj->update();



            $sale_detail_old = SaleDetail::where('id_sale',$obj->id_sale)->get();
            foreach ($sale_detail_old as $be) {
                $product = Product::find($be->id_product);
                $product->stock = $product->stock + $be->quantity;
                $product->update();
            }
            SaleDetail::where('id_sale',$obj->id_sale)->delete();
            KardexMovement::where('module','Sale')->where('id_module',$obj->id_sale)->delete();

            $sale_detail = $request->sale_detail;
            foreach ($sale_detail as $be) {

                $detail = new SaleDetail();
                $detail->id_sale = $obj->id_sale;
                $detail->id_product = $be['id_product'];
                $detail->quantity = $be['quantity'];
                $detail->unit_price = $be['unit_price'];
                $detail->total_price = $be['total_price'];
                $detail->state = 1;
                $detail->save();

                $kardex = new KardexMovement();
                $kardex->module = 'Sale';
                $kardex->id_module = $obj->id_sale;
                $kardex->id_product = $be['id_product'];
                $kardex->broadcast_date = $obj->broadcast_date;
                $kardex->type_operation = $obj->type_operation;
                $kardex->type_invoice = $obj->type_invoice;
                $kardex->serie = $obj->serie;
                $kardex->number = $obj->number;
                $kardex->quantity = $be['quantity'];
                $kardex->unit_price = $be['unit_price'];
                $kardex->total_price = $be['total_price'];
                $kardex->movement_type = 'Output';
                $kardex->state = 1;
                $kardex->save();

                $product = Product::find($be['id_product']);
                $product->stock = $product->stock - $be['quantity'];
                $product->update();

            }

            return response()->json(['status' => 200,'message'=>'Se ha modificado correctamente la venta','result' => $obj]);
        } catch (\Exception $e){
            return response()->json(['status' => 400,'message' => 'A ocurrido un error', 'result' => $e->getMessage()]);
        }
    }


    public function Delete($id_sale){
        try{

            $obj = Sale::find($id_sale);
            $obj->state = 9;
            $obj->update();

            $sale_detail = SaleDetail::where('id_sale',$obj->id_sale)->get();
            foreach ($sale_detail as $be) {
                $product = Product::find($be->id_product);
                $product->stock = $product->stock + $be->quantity;
                $product->update();
            }
            KardexMovement::where('module','Sale')->where('id_module',$obj->id_sale)->delete();


            return response()->json(['status' => 200,'message'=>'Se ha eliminado correctamente la venta','result' => $obj]);
        } catch (\Exception $e){
            return response()->json(['status' => 400,'message' => 'A ocurrido un error', 'result' => $e->getMessage()]);
        }
    }
    //
}
