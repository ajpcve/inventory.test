<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Cab_Sale_Inventory;
use App\Doc_sale_inventory;
use App\Cab_inbound_order;
use App\Doc_inbound_order;
use App\Document;


use App\Inventory;
use Carbon\Carbon;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $cab_order = Cab_inbound_order::with('warehouse')->where('cab_inbound_orders.id_status','=', 3)
                    ->join('warehouse', 'cab_inbound_orders.id_warehouse', '=', 'warehouse.id_warehouse')
                    ->where('warehouse.house_step','=', 3)
                    ->get();
        $airport_count = count($cab_order);
        

        $document = Document::where('doc_tabla', 'Airport')->where('id_status', 1)->get();

        $order_doc = Doc_inbound_order::join('cab_inbound_orders', 'doc_inbound_orders.id_ciord', '=', 'cab_inbound_orders.id_ciord')
                    ->where('cab_inbound_orders.id_status','=', 3)
                    ->join('warehouse', 'cab_inbound_orders.id_warehouse', '=', 'warehouse.id_warehouse')
                    ->where('warehouse.house_step','=', 3)
                    ->join('documents', 'doc_inbound_orders.id_doc', '=', 'documents.id_doc')
                    ->where('documents.doc_tabla','=','Airport')
                    ->where('documents.id_status', 1)
                    ->get();
        if (count($cab_order) > 0) {
            foreach ($cab_order as $or_cab) {
                foreach ($document as $doc) {
                    $cab_doc[$or_cab->id_ciord][$doc->id_doc] = 0;
                }
            }

            foreach ($cab_doc as $key => $value) {
                foreach ($order_doc as $or_doc) {

                if($or_doc->id_ciord == $key){

                    foreach ($value as $key_va => $val) {

                        if($or_doc->id_doc == $key_va){
                            $value[$key_va] = $or_doc->dociord_ruta;
                        }
                    }
                }
                $cab_doc[$key]=$value;
                }
            }

            foreach ($cab_doc as $key => $value) {

                foreach ($value as $key_va => $val) {
                    $valores[$key] = array_count_values($value);
                }
            }

            foreach ($valores as $key => $value) {

                if (array_key_exists(0, $value)) {

                    foreach ($value as $key_val => $val) {
                        if ($key_val == 0) {
                            $vale[$key] = $val;
                        }
                    }
                }
            }

            if (isset($vale)) {
                $doc_air_count = count($vale);
            }else{
                $doc_air_count = 0;
            }

            $doc_sale = Document::where('doc_tabla', 'Sale')->where('id_status', 1)->get();
            
        }else {
            $doc_air_count = 0;
        }
        $cab_sale_inv = Cab_Sale_Inventory::all();

        $doc_sale_inv = Doc_sale_inventory::join('cab_sale_inventory', 'doc_sale_inventory.id_csale_inventory', '=', 'cab_sale_inventory.id_csale_inventory')
                        ->get();
        if (count($doc_sale_inv) == 0) {

            $doc_sale_count = count($cab_sale_inv);
        }elseif (count($doc_sale_inv) != 0) {

             $doc_sale = Document::where('doc_tabla', 'Sale')->where('id_status', 1)->get();

            foreach ($cab_sale_inv as $sal_cab) {
                foreach ($doc_sale as $doc_sal) {
                    $sale_doc[$sal_cab->id_csale_inventory][$doc_sal->id_doc] = 0;
                }
            }
            foreach ($sale_doc as $key => $value) {
                foreach ($doc_sale_inv as $sa_doc) {

                if($sa_doc->id_csale_inventory == $key){

                    foreach ($value as $key_va => $val) {

                        if($sa_doc->id_doc == $key_va){
                            $value[$key_va] = $sa_doc->docsinven_ruta;
                        }
                    }
                }
                $sale_doc[$key]=$value;
                }
            }
            foreach ($sale_doc as $key => $value) {

                foreach ($value as $key_va => $val) {
                    $val_sale[$key] = array_count_values($value);
                }
            }
            foreach ($val_sale as $key => $value) {

                if (array_key_exists(0, $value)) {

                    foreach ($value as $key_val => $val) {
                        if ($key_val == 0) {
                            $vale_sale[$key] = $val;
                        }
                    }
                }
            }

            if (isset($vale_sale)) {
                $doc_sale_count = count($vale_sale);
            }else{
                $doc_sale_count = 0;
            }
        }

        $inven_item = Inventory::groupBy('id_item')->orderBy('inv_date', 'ASC')->get();

        if(count($inven_item) != 0 ){

            $inbound_order = Cab_inbound_order::join('det_inbound_orders', 'cab_inbound_orders.id_ciord', '=', 'det_inbound_orders.id_ciord')
                        ->join('inventory', 'det_inbound_orders.diord_lot', '=', 'inventory.inv_lot')
                        ->join('inventory_location', 'inventory.id_inv', '=', 'inventory_location.id_inv')
                        ->where('inventory_location.inv_location_qty','!=',0)
                        ->orderBy('det_inbound_orders.diord_expiration_date', 'ASC')
                        ->groupBy('det_inbound_orders.diord_lot')
                        ->get();

            foreach ($inbound_order as $in_order) {
                $fecha_array[] = new Carbon($in_order->diord_expiration_date); 
            }

            foreach ($inbound_order as $in_order) {
                $fech_array[] = $in_order->diord_expiration_date; 
            }
            $fecha = Carbon::now();

            foreach ($fech_array as $key => $value_fe) {
                foreach ($fecha_array as $fe_array => $value ) {
                    if ($fe_array == $key) {
                        $dia_array[$value_fe] = $fecha->diffInDays($value); 
                    }
                }
            }

            foreach ($dia_array as $key => $value) {
                if ($value <= 30) {
                    $vencer[] = $key;
                    
                }
            }
           // dd(isset($vencer));

            $inbound_order = Cab_inbound_order::join('det_inbound_orders', 'cab_inbound_orders.id_ciord', '=', 'det_inbound_orders.id_ciord')
                        ->join('inventory', 'det_inbound_orders.diord_lot', '=', 'inventory.inv_lot')
                        ->join('inventory_location', 'inventory.id_inv', '=', 'inventory_location.id_inv')
                        ->join('item', 'inventory.id_item', '=', 'item.id_item')
                        ->where('inventory_location.inv_location_qty','!=',0);
                        if (isset($vencer)) {
                            $inbound_order->whereIn('det_inbound_orders.diord_expiration_date', $vencer);
                        }

                        //
                        $inbound_order = $inbound_order->groupBy('det_inbound_orders.diord_lot')
                        ->get();
                       //dd($inbound_order);
        }else {
            $dia_array = 0;
        }

        return view('layouts.index', compact('airport_count', 'doc_air_count', 'doc_sale_count', 'inbound_order', 'dia_array'));
    }
}
