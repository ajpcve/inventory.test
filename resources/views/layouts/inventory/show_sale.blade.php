@extends('welcome')

@section('title')
    Stock Sale #
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
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><i class="material-icons">clear</i></button>
                <h5 class="modal-title" id="myModalLabel">Send email</h5>
            </div>
            <form action="{{ url('inventory/sale/email') }} " method="get" >
                <input type="hidden" name="id" value="{{$cab_sale_inv->id_csale_inventory}}">
                <div class="modal-body">
                    <div class="material-datatables">
                        <table class="table table-striped table-no-bordered table-hover table-shopping" cellspacing="0" width="100%" style="width:100%">
                            <thead>
                                <tr>
                                    <th><b>Customer email</b></th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>{{$cab_sale_inv->cust->cust_email}}</td>
                                    <td>
                                        <div class="checkbox hidden" >
                                            <label>
                                                <input type="checkbox" name="optionsCheckboxes[]" value="{{ $cab_sale_inv->cust->cust_email}}" checked>
                                            </label>
                                        </div>
                                    </td>
                                </tr>
                            </tbody>
                            <thead>
                                <tr>
                                    <th><b>Seller email</b></th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>{{$cab_sale_inv->user->email}}</td>
                                    <td>
                                        <div class="checkbox hidden">
                                            <label>
                                                <input type="checkbox" name="optionsCheckboxes[]" value="{{$cab_sale_inv->user->email}}" checked>
                                            </label>
                                        </div>
                                    </td>
                                </tr>
                            </tbody>
                            <thead>
                                <tr>
                                    <th><b>Transport email</b></th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>@if(isset($cab_sale_inv->csaleinv_tran_cust))
                                            {{$cab_sale_inv->cust->cust_email}}
                                        @elseif(isset($cab_sale_inv->trans->trans_email))
                                            {{$cab_sale_inv->trans->trans_email}}
                                        @else
                                        @endif</td>
                                    <td>
                                        <div class="checkbox hidden">
                                            <label>
                                                @if(isset($cab_sale_inv->csaleinv_tran_cust))
                                                    <input type="checkbox" name="optionsCheckboxes[]" value="{{ $cab_sale_inv->cust->cust_email}}" checked>
                                                @elseif(isset($cab_sale_inv->trans->trans_email))
                                                <input type="checkbox" name="optionsCheckboxes[]" value="{{ $cab_sale_inv->trans->trans_email}}" checked>
                                                @else
                                                @endif
                                                
                                            </label>
                                        </div>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                        <br>
                        <thead>
                            <tr>
                                <th><b>Warehouse email</b></th>
                            </tr>
                        </thead>
                        <table class="table table-striped table-no-bordered table-hover table-shopping" cellspacing="0" width="100%" style="width:100%">
                            @foreach($warehouse as $ware)
                            <thead>
                                <td>{{$ware->house_name}}</td>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>{{$ware->house_email}}<br>
                                        {{$ware->house_email_two}}<br>
                                        {{$ware->house_email_three}}</td>
                                    <td>
                                        <div class="checkbox hidden">
                                            <label>
                                                <input type="checkbox" name="optionsCheckboxes[]" value="{{$ware->house_email}}" checked>
                                                <input type="checkbox" name="optionsCheckboxes[]" value="{{$ware->house_email_two}}" checked>
                                                <input type="checkbox" name="optionsCheckboxes[]" value="{{$ware->house_email_three}}" checked>
                                            </label>
                                        </div>
                                    </td>
                                </tr>
                            </tbody>
                            @endforeach
                        </table>
                    </div>
                    <div class="clearfix"></div>
                    
                </div>
                <div class="modal-footer text-center">
                    <button type="submit" class="btn btn-info btn-round" onclick="demo.loader()">Send!</button>
                </div>
            </form>
        </div>
    </div>
