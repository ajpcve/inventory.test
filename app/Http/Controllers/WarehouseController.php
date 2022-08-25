<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Redirect;
use App\Http\Requests\WarehouseRequest;
use Illuminate\Http\Request;
use App\Cab_inbound_order;
use App\Inv_location;
use App\Warehouse;
use App\Status;

class WarehouseController extends Controller
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
        $status = Status::where('tabla', 'General')->orderBy('id_status', 'ASC')->pluck('status','id_status');

        $warehouse = Warehouse::all();

        return view('layouts.warehouse.index', compact('status','warehouse'));
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
    public function store(WarehouseRequest $request)
    {
        //dd($request->all());
        $warehouse = new Warehouse();
        $warehouse->house_name = $request->get('house_name');
        $warehouse->house_address = $request->get('house_address');
        $warehouse->house_phone = $request->get('house_phone');

        if ($request->house_phone_two != null) {
            $warehouse->house_phone_two = $request->get('house_phone_two');
        }

        $warehouse->house_person = $request->get('house_person');
        $warehouse->house_description = $request->get('house_description');
        $warehouse->house_email = $request->get('house_email');

        if ($request->house_email_two != null) {
            $warehouse->house_email_two = $request->get('house_email_two');
        }

        if ($request->house_email_three != null) {
            $warehouse->house_email_three = $request->get('house_email_three');
        }

        $warehouse->id_status = $request->get('id_status');

        if ($request->optionsCheckboxes != null) {
            $Activity =  implode(",",$request->optionsCheckboxes);
            $warehouse->house_activity = $Activity;
        }

        $warehouse->house_step = $request->get('step');
        $warehouse->save();

        session()->put('store','Item created successfully.');

        return Redirect::to('master/warehouse');
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
        $warehouse = Warehouse::findOrFail($id);
        $warehouse->house_address = $request->get('house_address');
        $warehouse->house_address = $request->get('house_address');
        $warehouse->house_phone = $request->get('house_phone');

        if ($request->house_phone_two != null) {
            $warehouse->house_phone_two = $request->get('house_phone_two');
        }

        $warehouse->house_person = $request->get('house_person');
        $warehouse->house_description = $request->get('house_description');
        $warehouse->house_email = $request->get('house_email');

        if ($request->house_email_two != null) {
            $warehouse->house_email_two = $request->get('house_email_two');
        }

        if ($request->house_email_three != null) {
            $warehouse->house_email_three = $request->get('house_email_three');
        }

        $warehouse->id_status = $request->get('id_status');

        if ($request->optionsCheckboxes != null) {
            $Activity =  implode(",",$request->optionsCheckboxes);
            $warehouse->house_activity = $Activity;
        }
        $warehouse->house_step = $request->get('step');
        $warehouse->save();

        session()->put('update','Item created successfully.');

        return Redirect::to('master/warehouse');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        //Se obtiene el dato con la prueba que fue seleccionada
        $Cab_inbound_order = Cab_inbound_order::where('id_warehouse',$request->id)->get();
        $Inv_location = Inv_location::where('id_warehouse',$request->id)->get();

        //Se obtiene la prueba seleccionada
        $warehouse = Warehouse::find($request->id);
        if(!empty($warehouse)){
            //si un dato posee esa prueba no puede ser elimada
            if ($Cab_inbound_order->count()>0 || $Inv_location->count()>0) {
                return 0;
            }else{
                $warehouse->delete();
                return 1;
            }
        }else{
            return 0;
        }
    }
}
