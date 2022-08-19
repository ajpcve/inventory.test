<?php

namespace App\Http\Controllers;

use Illuminate\Support\Collection as Collection;
use Illuminate\Support\Facades\Validator;
use App\Http\Requests\DocInbOrderRequest;
use Illuminate\Support\Facades\Redirect;
use App\Http\Requests\DetInbOrdRequest;
use Illuminate\Support\Facades\Mail;
use Illuminate\Http\Request;
use App\Cab_inbound_order;
use App\Det_inbound_order;
use App\Doc_inbound_order;
use App\Inv_location;
use App\Warehouse;
use App\Inventory;
use App\Document;
use App\Item;
use App\User;

class InboundOrdersController extends Controller
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
        $inbound_order = Cab_inbound_order::with('warehouse')->get();

        $inbound_pallet = Det_inbound_order::join('cab_inbound_orders', 'det_inbound_orders.id_ciord', '=', 'cab_inbound_orders.id_ciord')->get();

        foreach ($inbound_pallet as $key) {
            $pallet[$key->id_ciord][$key->diord_pallet] = 0;
        }

        $location_one = Warehouse::whereNotNull('house_step')->where('house_step', '2')->orderBy('id_warehouse', 'ASC')->pluck('house_address','id_warehouse');
       
        $location_two = Warehouse::whereNotNull('house_step')->where('house_step', '3')->orderBy('id_warehouse', 'ASC')->pluck('house_address','id_warehouse')->toArray();

        $document = Document::where('doc_tabla', 'Airport')->where('id_status', 1)->get();

        $inbound_order_doc = Doc_inbound_order::with('document')->get();

        $order_doc = Doc_inbound_order::join('cab_inbound_orders', 'doc_inbound_orders.id_ciord', '=', 'cab_inbound_orders.id_ciord')
                    ->where('cab_inbound_orders.id_status','=', 3)
                    ->join('warehouse', 'cab_inbound_orders.id_warehouse', '=', 'warehouse.id_warehouse')
                    ->where('warehouse.house_step','=', 3)
                    ->join('documents', 'doc_inbound_orders.id_doc', '=', 'documents.id_doc')
                    ->where('documents.doc_tabla','=','Airport')
                    ->where('documents.id_status', 1)
                    ->get();

        $cab_order = Cab_inbound_order::with('warehouse')->where('cab_inbound_orders.id_status','=', 3)
                    ->join('warehouse', 'cab_inbound_orders.id_warehouse', '=', 'warehouse.id_warehouse')
                    ->where('warehouse.house_step','=', 3)
                    ->get();

        //dd($cab_order );

        if (count($cab_order) > 0) {
           foreach ($cab_order as $or_cab) {
                foreach ($document as $doc) {
                    $cab_doc[$or_cab->id_ciord][$doc->id_doc] = 0;
                }
            }

            foreach ($cab_doc as $key => $val) {
                foreach ($pallet as $key_pallet => $val_pallet) {
                    if ($key_pallet == $key) {
                        foreach ($val as $key_val => $value) {
                            if($key_val == 8){
                                $val[$key_val] = $val_pallet;
                                $cab_doc[$key] = $val;
                            }
                        }
                    }
                }
            }

            foreach ($cab_doc as $key => $value) {

                foreach ($order_doc as $or_doc) {

                    if($or_doc->id_ciord == $key){

                        foreach ($value as $key_va => $val) {

                            if($or_doc->id_doc == $key_va){

                                if($key_va == 8){

                                    foreach ($val as $key_sa => $value_val) {

                                        if($or_doc->dociord_pallet == $key_sa){

                                            $val[$key_sa] = $or_doc->dociord_ruta;
                                        }
                                    }
                                    $value[$key_va] = $val;
                                }else{

                                    $value[$key_va] = $or_doc->dociord_ruta;
                                }
                            }
                        }
                    }
                    $cab_doc[$key]=$value;
                }
            }

            foreach ($cab_doc as $key_ca => $value_ca) {

                foreach ($value_ca as $keyca => $valca) {

                    if($keyca == 8){

                        if (in_array(0, $valca)) {

                            $value_ca[$keyca] = 0;

                        }else{

                            $value_ca[$keyca] = 1;           
                        }
                    }
                    $tabla[$key_ca] = $value_ca;
                }
            }

            foreach ($cab_doc as $key_cab => $value_ca) {

                foreach ($value_ca as $keycab => $valca) {

                    if($keycab == 8){

                        foreach ($valca as $val_ocho) {

                            if ($val_ocho != 0) {
                                $value_ca[$keycab] = 1;
                                break;
                            }
                        }
                    }
                    $docu[$key_cab] = $value_ca;
                }
            }

            foreach ($docu as $key_doc => $value_doc) {

                foreach ($value_doc as $keydoc => $valdoc) {

                    if($keydoc == 8 && is_array($valdoc)){

                        $value_doc[$keydoc] = 0;
                    }

                    if ($valdoc != 0 && $keydoc != 8) {
                        $value_doc[$keydoc] = 1;
                        
                    }
                    $docu[$key_doc] = $value_doc;
                }
            }

            $collection = Collection::make($cab_doc);
        }else{
            $cab_doc = 0;
        }
        
        

        return view('layouts.inboundorders.index', compact('inbound_order', 'inbound_order_det', 'location_one', 'location_two', 'document', 'inbound_order_doc', 'cab_doc', 'order_doc', 'or_tab', 'collection', 'location_one_1', 'pallet', 'tabla', 'docu'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $item = Item::where('id_status','1')->get();
        $document = Document::where('doc_tabla', 'Export')->get();

        return view('layouts.inboundorders.create', compact('item', 'document'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(DetInbOrdRequest $request)
    {
        $inbound_order = new Cab_inbound_order();
        $inbound_order->ciord_date = $request->get('ciord_date');
        $inbound_order->ciord_export_date = $request->get('ciord_export_date');
        $inbound_order->ciord_guia_aerea = $request->get('ciord_guia_aerea');
        $inbound_order->ciord_orden_compra = $request->get('ciord_orden_compra');
        $inbound_order->id_status = 4;
        $inbound_order->id_warehouse = 2;

        foreach ($request->item_code as $key => $value) {

            $inbound_order_det = new Det_inbound_order();
            $inbound_order_det->diord_pallet = $request->pallet[$key];
            $inbound_order_det->diord_item_code = $request->item_code[$key];
            $inbound_order_det->diord_lot = $request->diord_lot[$key];
            $inbound_order_det->diord_qty = $request->diord_qty[$key];
            $inbound_order_det->diord_expiration_date = $request->diord_expiration_date[$key];

            $inbound_order->save(); 
            $inbound_order_det->id_ciord = $inbound_order->id_ciord;
            $inbound_order_det->save();
        }

        if ($request->file('documents')) { //nombre del input (boton)

            foreach ($request->file('documents') as $key => $value) {

                $file = $request->file('documents')[$key];
                $documents = time() . $file->getClientOriginalName();   //generar nombre unico a la imagen
                $path = public_path(). '/documents/'; // ruta donde guardamos la imagen
                $file->move($path, $documents); // Movemos la imagen a la carpeta

                $inbound_order_doc = new Doc_inbound_order();
                $inbound_order_doc->dociord_ruta = $documents;
                $inbound_order_doc->id_doc = $request->id_doc[$key];
                $inbound_order_doc->id_ciord = $inbound_order->id_ciord;
                $inbound_order_doc->save();
            }
        }
        session()->put('store','Item created successfully.');

        return Redirect::to('inbound_orders/show/'. $inbound_order->id_ciord);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $inbound_order = Cab_inbound_order::with('warehouse')->findOrFail($id);
        $inbound_pallet = Det_inbound_order::where('id_ciord', $id)->groupBy('diord_pallet')->get();

        $inbound_order_det = Det_inbound_order::with('items')->where('id_ciord', $id)->get();

        foreach ($inbound_order_det as $key) {
            $item_co[] = $key ->diord_item_code;
        }

        $item_code = Item::with('unit')->whereIn('item_code', $item_co)->get();

        $inbound_order_doc = Doc_inbound_order::where('id_ciord', $id)->get();
       
        $document = Document::whereIn('doc_tabla', ['Export'])->get();

        $documents_airport = Document::where('doc_tabla', 'Airport')->where('id_status', 1)->get();

        $users = User::where('id_status', 1)->get();
        
        return view('layouts.inboundorders.show', compact('item', 'document', 'inbound_order', 'inbound_order_det', 'item_code', 'inbound_order_doc', 'documents_airport', 'users', 'inbound_pallet'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $inbound_order = Cab_inbound_order::findOrFail($id);
        $inbound_order_det = Det_inbound_order::where('id_ciord', $id)->get();

        foreach ($inbound_order_det as $key) {
            $item_co[] = $key ->diord_item_code;
        }

        $inbound_order_doc = Doc_inbound_order::where('id_ciord', $id)->get();

        $item = Item::where('id_status','1')->get();
        $document = Document::where('doc_tabla','Export')->get();

        foreach ($document as $key_doc => $doc) {
            $doc_rut[$doc->id_doc] = 0;
        }

        foreach ($doc_rut as $key_doc_rut => $doc_rut_val) {
            foreach ($inbound_order_doc as $order_doc) {
                if ($order_doc->id_doc == $key_doc_rut) {
                    $doc_rut[$key_doc_rut]=$order_doc->dociord_ruta;
                }
            }
        }
        return view('layouts.inboundorders.edit', compact('item', 'document', 'inbound_order', 'inbound_order_det', 'inbound_order_doc', 'doc_rut'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        if ($request->file('documents_airport')) { //nombre del input (boton)
                        
            foreach ($request->file('documents_airport') as $key => $value) {

                $file = $request->file('documents_airport')[$key];
                $documents_airport = time() . $file->getClientOriginalName();   //generar nombre unico a la imagen
                $path = public_path(). '/documents/airport'; // ruta donde guardamos la imagen
                $file->move($path, $documents_airport); // Movemos la imagen a la carpeta

                if (isset($request->pallet)) {
                    foreach ($request->pallet as $key_val => $value) {

                        $inbound_order_doc = new Doc_inbound_order();
                        $inbound_order_doc->dociord_ruta = $documents_airport;
                        $inbound_order_doc->dociord_pallet = $value;
                        $inbound_order_doc->id_doc = $request->id_doc[$key];
                        $inbound_order_doc->id_ciord = $id;
                        $inbound_order_doc->save();
                    } 
                }else{
                    $inbound_order_doc = new Doc_inbound_order();
                    $inbound_order_doc->dociord_ruta = $documents_airport;
                    $inbound_order_doc->id_doc = $request->id_doc[$key];
                    $inbound_order_doc->id_ciord = $id;
                    $inbound_order_doc->save();
                }
                
            }

            $inbound_order_doc = Doc_inbound_order::where('id_ciord', $id)->where('id_doc','7')->get()->count();

            if ($inbound_order_doc >= 1) {

                $inbound_order_det = Det_inbound_order::where('id_ciord', $id)->get();
                
                foreach ($inbound_order_det as $key => $value) {

                    $inbound_order = Cab_inbound_order::with('warehouse')->findOrFail($id);

                    $inventory = new Inventory();
                    $inventory->inv_date = $inbound_order->ciord_date;
                    $inventory->inv_pallet = $inbound_order_det[$key]->diord_pallet;
                    $inventory->inv_inborders = $inbound_order_det[$key]->id_ciord;
                    $inventory->id_item = $inbound_order_det[$key]->diord_item_code;
                    $inventory->inv_lot = $inbound_order_det[$key]->diord_lot;
                    $inventory->id_status = 1;

                    $inv_location = new Inv_location();
                    $inv_location->inv_location_qty = $inbound_order_det[$key]->diord_qty;
                    $inv_location->id_warehouse = 4;

                    $inventory->save();
                    $inv_location->id_inv = $inventory->id_inv;

                    $inv_location->save();
                }
            }

            session()->put('store','Item created successfully.');
            return Redirect::to('inbound_orders');
        }    

        if ($request->get('location_index') != null) {

            $inbound_order = Cab_inbound_order::with('warehouse')->findOrFail($id);
            $inbound_order->id_warehouse = $request->get('location_index');
            $inbound_order->save();

            session()->put('update','Item created successfully.');
            return Redirect::to('inbound_orders');
        }

        //Liberar
        if ($request->variable != null) {

            $inbound_order = Cab_inbound_order::findOrFail($id)->toArray();
            
            $cab_vacio = in_array(null, $inbound_order);

            if ($cab_vacio == true) {
                return 0;
                session()->put('liberar','Item created successfully.');
                return Redirect::to('inbound_orders/show/'. $inbound_order['id_ciord']);

            }

            $inbound_order_det = Det_inbound_order::where('id_ciord', $id)->get()->toArray();
            //Uno los arreglos multidimensionales de la coleccion
            $a = array_dot($inbound_order_det);

            $det_vacio = in_array(null, $a);

            if ($det_vacio == true) {
                return 0;
                session()->put('liberar','Item created successfully.');
                return Redirect::to('inbound_orders/show/'. $inbound_order['id_ciord']);

            }

            $inbound_order_doc = Doc_inbound_order::where('id_ciord', $id)->get()->count();

            $document = Document::whereIn('doc_tabla', ['Export'])->get()->count();

            if ($inbound_order_doc != $document) {
               return 0;
                session()->put('liberar','Item created successfully.');
                return Redirect::to('inbound_orders/show/'. $inbound_order['id_ciord']);
            }

            $inbound_order = Cab_inbound_order::findOrFail($id);
            
            $inbound_order->id_status = $request->variable;
            $inbound_order->save();
            return 1;            
        }

        if ($request->get('ciord_date') != null) {

            //Actualiza la cabecera sin el estado
            $inbound_order = Cab_inbound_order::findOrFail($id);
            $inbound_order->ciord_date = $request->get('ciord_date');
            $inbound_order->ciord_export_date = $request->get('ciord_export_date');
            $inbound_order->ciord_guia_aerea = $request->get('ciord_guia_aerea');
            $inbound_order->ciord_orden_compra = $request->get('ciord_orden_compra');
            $inbound_order->save();

            //Busco el detalle de la cabecera
            $inbound_order_det = Det_inbound_order::where('id_ciord', $id)->get();

            //Saco los id del detalle
            foreach ($inbound_order_det as $key) {
                $det_id[] = $key->id_diord;
            }

            //Elimino los detalles existentes en la base de datos
            foreach ($det_id as $key) {
                $inbound_order_det = Det_inbound_order::findOrFail($key);
                $inbound_order_det->delete();
            }

            //creo los nuevos detalles
            foreach ($request->item_code as $key => $value) {

                $inbound_order_det = new Det_inbound_order();
                $inbound_order_det->diord_pallet = $request->pallet[$key];
                $inbound_order_det->diord_item_code = $request->item_code[$key];
                $inbound_order_det->diord_lot = $request->diord_lot[$key];
                $inbound_order_det->diord_qty = $request->diord_qty[$key];
                $inbound_order_det->diord_expiration_date = $request->diord_expiration_date[$key];
                $inbound_order_det->id_ciord = $id;
                $inbound_order_det->save();
            }

            //Verifico si existen documentos
            if ($request->file('documents')) {

                //Recorro la cantidad de documentos que necesito
                foreach ($request->id_doc as $key => $value) {

                    //Verifico si el id del documento que me estoy trayendo, es igual al key del documento qu estoy recorriendo de los docuemntos que ncesito
                    if (array_key_exists($request->id_doc[$key], $request->file('documents'))) {

                        //reviso si ese id del documento que me traigo, existe en la tabla de los documentos detalle
                        //Si es si, actualizo
                        if (Doc_inbound_order::where('id_ciord', $id)->where('id_doc', $request->id_doc[$key])->first()) {

                            $inbound_order_doc = Doc_inbound_order::where('id_ciord', $id)->where('id_doc', $request->id_doc[$key])->first();
                            //dd($inbound_order_doc);
                            $file = $request->file('documents')[$request->id_doc[$key]];
                            $documents = time() . $file->getClientOriginalName();
                            $path = public_path(). '/documents/';
                            $file->move($path, $documents);

                            $inbound_order_doc->dociord_ruta = $documents;
                            $inbound_order_doc->id_doc = $request->id_doc[$key];
                            $inbound_order_doc->id_ciord = $id;
                            $inbound_order_doc->save();

                        }else {//Sino, creo uno nuevo

                            $file = $request->file('documents')[$request->id_doc[$key]];

                            $documents = time() . $file->getClientOriginalName();   //generar nombre unico a la imagen
                            $path = public_path(). '/documents/'; // ruta donde guardamos la imagen
                            $file->move($path, $documents); // Movemos la imagen a la carpeta

                            $inbound_order_doc = new Doc_inbound_order();
                            $inbound_order_doc->dociord_ruta = $documents;
                            $inbound_order_doc->id_doc = $request->id_doc[$key];
                            $inbound_order_doc->id_ciord = $id;
                            $inbound_order_doc->save();
                        }
                    }
                }
            }
            //dd($request->delete);
            if ($request->delete != null) {
                foreach ($request->delete as $key_del => $delet) {
                    if ($delet != null) {

                        $inbound_order_doc = Doc_inbound_order::find($delet);
                        $inbound_order_doc->delete();
                    }
                }
            }
            
            

            session()->put('update','Item created successfully.');
            return Redirect::to('inbound_orders/show/'. $inbound_order['id_ciord']);
        }
        
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function items(Request $request)
    {
        $itemid = $request->itemid;

        $item = Item::with('unit')->where('id_item', $itemid)->get();
        
        $data = array();

        foreach ($item as $iditem) {
            $data[] = array('item_code' => $iditem->item_code, 'item_name' => $iditem->item_name, 'id_unit' => $iditem->unit->unit, 'id_item' => $iditem->id_item);
        }

        if (count($data)) {
            return $data;
        } else {
            return ['item_code' => 'no se encuentra', 'item_name' => 'no se encuentra', 'id_unit' => 'no se encuentra'];
        }
    }

    public function email(Request $request)
    {
        $inbound_order_doc = Doc_inbound_order::where('id_ciord', $request->id)
                            ->join('documents', 'doc_inbound_orders.id_doc', '=', 'documents.id_doc')
                    ->where('documents.doc_tabla','Export')
                    ->get();

        foreach ($inbound_order_doc as $inbound_doc) {
            $ruta[] = public_path().'/documents/'.$inbound_doc->dociord_ruta;
        }
        //dd($ruta);
        $emails = array_filter($request->optionsCheckboxes);
        
        $logo = asset('assets/img/logosinsloganconsombra1.png');

        $data = array(
            'logo' => $logo,
        );

        Mail::send('email.export', $data , function ($message) use ($emails, $ruta){
        //¿Mail::send('email.export', $data , function ($message) use ($emails){

            $message->from('no-reply@bufalinda.com', 'BUFALINDA USA');
            $message->to($emails)->subject('Export document');

            foreach ($ruta as $rut) {
                $message->attach($rut);
            }
        });
        
        return Redirect::to('inbound_orders/show/'. $request->id);
    }
}
