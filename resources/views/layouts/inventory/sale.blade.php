@extends('welcome')

@section('title')
    Stock Sale
@endsection

@section('extra-css')
    <style type="text/css">
    	tfoot input {
            width: 100%;
            padding: 3px;
            box-sizing: border-box;
        }
        .checkbox label {
            cursor: pointer;
            color: rgb(45, 71, 32);
        }
        .form-group {
            padding-bottom: 0px;
            margin: 0 0 5px 0;
        }
    </style>
@endsection

@section('content')

@if(count($inventory) == 0)
    <div class="header text-center">
        <h3 class="title">Stock</h3>
        <p class="category">You still do not have anything in stock!</p>
    </div>
@else
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header card-header-icon" data-background-color="green">
                    <i class="material-icons">library_books</i>
                </div>
                <div class="card-content">
                    <h4 class="card-title">New 
                        <small class="category">Information</small>
                    </h4>
                    <form action="{{ action('SaleInventoryController@store') }}" method="POST" class="form-horizontal" >
                        {{ csrf_field() }}
                        <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                            <div class="modal-dialog modal-lg">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
                                            <i class="material-icons">clear</i>
                                        </button>
                                        <h4 class="modal-title">Customer Details</h4>
                                    </div>
                                    <div class="modal-body">
                                        <div class="material-datatables">
                                            <table id="datatables" class="table table-striped table-no-bordered table-hover table-shopping" cellspacing="0" width="100%" style="width:100%">
                                                <thead>
                                                    <tr>
                                                        <th><b>Name</b></th>
                                                        <th><b>Phone</b></th>
                                                        <th><b>Address</b></th>
                                                        <th><b>Email</b></th>
                                                        <th class="disabled-sorting text-right"><b>Select</b></th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach($customer as $custo)
                                                    <tr>
                                                        <td width="100" >{{ $custo->cust_company}}</td>
                                                        <td width="150">{{ $custo->cust_phone}}</td>
                                                        <td width="250">{{ $custo->cust_address}}</td>
                                                        <td width="100">{{ $custo->cust_email}}</td>
                                                        <td width="80">
                                                            <div class="radio">
                                                                <label>
                                                                    <input type="radio" name="costum_id" id="modal" value="{{ $custo->id_customer}}" checked onclick="id_costum('')">
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
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-success btn-sm pull-right close" data-dismiss="modal" aria-hidden="true">Oks</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="modal fade" id="myModalDelivery" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                            <div class="modal-dialog modal-lg">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
                                            <i class="material-icons">clear</i>
                                        </button>
                                        <h4 class="modal-title">Sucursal Details</h4>
                                    </div>
                                    <div class="modal-body">
                                        <div class="material-datatables">
                                            <table id="example1" class="table table-striped table-no-bordered table-hover table-shopping" cellspacing="0" width="100%" style="width:100%">
                                                <thead>
                                                    <tr>
                                                        <th><b>Name</b></th>
                                                        <th><b>Phone</b></th>
                                                        <th><b>Address</b></th>
                                                        <th><b>Email</b></th>
                                                        <th class="disabled-sorting text-right"><b>Select</b></th>
                                                    </tr>
                                                </thead>
                                            </table>
                                        </div>
                                        <div class="clearfix"></div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-success btn-sm pull-right close" data-dismiss="modal" aria-hidden="true">Oks</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="modal fade" id="myModalTrans" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                            <div class="modal-dialog modal-lg">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
                                            <i class="material-icons">clear</i>
                                        </button>
                                        <h4 class="modal-title">Transport Details</h4>
                                    </div>
                                    <div class="modal-body">
                                        <div class="material-datatables">
                                            <table id="datatables" class="table table-striped table-no-bordered table-hover table-shopping" cellspacing="0" width="100%" style="width:100%">
                                                <thead>
                                                    <tr>
                                                        <th><b>Name</b></th>
                                                        <th><b>Phone</b></th>
                                                        <th><b>Address</b></th>
                                                        <th><b>Email</b></th>
                                                        <th class="disabled-sorting text-right"><b>Select</b></th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach($transport as $trans)
                                                    <tr>
                                                        <td>{{ $trans->trans_company}}</td>
                                                        <td>{{ $trans->trans_phone}}</td>
                                                        <td>{{ $trans->trans_address}}</td>
                                                        <td>{{ $trans->trans_email}}</td>
                                                        <td>
                                                            <div class="radio">
                                                                <label>
                                                                    <input type="radio" name="tran_id" id="modal" value="{{ $trans->id_transport}}" checked onclick="id_tran('')">
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
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-success btn-sm pull-right close" data-dismiss="modal" aria-hidden="true">Oks</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-2 col-md-offset-1">
                                <div class="form-group ">
                                    <label class="control-label">Date</label>
                                    <input type="date" class="form-control" name="csaleinv_date" min="<?php echo date("Y-m-d");?>" required/>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label class="control-label">PO number</label>
                                    <input type="text" class="form-control" name="csaleinv_invoice" required/>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label class="control-label">Order number</label>
                                    <input type="text" class="form-control" name="csaleinv_or_num" required/>
                                </div>
                            </div>
                        </div>
                        <br>
                        <p class="col-md-offset-1">Customer</p>
                        <div class="row">
                            <div class="col-md-1">
                                <div class="form-group ">
                                    <a data-toggle="modal" data-target="#myModal" class="btn btn-info btn-round btn-fab btn-fab-mini"><i class="material-icons">assignment_ind</i></a>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group ">
                                    <label class="control-label">Customer name</label>
                                    <input type="text" class="form-control" id='cust_company_1' name="cust_company" maxlength="191" required>
                                    <input type="hidden" class="form-control id_cust" id='id_customer_1' name="id_cust" readonly>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group ">
                                    <label class="control-label">Phone</label>
                                    <input type="text" class="form-control date" id='cust_phone_1' name="cust_phone" data-mask="+(99)(999) 999-9999"required>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group ">
                                    <label class="control-label">Email</label>
                                    <input id="cust_email_1" type="email" class="form-control" name="cust_email" required>
                                    @if ($errors->has('email'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('email') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-8 col-md-offset-1">
                                <div class="form-group ">
                                    <label class="control-label">Address</label>
                                    <input type="text" class="form-control" id='cust_address_1' name="cust_address" required >
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-offset-1">
                                 <div class="checkbox">
                                    <label>
                                        <input type="checkbox" name="checked" id="che" value="cliente"> The customer withdraws the merchandise?
                                    </label>
                                </div>
                            </div>
                        </div>
                        <br>
                        <p class="col-md-offset-1">Delivery Address</p>
                        <div class="row">
                            <div class="col-md-1" >
                                <div class="form-group " id="div2">
                                    <a data-toggle="modal" data-target="#myModalDelivery" class="btn btn-info btn-round btn-fab btn-fab-mini"><i class="material-icons">commute</i></a>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group ">
                                    <label class="control-label">Company name</label>
                                    <input type="text" class="form-control" id='deli_name_1' name="deli_company" maxlength="191"  >
                                    <input type="hidden" class="form-control" id='id_deli_1' name="id_deli" readonly>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group ">
                                    <label class="control-label">Phone</label>
                                    <input type="text" class="form-control" id='deli_phone_1' name="deli_phone" data-mask="+(99)(999) 999-9999" >
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group ">
                                    <label class="control-label">Email</label>
                                    <input id='deli_email_1' type="email" class="form-control" name="deli_email" maxlength="191" >
                                    @if ($errors->has('email'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('email') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-8 col-md-offset-1">
                                <div class="form-group ">
                                    <label class="control-label">Address</label>
                                    <input type="text" class="form-control" id='deli_address_1' name="deli_address"  >
                                </div>
                            </div>
                        </div>
                        <br>
                        <p class="col-md-offset-1">Transportation Company</p>
                        <div class="row">
                            <div class="col-md-1">
                                <div class="form-group ">
                                    <a data-toggle="modal" data-target="#myModalTrans" class="btn btn-info btn-round btn-fab btn-fab-mini"><i class="material-icons">commute</i></a>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group ">
                                    <label class="control-label">Company name</label>
                                    <input type="text" class="form-control name" id='trans_name_1' name="trans_company" maxlength="191"  >
                                    <input type="hidden" class="form-control" id='id_trans_1' name="id_trans" readonly>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group ">
                                    <label class="control-label">Phone</label>
                                    <input type="text" class="form-control phone" id='trans_phone_1' name="trans_phone" data-mask="+(99)(999) 999-9999" >
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group ">
                                    <label class="control-label">Email</label>
                                    <input id='trans_email_1' type="email" class="form-control email" name="trans_email" maxlength="191" >
                                    @if ($errors->has('email'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('email') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-2 col-md-offset-1">
                                <div class="form-group ">
                                    <label class="control-label">Driver name</label>
                                    <input type="text" class="form-control name" name="csaleinv_driver_name" maxlength="191"  >
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group ">
                                    <label class="control-label">Driver phone</label>
                                    <input type="text" class="form-control phone" name="csaleinv_driver_phone" data-mask="+(99)(999) 999-9999" >
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group ">
                                    <label class="control-label">Pick up date</label>
                                    <input type="date" class="form-control" name="csaleinv_date_pick_up" min="<?php echo date("Y-m-d");?>" required />
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group ">
                                    <label class="control-label">Time:</label>
                                    <input type="time" class="form-control" name="csaleinv_date_time"/>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-2 col-md-offset-1">
                                <div class="form-group ">
                                    <label class="control-label">Estimated Date of Delivery</label>
                                    <input type="date" class="form-control" name="csaleinv_date_delivery" min="<?php echo date("Y-m-d");?>"/>
                                </div>
                            </div>
                            <label class="col-md-2 label-on-left">Appointment required:</label>
                            <div class="col-md-3 checkbox-radios">
                                <div class="radio checkbox-inline">
                                    <label>
                                        <input type="radio" name="optionsRadios" checked="true" value="No">No
                                    </label>
                                </div>
                                <div class="radio checkbox-inline">
                                    <label>
                                        <input type="radio" name="optionsRadios" value="Yes"> Yes
                                    </label>
                                </div>
                            </div>
                            <div class="col-md-2" id="div1">
                                <div class="form-group ">
                                    <label class="control-label">Appointment time:</label>
                                    <input type="time" class="form-control" name="csaleinv_appointment"/>
                                </div>
                            </div>
                        </div>
                        <br>
                        <p class="col-md-offset-1">Warehouse Requirements:</p>
                        <div class="row">
                            <div class="col-md-4 col-md-offset-1 checkbox-radios">
                                <div class="checkbox">
                                    <label>
                                        <input type="checkbox" name="csaleinv_chep_pallet">Chep Pallet Required 
                                    </label>
                                </div>
                                <div class="checkbox">
                                    <label>
                                        <input type="checkbox" name="csaleinv_shrink_wrap">Shrink Wrap Required 
                                    </label>
                                </div>
                                <div class="checkbox">
                                    <label>
                                        <input type="checkbox" name="csaleinv_palletization">Palletization Required 
                                    </label>
                                </div>
                            </div>
                        </div>
                        <div class="clearfix"></div>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            @foreach ($inven_item as $inven)
                @foreach ($item as $ite)
                    @if($ite->id_item == $inven->id_item)
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
                                            <th>Quantity</th>
                                            <th>Expiration Date</th>
                                            <th>Location</th>
                                            <th>Sale</th>
                                        </thead>
                                        <tbody>
                                            @foreach ($iund_order as $inve)
                                                @if($ite->id_item == $inve->id_item)
                                                    @foreach ($inv_loc as $inv_lo)
                                                        @if($inv_lo->id_inv == $inve->id_inv)
                                                            <tr>
                                                                <td>{{$inve->diord_pallet}}</td>
                                                                <td>{{$inve->inv_lot}}</td>
                                                                <td><?PHP echo date('m/d/Y',strtotime($inve->inv_date));?></td>
                                                                <td>
                                                                    @foreach ($inbound_order_det as $ord_det)
                                                                        @foreach ($inbound_order as $ord_cab)
                                                                        @if($inve->inv_lot == $ord_det->diord_lot)

                                                                            @if($ord_cab->id_ciord == $ord_det->id_ciord)
                                                                                {{$ord_cab->ciord_orden_compra}}
                                                                            @endif
                                                                            @endif
                                                                        @endforeach
                                                                    @endforeach
                                                                </td>
                                                                <td>{{$ite->unit->unit}}</td>
                                                                <td>{{$inv_lo->inv_location_qty}}</td>
                                                                
                                                                
                                                                <td>
                                                                    @foreach ($inbound_order_det as $ord_det)
                                                                        @if($inve->inv_lot == $ord_det->diord_lot)
                                                                            <?PHP echo date('m/d/Y',strtotime($ord_det->diord_expiration_date));?>
                                                                        @endif
                                                                    @endforeach
                                                                </td>
                                                                <td>{{$inv_lo->warehouse->house_name}}</td>
                                                                <td width="90px">
                                                                    <div class="form-group">
                                                                        <input type="number" class="form-control" name="dsaleinv_qty[]" max="{{$inv_lo->inv_location_qty}}" min="0">
                                                                        <input type="hidden" class="form-control" name="it_code[]" value="{{$inven->id_item}}">
                                                                        <input type="hidden" class="form-control" name="lot_it[]" value="{{$inve->inv_lot}}">
                                                                        <input type="hidden" class="form-control" name="id_ware[]" value="{{$inv_lo->id_warehouse}}">
                                                                        <input type="hidden" class="form-control" name="id_inv[]" value="{{$inve->id_inv}}">
                                                                    </div>
                                                                </td>
                                                            </tr>
                                                        @endif
                                                    @endforeach
                                                @endif
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    @endif
                @endforeach
            @endforeach
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-content">  
                        <button type="submit" class="btn btn-success btn-sm pull-right">Save</button>
                        <div class="clearfix"></div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endif

@endsection

@section('extra-script')
    <script type="text/javascript">
        $(document).ready(function() {
            $("#div1").hide();
            $("#div2").hide();
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

            $('.card .material-datatables label').addClass('form-group');
        });
        $('input:checkbox[name=checked]').on('change', function(e){
        //$('input[type="checkbox"]').on('change', function(e){
            if (this.checked) {

                console.log('Checkbox ' + $(e.currentTarget).val() + ' checked');

                var costum = $(".id_cust").val();
                console.log(costum);

                $.ajax({
                    url: "{{ route('inventory/customer') }}",
                    method: 'get',
                    data: {
                        costum: costum,
                    },
                    success: function(data) {

                        $('#trans_name_1').val(data[0].cust_company);
                        $('#trans_phone_1').val(data[0].cust_phone);
                        $('#trans_address_1').val(data[0].cust_address);
                        $('#trans_email_1').val(data[0].cust_email);
                    }
                });
            } else {
                console.log('Checkbox ' + $(e.currentTarget).val() + ' unchecked');
                $(".name").val('');
                $(".phone").val('');
                $(".addess").val('');
                $(".email").val('');
            }
        });

        function id_costum() {
            var costum = $('input:radio[name=costum_id]:checked').val();
            console.log(costum);

            $.ajax({
                url: "{{ route('inventory/customer') }}",
                method: 'get',
                data: {
                    costum: costum,
                },
                success: function(data) {
                    //console.log(data);
                    $('#cust_company_1').val(data[0].cust_company);
                    $('#cust_phone_1').val(data[0].cust_phone);
                    $('#cust_address_1').val(data[0].cust_address);
                    $('#cust_email_1').val(data[0].cust_email);
                    $('#id_customer_1').val(data[0].id_customer);

                    if(data[0].cust_sucursal =="C"){
                        delivery = data[0].id_customer
                        delivery_num = data[0].cust_num_sucursal
                        $("#div2").show();
                        $.ajax({
                            url: "{{ route('inventory/delivery') }}",
                            method: 'get',
                            data: {
                                delivery: delivery,
                                delivery_num: delivery_num,
                            },
                            success: function(deli) {
                                //console.log(deli)
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
                                                  data = '<input type="radio" name="id_delive" value="' + data + '" onclick="delive()">'; 
                                                  console.log(data);    
                                               }
                                                
                                               return data;
                                            }
                                        }
                                    ],
                                    "columns":[
                                        {"data":"cust_company"},
                                        {"data":"cust_phone"},
                                        {"data":"cust_address"},
                                        {"data":"cust_email"},                                        
                                        {"data":"id_customer"},                                        
                                        
                                    ]
                                    
                                });
                                
                            }
                        });
                    } else{
                        $("#div2").hide();
                    };
                }
            });
        }

        function id_tran() {
            console.log('aqui');
            var trans = $('input:radio[name=tran_id]:checked').val();
            console.log(trans);

            $.ajax({
                url: "{{ route('inventory/transport') }}",
                method: 'get',
                data: {
                    trans: trans,
                },
                success: function(data) {
                    //console.log(elementId);
                    $('#trans_name_1').val(data[0].trans_company);
                    $('#trans_phone_1').val(data[0].trans_phone);
                    $('#trans_address_1').val(data[0].trans_address);
                    $('#trans_email_1').val(data[0].trans_email);
                    $('#id_trans_1').val(data[0].id_transport);
                }
            });
        }
        function delive() {
            console.log('delive');
            var deli = $('input:radio[name=id_delive]:checked').val();
            console.log(deli);

            $.ajax({
                url: "{{ route('inventory/customer') }}",
                method: 'get',
                data: {
                    costum: deli,
                },
                success: function(data) {
                    //console.log(elementId);
                    $('#deli_name_1').val(data[0].cust_company);
                    $('#deli_phone_1').val(data[0].cust_phone);
                    $('#deli_address_1').val(data[0].cust_address);
                    $('#deli_email_1').val(data[0].cust_email);
                    $('#id_deli_1').val(data[0].id_customer);
                }
            });
        }

        $("input[type=radio]").click(function(event){
            var valor = $(event.target).val();
            if(valor =="Yes"){
                $("#div1").show();
                //$("#div2").hide();
            } else if (valor == "No") {
                $("#div1").hide();
                //$("#div2").show();
            }
        });

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