</div>
<div class="modal fade" id="myModalSale" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog ">
        <form action="{{ url('inventory/sale/update/'. $cab_sale_inv->id_csale_inventory) }} " method="post" enctype="multipart/form-data">
            {{ csrf_field() }}
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><i class="material-icons">clear</i></button>
                    <h5 class="modal-title" id="myModalLabel">Upload documents</h5>
                </div>
                <div class="modal-body">
                    <br>
                    <div class="row">
                        <div class="col-md-10 col-md-offset-1">
                            <div class="card" style="margin-top: -10px;margin-bottom: -20px;">
                                <div class="card-content">
                                    <div class="table-responsive">
                                        <table class="table">
                                            <thead class="text-success">
                                                <th class="text-center">Name</th>
                                                <th class="text-center">Select</th>
                                            </thead>
                                            <tbody>
                                                @foreach($document_modal as $item)
                                                    @if($collection[$item->doc_description] == 0)
                                                    <tr class="text-center">
                                                        <input type="hidden" name="id_doc[]" value="{{ $item->id_doc }}">
                                                        <td class="text-center">{{ $item->doc_description}}</td>
                                                        <td class="text-center">
                                                            <div class="form-group label-floating">
                                                                <div class="fileinput fileinput-new " data-provides="fileinput">
                                                                    <div class="fileinput-preview fileinput-exists thumbnail"></div>
                                                                    <div>
                                                                        <span class="btn btn-success btn-xs btn-file">
                                                                            <span class="fileinput-new">Select document</span>
                                                                            <span class="fileinput-exists">Change</span>
                                                                            <input name="documents[]" type="file" accept="application/pdf"/>
                                                                            
                                                                        </span>
                                                                        <a href="#pablo" class="btn btn-danger btn-xs fileinput-exists" data-dismiss="fileinput"><i class="fa fa-times"></i> Remove</a>
                                                                    </div>
                                                                </div>
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
                        </div>
                    </div>
                    <br>
                </div>
                <div class="modal-footer text-center">
                    <button type="submit" class="btn btn-success btn-sm pull-right" >Save</button> 
                </div>
            </div>
        </form>
    </div>
</div>

