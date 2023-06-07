<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;


class ProductController extends Controller
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


    public function ListAll($search){
        try{
            $result = Product::ListAll($search);
            return response()->json(['status' => 200,'result' => $result]);
        } catch (\Exception $e){
            return response()->json(['status' => 400,'message' => 'A ocurrido un error', 'result' => $e->getMessage()]);
        }
    }

    public function Search(Request $request){
        try{
            $result = Product::Search($request->search);
            foreach ($result as $be) {
                $be->quantity = 0;
            }
            return response()->json(['status' => 200,'result' => $result]);
        } catch (\Exception $e){
            return response()->json(['status' => 400,'message' => 'A ocurrido un error', 'result' => $e->getMessage()]);
        }
    }


    public function View($id_product){
        try{
            $obj = Product::GetById($id_product);
            return response()->json(['status' => 200,'result' => $obj]);
        } catch (\Exception $e){
            return response()->json(['status' => 400,'message' => 'A ocurrido un error', 'result' => $e->getMessage()]);
        }
    }

    public function Store(Request $request){
        try{
            $this->validate($request, [
                'id_category' => 'required',
                'code' => 'required',
                'name' => 'required',
                'igv' => 'required',
                'purchase_price' => 'required',
                'sale_price' => 'required',
                'state' => 'required',
            ]);

            $obj = new Product();
            $obj->id_category = $request->id_category;
            $obj->code = $request->code;
            $obj->name = $request->name;
            $obj->barcode = $request->barcode;
            $obj->igv = $request->igv;
            $obj->unit_measure = $request->unit_measure;
            $obj->purchase_price = $request->purchase_price;
            $obj->sale_price = $request->sale_price;
            $obj->state = $request->state;
            $obj->save();

            return response()->json(['status' => 201,'message'=>'Se ha registrado correctamente el producto','result' => $obj]);
        } catch (\Exception $e){
            return response()->json(['status' => 400,'message' => 'A ocurrido un error', 'result' => $e->getMessage()]);
        }
    }

    public function Update(Request $request){
        try{
            $this->validate($request, [
                'id_product' => 'required',
                'name' => 'required',
                'state' => 'required',
            ]);

            $obj = Product::find($request->id_product);
            $obj->id_category = $request->id_category;
            $obj->code = $request->code;
            $obj->name = $request->name;
            $obj->barcode = $request->barcode;
            $obj->igv = $request->igv;
            $obj->unit_measure = $request->unit_measure;
            $obj->purchase_price = $request->purchase_price;
            $obj->sale_price = $request->sale_price;
            $obj->state = $request->state;
            $obj->update();

            return response()->json(['status' => 200,'message'=>'Se ha modificado correctamente el producto','result' => $obj]);
        } catch (\Exception $e){
            return response()->json(['status' => 400,'message' => 'A ocurrido un error', 'result' => $e->getMessage()]);
        }
    }


    public function Delete($id_product){
        try{

            $obj = Product::find($id_product);
            $obj->state = 9;
            $obj->update();
            return response()->json(['status' => 200,'message'=>'Se ha eliminado correctamente el producto','result' => $obj]);
        } catch (\Exception $e){
            return response()->json(['status' => 400,'message' => 'A ocurrido un error', 'result' => $e->getMessage()]);
        }
    }
    //
}
