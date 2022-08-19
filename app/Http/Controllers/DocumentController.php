<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Redirect;
use App\Http\Requests\DocumentRequest;
use Illuminate\Http\Request;
use App\Doc_inbound_order;
use App\Document;
use App\Status;

class DocumentController extends Controller
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
        $document = Document::all();
        
        return view('layouts.documents.index', compact('status', 'document'));
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
    public function store(DocumentRequest $request)
    {
        $document = new Document();
        $document->doc_description = $request->get('doc_description');
        $document->doc_tabla = $request->get('doc_tabla');
        $document->id_status = $request->get('id_status');
        $document->save(); 

        session()->put('store','Item created successfully.');

        return Redirect::to('master/documents');
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
        $document = Document::findOrFail($id);
        $document->doc_description = $request->get('doc_description');
        $document->doc_tabla = $request->get('doc_tabla');
        $document->id_status = $request->get('id_status');
        $document->save(); 

        session()->put('update','Item created successfully.');

        return Redirect::to('master/documents');
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
        $Doc_inbound_order = Doc_inbound_order::where('id_doc',$request->id)->get();

        //Se obtiene la prueba seleccionada
        $document = Document::find($request->id);
        if(!empty($document)){
            //si un dato posee esa prueba no puede ser elimada
            if ($Doc_inbound_order->count()>0) {
                return 0;
            }else{
                $document->delete();
                return 1;
            }
        }else{
            return 0;
        }
    }
}
