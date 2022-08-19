<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Redirect;
use App\Http\Requests\StatusRequest;
use Illuminate\Http\Request;
use App\Cab_inbound_order;
use App\Transport;
use App\Warehouse;
use App\Customer;
use App\Status;
use App\Unit;
use App\Item;

class StatusController extends Controller
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
        $status = Status::all();
        return view('layouts.admin.status.index', compact('status'));
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StatusRequest $request)
    {
        $status = new Status();
        $status->status = $request->get('status');
        $status->tabla = $request->get('tabla');
        $status->save(); 

        session()->put('store','Item created successfully.');

        return Redirect::to('/admin/status');
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
        $status = Status::findOrFail($id);
        $status->status = $request->get('status');
        $status->tabla = $request->get('tabla');
        $status->save();

        session()->put('update','Item created successfully.');

        return Redirect::to('/admin/status');
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
        $Cab_inbound_order = Cab_inbound_order::where('id_status',$request->id)->get();
        $warehouse = Warehouse::where('id_status',$request->id)->get();
        $transport = Transport::where('id_status',$request->id)->get();
        $customer = Customer::where('id_status',$request->id)->get();
        $item = Item::where('id_status',$request->id)->get();        
        $unit = Unit::where('id_status',$request->id)->get();

        //Se obtiene la prueba seleccionada
        $status = Status::find($request->id);
        if(!empty($status)){
            //si un dato posee esa prueba no puede ser elimada
            if ($warehouse->count()>0 || $transport->count()>0 || $customer->count()>0 || $item->count()>0 || $unit->count()>0 || $Cab_inbound_order->count()>0) {
                return 0;
            }else{
                $status->delete();
                return 1;
            }
        }else{
            return 0;
        }
        
        
    }
}
