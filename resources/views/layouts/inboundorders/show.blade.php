@extends('welcome')

@section('title')
    Detail inbound Order #{{$inbound_order->ciord_orden_compra}}
@endsection

@section('extra-css')
    <style type="text/css">
        .row{
            margin-top: -15px;
        }
    </style>
@endsection

@section('content')
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><i class="material-icons">clear</i></button>
                <h5 class="modal-title" id="myModalLabel">Send email</h5>
            </div>
            <form action="{{ url('inbound_orders/email') }} " method="get" >
                <input type="hidden" name="id" value="{{$inbound_order->id_ciord}}">
                <div class="modal-body">
                    <div class="material-datatables">
                        <table id="datatables" class="table table-striped table-no-bordered table-hover table-shopping" cellspacing="0" width="100%" style="width:100%">
                            <thead>
                                <tr>
                                    <th width="100"><b>Name</b></th>
                                    <th width="200"><b>Phone</b></th>
                                    <th width="50"><b>Email</b></th>
                                    <th width="100" class="disabled-sorting "><b>Select</b></th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($users as $item)
                                <tr>
                                    <td>{{ $item->name}}</td>
                                    <td>{{ $item->phone}}</td>
                                    <td>{{ $item->email}}</td>
                                    <td>
                                        <div class="checkbox" >
                                            <label>
                                                <input type="checkbox" name="optionsCheckboxes[]" class="detalles" value="{{ $item->email}}" checked>
                                            </label>
                                        </div>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div class="clearfix"></div>
                </div>
                <div class="modal-footer text-center">
                    <button id="sub" type="submit" class="btn btn-info btn-round" onclick="demo.loader()">Send! </button>
                </div>
            </form>
        </div>
    </div>
