<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\ItemRequest;
use Illuminate\Http\Request;
use App\Det_Sale_Inventory;
use App\Det_inbound_order;
use App\Inventory;
use App\Status;
use App\Unit;
use App\Item;

class ItemController extends Controller
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
        //dd('a');
        $status = Status::where('tabla', 'General')->orderBy('id_status', 'ASC')->pluck('status','id_status');
        $unit = Unit::whereIn('id_status', ['1'])->orderBy('id_unit', 'ASC')->pluck('unit','id_unit');

        $item = Item::all();

        return view('layouts.item.index', compact('status', 'unit','item'));
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
    public function store(ItemRequest $request)
    {
        //dd('a');
        //MANIPULACION DE IMAGENES
        if ($request->file('item_ruta')) { //nombre del input (boton)
            $file = $request->file('item_ruta');
            $item_ruta = time() . $file->getClientOriginalName();   //generar nombre unico a la imagen
            $path = public_path(). '/inv_img/'; // ruta donde guardamos la imagen
            $file->move($path, $item_ruta); // Movemos la imagen a la carpeta
        }

        $item = new Item();
        $item->item_code = $request->get('item_code');
        $item->item_name = $request->get('item_name');
        $item->id_unit = $request->get('id_unit');
        $item->item_ruta = $item_ruta;
        $item->id_status = $request->get('id_status');
        $item->save(); 

        session()->put('store','Item created successfully.');

        return Redirect::to('master/item');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
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
        
        //VALIDACION
        $this->validate($request, [
            'item_ruta' => 'image',
        ]);
        
        //MANIPULACION DE IMAGENES
        if ($request->file('item_ruta')) { //nombre del input (boton)
            $file = $request->file('item_ruta');
            $item_ruta = time() . $file->getClientOriginalName();   //generar nombre unico a la imagen
            $path = public_path(). '/inv_img/'; // ruta donde guardamos la imagen
            $file->move($path, $item_ruta); // Movemos la imagen a la carpeta
        }

        $item = Item::findOrFail($id); 
        $item->item_code = $request->get('item_code');
        $item->item_name = $request->get('item_name');

        //Si la imagen existe
        if ($request->file('item_ruta')) { 
            $item->item_ruta = $item_ruta;
        }
        
        $item->id_unit = $request->get('id_unit');
        $item->id_status = $request->get('id_status');
        $item->save(); 

        session()->put('update','Item created successfully.');

        return Redirect::to('master/item');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $item = Item::find($request->id);
        
        //Se obtiene el dato con la prueba que fue seleccionada
        $Det_inbound_order = Det_inbound_order::where('diord_item_code',$item->item_code)->get();
        $Det_Sale_Inventory = Det_Sale_Inventory::where('id_item',$request->id)->get();
        $Inventory = Inventory::where('id_item',$request->id)->get();

        //Se obtiene la prueba seleccionada
        $item = Item::find($request->id);
        if(!empty($item)){
            //si un dato posee esa prueba no puede ser elimada
            if ($Det_inbound_order->count()>0 || $Det_Sale_Inventory->count()>0 || $Inventory->count()>0) {
                return 0;
            }else{
                $item->delete();
                return 1;
            }
        }else{
            return 0;
        }
    }
}
