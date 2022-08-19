@extends('welcome')

@section('title')
    Stock Transfers
@endsection

@section('extra-css')
    <style type="text/css">
    	.form-group {
            padding-bottom: 0px;
            margin: 0 0 5px 0;
        }
        .table-responsive{
            overflow: inherit;
            overflow-x: inherit;
        }
    </style>
@endsection

@section('content')

@if(count($inven_item) == 0)
    <div class="header text-center">
        <h3 class="title">Stock</h3>
        <p class="category">You still do not have anything in stock!</p>
    </div>
@else
    <div class="row">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title">Stock Transfers -
                    <small>Pallets and details</small>
                </h4>
            </div>
            <div class="card-content">
                <ul class="nav nav-pills nav-pills-success">
                    <li class="active">
                        <a href="#pill1" data-toggle="tab">Pallets</a>
                    </li>
                    <li>
                        <a href="#pill2" data-toggle="tab">Details</a>
                    </li>
                </ul>
                <div class="tab-content">
                    <div class="tab-pane active" id="pill1">
                        @foreach ($pallet as $key => $inven)
                            @foreach ($inven as $key_inv => $inv)
                            <div class="card">
                                <div class="card-content">
                                    <h4 class="card-title">Pallet {{$key_inv}}-{{$key}}</h4>
                                    @foreach ($valores as $key_val => $valor)
                                        @if($key_val == $key )
                                            @foreach ($valor as $key_va => $val)
                                                @if($key_va == $key_inv && $val == 1 )
                                                    <p class="category pull-right" style="margin-top: -30px;"> Move:
                                                    <a href="#" class="btn btn-simple btn-warning btn-icon" data-toggle="modal" data-target="#myModalExportPallet{{ $key}}" style="margin-top: -10px;"><i class="material-icons">exit_to_app</i></a>
                                                </p>
                                                @endif
                                            @endforeach
                                        @endif
                                    @endforeach
                                    <div class="table-responsive">
                                        <table class="table">
                                            <thead class="text-primary">
                                                <th>Product</th>
                                                <th>Batch</th>
                                                <th>Receipt Date</th>
                                                <th>Packs</th>
                                                <th>Expiration Date</th>
                                                <th>Quantity</th>
                                                <th>Location</th>
                                            </thead>
                                            <tbody>
                                                @foreach ($inbound_order as $inve_ord)
                                                    @if($inve_ord->ciord_orden_compra == $key && $inve_ord->diord_pallet == $key_inv)
                                                    <tr>
                                                        <td>
                                                            {{$inve_ord->item_name}}
                                                        </td>
                                                        <td>{{$inve_ord->inv_lot}}</td>
                                                        <td><?PHP echo date('m/d/Y',strtotime($inve_ord->inv_date));?></td>
                                                        
                                                        <td>
                                                            {{$inve_ord->unit}}
                                                        </td>
                                                        <td>
                                                            @foreach ($inbound_order as $ord_det)
                                                                @if($inve_ord->inv_lot == $ord_det->diord_lot)
                                                                    <?PHP echo date('m/d/Y',strtotime($ord_det->diord_expiration_date));?>
                                                                @endif
                                                            @endforeach
                                                        </td>
                                                        <td>
                                                            @foreach ($inv_loc as $invloc)
                                                                @if($inve_ord->id_inv == $invloc->id_inv)
                                                                    {{$invloc->inv_location_qty}} <br>
                                                                @endif
                                                            @endforeach
                                                        </td>
                                                        <td>
                                                            @foreach ($inv_loc as $invloc)
                                                                @if($inve_ord->id_inv == $invloc->id_inv)
                                                                    {{$invloc->warehouse->house_name}} <br>
                                                                @endif
                                                            @endforeach
                                                        </td>
                                                    </tr>
                                                    <div class="modal fade" id="myModalExportPallet{{ $key }}" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                                                        <div class="modal-dialog modal-md">
                                                            <div class="modal-content">
                                                                <div class="modal-header">
                                                                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
                                                                        <i class="material-icons">clear</i>
                                                                    </button>
                                                                    <h4 class="modal-title">Pallet {{$key_inv}}-{{$key}}</h4>
                                                                </div>
                                                                <div class="modal-body">
                                                                    <form action="{{ action('InventoryController@update') }}" method="POST" enctype="multipart/form-data">
                                                                    {{ csrf_field() }}
                                                                        <div class="row">
                                                                            <div class="col-md-4 col-md-offset-1">
                                                                                <div class="form-group">
                                                                                    <label class="control-label">Item</label>
                                                                                    <p>
                                                                                        Pallet {{$key_inv}}-{{$key}}
                                                                                        <input type="hidden" name="pallet" value="{{$key_inv}}">
                                                                                        <input type="hidden" name="orden" value="{{$key}}">
                                                                                    </p>
                                                                                </div>
                                                                            </div>
                                                                            <div class="col-md-4">
                                                                                <div class="form-group">
                                                                                    <label class="control-label">Move</label>
                                                                                    <p>{!! Form::select('bodega', $warehouse_bodega, null, ['class' => 'selectpicker form-group label-floating', 'data-style' => 'select-with-transition', 'data-size' => '7']) !!}</p>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                        <br>
                                                                        @foreach ($document as $doc)
                                                                        <input type="hidden" name="id_doc[]" value="{{ $doc->id_doc }}">
                                                                        <div class="row">
                                                                            <div class="col-md-offset-1 col-md-4 ">
                                                                                <div class="form-group">
                                                                                    <p>{{ $doc->doc_description}}</p>
                                                                                </div>
                                                                            </div>
                                                                            <div class="col-md-5">
                                                                                <div class="form-group label-floating">
                                                                                    <div class="fileinput fileinput-new " data-provides="fileinput">
                                                                                        <div class="fileinput-preview fileinput-exists thumbnail"></div>
                                                                                        <div>
                                                                                            <span class="btn btn-success btn-xs btn-file">
                                                                                                <span class="fileinput-new">Select document</span>
                                                                                                <span class="fileinput-exists">Change</span>
                                                                                                <input name="document_warehouse[]" type="file" accept="application/pdf" required />
                                                                                            </span>
                                                                                            <a href="#" class="btn btn-danger btn-xs fileinput-exists" data-dismiss="fileinput"><i class="fa fa-times"></i> Remove</a>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                        @endforeach
                                                                        <div class="row">
                                                                            <div class="col-md-offset-1">
                                                                                <div class="form-group">
                                                                                    <label class="control-label">Note:</label>
                                                                                    <p>The complete movement of the pallet will be made</p>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                        <div class="row">
                                                                            <button type="submit" class="btn btn-success btn-sm pull-right">Save</button>
                                                                        </div>
                                                                    </form>
                                                                    <div class="clearfix"></div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    @endif   
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        @endforeach
                    </div>
                    <div class="tab-pane" id="pill2">
                        @foreach ($inven_item as $inven)
                        <div class="card">
                            <div class="card-content">
                                <h4 class="card-title">{{$inven->item->item_name}}</h4>
                                <p class="category">{{$inven->item->item_code}}</p>
                                <div class="table-responsive">
                                    <table class="table">
                                        <thead class="text-primary">
                                            <th>Pallet</th>
                                            <th>Batch</th>
                                            <th>Receipt Date</th>
                                            <th>Purchase order</th>
                                            <th>Packs</th>
                                            <th>Expiration Date</th>
                                            <th>Quantity</th>
                                            <th>Location</th>
                                            <th>Move</th>
                                        </thead>
                                        <tbody>
                                            @foreach ($inbound_order as $inve)
                                                @if($inve->id_item == $inven->id_item)
                                                <tr>
                                                    <td>{{$inve->diord_pallet}}-{{$inve->ciord_orden_compra}}</td>
                                                    <td>{{$inve->inv_lot}}</td>
                                                    <td><?PHP echo date('m/d/Y',strtotime($inve->inv_date));?></td>
                                                    <td>
                                                        @foreach ($inbound_order as $ord_det)
                                                            @if($inve->inv_lot == $ord_det->diord_lot)
                                                                {{$ord_det->ciord_orden_compra}}
                                                            @endif
                                                        @endforeach
                                                    </td>
                                                    <td>
                                                        {{$inve_ord->unit}}
                                                    </td>
                                                    <td>
                                                        @foreach ($inbound_order as $ord_det)
                                                            @if($inve->inv_lot == $ord_det->diord_lot)
                                                                <?PHP echo date('m/d/Y',strtotime($ord_det->diord_expiration_date));?>
                                                            @endif
                                                        @endforeach
                                                    </td>
                                                    <td>
                                                        @foreach ($inv_loc as $invloc)
                                                            @if($inve->id_inv == $invloc->id_inv)
                                                                {{$invloc->inv_location_qty}} <br>
                                                            @endif
                                                        @endforeach
                                                    </td>
                                                    <td>
                                                        @foreach ($inv_loc as $invloc)
                                                            @if($inve->id_inv == $invloc->id_inv)
                                                                {{$invloc->warehouse->house_name}} <br>
                                                            @endif
                                                        @endforeach
                                                    </td>
                                                    <td>
                                                        <div class="checkbox">
                                                            <label>
                                                                <input type="checkbox" name="detalle[]" class="btn-simple detalles" value="{{$inve->inv_lot}}">
                                                            </label>
                                                        </div>
                                                    </td>
                                                </tr>
                                                @endif
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                        @endforeach
                        <div class="modal fade" id="myModalExport" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
                                            <i class="material-icons">clear</i>
                                        </button>
                                        <h4 class="modal-title">Move details</h4>
                                    </div>
                                    <div class="modal-body">
                                        <form action="{{ action('InventoryController@update') }}" method="POST" enctype="multipart/form-data" >
                                        {{ csrf_field() }}
                                            <div class="material-datatables">
                                                <table id="example1" class="table table-striped table-no-bordered table-hover table-shopping" cellspacing="0" width="100%" style="width:100%">
                                                    <thead>
                                                        <tr class="text-center">
                                                            <th class="text-center" width="150">Order</th>
                                                            <th class="text-center" width="200">Pallet</th>
                                                            <th class="text-center" width="100">Batch</th>
                                                            <th class="text-center" width="100">Qty item</th>
                                                            <th class="text-center" width="100">Move</th>
                                                            <th class="text-center" width="0"class="hidden"></th>
                                                            <th class="text-center" width="0"class="hidden"></th>
                                                            <th class="text-center" width="0"class="hidden"></th>
                                                            <th class="text-center" width="0"class="hidden"></th>
                                                        </tr>
                                                    </thead>
                                                </table>
                                            </div>
                                            <div class="row">
                                                <br>
                                                <div class="col-md-10"> 
                                                    <label class="col-sm-2 label-on-left">Move</label>
                                                    <div class="col-sm-10">
                                                        <div class="form-group label-floating is-empty has-success">
                                                            {!! Form::select('bodega', $warehouse_bodega, null, ['class' => 'selectpicker form-group label-floating', 'data-style' => 'select-with-transition', 'data-size' => '7']) !!}
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <br>
                                            @foreach ($document as $doc)
                                            <input type="hidden" name="id_doc[]" value="{{ $doc->id_doc }}">
                                            <div class="row">
                                                <div class="col-md-offset-1 col-md-4 ">
                                                    <div class="form-group">
                                                        <p>{{ $doc->doc_description}}</p>
                                                    </div>
                                                </div>
                                                <div class="col-md-5">
                                                    <div class="form-group label-floating">
                                                        <div class="fileinput fileinput-new " data-provides="fileinput">
                                                            <div class="fileinput-preview fileinput-exists thumbnail"></div>
                                                            <div>
                                                                <span class="btn btn-success btn-xs btn-file">
                                                                    <span class="fileinput-new">Select document</span>
                                                                    <span class="fileinput-exists">Change</span>
                                                                    <input name="doc_house[]" type="file" accept="application/pdf" required />
                                                                </span>
                                                                <a href="#" class="btn btn-danger btn-xs fileinput-exists" data-dismiss="fileinput"><i class="fa fa-times"></i> Remove</a>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            @endforeach
                                            <div class="row">
                                                <button type="submit" class="btn btn-success btn-sm pull-right">Save</button>
                                            </div>
                                        </form>
                                        <div class="clearfix"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-offset-10">
                            <a id="sub" class="btn btn-success" data-toggle="modal" data-target="#myModalExport" onclick="modal_detalle('')">
                                <span class="btn-label">
                                    <i class="material-icons">exit_to_app</i>
                                </span>
                                Move
                            </a>
                        </div>
                        <div class="row clearfix"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endif