</div>
<div class="row" style="margin-top: 15px">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header card-header-icon" data-background-color="green">
                <i class="material-icons">library_books</i>
            </div>
            <div class="card-content">
                <h4 class="card-title">Detail inbound Order #{{$inbound_order->ciord_orden_compra}}-
                    <small class="category">Order Information</small>
                    @if($inbound_order->id_status == 4)
                        <a href="{{ url('inbound_orders/edit/'. $inbound_order->id_ciord) }} " class="btn btn-success btn-sm pull-right">Edit</a>
                        <a class="btn btn-warning btn-simple btn-icon pull-right" rel="tooltip" data-placement="left" title="Release" onclick="demo.showRelease('{{ $inbound_order->id_ciord }}','{{csrf_token()}}','../../inbound_orders/update/{{ $inbound_order->id_ciord }}')" style="margin-top: 0px; margin-bottom: -10px">
                            <i class="material-icons">done_all</i> Release
                        </a>
                    @endif
                    @if($inbound_order->id_status == 3)
                    <ul class="nav navbar-nav navbar-right">
                        <li class="dropdown">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                                <i class="material-icons">toc</i>
                                <p class="hidden-lg hidden-md">
                                    Notifications
                                    <b class="caret"></b>
                                </p>
                            </a>
                            <ul class="dropdown-menu">
                                <li>
                                    <a data-toggle="modal" data-target="#myModal">Send email</a>
                                </li>
                            </ul>
                        </li>
                    </ul>
                    @endif
                </h4>
                <div class="row">
                    <div class="col-md-2 col-md-offset-1">
                        <div class="form-group ">
                            <label class="control-label">Date</label>
                            <p><?PHP echo date('m/d/Y',strtotime($inbound_order->ciord_date));?></p>
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="form-group ">
                            <label class="control-label">Date Export</label>
                            @if(isset($inbound_order->ciord_export_date))
                            <p><?PHP echo date('m/d/Y',strtotime($inbound_order->ciord_export_date));?></p>
                            @endif
                            
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group ">
                            <label class="control-label">Air Waybill</label>
                            <p>{{$inbound_order->ciord_guia_aerea}}</p>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group ">
                            <label class="control-label">Purchase order</label>
                            <p>{{$inbound_order->ciord_orden_compra}}</p>
                        </div>
                    </div>
                </div>
                <div class="card-content">
                    <div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
                        @foreach($inbound_pallet as $order_pallet)
                        <div class="panel panel-default">
                            <div class="panel-heading" role="tab" id="heading_{{$order_pallet->diord_pallet}}">
                                <a role="button" data-toggle="collapse" data-parent="#accordion" href="#collapse_{{$order_pallet->diord_pallet}}" aria-expanded="true" aria-controls="collapse_{{$order_pallet->diord_pallet}}">
                                    <h4 class="panel-title">
                                        Pallet #{{$order_pallet->diord_pallet}}-{{$inbound_order->ciord_orden_compra}}
                                        <i class="material-icons">keyboard_arrow_down</i>
                                    </h4>
                                </a>
                            </div>
                            <div id="collapse_{{$order_pallet->diord_pallet}}" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="heading_{{$order_pallet->diord_pallet}}">
                                <div class="panel-body">
                                    <div class="card-content">
                                        <div class="col-md-10 col-md-offset-1 text-center">
                                        <div class="table-responsive">
                                            <table class="table  table-shopping">
                                                <thead class="text-success">
                                                    <th>Image</th>
                                                    <th>Code</th>
                                                    <th>Name</th>
                                                    <th>Unit</th>
                                                    <th>Qty</th>
                                                    <th>Lote orde</th>
                                                    <th>Expiration date</th>
                                                </thead>
                                                <tbody>
                                                    @foreach($inbound_order_det as $order_det)
                                                        @if($order_det->diord_pallet == $order_pallet->diord_pallet)
                                                        <tr>
                                                            <td>
                                                                <div class="img-container">
                                                                    <img src="../../inv_img/{{ $order_det->items->item_ruta}}" alt="...">
                                                                </div>
                                                            </td>
                                                            <td>{{$order_det->items->item_code}}</td>
                                                            <td>{{$order_det->items->item_name}}</td>
                                                            <td>{{$order_det->items->unit->unit}}</td>
                                                            <td>{{$order_det->diord_qty}}</td>
                                                            <td>{{$order_det->diord_lot}}</td>
                                                            <td>
                                                                @if(isset($order_det->diord_expiration_date))
                                                                    <?PHP echo date('m/d/Y',strtotime($order_det->diord_expiration_date));?>
                                                                @endif
                                                            </td>
                                                        </tr>
                                                        @endif
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6 col-md-offset-3 text-center">
                        <h4 class="card-title">
                            Documents
                            <p class="category">Required documents</p>
                        </h4>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-8 col-md-offset-2 text-center">
                        <div class="card" style="margin-top: -10px;margin-bottom:10px;">
                            <div class="card-content">
                                <div class="table-responsive">
                                    <table class="table">
                                        <thead class="text-success text-center">
                                            <tr >
                                                <th class="text-center">Name</th>
                                                <th class="text-center">View</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($document as $item)
                                                <tr class="text-center">
                                                    <td>{{ $item->doc_description}}</td>
                                                    
                                                    @foreach($inbound_order_doc as $item1)
                                                        @if($item1->id_doc == $item->id_doc)
                                                            @if ( !empty ( $item1->dociord_ruta) ) <!-- Difetente de vacio es decir lleno -->
                                                            <td>
                                                                <a href="../../documents/{{ $item1->dociord_ruta}}" class="btn btn-info btn-simple btn-icon btn-lg" rel="tooltip" style="margin: 0px;">
                                                                    <i class="material-icons">pageview</i>
                                                                </a>
                                                            </td>
                                                            @else
                                                            <td>
                                                                <p>Does not exist</p>
                                                            </td>
                                                            @endif
                                                        @endif
                                                    @endforeach
                                                    
                                                </tr>
                                            @endforeach
                                            @if($inbound_order->warehouse->house_step == 3)
                                            <tr class="text-center">
                                                <td colspan="2">
                                                    <h4 class="card-title">
                                                        Airport documents
                                                        <p class="category">Required documents</p>
                                                    </h4>
                                                </td>
                                            </tr>
                                            @foreach($documents_airport as $item)
                                                <tr class="text-center">
                                                    <td>{{ $item->doc_description}}</td>
                                                    
                                                    @foreach($inbound_order_doc as $item1)
                                                        @if($item1->id_doc == $item->id_doc)
                                                            @if ( !empty ( $item1->dociord_ruta) ) <!-- Difetente de vacio es decir lleno -->
                                                            <td>
                                                                <a href="../../documents/airport/{{ $item1->dociord_ruta}}" class="btn btn-info btn-simple btn-icon btn-lg" rel="tooltip" style="margin: 0px;">
                                                                    <i class="material-icons">pageview</i>
                                                                </a>
                                                            </td>
                                                            @else
                                                            <td>
                                                                <p>Does not exist</p>
                                                            </td>
                                                            @endif
                                                        @endif
                                                    @endforeach
                                                    
                                                </tr>
                                            @endforeach
                                            @endif
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                 <div class="clearfix"></div>
             </div>
        </div>
    </div>
</div>
@endsection

@section('extra-script')
    <script type="text/javascript">
        $("input:checkbox.detalles").on('change', function() {
            $('#sub').prop("disabled",$($("input:checkbox.detalles").is(":checked")).length == 0);
        }).trigger('change');

        $(document).ready(function() {
            $('#datatables').DataTable({
                "pagingType": "full_numbers",
                "lengthMenu": [
                    [10, 25, 50, -1],
                    [10, 25, 50, "All"]
                ],
                responsive: true,
                language: {
                    search: "_INPUT_",
                    searchPlaceholder: "Search records",
                }
            });

            $('.card .material-datatables label').addClass('form-group ');
        });

        @if(Session::has('store'))
            demo.showSaveSuccess('top','center');

            @php
                Session::forget('store');
            @endphp
        @endif
        @if(Session::has('update'))
            demo.showUpdateSuccess('top','center');

            @php
                Session::forget('update');
            @endphp
        @endif
        @if(Session::has('liberar'))
            demo.showLiberarSuccess('top','center');

            @php
                Session::forget('liberar');
            @endphp
        @endif
    </script>
@endsection