<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Redirect;
use App\Http\Requests\TransportRequest;
use Illuminate\Http\Request;
use App\Cab_Sale_Inventory;
use App\Transport;
use App\Status;

class TransportController extends Controller
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
        $transport = Transport::all();

        return view('layouts.transport.index', compact('status', 'transport'));
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
    public function store(TransportRequest $request)
    {
        $transport = new Transport();
        $transport->trans_company = $request->get('trans_company');
        $transport->trans_phone = $request->get('trans_phone');
        $transport->trans_address = $request->get('trans_address');
        $transport->trans_email = $request->get('trans_email');
        $transport->trans_contact = $request->get('trans_contact');
        $transport->id_status = $request->get('id_status');
        $transport->save(); 

        session()->put('store','Item created successfully.');

        return Redirect::to('master/transport');
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
        $transport = Transport::findOrFail($id);
        $transport->trans_company = $request->get('trans_company');
        $transport->trans_phone = $request->get('trans_phone');
        $transport->trans_address = $request->get('trans_address');
        $transport->trans_email = $request->get('trans_email');
        $transport->id_status = $request->get('id_status');
        $transport->save();

        session()->put('update','Item created successfully.');

        return Redirect::to('master/transport');
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
        $Cab_Sale_Inventory = Cab_Sale_Inventory::where('csaleinv_transport',$request->id)->whereNull('csaleinv_tran_cust')->get();

        //Se obtiene la prueba seleccionada
        $transport = Transport::find($request->id);
        if(!empty($transport)){
            //si un dato posee esa prueba no puede ser elimada
            if ($Cab_Sale_Inventory->count()>0) {
                return 0;
            }else{
                $transport->delete();
                return 1;
            }
        }else{
            return 0;
        }
    }
}