<div class="row" style="margin-top: 15px">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header card-header-icon" data-background-color="green">
                <i class="material-icons">library_books</i>
            </div>
            <div class="card-content">
                <h4 class="card-title">Sale #{{$cab_sale_inv->csaleinv_invoice}} 
                    <small class="category">Information</small>
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
                                <li>
                                    <a href="{{ url('inventory/sale/pdf/'. $cab_sale_inv->id_csale_inventory) }}">Export PDF</a>
                                </li>
                                @if(count($doc_sale_inv) != count($document_modal))
                                <li>
                                    <a data-toggle="modal" data-target="#myModalSale">Upload documents</a>
                                </li>
                                @endif
                                
                            </ul>
                        </li>
                    </ul>
                </h4>
                <div class="row">
                    <div class="col-md-2 col-md-offset-1">
                        <div class="form-group">
                            <label class="control-label">Date</label>
                            <p><?PHP echo date('m/d/Y',strtotime($cab_sale_inv->csaleinv_date));?></p>
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="form-group ">
                            <label class="control-label">PO number</label>
                            <p>{{$cab_sale_inv->csaleinv_invoice}}</p>
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="form-group ">
                            <label class="control-label">Order number</label>
                            <p>{{$cab_sale_inv->csaleinv_or_num}}</p>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group ">
                            <label class="control-label">Seller</label>
                            <p>{{$cab_sale_inv->user->name}}</p>
                        </div>
                    </div>
                </div>
                <br>
                <p class="col-md-offset-1">Customer</p>
                <div class="row" style="margin-top: -30px;">
                    <div class="col-md-2 col-md-offset-1">
                        <div class="form-group ">
                            <label class="control-label">Customer name</label>
                            <p>{{$cab_sale_inv->cust->cust_company}}</p>
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="form-group ">
                            <label class="control-label">Phone</label>
                            <p>{{$cab_sale_inv->cust->cust_phone}}</p>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group ">
                            <label class="control-label">Addrees</label>
                            <p>{{$cab_sale_inv->cust->cust_address}}</p>
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="form-group ">
                            <label class="control-label">Email</label>
                            <p>{{$cab_sale_inv->cust->cust_email}}</p>
                        </div>
                    </div>
                </div>
                <br>
                <p class="col-md-offset-1">Delivery Address</p>
                <div class="row" style="margin-top: -30px;">
                    @if(isset($cab_sale_inv->csaleinv_deli_name))
                    <div class="col-md-2 col-md-offset-1">
                        <div class="form-group ">
                            <label class="control-label">Company name</label>
                            <p>{{$cab_sale_inv->csaleinv_deli_name}}</p>
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="form-group ">
                            <label class="control-label">Phone</label>
                            <p>{{$cab_sale_inv->csaleinv_deli_phone}}</p>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group ">
                            <label class="control-label">Addrees</label>
                            <p>{{$cab_sale_inv->csaleinv_deli_address}}</p>
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="form-group ">
                            <label class="control-label">Email</label>
                            <p>{{$cab_sale_inv->csaleinv_deli_email}}</p>
                        </div>
                    </div>
                    @endif
                    @if(isset($cab_sale_inv->id_delivery))
                    <div class="col-md-2 col-md-offset-1">
                        <div class="form-group ">
                            <label class="control-label">Company name</label>
                            <p>{{$cab_sale_inv->sucursal->cust_company}}</p>
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="form-group ">
                            <label class="control-label">Phone</label>
                            <p>{{$cab_sale_inv->sucursal->cust_phone}}</p>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group ">
                            <label class="control-label">Addrees</label>
                            <p>{{$cab_sale_inv->sucursal->cust_address}}</p>
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="form-group ">
                            <label class="control-label">Email</label>
                            <p>{{$cab_sale_inv->sucursal->cust_email}}</p>
                        </div>
                    </div>
                    @endif
                    @if(!isset($cab_sale_inv->csaleinv_deli_name) && !isset($cab_sale_inv->id_delivery))
                    <div class="col-md-8 col-md-offset-1">
                        <div class="form-group ">
                            <p>The customer withdraws the merchandise</p>
                        </div>
                    </div>
                    @endif
                </div>
                <br>
                <p class="col-md-offset-1">Transportation Company</p>
                @if(isset($cab_sale_inv->csaleinv_tran_cust))
                <div class="row" style="margin-top: -30px;">
                    <div class="col-md-2 col-md-offset-1">
                        <div class="form-group ">
                            <label class="control-label">Company name</label>
                            <p>{{$cab_sale_inv->cust->cust_company}}</p>
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="form-group ">
                            <label class="control-label">Phone</label>
                            <p>{{$cab_sale_inv->cust->cust_phone}}</p>
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="form-group ">
                            <label class="control-label">Email</label>
                            <p>{{$cab_sale_inv->cust->cust_email}}</p>
                        </div>
                    </div>
                </div>
                @else
                    @if($cab_sale_inv->csaleinv_transport == 0)
                    <div class="row" style="margin-top: -30px;">
                        <div class="col-md-2 col-md-offset-1">
                            <div class="form-group ">
                                <label class="control-label">Company name</label>
                                <p></p>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group ">
                                <label class="control-label">Phone</label>
                                <p></p>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group ">
                                <label class="control-label">Email</label>
                                <p></p>
                            </div>
                        </div>
                    </div>
                    @else
                    <div class="row" style="margin-top: -30px;">
                        <div class="col-md-2 col-md-offset-1">
                            <div class="form-group ">
                                <label class="control-label">Company name</label>
                                <p>{{$cab_sale_inv->trans->trans_company}}</p>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group ">
                                <label class="control-label">Phone</label>
                                <p>{{$cab_sale_inv->trans->trans_phone}}</p>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group ">
                                <label class="control-label">Email</label>
                                <p>{{$cab_sale_inv->trans->trans_email}}</p>
                            </div>
                        </div>
                    </div>
                    @endif
                @endif
                <br>
                <p class="col-md-offset-1">Driver data</p>
                <div class="row" style="margin-top: -30px;">
                    <div class="col-md-2 col-md-offset-1">
                        <div class="form-group ">
                            <label class="control-label">Driver name</label>
                            <p>{{$cab_sale_inv->csaleinv_driver_name}}</p>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group ">
                            <label class="control-label">Driver phone</label>
                            <p>{{$cab_sale_inv->csaleinv_driver_phone}}</p>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group ">
                            <label class="control-label">Pick Up date</label>
                            <p><?PHP echo date('m/d/Y',strtotime($cab_sale_inv->csaleinv_date_pick_up));?></p>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group ">
                            <label class="control-label">Time</label>
                            @if(isset($cab_sale_inv->csaleinv_date_time))
                                <p><?PHP echo date("h:i a",strtotime($cab_sale_inv->csaleinv_date_time));?></p>
                            @else
                            <p>No</p>
                            @endif
                        </div>
                    </div>
                </div>
                <br>
                <div class="row" style="margin-top: -30px;">
                    <div class="col-md-2 col-md-offset-1">
                        <div class="form-group ">
                            <label class="control-label">Estimated Date of Delivery</label>
                            @if(isset($cab_sale_inv->csaleinv_date_delivery))
                                <p><?PHP echo date('m/d/Y',strtotime($cab_sale_inv->csaleinv_date_delivery));?></p>
                            @endif
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group ">
                            <label class="control-label">Appointment required</label>
                            <p>{{$cab_sale_inv->csaleinv_appointment_selet}}</p>
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="form-group ">
                            <label class="control-label">Appointment Time</label>
                            @if(isset($cab_sale_inv->csaleinv_appointment))
                            <p><?PHP echo date("h:i a",strtotime($cab_sale_inv->csaleinv_appointment));?></p>
                            @else
                            <p>No</p>
                            @endif
                        </div>
                    </div>
                </div>
                <br>
                <p class="col-md-offset-1">Warehouse Requirements</p>
                <div class="row form-horizontal"  style="margin-top: -30px;">
                    @if(isset($cab_sale_inv->csaleinv_chep_pallet) || isset($cab_sale_inv->csaleinv_shrink_wrap) || isset($cab_sale_inv->csaleinv_palletization))
                    <div class="col-md-8 col-md-offset-1">
                        <div class="checkbox checkbox-inline">
                            @if(isset($cab_sale_inv->csaleinv_chep_pallet))
                            <label>
                                <input type="checkbox" checked onclick="return false;">Chep Pallet Required
                            </label>
                            @endif
                        </div>
                        <div class="checkbox checkbox-inline">
                            @if(isset($cab_sale_inv->csaleinv_shrink_wrap))
                            <label>
                                <input type="checkbox" checked onclick="return false;">Shrink Wrap Required
                            </label>
                            @endif                            
                        </div>
                        <div class="checkbox checkbox-inline">
                            @if(isset($cab_sale_inv->csaleinv_palletization))
                            <label>
                                <input type="checkbox" checked onclick="return false;">Palletization Required 
                            </label>
                            @endif
                        </div>
                    </div>
                    @else
                    <div class="col-md-8 col-md-offset-1">
                        <div class="form-group ">
                            <p>Does not apply</p>
                        </div>
                    </div>
                    @endif
                </div>
                <br>
                <div class="row">
                    <div class="col-md-6 col-md-offset-3 text-center">
                        <h4 class="card-title">
                            Item
                            <p class="category">Item solds</p>
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
                                                <th class="text-center">Code</th>
                                                <th class="text-center">Name</th>
                                                <th class="text-center">Batch</th>
                                                <th class="text-center">Qty</th>
                                                <th class="text-center">Packs</th>
                                                <th class="text-center">Expiration Date</th>
                                                <th class="text-center">Output cellar</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($det_sale_inv as $det_sale)
                                                <tr>
                                                    <td>{{$det_sale->item->item_code}}</td>
                                                    <td>{{$det_sale->item->item_name}}</td>
                                                    <td>{{$det_sale->dsaleinv_lot}}</td>
                                                    <td>{{$det_sale->dsaleinv_qty}}</td>
                                                    <td>
                                                        @foreach ($unit as $uni)
                                                            @if($uni->id_unit == $det_sale->item->id_unit)
                                                                {{$uni->unit}}
                                                            @endif
                                                        @endforeach
                                                    </td>
                                                    <td>
                                                        @foreach ($inbound_order_det as $order_det)
                                                            @if($order_det->diord_lot == $det_sale->dsaleinv_lot)
                                                                <?PHP echo date('m/d/Y',strtotime($order_det->diord_expiration_date));?>
                                                            @endif
                                                        @endforeach
                                                    </td>
                                                    <td>
                                                        {{$det_sale->warehouse->house_name}}
                                                    </td>
                                                </tr>
                                            @endforeach
                                            <tr>
                                                <td colspan="3">Total Number of Boxes</td>
                                                <td>{{$qty}}</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <br>
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
                                            <tr>
                                                <th class="text-center">Name</th>
                                                <th class="text-center">View</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($document_view as $doc_viw)
                                                @if($doc_viw->id_status != 2 && $collection[$doc_viw->doc_description] == 0)
                                                <tr>
                                                    <td>{{ $doc_viw->doc_description}}</td>
                                                    <td></td>
                                                </tr>
                                                @elseif($doc_viw->id_status == 2 && $collection[$doc_viw->doc_description] == 0)
                                                <tr>
                                                    <td></td>
                                                    <td></td>
                                                </tr>
                                                @else
                                                <tr>
                                                    <td>{{ $doc_viw->doc_description}}</td>
                                                    <td>
                                                        <a href="../../../documents/sale/{{$collection[$doc_viw->doc_description]}}" class="btn btn-info btn-simple btn-icon btn-lg" rel="tooltip" style="margin: 0px;">
                                                            <i class="material-icons">pageview</i>
                                                        </a>
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
                <div class="clearfix"></div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('extra-script')
    <script type="text/javascript">
        @if(Session::has('success'))
            demo.showUpdateSuccess('top','center');

            @php
                Session::forget('success');
            @endphp
        @endif

        @if(Session::has('store'))
            demo.showSaveSuccess('top','center');

            @php
                Session::forget('store');
            @endphp
        @endif
    </script>
@endsection