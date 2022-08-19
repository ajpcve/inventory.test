@extends('welcome')

@section('title')
    Stock
@endsection

@section('extra-css')
    <style type="text/css">
    	tfoot input {
            width: 100%;
            padding: 3px;
            box-sizing: border-box;
        }
    </style>
@endsection

@section('content')
<div class="row">
    <div class="col-md-12">
        @if(count($inven_item) == 0)
            <div class="header text-center">
                <h3 class="title">Stock</h3>
                <p class="category">You still do not have anything in stock!</p>
            </div>
        @else
            <div class="row">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">Stock -
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
                            <!-- <li>
                                <a href="#pill3" data-toggle="tab">History</a>
                            </li> -->
                        </ul>
                        <div class="tab-content">
                            <div class="tab-pane active" id="pill1">
                                @foreach ($pallet as $key => $inven)
                                    @foreach ($inven as $key_inv => $inv)
                                    <div class="card">
                                        <div class="card-content">
                                            <h4 class="card-title">Pallet {{$key_inv}}-{{$key}}</h4>
                                            <p class="category"></p>
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
                                                        </tr>
                                                        @endif
                                                    
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                                @endforeach
                            </div>
                            <!----<div class="tab-pane" id="pill3">
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
                                                </thead>
                                                <tbody>
                                                    @foreach ($inbound_order_all as $inve)
                                                        @if($inve->id_item == $inven->id_item)
                                                        <tr>
                                                            <td>{{$inve->diord_pallet}}-{{$inve->ciord_orden_compra}}</td>
                                                            <td>{{$inve->inv_lot}}</td>
                                                            <td><?PHP echo date('m/d/Y',strtotime($inve->inv_date));?></td>
                                                            <td>
                                                                @foreach ($inbound_order_all as $ord_det)
                                                                    @if($inve->inv_lot == $ord_det->diord_lot)
                                                                        {{$ord_det->ciord_orden_compra}}
                                                                    @endif
                                                                @endforeach
                                                            </td>
                                                            <td>
                                                                {{$inve_ord->unit}}
                                                            </td>
                                                            <td>
                                                                @foreach ($inbound_order_all as $ord_det)
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
                                                        </tr>
                                                        @endif
                                                    
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                                @endforeach
                            </div>}} -->
                        </div>
                    </div>
                </div>
            </div>
        @endif
    </div>
</div>

@endsection

@section('extra-script')
@endsection