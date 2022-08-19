@extends('welcome')

@section('title')
    Edit inbound Order #{{$inbound_order->id_ciord}}
@endsection

@section('extra-css')
    <style type="text/css">
        .row{
            margin-top: -15px;
        }
        .addel{
            margin-top: -150px;
        }
        .form-group {
            margin: 0 0 0 0;
        }
    </style>
@endsection

@section('content')
@if (count($errors) > 0)
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $message)
                <li>{{ $message }}</li>
            @endforeach
        </ul>
    </div>
@endif
<div class="row" style="margin-top: 15px">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header card-header-icon" data-background-color="green">
                <i class="material-icons">library_books</i>
            </div>
            <div class="card-content">
                <form action="{{ url('inbound_orders/update/'. $inbound_order->id_ciord) }} " method="post" enctype="multipart/form-data">
                    {{ csrf_field() }}
                    <h4 class="card-title">Edit inbound Order #{{$inbound_order->id_ciord}}-
                        <small class="category">Order Information</small>
                    </h4>
                    <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                        <div class="modal-dialog modal-lg">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
                                        <i class="material-icons">clear</i>
                                    </button>
                                    <h4 class="modal-title">Customer  Details</h4>
                                </div>
                                <div class="modal-body">
                                    <div class="material-datatables">
                                        <table id="datatables" class="table table-striped table-no-bordered table-hover table-shopping" cellspacing="0" width="100%" style="width:100%">
                                            <thead>
                                                <tr>
                                                    <th><b>Image</b></th>
                                                    <th><b>Code</b></th>
                                                    <th><b>Name</b></th>
                                                    <th><b>Description</b></th>
                                                    <th class="disabled-sorting text-right"><b>Select</b></th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach($item as $item)
                                                <tr>
                                                    <td>
                                                        <div class="img-container">
                                                            <img src="../../inv_img/{{ $item->item_ruta}}" alt="...">
                                                        </div>
                                                    </td>
                                                    <td>{{ $item->item_code}}</td>
                                                    <td>{{ $item->item_name}}</td>
                                                    <td>{{ $item->unit->unit}}</td>
                                                    <td>
                                                        <div class="radio">
                                                            <label>
                                                                <input type="radio" name="item_id" id="modal" value="{{ $item->id_item}}" checked onclick="id_item('')">
                                                            </label>
                                                        </div>
                                                    </td>
                                                </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div> 
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-3">
                            <div class="form-group ">
                                <label class="control-label">Date</label>
                                <input type="date" class="form-control" name="ciord_date" value="{{$inbound_order->ciord_date}}" readonly/>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group ">
                                <label class="control-label">Date Export</label>
                                <input type="date" class="form-control " min="{{$inbound_order->ciord_date}}" name="ciord_export_date" value="{{$inbound_order->ciord_export_date}}" />
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group ">
                                <label class="control-label">Air Waybill</label>
                                <input type="text" class="form-control" name="ciord_guia_aerea" value="{{$inbound_order->ciord_guia_aerea}}">
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group ">
                                <label class="control-label">Purchase order</label>
                                <input type="text" class="form-control" name="ciord_orden_compra" value="{{$inbound_order->ciord_orden_compra}}">
                            </div>
                        </div>
                    </div>
                    <div class="addel">
                        <div class="row">
                            @foreach($inbound_order_det as $order_det)
                                <div class="form-group addel-target" id="id{{$order_det->id_diord}}">
                                    <div class="col-md-1">
                                        <div class="form-group ">
                                            <label class="control-label">Pallet</label>
                                            <input type="text" class="form-control" name="pallet[]" value="{{$order_det->diord_pallet}}">
                                        </div>
                                    </div>
                                    <div class="col-md-1">
                                        <div class="form-group ">
                                            <label class="control-label">Code Item</label>
                                            <input type="text" class="form-control code" id='codeitem_1' value="{{$order_det->items->item_code}}" data-toggle="modal" data-target="#myModal" required onkeypress="return false;">
                                            <input type="hidden" name="item_code[]" class="form-control iditem" id='id_item_1' value="{{$order_det->diord_item_code}}"  readonly>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group ">
                                            <label class="control-label">Name Item</label>
                                            <input type="text" class="form-control name" id='name_item_1' value="{{$order_det->items->item_name}}" readonly>
                                        </div>
                                    </div>
                                    <div class="col-md-1">
                                        <div class="form-group ">
                                            <label class="control-label">Unit</label>
                                            <input type="text" class="form-control unit" id='unit_item_1' value="{{$order_det->items->unit->unit}}" readonly >
                                        </div>
                                    </div>
                                    <div class="col-md-1">
                                        <div class="form-group ">
                                            <label class="control-label">Qty</label>
                                            <input type="number" min="1" class="form-control" name="diord_qty[]" value="{{$order_det->diord_qty}}">
                                        </div>
                                    </div>
                                    <div class="col-md-2">
                                        <div class="form-group ">
                                            <label class="control-label">Lote order</label>
                                            <input type="text" class="form-control" name="diord_lot[]" value="{{$order_det->diord_lot}}">
                                        </div>
                                    </div>
                                    <div class="col-md-2">
                                        
                                        <div class="form-group ">
                                            <label class="control-label">Expiration date</label>
                                            <input type="date" class="form-control" name="diord_expiration_date[]" value="{{$order_det->diord_expiration_date}}" min="{{$inbound_order->ciord_date}}"/>
                                        </div>
                                    </div>
                                    <div class="col-md-1 ">
                                        <div class="form-group" style="margin-top: 40px;">
                                            <button type="button" class="btn btn-xs btn-danger pull-right addel-delete">
                                                <i class="fa fa-remove"> </i>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                        <div class="row">
                            <div class="form-group col-md-offset-10">
                                <button type="button" class="btn btn-success btn-xs pull-right addel-add">
                                    <i class="fa fa-plus"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 col-md-offset-3 text-center">
                            <h4 class="card-title">
                                Required documents
                                <p class="category">Click to view notifications</p>
                            </h4>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-8 col-md-offset-2 text-center">
                            <div class="card" style="margin-top: -10px;margin-bottom: -20px;">
                                <div class="card-content">
                                    <div class="table-responsive">
                                        <table class="table">
                                            <thead class="text-success">
                                                <th class="text-center">Name</th>
                                                <th class="text-center">Select</th>
                                            </thead>
                                            <tbody>
                                                @foreach ($doc_rut as $key_doc_rut => $doc_rut_val)
                                                @foreach($document as $item)
                                                @if($item->id_doc == $key_doc_rut)
                                                @if($doc_rut_val == 0)
                                                <tr>
                                                    <input type="hidden" name="id_doc[]" value="{{ $item->id_doc }}">
                                                    <td>{{ $item->doc_description}}</td>
                                                    <td>
                                                        <div class="col-md-10">
                                                            <div class="form-group label-floating">
                                                                <div class="fileinput fileinput-new " data-provides="fileinput">
                                                                    <div class="fileinput-preview fileinput-exists thumbnail"></div>
                                                                    <div>
                                                                        <span class="btn btn-success btn-xs btn-file">
                                                                            <span class="fileinput-new">Select document</span>
                                                                            <span class="fileinput-exists">Change</span>
                                                                            <input name="documents[{{ $item->id_doc }}]" type="file" accept="application/pdf"/>
                                                                        </span>
                                                                        <a href="#" class="btn btn-danger btn-xs fileinput-exists" data-dismiss="fileinput"><i class="fa fa-times"></i> Remove</a>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </td>
                                                </tr>
                                                @else
                                                <tr class="text-center">
                                                    <input type="hidden" name="id_doc[]" value="{{ $item->id_doc }}">
                                                    <td> {{ $item->doc_description}}</td>
                                                    @foreach($inbound_order_doc as $item1)
                                                        @if($item1->id_doc == $item->id_doc)
                                                            <td>
                                                                <div class="col-md-10">
                                                                    <div class="form-group label-floating">
                                                                        <div class="fileinput fileinput-exists " data-provides="fileinput">
                                                                            <div class="fileinput-preview fileinput-exists thumbnail">
                                                                                <p>{{ $item1->dociord_ruta}}</p>
                                                                                <p>{{ $item1->id_dociord}}</p>
                                                                                <img src="../../documents/{{ $item1->dociord_ruta}}" alt="...">
                                                                            </div>
                                                                            <div>
                                                                                <span class="btn btn-success btn-xs btn-file">
                                                                                    <span class="fileinput-new">Select document</span>
                                                                                    <span class="fileinput-exists">Change</span>
                                                                                    <input name="documents[{{ $item->id_doc }}]" type="file" accept="application/pdf"/>
                                                                                </span>
                                                                                <a href="#" class="btn btn-danger btn-xs fileinput-exists" data-dismiss="fileinput" onclick="showSwal('{{ $item->id_doc }}', '{{ $item1->id_dociord }}')"><i class="fa fa-times" ></i> Remove</a>
                                                                                <input type="hidden" name="delete[{{ $item->id_doc }}]" class="delete_{{ $item->id_doc }}">
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </td>
                                                        @endif
                                                    @endforeach
                                                </tr>
                                                @endif
                                                @endif
                                                @endforeach
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-success btn-sm pull-right">Save</button>
                    <div class="clearfix"></div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@section('extra-script')
    {{Html::script('assets/dynamic.addel/addel.jquery.js')}}
    <script>
        $(document).ready(function () {
            var j=$('.addel-target').length;
            var a = '{{$order_det->id_diord}}';
            console.log(a);
            var cloneCount = j+1; 
            
            $('.addel').addel({
                events: {
                    added: function (event) {
                        var h=$('.addel-target').last();
                        var i=$('.code').last();
                        var j=$('.name').last();
                        var k=$('.unit').last();
                        var l=$('.iditem').last();
                        //var i=$('.addel-target').length;
                        console.log(h);
                        a++;
                        //$("#id"+a).attr('id', 'id'+a).after("#id"+a-1);
                        $(h).attr('id', 'id'+a);
                        $(i).attr('id', 'codeitem_1'+a).after("#codeitem_1"+a-1);
                        $(j).attr('id', 'name_item_1'+a).after("#name_item_1"+a-1);
                        $(k).attr('id', 'unit_item_1'+a).after("#unit_item_1"+a-1);
                        $(l).attr('id', 'id_item_1'+a).after("#id_item_1"+a-1);
                        
                    }
                }
            }).on('addel:delete', function (event) {
                if (!window.confirm('Are you absolutely positive you would like to delete: ' + '"' + event.target.find(':input').val() + '"?')) {
                    console.log('Deletion prevented!');
                    event.preventDefault();
                }
            });
        });
    </script>
    <script type="text/javascript">
        var elementId = null; 
        $(function() {
            $(document).on('click', 'input[type="text"]', function(event) {
                let id = this.id;
                //console.log("Se presionó el Boton con Id :"+ id)
                idsp = id.split("_");
                //console.log(idsp)
                elementId = idsp[idsp.length-1];
                //console.log(elementId)

            });
        });

        function id_item() {
            var itemid = $('input:radio[name=item_id]:checked').val();
            console.log(itemid);

            $.ajax({
                url: "{{ route('inbound_orders/items') }}",
                method: 'get',
                data: {
                    itemid: itemid,
                    elementId: elementId,
                },
                success: function(data) {
                    //console.log(elementId);
                    $('#codeitem_'+elementId).val(data[0].item_code);
                    $('#name_item_'+elementId).val(data[0].item_name);
                    $('#unit_item_'+elementId).val(data[0].id_unit);
                    $('#id_item_'+elementId).val(data[0].id_item);
                }
            });
        }

        $(document).ready(function() {
            demo.initFormExtendedDatetimepickers();

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
        
        
    </script>
    <script type="text/javascript">
        function showSwal(a,e) {
            var id = e;
            $(".delete_"+a).val(e);
            console.log(id);
        }
    </script>
@endsection