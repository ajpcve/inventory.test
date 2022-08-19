<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Redirect;
use App\Http\Requests\UnitRequest;
use Illuminate\Http\Request;
use App\Status;
use App\Unit;
use App\Item;

class UnitsController extends Controller
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
        $unit = Unit::all();
        return view('layouts.units.index', compact('status', 'unit'));
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
    public function store(UnitRequest $request)
    {
        $unit = new unit();
        $unit->unit = $request->get('unit');
        $unit->id_status = $request->get('id_status');
        $unit->save(); 

        session()->put('store','Item created successfully.');

        return Redirect::to('master/units');
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
        $unit = Unit::findOrFail($id);
        $unit->unit = $request->get('unit');
        $unit->id_status = $request->get('id_status');
        $unit->save(); 

        session()->put('update','Item created successfully.');

        return Redirect::to('master/units');
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
        $item = Item::where('id_status',$request->id)->get();        
        
        //Se obtiene la prueba seleccionada
        $unit = Unit::find($request->id);
        if(!empty($unit)){
            //si un dato posee esa prueba no puede ser elimada
            if ($item->count()>0) {
                return 0;
            }else{
                $unit->delete();
                return 1;
            }
        }else{
            return 0;
        }
    }
}
