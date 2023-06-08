<?php

namespace App\Http\Controllers;

use App\Models\KardexMovement;
use App\Models\Product;
use App\Models\Purchase;
use App\Models\PurchaseDetail;
use Illuminate\Http\Request;


class PurchaseController extends Controller
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
            $result = Purchase::ListAll($from,$to,$search);
            return response()->json(['status' => 200,'result' => $result]);
        } catch (\Exception $e){
            return response()->json(['status' => 400,'message' => 'A ocurrido un error', 'result' => $e->getMessage()]);
        }
    }

    public function View($id_purchase){
        try{
            $obj = Purchase::GetById($id_purchase);
            $detail = PurchaseDetail::ListAll($id_purchase);
            return response()->json(['status' => 200,'result' => [
                'purchase' => $obj,
                'purchase_detail' => $detail,
            ]]);
        } catch (\Exception $e){
            return response()->json(['status' => 400,'message' => 'A ocurrido un error', 'result' => $e->getMessage()]);
        }
    }

    public function Store(Request $request){
        try{
            $this->validate($request, [
                'id_provider' => 'required',
                'type_invoice' => 'required',
                'total' => 'required',
                'purchase_detail' => 'required',
                'state' => 'required',
            ]);

            $obj = new Purchase();
            $obj->id_provider = $request->id_provider;
            $obj->type_invoice = $request->type_invoice;
            $obj->serie = $request->serie;
            $obj->number = $request->number;
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

            $purchase_detail = $request->purchase_detail;
            foreach ($purchase_detail as $be) {

                $detail = new PurchaseDetail();
                $detail->id_purchase = $obj->id_purchase;
                $detail->id_product = $be['id_product'];
                $detail->quantity = $be['quantity'];
                $detail->unit_price = $be['unit_price'];
                $detail->total_price = $be['total_price'];
                $detail->state = 1;
                $detail->save();

                $kardex = new KardexMovement();
                $kardex->module = 'Purchase';
                $kardex->id_module = $obj->id_purchase;
                $kardex->id_product = $be['id_product'];
                $kardex->broadcast_date = $obj->broadcast_date;
                $kardex->type_operation = $obj->type_operation;
                $kardex->type_invoice = $obj->type_invoice;
                $kardex->serie = $obj->serie;
                $kardex->number = $obj->number;
                $kardex->quantity = $be['quantity'];
                $kardex->unit_price = $be['unit_price'];
                $kardex->total_price = $be['total_price'];
                $kardex->movement_type = 'Input';
                $kardex->state = 1;
                $kardex->save();

                $product = Product::find($be['id_product']);
                $product->stock = $product->stock + $be['quantity'];
                $product->update();

            }

            return response()->json(['status' => 201,'message'=>'Se ha registrado correctamente la compra','result' => $obj]);
        } catch (\Exception $e){
            return response()->json(['status' => 400,'message' => 'A ocurrido un error', 'result' => $e->getMessage()]);
        }
    }

    public function Update(Request $request){
        try{
            $this->validate($request, [
                'id_provider' => 'required',
                'type_invoice' => 'required',
                'total' => 'required',
                'purchase_detail' => 'required',
                'state' => 'required',
            ]);

            $obj = Purchase::find($request->id_purchase);
            $obj->id_provider = $request->id_provider;
            $obj->type_invoice = $request->type_invoice;
            $obj->serie = $request->serie;
            $obj->number = $request->number;
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



            $purchase_detail_old = PurchaseDetail::where('id_purchase',$obj->id_purchase)->get();
            foreach ($purchase_detail_old as $be) {
                $product = Product::find($be->id_product);
                $product->stock = $product->stock - $be->quantity;
                $product->update();
            }
            PurchaseDetail::where('id_purchase',$obj->id_purchase)->delete();
            KardexMovement::where('module','Purchase')->where('id_module',$obj->id_purchase)->delete();

            $purchase_detail = $request->purchase_detail;
            foreach ($purchase_detail as $be) {

                $detail = new PurchaseDetail();
                $detail->id_purchase = $obj->id_purchase;
                $detail->id_product = $be['id_product'];
                $detail->quantity = $be['quantity'];
                $detail->unit_price = $be['unit_price'];
                $detail->total_price = $be['total_price'];
                $detail->state = 1;
                $detail->save();

                $kardex = new KardexMovement();
                $kardex->module = 'Purchase';
                $kardex->id_module = $obj->id_purchase;
                $kardex->id_product = $be['id_product'];
                $kardex->broadcast_date = $obj->broadcast_date;
                $kardex->type_operation = $obj->type_operation;
                $kardex->type_invoice = $obj->type_invoice;
                $kardex->serie = $obj->serie;
                $kardex->number = $obj->number;
                $kardex->quantity = $be['quantity'];
                $kardex->unit_price = $be['unit_price'];
                $kardex->total_price = $be['total_price'];
                $kardex->movement_type = 'Input';
                $kardex->state = 1;
                $kardex->save();

                $product = Product::find($be['id_product']);
                $product->stock = $product->stock + $be['quantity'];
                $product->update();

            }

            return response()->json(['status' => 200,'message'=>'Se ha modificado correctamente la compra','result' => $obj]);
        } catch (\Exception $e){
            return response()->json(['status' => 400,'message' => 'A ocurrido un error', 'result' => $e->getMessage()]);
        }
    }


    public function Delete($id_purchase){
        try{

            $obj = Purchase::find($id_purchase);
            $obj->state = 9;
            $obj->update();

            $purchase_detail = PurchaseDetail::where('id_purchase',$obj->id_purchase)->get();
            foreach ($purchase_detail as $be) {
                $product = Product::find($be->id_product);
                $product->stock = $product->stock - $be->quantity;
                $product->update();
            }
            KardexMovement::where('module','Purchase')->where('id_module',$obj->id_purchase)->delete();


            return response()->json(['status' => 200,'message'=>'Se ha eliminado correctamente la compra','result' => $obj]);
        } catch (\Exception $e){
            return response()->json(['status' => 400,'message' => 'A ocurrido un error', 'result' => $e->getMessage()]);
        }
    }
    //
}
