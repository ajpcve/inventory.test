<?php

namespace App\Http\Controllers;

use Illuminate\Support\Collection as Collection;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Cab_inbound_order;
use App\Det_inbound_order;
use App\Doc_warehouse;
use App\Inv_location;
use App\Transport;
use App\Inventory;
use App\Warehouse;
use App\Document;
use App\Customer;
use App\Status;
use App\Item;


class InventoryController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $inven_item = Inventory::groupBy('id_item')->orderBy('inv_date' , 'ASC')->get();

        if (count($inven_item)!=0){

            $inbound_order = Cab_inbound_order::join('det_inbound_orders' , 'cab_inbound_orders.id_ciord' , '=' , 'det_inbound_orders.id_ciord')
                ->join('inventory' , 'det_inbound_orders.diord_lot' , '=' , 'inventory.inv_lot')
                ->join('inventory_location' , 'inventory.id_inv' , '=' , 'inventory_location.id_inv')
                ->join('item' , 'inventory.id_item' , '=' , 'item.id_item')
                ->join('unit' , 'item.id_unit' , '=' , 'unit.id_unit')
                ->where('inventory_location.inv_location_qty' , '!=' , 0)
                ->orderBy('det_inbound_orders.diord_expiration_date' , 'DES')
                ->groupBy('det_inbound_orders.diord_lot')
                ->get();

            $inv_loc = Inv_location::where('inv_location_qty' , '!=' , 0)->orderBy('id_inv' , 'ASC')->get();

            $inven_pallet = Inventory::join('cab_inbound_orders' , 'inventory.inv_inborders' , '=' , 'cab_inbound_orders.id_ciord')->orderBy('inv_date' , 'ASC')->get();

            foreach ($inven_pallet as $key) {
                $pallet[$key->ciord_orden_compra][$key->inv_pallet] = 0;
            }

            $inbound_order_all = Cab_inbound_order::join('det_inbound_orders' , 'cab_inbound_orders.id_ciord' , '=' , 'det_inbound_orders.id_ciord')
                ->join('inventory' , 'det_inbound_orders.diord_lot' , '=' , 'inventory.inv_lot')
                ->join('inventory_location' , 'inventory.id_inv' , '=' , 'inventory_location.id_inv')
                ->join('item' , 'inventory.id_item' , '=' , 'item.id_item')
                ->join('unit' , 'item.id_unit' , '=' , 'unit.id_unit')
                ->orderBy('det_inbound_orders.diord_expiration_date' , 'DES')
                ->groupBy('det_inbound_orders.diord_lot')
                ->get();
//dd($inbound_order_all);
        }

        return view('layouts.inventory.index' , compact('inven_item' , 'inbound_order' , 'inv_loc' , 'pallet' , 'inbound_order_all'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        //dd($request->all());
        if ($request->pallet!=null){

            $inbound_order = Cab_inbound_order::where('ciord_orden_compra' , $request->orden)->first();

            $inventory = Inventory::where('inv_inborders' , $inbound_order->id_ciord)->where('inv_pallet' , $request->pallet)->get();

            foreach ($inventory as $key_inv => $inven) {


                $inv_locati = Inv_location::where('id_inv' , $inven->id_inv)->first();

                $inv_locati->id_warehouse = $request->bodega;
                $inv_locati->save();
            }

            if ($request->file('document_warehouse')){ //nombre del input (boton)

                $file      = $request->file('document_warehouse')[0];
                $documents = time() . $file->getClientOriginalName();   //generar nombre unico a la imagen
                $path      = public_path() . '/documents/warehouse/'; // ruta donde guardamos la imagen
                $file->move($path , $documents); // Movemos la imagen a la carpeta

                foreach ($inventory as $key => $value) {

                    $doc_house                    = new Doc_warehouse();
                    $doc_house->docware_ruta      = $documents;
                    $doc_house->docware_pallet    = $request->pallet;
                    $doc_house->docware_lot       = $value->inv_lot;
                    $doc_house->docware_inborders = $value->inv_inborders;
                    $doc_house->id_doc            = $request->id_doc[0];
                    $doc_house->save();
                }
            }

            session()->put('pallet_fine' , 'Item created successfully.');
            return Redirect::to('inventory/transfer');
        }

        if ($request->detalle!=null){

            $inventory = Inv_location::findOrFail($request->lot);

            foreach ($inventory as $key_inv => $inven) {

                if ($inven->inv_location_qty==$request->detalle[$key_inv]){

                    $inv_locati               = Inv_location::find($inven->id_inventory_location);
                    $inv_locati->id_warehouse = $request->bodega;
                    $inv_locati->save();

                } else {

                    $inv_locati                   = new Inv_location();
                    $inv_locati->inv_location_qty = $request->detalle[$key_inv];
                    $inv_locati->id_warehouse     = $request->bodega;
                    $inv_locati->id_inv           = $inven->id_inv;
                    $inv_locati->save();

                    $inv_locati                   = Inv_location::findOrFail($inven->id_inventory_location);
                    $inv_locati->inv_location_qty = $inven->inv_location_qty - $request->detalle[$key_inv];
                    $inv_locati->save();
                }
            }
            //dd($request->all());
            if ($request->file('doc_house')){ //nombre del input (boton)

                $file      = $request->file('doc_house')[0];
                $documents = time() . $file->getClientOriginalName();   //generar nombre unico a la imagen
                $path      = public_path() . '/documents/warehouse/'; // ruta donde guardamos la imagen
                $file->move($path , $documents); // Movemos la imagen a la carpeta

                foreach ($inventory as $key => $value) {

                    $doc_house                    = new Doc_warehouse();
                    $doc_house->docware_ruta      = $documents;
                    $doc_house->docware_pallet    = $request->pallet_det[$key];
                    $doc_house->docware_lot       = $request->lot_ord[$key];
                    $doc_house->docware_inborders = $request->or_com[$key];
                    $doc_house->id_doc            = $request->id_doc[0];
                    $doc_house->save();
                }
            }

            session()->put('pallet_fine' , 'Item created successfully.');
            return Redirect::to('inventory/transfer');
        }

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function customer(Request $request)
    {
        $costum = $request->costum;

        $customer = Customer::where('id_customer' , $costum)->get();

        $data = array();

        foreach ($customer as $custoid) {
            $data[] = array('cust_company' => $custoid->cust_company , 'cust_phone' => $custoid->cust_phone , 'cust_address' => $custoid->cust_address , 'cust_email' => $custoid->cust_email , 'id_customer' => $custoid->id_customer , 'cust_sucursal' => $custoid->cust_sucursal , 'cust_num_sucursal' => $custoid->cust_num_sucursal);
        }

        if (count($data)){
            return $data;
        } else {
            return ['cust_company' => 'no se encuentra' , 'cust_phone' => 'no se encuentra' , 'cust_email' => 'no se encuentra' , 'cust_address' => 'no se encuentra'];
        }
    }

    public function delivery(Request $request)
    {
        $delivery_num = $request->delivery_num;

        $deli = Customer::where('cust_num_sucursal' , $delivery_num)->get();

        return response()->json($deli);
    }

    public function transport(Request $request)
    {
        $trans = $request->trans;

        $transport = Transport::where('id_transport' , $trans)->get();

        $data = array();

        foreach ($transport as $custoid) {
            $data[] = array('trans_company' => $custoid->trans_company , 'trans_phone' => $custoid->trans_phone , 'trans_address' => $custoid->trans_address , 'trans_email' => $custoid->trans_email , 'id_transport' => $custoid->id_transport);
        }

        if (count($data)){
            return $data;
        } else {
            return ['trans_company' => 'no se encuentra' , 'trans_phone' => 'no se encuentra' , 'trans_email' => 'no se encuentra' , 'trans_address' => 'no se encuentra'];
        }
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function sale(Request $request)
    {
        $customer = Customer::where('id_status' , '1')->whereIn('cust_sucursal' , ['U' , 'C'])->get();
        //dd($customer);
        $data      = 0;
        $id_ware   = [];
        $transport = Transport::where('id_status' , '1')->get();

        $inven_item = Inventory::select('id_item')->groupBy('id_item')->get();

        $item = Item::with('unit')->get();

        $inventory = Inventory::with('item')->get();

        if (count($inventory)!=0){

            $inv_loc = Inv_location::where('inv_location_qty' , '!=' , 0)->get();

            foreach ($inventory as $key) {
                $lote[] = $key->inv_lot;
            }

            $inbound_order_det = Det_inbound_order::whereIn('diord_lot' , $lote)->get();
            foreach ($inbound_order_det as $key) {
                $cab_id[] = $key->id_ciord;
            }

            $inbound_order = Cab_inbound_order::whereIn('id_ciord' , $cab_id)->get();

            $warehouse = Warehouse::all();

            foreach ($warehouse as $value) {
                $array       = explode("," , $value->house_activity);
                $id          = $value->id_warehouse;
                $resultado[] = array_merge((array)$array , (array)$id);
            }

            foreach ($resultado as $key => $value) {
                foreach ($value as $int) {
                    if ($int=='Sale'){
                        foreach ($value as $int2) {
                            if (is_int($int2)){
                                $id_ware[] = $int2;
                            }
                        }
                    }
                }
            }

            $Warehouse = Warehouse::whereIn('id_warehouse' , $id_ware)->orderBy('id_warehouse' , 'ASC')->pluck('house_address' , 'id_warehouse');

            $iund_order = Cab_inbound_order::join('det_inbound_orders' , 'cab_inbound_orders.id_ciord' , '=' , 'det_inbound_orders.id_ciord')
                ->join('inventory' , 'det_inbound_orders.diord_lot' , '=' , 'inventory.inv_lot')
                //->whereIn('det_inbound_orders.diord_lot', $lote)
                ->orderBy('det_inbound_orders.diord_expiration_date' , 'DES')
                ->groupBy('det_inbound_orders.diord_lot')
                ->get();
        }


        return view('layouts.inventory.sale' , compact('customer' , 'transport' , 'inven_item' , 'item' , 'inventory' , 'inbound_order_det' , 'inbound_order' , 'Warehouse' , 'inv_loc' , 'iund_order'));
    }

    public function transfer()
    {
        $inven_item = Inventory::groupBy('id_item')->get();
        if (count($inven_item)!=0){

            $inbound_order = Cab_inbound_order::join('det_inbound_orders' , 'cab_inbound_orders.id_ciord' , '=' , 'det_inbound_orders.id_ciord')
                ->join('inventory' , 'det_inbound_orders.diord_lot' , '=' , 'inventory.inv_lot')
                ->join('inventory_location' , 'inventory.id_inv' , '=' , 'inventory_location.id_inv')
                ->join('item' , 'inventory.id_item' , '=' , 'item.id_item')
                ->join('unit' , 'item.id_unit' , '=' , 'unit.id_unit')
                ->where('inventory_location.inv_location_qty' , '!=' , 0)
                ->orderBy('det_inbound_orders.diord_expiration_date' , 'DES')
                ->groupBy('det_inbound_orders.diord_lot')
                ->get();
//            return response()->json($inbound_order);
            $inven_pallet = Inventory::join('cab_inbound_orders' , 'inventory.inv_inborders' , '=' , 'cab_inbound_orders.id_ciord')->orderBy('inv_date' , 'ASC')->get();

            foreach ($inven_pallet as $key) {

                $pallet[$key->ciord_orden_compra][$key->inv_pallet] = 0;
            }

            $inv_loc = Inv_location::where('inv_location_qty' , '!=' , 0)->orderBy('id_inv' , 'ASC')->get();

            foreach ($pallet as $key => $inven) {
                foreach ($inven as $key_inv => $inv) {
                    foreach ($inbound_order as $inve_ord) {
                        if ($inve_ord->ciord_orden_compra==$key && $inve_ord->diord_pallet==$key_inv){
                            foreach ($inv_loc as $invloc) {
                                if ($inve_ord->id_inv==$invloc->id_inv){
                                    $valores[$key][$key_inv][] = $invloc->warehouse->house_name;
                                }
                            }
                        }
                    }
                }
            }

            foreach ($valores as $key => $value) {
                foreach ($value as $key_val => $val) {
                    if (count(array_unique($val))===1){
                        $value[$key_val] = '1';
                    } else {
                        $value[$key_val] = '2';
                    }
                    $valores[$key] = $value;
                }
            }
            $warehouse_bodega = Warehouse::where('house_step' , 0)->orderBy('id_warehouse' , 'ASC')->pluck('house_name' , 'id_warehouse');

            $document = Document::where('doc_tabla' , 'Warehouse')->where('id_status' , 1)->get();
            //dd($document);          
        }
        return view('layouts.inventory.transfers' , compact('inven_item' , 'inbound_order' , 'inv_loc' , 'pallet' , 'warehouse_bodega' , 'valores' , 'document'));
    }

    public function modal_detalle(Request $request)
    {
        $inbound_order_all = Det_inbound_order::join('cab_inbound_orders' , 'det_inbound_orders.id_ciord' , '=' , 'cab_inbound_orders.id_ciord')
            ->join('inventory' , 'det_inbound_orders.diord_lot' , '=' , 'inventory.inv_lot')
            ->join('inventory_location' , 'inventory.id_inv' , '=' , 'inventory_location.id_inv')
            ->join('item' , 'inventory.id_item' , '=' , 'item.id_item')
            ->join('unit' , 'item.id_unit' , '=' , 'unit.id_unit')
            ->whereIn('inv_lot' , $request->costum)
            ->orderBy('det_inbound_orders.diord_expiration_date' , 'DES')
            ->groupBy('det_inbound_orders.diord_lot')
            ->get();

        return response()->json($inbound_order_all);
    }
}
