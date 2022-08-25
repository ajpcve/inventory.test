<?php

namespace App\Http\Controllers;

use Illuminate\Support\Collection as Collection;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Auth;
use Barryvdh\DomPDF\Facade as PDF;
use Illuminate\Http\Request;
use App\Cab_Sale_Inventory;
use App\Det_Sale_Inventory;
use App\Doc_sale_inventory;
use App\Det_inbound_order;
use App\Inv_location;
use App\Warehouse;
use App\Inventory;
use App\Transport;
use App\Customer;
use App\Document;
use App\Item;
use App\Unit;
use App\User;

class SaleInventoryController extends Controller
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
        $cab_sale_inv = Cab_Sale_Inventory::all();
        $det_sale_inv = Det_Sale_Inventory::with('item')->get();

        $lote_index = Det_Sale_Inventory::orderBy('id_dsale_inventory', 'ASC')->groupBy('dsaleinv_lot')->pluck('dsaleinv_lot','id_dsale_inventory');

        return view('layouts.inventory.index_sale', compact('cab_sale_inv', 'det_sale_inv', 'lote_index'));
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
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        
        //dd($request->all());
        $cab_sale_inv = new Cab_Sale_Inventory();
        $cab_sale_inv->csaleinv_date = $request->csaleinv_date;
        $cab_sale_inv->csaleinv_invoice = $request->csaleinv_invoice;
        $cab_sale_inv->csaleinv_or_num = $request->csaleinv_or_num;
        $cab_sale_inv->id_users = Auth::user()->id;

        //SE VERIFICA SI EXISTE TANTO EL CLIENTE COMO EL TRANSPORTE POR EL ID QUE SE MANDA DEL FORMULARIO 
        //SI EL ID ESTA VACIO SE GUARDAN LOS DATOS, DE LO CONTRARIO SOLO SE GUARDA EL ID

        //CLIENTE
        //SINO ME TRAIGO ID DEL FORMULARIO, LO REGISTRO
        if ($request->id_cust == null) {

            $customer = new Customer();
            $customer->cust_company = $request->get('cust_company');
            $customer->cust_phone = $request->get('cust_phone');
            $customer->cust_address = $request->get('cust_address');
            $customer->cust_email = $request->get('cust_email');
            $customer->id_status = 1;
            $customer->save();

            $customer = Customer::all();

            $cab_sale_inv->id_customer = $customer->last()->id_customer;
        }else{
            $cab_sale_inv->id_customer = $request->id_cust;
        }

        //AGRGAR EN LA BASE DE DATOS EL DESTINO DELIVERY ADDRESS
        //PUEDE SER UNA SUCURSAL
        if ($request->id_deli != null) {
             $cab_sale_inv->id_delivery = $request->id_deli;
        }
        //UN NUEVO DESTINO
        //O NO LLENARLO PORQ LO RETIRA LA MISMA EMPRESA
        if ($request->id_deli == null && $request->deli_company != null) {
            $cab_sale_inv->csaleinv_deli_name = $request->deli_company;
            $cab_sale_inv->csaleinv_deli_phone = $request->deli_phone;
            $cab_sale_inv->csaleinv_deli_email = $request->deli_email;
            $cab_sale_inv->csaleinv_deli_address = $request->deli_address;
        }

        //TRANSPORTE
        $cab_sale_inv->csaleinv_tran_cust = $request->checked;

        //SINO NO TRAIGO ID DEL FORMULARIO, LO REGISTRO

        if ($request->id_trans == null && $request->checked != null && $request->id_cust != null) {

            $cab_sale_inv->csaleinv_transport = $request->id_cust;

        }elseif($request->id_trans == null && $request->checked != null && $request->id_cust == null){

            $customer = Customer::all();
            $cab_sale_inv->csaleinv_transport = $customer->last()->id_customer;

        }elseif ($request->id_trans == null && $request->checked == null && $request->trans_company != null) {
            $transport = new Transport();
            $transport->trans_company = $request->get('trans_company');
            $transport->trans_phone = $request->get('trans_phone');
            $transport->trans_email = $request->get('trans_email');
            $transport->id_status = 1;
            $transport->save();

            $transport = Transport::all();
            $cab_sale_inv->csaleinv_transport = $transport->last()->id_transport;

        }elseif ($request->id_trans != null) {
            $cab_sale_inv->csaleinv_transport = $request->id_trans;
        }

        $cab_sale_inv->csaleinv_driver_name = $request->csaleinv_driver_name;
        $cab_sale_inv->csaleinv_driver_phone = $request->csaleinv_driver_phone;
        $cab_sale_inv->csaleinv_date_pick_up = $request->csaleinv_date_pick_up;
        $cab_sale_inv->csaleinv_date_time = $request->csaleinv_date_time;
        $cab_sale_inv->csaleinv_date_delivery = $request->csaleinv_date_delivery;
        $cab_sale_inv->csaleinv_appointment_selet = $request->optionsRadios;
        $cab_sale_inv->csaleinv_appointment = $request->csaleinv_appointment;
        
        $cab_sale_inv->csaleinv_chep_pallet = $request->csaleinv_chep_pallet;
        $cab_sale_inv->csaleinv_shrink_wrap = $request->csaleinv_shrink_wrap;
        $cab_sale_inv->csaleinv_palletization = $request->csaleinv_palletization;
        

        

        

        $a = count($request->it_code);

        //INVENTARIO LOCACION
        foreach ($request->dsaleinv_qty as $key_qty_req => $qty_req) {
            foreach ($request->id_ware as $key_ware_req => $ware_req) {
                foreach ($request->id_inv as $key_inv_req => $inv_req) {
                    if ($key_qty_req == $key_ware_req && $key_ware_req == $key_inv_req) {

                         $inv_ware_qty[$inv_req][$ware_req] = $qty_req ;
                    }
                   
                }
               
            }
        }
        
        foreach ($inv_ware_qty as $key_inv_ware_qty => $inv_ware_qty_value) {

            $inv_ware_qty[$key_inv_ware_qty]=array_filter($inv_ware_qty_value);
        }

        $filtre_inv_ware_qty = array_filter($inv_ware_qty);
        //dd($filtre_inv_ware_qty);
        
        foreach ($filtre_inv_ware_qty as $key_filtre_inv_ware_qty => $filtre_inv_ware_qty_value) {
            $inv_qty_sum[$key_filtre_inv_ware_qty] = array_sum($filtre_inv_ware_qty_value);
        }
        
        /*foreach ($inv_qty_sum as $key_inv_qty_sum => $val_inv_qty_sum) {

            $inven_item = Inventory::findOrFail($key_inv_qty_sum);
            
            $det_sale_inv = new Det_Sale_Inventory();

            $det_sale_inv->id_item = $inven_item->id_item;
            $det_sale_inv->dsaleinv_lot = $inven_item->inv_lot;
            $det_sale_inv->dsaleinv_qty = $val_inv_qty_sum;

            $cab_sale_inv->save();

            $det_sale_inv->id_csale_inventory = $cab_sale_inv->id_csale_inventory;

            $det_sale_inv->save();
        }*/

        foreach ($filtre_inv_ware_qty as $key_filtre_inv_ware_qty => $val_filtre_inv_ware_qty) {


            foreach ($val_filtre_inv_ware_qty as $key_val_filtre_inv_ware_qty => $val_val_filtre_inv_ware_qty) {
                //dd($key_filtre_inv_ware_qty);

                $inven_item = Inventory::findOrFail($key_filtre_inv_ware_qty);
            
                $det_sale_inv = new Det_Sale_Inventory();

                $det_sale_inv->id_item = $inven_item->id_item;
                $det_sale_inv->dsaleinv_lot = $inven_item->inv_lot;
                $det_sale_inv->dsaleinv_qty = $val_val_filtre_inv_ware_qty;
                $det_sale_inv->id_warehouse = $key_val_filtre_inv_ware_qty;

                $cab_sale_inv->save();

                $det_sale_inv->id_csale_inventory = $cab_sale_inv->id_csale_inventory;

                $det_sale_inv->save();
                
            }
        }

        foreach ($filtre_inv_ware_qty as $key_filtre_inv_ware_qty => $val_filtre_inv_ware_qty) {

            foreach ($val_filtre_inv_ware_qty as $key_val_filtre_inv_ware_qty => $val_val_filtre_inv_ware_qty) {

                $inv_loc = Inv_location::where('id_inv',$key_filtre_inv_ware_qty)->where('id_warehouse',$key_val_filtre_inv_ware_qty)->first();
               
                $new_qty = $inv_loc->inv_location_qty-$val_val_filtre_inv_ware_qty;

                $inv_loc->inv_location_qty = $new_qty;
                $inv_loc->save();
                
            }
        }
        
        return Redirect::to('inventory/sale/show/'.$cab_sale_inv->id_csale_inventory);
    }
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    
    public function show($id)
    {
        $cab_sale_inv = Cab_Sale_Inventory::findOrFail($id);

        $det_sale_inv = Det_Sale_Inventory::with('item', 'warehouse')->where('id_csale_inventory', $id)->get();
        //dd($det_sale_inv);

        $qty=0;
        foreach ($det_sale_inv as $sale_qty) {
            $qty = $sale_qty->dsaleinv_qty+$qty;
        }

        foreach ($det_sale_inv as $det_sale_ware) {
            $ware[] = $det_sale_ware->id_warehouse;
        }
        $uniq_ware = array_unique($ware);
        
        
        $doc_sale_inv = Doc_sale_inventory::where('id_csale_inventory', $id)->get();
        $unit = Unit::all();

        foreach ($det_sale_inv as $key) {
            $lote[] = $key->dsaleinv_lot;
        }

        $inbound_order_det = Det_inbound_order::whereIn('diord_lot', $lote)->get();
        

        $document_view = Document::where('doc_tabla', 'Sale')->get();

        if (count( $doc_sale_inv)>0) {
            foreach ($document_view as $value) {
                foreach ($doc_sale_inv as $doc_sale) {

                    if ($value->id_doc == $doc_sale->id_doc) {
                       $a[$value->doc_description] = $doc_sale->docsinven_ruta;
                    }
                    
                }
            }

            foreach ($a as $key => $value) {
                foreach ($document_view as $doc_sale) {

                    if (array_key_exists($doc_sale->doc_description, $a)) {
                        //dd("The 'first' element is in the array");
                    }else{
                        $a = array_add($a, $doc_sale->doc_description, 0);
                    }
                    $a[$key]=$value;
                }
            }
        
            $collection = Collection::make($a);
            //dd($a);
        }else{
            foreach ($document_view as $value) {
                $a[$value->doc_description] = 0;
            }
            $collection = Collection::make($a);
        }

        $document_modal = Document::where('doc_tabla', 'Sale')->where('id_status', 1)->get();

        $warehouse = Warehouse::whereIn('id_warehouse', $uniq_ware)->get();
        //dd($warehouse);

        return view('layouts.inventory.show_sale', compact('cab_sale_inv', 'det_sale_inv', 'unit', 'inbound_order_det', 'document_view', 'doc_sale_inv', 'collection', 'document_modal', 'qty', 'warehouse'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
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
        if ($request->file('documents')) { //nombre del input (boton)

            foreach ($request->file('documents') as $key => $value) {

                $file = $request->file('documents')[$key];
                $documents = time() . $file->getClientOriginalName();   //generar nombre unico a la imagen
                $path = public_path(). '/documents/sale'; // ruta donde guardamos la imagen
                $file->move($path, $documents); // Movemos la imagen a la carpeta

                $inventory_sale_doc = new Doc_sale_inventory();
                $inventory_sale_doc->docsinven_ruta = $documents;
                $inventory_sale_doc->id_doc = $request->id_doc[$key];
                $inventory_sale_doc->id_csale_inventory = $id;
                $inventory_sale_doc->save();
            }
        }

        session()->put('update','Item created successfully.');
        return Redirect::to('inventory/sale/show/'. $id);
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

    /**
     * Generar documentos
    **/
    public function pdf($id)
    {
        $cab_sale_inv = Cab_Sale_Inventory::findOrFail($id);

        $det_sale_inv = Det_Sale_Inventory::with('item', 'warehouse')->where('id_csale_inventory', $id)->get();
        //dd($det_sale_inv);

        $unit = Unit::all();

        foreach ($det_sale_inv as $key) {
            $lote[] = $key->dsaleinv_lot;
        }

        foreach ($det_sale_inv as $det_sale_ware) {
            $ware[] = $det_sale_ware->id_warehouse;
        }
        $uniq_ware = array_unique($ware);

        $inbound_order_det = Det_inbound_order::whereIn('diord_lot', $lote)->get(); 

        $qty=0;
        foreach ($det_sale_inv as $sale_qty) {
            $qty = $sale_qty->dsaleinv_qty+$qty;
        }

        $warehouse = Warehouse::whereIn('id_warehouse', $uniq_ware)->get();
        //dd($warehouse);
        

        $pdf = PDF::loadView('layouts.inventory.pdf.show_sale', compact('cab_sale_inv', 'det_sale_inv', 'unit', 'inbound_order_det', 'qty', 'warehouse'));

        return $pdf->stream('BillOfLading-BUFALINDAUSA.pdf');
        //return $pdf->download('listado.pdf');
    }

    public function email(Request $request)
    {
        //PDF
        $cab_sale_inv = Cab_Sale_Inventory::with('cust', 'user')->findOrFail($request->id);

        $det_sale_inv = Det_Sale_Inventory::with('item', 'warehouse')->where('id_csale_inventory', $request->id)->get();

        $unit = Unit::all();

        foreach ($det_sale_inv as $key) {
            $lote[] = $key->dsaleinv_lot;
        }

        foreach ($det_sale_inv as $det_sale_ware) {
            $ware[] = $det_sale_ware->id_warehouse;
        }
        $uniq_ware = array_unique($ware);
        
        $inbound_order_det = Det_inbound_order::whereIn('diord_lot', $lote)->get(); 

        $qty=0;
        foreach ($det_sale_inv as $sale_qty) {
            $qty = $sale_qty->dsaleinv_qty+$qty;
        }

        $warehouse = Warehouse::whereIn('id_warehouse', $uniq_ware)->get();

        //CORREO
        $emails_cliente[] = $cab_sale_inv->cust->cust_email;
        $emails_seller[] = $cab_sale_inv->user->email;

        if ($cab_sale_inv->csaleinv_tran_cust != null) {
            $emails_transport = $cab_sale_inv->cust->cust_email;
        }else{
            $emails_transport = $cab_sale_inv->trans->trans_email;
        }
        
        $logo = asset('assets/img/logosinsloganconsombra1.png');

        $data = array(
                'logo' => $logo,
                'cab_sale_inv' => $cab_sale_inv,
                'det_sale_inv' => $det_sale_inv,
                
            );

        Mail::send('email.cliente', $data , function ($message) use ($emails_cliente, $cab_sale_inv, $det_sale_inv, $inbound_order_det, $qty, $warehouse){

            $pdf = PDF::loadView('layouts.inventory.pdf.show_sale', compact('cab_sale_inv', 'det_sale_inv', 'unit', 'inbound_order_det', 'qty', 'warehouse'));

            $message->from('no-reply@bufalinda.com', 'BUFALINDA USA');
            $message->to($emails_cliente)->subject('BILL OF LADING');

            $message->attachData($pdf->output(), 'BUFALINDAUSA.pdf');
        });
        Mail::send('email.seller', $data , function ($message) use ($emails_seller, $cab_sale_inv, $det_sale_inv, $inbound_order_det, $qty, $warehouse){

            $pdf = PDF::loadView('layouts.inventory.pdf.show_sale', compact('cab_sale_inv', 'det_sale_inv', 'unit', 'inbound_order_det', 'qty', 'warehouse'));

            $message->from('no-reply@bufalinda.com', 'BUFALINDA USA');
            $message->to($emails_seller)->subject('BILL OF LADING');

            $message->attachData($pdf->output(), 'BUFALINDAUSA.pdf');
        });
        Mail::send('email.transport', $data , function ($message) use ($emails_transport, $cab_sale_inv, $det_sale_inv, $inbound_order_det, $qty, $warehouse){

            $pdf = PDF::loadView('layouts.inventory.pdf.show_sale', compact('cab_sale_inv', 'det_sale_inv', 'unit', 'inbound_order_det', 'qty', 'warehouse'));

            $message->from('no-reply@bufalinda.com', 'BUFALINDA USA');
            $message->to($emails_transport)->subject('BILL OF LADING');

            $message->attachData($pdf->output(), 'BUFALINDAUSA.pdf');
        });
        foreach ($warehouse as $wareh) {
            $ware_ema[] = $wareh->house_email;
            $ware_ema[] = $wareh->house_email_two;
            $ware_ema[] = $wareh->house_email_three;

            //dd($wareh);
            $emails_warehouse = array_filter($ware_ema);
            
            $data = array(
                'logo' => $logo,
                'cab_sale_inv' => $cab_sale_inv,
                'wareh' => $wareh,
            );
            //dd($data);

            Mail::send('email.warehouse', $data , function ($message) use ($emails_warehouse, $cab_sale_inv, $det_sale_inv, $inbound_order_det, $qty, $warehouse, $wareh){

                $pdf = PDF::loadView('layouts.inventory.pdf.show_trans_sale', compact('cab_sale_inv', 'det_sale_inv', 'unit', 'inbound_order_det', 'qty', 'warehouse', 'wareh'));

                $message->from('no-reply@bufalinda.com', 'BUFALINDA USA');
                $message->to($emails_warehouse)->subject('BILL OF LADING');

                $message->attachData($pdf->output(), 'BUFALINDAUSA.pdf');
            });
        }
        //dd($emails_warehouse);

        return Redirect::to('inventory/sale/show/'.$cab_sale_inv->id_csale_inventory);
    }

    /*public function email(Request $request)
    {
        //PDF
        $cab_sale_inv = Cab_Sale_Inventory::with('cust', 'user')->findOrFail($request->id);
        dd($cab_sale_inv);
        
        $det_sale_inv = Det_Sale_Inventory::with('item')->where('id_csale_inventory', $request->id)->get();

        $unit = Unit::all();

        foreach ($det_sale_inv as $key) {
            $lote[] = $key->dsaleinv_lot;
        }

        foreach ($det_sale_inv as $det_sale_ware) {
            $ware[] = $det_sale_ware->id_warehouse;
        }
        $uniq_ware = array_unique($ware);

        $inbound_order_det = Det_inbound_order::whereIn('diord_lot', $lote)->get(); 

        $qty=0;
        foreach ($det_sale_inv as $sale_qty) {
            $qty = $sale_qty->dsaleinv_qty+$qty;
        }

        $warehouse = Warehouse::where('house_step', '0')->get();

        //CORREO
        $emails = array_filter($request->optionsCheckboxes);
        
        $logo = asset('assets/img/logosinsloganconsombra1.png');

        $data = array(
            'logo' => $logo,
            'cab_sale_inv' => $cab_sale_inv,
        );

        Mail::send('email.cliente', $data , function ($message) use ($emails, $cab_sale_inv, $det_sale_inv, $inbound_order_det, $qty, $warehouse){

            $pdf = PDF::loadView('layouts.inventory.pdf.show_sale', compact('cab_sale_inv', 'det_sale_inv', 'unit', 'inbound_order_det', 'qty', 'warehouse'));

            $message->from('no-reply@bufalinda.com', 'BUFALINDA USA');
            $message->to($emails)->subject('BILL OF LADING');

            //$message->attachData($pdf->output(), 'BUFALINDAUSA.pdf');
        });
        Mail::send('email.transport', $data , function ($message) use ($emails, $cab_sale_inv, $det_sale_inv, $inbound_order_det, $qty, $warehouse){

            $pdf = PDF::loadView('layouts.inventory.pdf.show_sale', compact('cab_sale_inv', 'det_sale_inv', 'unit', 'inbound_order_det', 'qty', 'warehouse'));

            $message->from('no-reply@bufalinda.com', 'BUFALINDA USA');
            $message->to($emails)->subject('BILL OF LADING');

            //$message->attachData($pdf->output(), 'BUFALINDAUSA.pdf');
        });
        Mail::send('email.warehouse', $data , function ($message) use ($emails, $cab_sale_inv, $det_sale_inv, $inbound_order_det, $qty, $warehouse){

            $pdf = PDF::loadView('layouts.inventory.pdf.show_sale', compact('cab_sale_inv', 'det_sale_inv', 'unit', 'inbound_order_det', 'qty', 'warehouse'));

            $message->from('no-reply@bufalinda.com', 'BUFALINDA USA');
            $message->to($emails)->subject('BILL OF LADING');

            //$message->attachData($pdf->output(), 'BUFALINDAUSA.pdf');
        });

        return Redirect::to('inventory/sale/show/'.$cab_sale_inv->id_csale_inventory);
    }*/

    public function batch(Request $request)
    {
        $batch = $request->select_batch;

        $batch_index = Det_Sale_Inventory::select('id_dsale_inventory', 'dsaleinv_lot', 'customer.id_customer', 'det_sale_inventory.id_csale_inventory','id_item', 'customer.cust_company', 'csaleinv_invoice', 'csaleinv_date')
                    ->join('cab_sale_inventory', 'det_sale_inventory.id_csale_inventory', '=', 'cab_sale_inventory.id_csale_inventory')
                    ->where('det_sale_inventory.dsaleinv_lot',$batch)
                    ->join('customer', 'cab_sale_inventory.id_customer', '=', 'customer.id_customer')
                    ->orderBy('det_sale_inventory.id_dsale_inventory', 'ASC')->get();

        return response()->json($batch_index);
    }

    public function pdf_batch(Request $request)
    {
        dd($request->id);

        
        $pdf_batch = $request->id;
        dd($pdf_batch);
        $cab_sale_inv = Cab_Sale_Inventory::findOrFail($id);

        $det_sale_inv = Det_Sale_Inventory::with('item')->where('id_csale_inventory', $id)->get();

        $unit = Unit::all();

        foreach ($det_sale_inv as $key) {
            $lote[] = $key->dsaleinv_lot;
        }

        $inbound_order_det = Det_inbound_order::whereIn('diord_lot', $lote)->get(); 

        $qty=0;
        foreach ($det_sale_inv as $sale_qty) {
            $qty = $sale_qty->dsaleinv_qty+$qty;
        }

        $warehouse = Warehouse::where('house_step', '0')->get();
        

        $pdf = PDF::loadView('layouts.inventory.pdf.show_sale', compact('cab_sale_inv', 'det_sale_inv', 'unit', 'inbound_order_det', 'qty', 'warehouse'));

        return $pdf->stream('BillOfLading-BUFALINDAUSA.pdf');
        //return $pdf->download('listado.pdf');
    }
}
