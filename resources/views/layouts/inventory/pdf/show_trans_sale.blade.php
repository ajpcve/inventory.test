<link href="assets/css/bootstrap.min.css" rel="stylesheet">
<link rel="stylesheet" href="assets/example2/style.css" media="all" />

<style type="text/css">
    /**@page { margin: 100px 25px;}
    header { position: fixed; top: -100px; left: 0px; right: 0px;}
    footer { position: fixed; bottom: -5px; left: 0px; right: 0px;}
     { background-image: url("{{asset('bsbmd/images/imag.png')}}");}*/
    #watermark {
        position: fixed;
        /** 
            Set a position in the page for your image
            This should center it vertically
        **/
        bottom:  -100cm;
        left:   0cm;
        top:    0cm;

        /** Change image dimensions**/
       width:    30cm;
       height:   30cm;

        /** Your watermark should be behind every content**/
        z-index:  -1000;
    }
    .table-bordered {
        border: #bde191 1px solid;
    }
    p{
        margin-top: -10px;
    }
</style>

<!doctype html>
<html>
    <head>
        <title>Bufalinda USA - Product Order Form</title>
    </head>
    <body>
        <header class="clearfix">
            <div id="logo">
                <img src="assets/img/logosinsloganconsombra1.png" width="130" height="130" style="margin: 10px -20px 0px 20px;">
            </div>
            <div class="text-center" style="margin: -120px -20px 0px 20px;">
                <h2 class="name">BUFALINDA USA LLC</h2>
                <div>20200 W. Dixie Highway Suite 604, Aventura, FL 33180</div>
                <div>786-505-9513</div>
                <div><a href="www.bufalindausa.com">www.bufalindausa.com</a></div>
            </div>

        </header>
        <div id="watermark">
            <img src="assets/img/0001.jpg" height="100%" width="100%" />
        </div>
        <main>
            <h3 class="text-center" style="margin-top: 0px; margin-bottom: 0px;">Bufalinda USA - Product Order Form </h3>
            <br>
            <div class="row" style="margin-left: 20px;">
                <div class="col-md-2">
                    <label  >Customer Name</label>
                    <p >{!! $cab_sale_inv->cust->cust_company !!}</p>
                </div>
                <div class="col-md-2">
                    <label>Phone</label>
                    <p>{{$cab_sale_inv->cust->cust_phone}}</p>
                </div>
                <div class="col-md-3">
                    <label>Address</label>
                    <p>{{$cab_sale_inv->cust->cust_address}}</p>
                </div>
                <div class="col-md-2">
                    <label>Email</label>
                    <p><a href="mailto:{{$cab_sale_inv->cust->cust_email}}">{{$cab_sale_inv->cust->cust_email}}</a></p>
                </div>
            </div>
            <div class="row" style="margin-left: 20px;">
                <div class="col-md-2">
                    <label>Pick Up Date</label>
                    <p><?PHP echo date('m/d/Y',strtotime($cab_sale_inv->csaleinv_date_pick_up));?></p>
                </div>
                <div class="col-md-2">
                    <label>Time</label>
                    @if(isset($cab_sale_inv->csaleinv_date_time))
                    <p><?PHP echo date("h:i a",strtotime($cab_sale_inv->csaleinv_date_time));?></p>
                    
                    @endif
                </div>
                <div class="col-md-2">
                    <label>PO Number</label>
                    <p>{{$cab_sale_inv->csaleinv_invoice}}</p>
                </div>
                <div class="col-md-3">
                    <label>Order Number</label>
                    <p>{{$cab_sale_inv->csaleinv_or_num}}</p>
                </div>
            </div>
            <br>
            <div class="row">
                <div class="col-md-8 col-md-offset-2 text-center">
                    <div class="card" style="margin-top: -10px;margin-bottom:10px;">
                        <div class="card-content">
                            <div class="table-responsive" style="background-color: transparent;">
                                <table class="table table-hover  table-bordered">
                                    <thead class="text-center">
                                        <tr >
                                            <th class="text-center" style="background-color: #bde199;"><b>Item Description</b> </th>
                                            <th class="text-center" style="background-color: #bde199;"><b>Code</b></th>
                                            <th class="text-center" style="background-color: #bde199;"><b>Expiration Date</b></th>
                                            <th class="text-center" style="background-color: #bde199;"><b>Qty</b></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($det_sale_inv as $det_sale)

                                            <tr>
                                                <td style="background-color: #ffffff;">{{$det_sale->item->item_name}}</td>
                                                <td style="background-color: #ffffff;">{{$det_sale->item->item_code}}</td>
                                                <td style="background-color: #ffffff;">
                                                    @foreach ($inbound_order_det as $order_det)
                                                        @if($order_det->diord_lot == $det_sale->dsaleinv_lot)
                                                            <?PHP echo date('m/d/Y',strtotime($order_det->diord_expiration_date));?>
                                                        @endif
                                                    @endforeach
                                                </td style="background-color: #ffffff;">
                                                <td style="background-color: #ffffff;">{{$det_sale->dsaleinv_qty}}</td>
                                            </tr>
                                        @endforeach
                                        <tr>
                                            <td colspan="3" style="background-color: #ffffff;">Total Number of Boxes</td>
                                            <td style="background-color: #ffffff;">{{$qty}}</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row" style="margin-top: -20px">
                <div class="col-md-10 col-md-offset-1">
                    <label>Warehouse Address</label>
                    {{$wareh->id_warehouse}}
                    <p>{{$wareh->house_address}} / {{$wareh->house_phone}}</p>
                </div>
            </div>
            @if(isset($cab_sale_inv->csaleinv_chep_pallet) || isset($cab_sale_inv->csaleinv_shrink_wrap) || isset($cab_sale_inv->csaleinv_palletization))
            <div class="row form-horizontal" style="margin-left: 0px;">
                <label class="col-md-offset-1">Warehouse Requirements</label>
                <div class="col-md-8 col-md-offset-1">
                    <div class="checkbox checkbox-inline">
                        @if(isset($cab_sale_inv->csaleinv_chep_pallet))
                        <img src="assets/img/check.png" width="27" height="27">Chep Pallet Required
                        @endif
                    </div>
                    <div class="checkbox checkbox-inline">
                        @if(isset($cab_sale_inv->csaleinv_shrink_wrap))
                        <img src="assets/img/check.png" width="27" height="27">Shrink Wrap Required
                        @endif                            
                    </div>
                    <div class="checkbox checkbox-inline">
                        @if(isset($cab_sale_inv->csaleinv_palletization))
                        <img src="assets/img/check.png" width="27" height="27">Palletization Required 
                        @endif
                    </div>
                </div>
            </div>
            @endif
            <br>
            @if(!isset($cab_sale_inv->csaleinv_tran_cust))
            @if(isset($cab_sale_inv->csaleinv_tran_cust))
            <div class="row" style="margin-left: 20px;">
                <div class="col-md-3">
                    <label>Transportation Company</label>
                    <p>{{$cab_sale_inv->cust->cust_company}}</p>
                </div>
                <div class="col-md-2">
                    <label>Phone</label>
                    <p>{{$cab_sale_inv->cust->cust_phone}}</p>
                </div>
                <div class="col-md-2">
                    <label>Email</label>
                    <p><a href="mailto:{{$cab_sale_inv->cust->cust_email}}m">{{$cab_sale_inv->cust->cust_email}}</a></p>
                </div>
            </div>
            @elseif($cab_sale_inv->csaleinv_transport == 0)
            <div class="row" style="margin-left: 20px;">
                <div class="col-md-3">
                    <label>Transportation Company</label>
                    <p></p>
                </div>
                <div class="col-md-2">
                    <label>Phone</label>
                    <p></p>
                </div>
                <div class="col-md-2">
                    <label>Email</label>
                    <p></p>
                </div>
            </div>
            <br><br>
            @else
            <div class="row" style="margin-left: 20px;">
                <div class="col-md-3">
                    <label>Transportation Company</label>
                    <p>{{$cab_sale_inv->trans->trans_company}}</p>
                </div>
                <div class="col-md-2">
                    <label>Phone</label>
                    <p>{{$cab_sale_inv->trans->trans_phone}}</p>
                </div>
                <div class="col-md-2">
                    <label>Email</label>
                    <p><a href="mailto:{{$cab_sale_inv->trans->trans_email}}">{{$cab_sale_inv->trans->trans_email}}</a></p>
                </div>
            </div>
            @endif
            <div class="row" style="margin-left: 20px;">
                <div class="col-md-12">
                    @if(isset($cab_sale_inv->csaleinv_deli_name))
                    <label>Delivery Address</label>
                    <p>{{$cab_sale_inv->csaleinv_deli_name}} / {{$cab_sale_inv->csaleinv_deli_address}} / {{$cab_sale_inv->csaleinv_deli_phone}} / <a href="mailto:{{$cab_sale_inv->csaleinv_deli_email}}">{{$cab_sale_inv->csaleinv_deli_email}}</a></p>
                    @endif
                    @if(isset($cab_sale_inv->id_delivery))
                    <label>Delivery Address</label>
                    <p>{{$cab_sale_inv->sucursal->cust_company}} / {{$cab_sale_inv->sucursal->cust_address}} / {{$cab_sale_inv->sucursal->cust_phone}} / <a href="mailto:{{$cab_sale_inv->sucursal->cust_email}}">{{$cab_sale_inv->sucursal->cust_email}}</a></p>
                    @endif
                </div>
            </div>
            <div class="row" style="margin-left: 20px;;">
                <div class="col-md-3">
                    <div class="form-group ">
                        <label class="control-label">Estimated Date of Delivery</label>
                        @if(isset($cab_sale_inv->csaleinv_date_delivery))
                            <p><?PHP echo date('m/d/Y',strtotime($cab_sale_inv->csaleinv_date_delivery));?></p>
                        @endif
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group ">
                        <label class="control-label">Appointment Required</label>
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
            @endif
            
            <div class="row" style="margin-left: 20px;">
                <div class="col-md-2">
                    <label>Driver’s Name</label>
                    <p>{{$cab_sale_inv->csaleinv_driver_name}}</p>
                </div>
                <div class="col-md-2">
                    <label>Driver’s Phone #</label>
                    <p>{{$cab_sale_inv->csaleinv_driver_phone}}</p>
                </div>
                <div class="col-md-6">
                    <label>Driver’s Signature</label>
                    <br><br>
                    <p>_________________________</p>
                </div>
            </div>
            <div class="row" style="margin-left: 20px;">
                <div class="col-md-2">
                    <label>Observations</label>
                </div>
            </div>
        </main>
    </body>
</html>
