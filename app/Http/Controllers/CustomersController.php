<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Redirect;
use App\Http\Requests\CustomerRequest;
use Illuminate\Http\Request;
use App\Cab_Sale_Inventory;
use App\Customer;
use App\Status;

class CustomersController extends Controller
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
        $status_modal = Status::where('tabla', 'General')->orderBy('id_status', 'ASC')->pluck('status','id_status');
        $status = Status::where('tabla', 'General')->orderBy('id_status', 'ASC')->get();
        $customer = Customer::all();

        foreach ($customer as $cust) {
            if ($cust->cust_sucursal == 'C') {
                $custo[$cust->cust_num_sucursal] = $cust->cust_company;
            }
        }

        if (!isset($custo)) {
            $custo= 0;
        }

        $cust_sucursal = Customer::where('cust_sucursal','!=' ,'S')->orderBy('id_customer', 'ASC')->pluck('cust_company','id_customer');
        $cust_sucur_tiene = Customer::where('cust_sucursal','U')->orderBy('id_customer', 'ASC')->pluck('cust_company','id_customer');
        $cust_sucur_es = Customer::where('cust_sucursal','C')->orderBy('id_customer', 'ASC')->pluck('cust_company','id_customer');
        //dd($cust_sucursal);

        return view('layouts.customers.index', compact('status', 'customer', 'status_modal', 'custo', 'cust_sucursal', 'cust_sucur_tiene', 'cust_sucur_es'));
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
    public function store(CustomerRequest $request)
    {
        if ($request->cust_sucursal[0] == null) {

            $customer = new Customer();
            $customer->cust_company = $request->get('cust_company')[0];
            $customer->cust_phone = $request->get('cust_phone')[0];
            $customer->cust_address = $request->get('cust_address')[0];
            $customer->cust_email = $request->get('cust_email')[0];
            $customer->cust_tax = $request->get('cust_tax')[0];
            $customer->cust_contact = $request->get('cust_contact')[0];
            $customer->cust_sucursal = 'U';
           // $customer->cust_num_sucursal = $cant;
            $customer->id_status = $request->get('id_status')[0];
            $customer->save(); 
        }
        if ($request->cust_sucursal[0] == 'C') {

            $sucur = $request->cust_sucursal;

            foreach ($sucur as $key_sust => $val_sut) {
                if ($val_sut == null) {
                    $sucur[$key_sust] = 'S';
                }
            }
            $customer = Customer::where('cust_sucursal', 'C')->get();
            $cant = count($customer)+1;

            foreach ($request->get('cust_company') as $key => $value) {
                $customer = new Customer();
                $customer->cust_company = $request->get('cust_company')[$key];
                $customer->cust_phone = $request->get('cust_phone')[$key];
                $customer->cust_address = $request->get('cust_address')[$key];
                $customer->cust_email = $request->get('cust_email')[$key];
                $customer->cust_tax = $request->get('cust_tax')[$key];
                $customer->cust_contact = $request->get('cust_contact')[$key];
                $customer->cust_sucursal = $sucur[$key];
                $customer->cust_num_sucursal = $cant;
                $customer->id_status = $request->get('id_status')[$key];
                $customer->save(); 
            }
        }

        session()->put('store','Item created successfully.');

        return Redirect::to('master/customers');
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
        //dd($request->all());
        $customer = Customer::findOrFail($id);
        $customer->cust_company = $request->get('cust_company');
        $customer->cust_phone = $request->get('cust_phone');
        $customer->cust_address = $request->get('cust_address');
        $customer->cust_email = $request->get('cust_email');
        $customer->cust_tax = $request->get('cust_tax');
        $customer->cust_contact = $request->get('cust_contact');
        $customer->id_status = $request->get('id_status');

        if ($request->get('sucursal_checked') == 'No') {
            $customer->cust_sucursal = 'U';
            $customer->cust_num_sucursal = null;
        }
        if ($request->get('sucursal_checked') == 'Es') {

            $cust_es = Customer::findOrFail($request->sucursal_es);
            $customer->cust_sucursal = 'S';
            $customer->cust_num_sucursal = $cust_es->cust_num_sucursal;
        }
        if ($request->get('sucursal_checked') == 'C') {

            $cust_cabezera = Customer::where('cust_sucursal', 'C')->get();
            $cant = count($cust_cabezera)+1;

            $customer->cust_sucursal = 'C';
            $customer->cust_num_sucursal = $cant;

            $cust_upate = Customer::findOrFail($request->sucursal_tiene);
            $cust_upate->cust_sucursal = 'S';
            $cust_upate->cust_num_sucursal = $cant;
            $cust_upate->save();
        }
        if ($request->get('sucursal_checked') == 'Other') {

            $cust_cabezera = Customer::where('cust_sucursal', 'C')->get();
            $cant = count($cust_cabezera)+1;

            $cust_upate = Customer::findOrFail($request->sucursal_es);

            if ($cust_upate->cust_sucursal == 'U') {

                $cust_upate->cust_sucursal = 'C';
                $cust_upate->cust_num_sucursal = $cant;
                $cust_upate->save();

                $customer->cust_sucursal = 'S';
                $customer->cust_num_sucursal = $cant;
            }
            elseif ($cust_upate->cust_sucursal == 'C') {

                $customer->cust_sucursal = 'S';
                $customer->cust_num_sucursal = $cust_upate->cust_num_sucursal;
            }
        }
        $customer->save();

        session()->put('update','Item created successfully.');

        return Redirect::to('master/customers');
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
        $Cab_Sale_Inventory = Cab_Sale_Inventory::where('id_customer',$request->id)->get();

        //Se obtiene la prueba seleccionada
        $customer = Customer::find($request->id);
        if(!empty($customer)){
            //si un dato posee esa prueba no puede ser elimada
            if ($Cab_Sale_Inventory->count()>0) {
                return 0;
            }else{
                $customer->delete();
                return 1;
            }
        }else{
            return 0;
        }
    }
}