@endsection

@section('extra-script')
<script type="text/javascript">
    $("input:checkbox.detalles").on('change', function() {
        $('#sub').prop("disabled",$($("input:checkbox.detalles").is(":checked")).length == 0);
    }).trigger('change');

    function modal_detalle() {

        let valoresCheck = [];

        $("input:checkbox.detalles:checked").each(function(){
            valoresCheck.push(this.value);
        });

        $.ajax({
            url: "{{ route('inventory/modal_detalle') }}",
            method: 'get',
            data: {
                costum: valoresCheck,
            },
            success: function(deli) {
                $('#example1').DataTable({
                    "destroy": true,
                    "data": deli,
                     columnDefs:[
                        {
                            targets: 4,
                            searchable: false,
                            orderable: false,
                            render: function(data, type, full, meta){
                                if(type === 'display'){
                                    data = '<input type="number" name="detalle[]" class="form-control" max="' + data + '" min="1" required>'; 
                                }
                                return data;
                            }
                        },
                        {
                            targets: 5,
                            render: function(data, type, full, meta){
                                if(type === 'display'){
                                    data = '<input type="hidden" name="lot[]" value="' + data + '" required>';
                                }
                                return data;
                            }
                        },
                        {
                            targets: 6,
                            render: function(data, type, full, meta){
                                if(type === 'display'){
                                    data = '<input type="hidden" name="lot_ord[]" value="' + data + '" required>';
                                }
                                return data;
                            }
                        },
                        {
                            targets: 7,
                            render: function(data, type, full, meta){
                                if(type === 'display'){
                                    data = '<input type="hidden" name="or_com[]" value="' + data + '" required>';
                                }
                                return data;
                            }
                        },
                        {
                            targets: 8,
                            render: function(data, type, full, meta){
                                if(type === 'display'){
                                    data = '<input type="hidden" name="pallet_det[]" value="' + data + '" required>';
                                }
                                return data;
                            }
                        }
                    ],
                    "columns":[
                        {"data":"ciord_orden_compra"},
                        {"data":"diord_pallet"},
                        {"data":"diord_lot"},
                        {"data":"diord_qty"},
                        {"data":"diord_qty"},  
                        {"data":"id_inventory_location"},
                        {"data":"inv_lot"},
                        {"data":"id_ciord"},
                        {"data":"diord_pallet"},
                    ]
                });
            }
        });
    }

    @if(Session::has('pallet_fine'))
        demo.showSaveSuccess('top','center');

        @php
            Session::forget('pallet_fine');
        @endphp
    @endif
</script>
@endsection