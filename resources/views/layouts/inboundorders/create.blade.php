@extends('welcome')

@section('title')
    New inbound Order 
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

@if(count($item) == 0)
    <div class="header text-center">
        <h3 class="title">No items</h3>
        <p class="category">You need items to create a new inbound order!</p>
    </div>
@else
    <div class="row" style="margin-top: 15px">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header card-header-icon" data-background-color="green">
                    <i class="material-icons">library_books</i>
                </div>
                <div class="card-content">
                    <h4 class="card-title">New inbound Order -
                        <small class="category">Order Information</small>
                    </h4>
                    {{ Form::open(array('action' => 'InboundOrdersController@store', 'files' => true)) }}
                        {{ csrf_field() }}
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
                                                        <th><b>Units</b></th>
                                                        <th class="disabled-sorting text-right"><b>Select</b></th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach($item as $item)
                                                    <tr>
                                                        <td>
                                                            <div class="img-container">
                                                                <img src="../inv_img/{{ $item->item_ruta}}" alt="...">
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
                                    <input type="date" class="form-control" name="ciord_date" value="<?php echo date('Y-m-d'); ?>"  readonly/>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group ">
                                    <label class="control-label">Date Export</label>
                                    <input type="date" class="form-control " min="<?php echo date("Y-m-d");?>" name="ciord_export_date" />
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group ">
                                    <label class="control-label">Air Waybill</label>
                                    <input type="text" class="form-control" name="ciord_guia_aerea" value="{{old('ciord_guia_aerea')}}">
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group ">
                                    <label class="control-label">Purchase order</label>
                                    <input type="text" class="form-control" name="ciord_orden_compra" value="{{old('ciord_orden_compra')}}" required>
                                </div>
                            </div>
                        </div>
                        <div class="addel">
                            <div class="row">
                                <div class="form-group addel-target" id="id">
                                    <div class="col-md-1">
                                        <div class="form-group">
                                            <label class="control-label">Pallet</label>
                                            <input type="text" class="form-control" name="pallet[]" required>
                                        </div>
                                    </div>
                                    <div class="col-md-1">
                                        <div class="form-group">
                                            <label class="control-label">Code Item</label>
                                            <input type="text" class="form-control funlinea" id='codeitem_1' data-toggle="modal" data-target="#myModal" required onkeypress="return false;">
                                            <input type="hidden" name="item_code[]" id='id_item_1' readonly>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group ">
                                            <label class="control-label">Name Item</label>
                                            <input type="text" class="form-control" id='name_item_1' readonly>
                                        </div>
                                    </div>
                                    <div class="col-md-2" style="width: 12%;">
                                        <div class="form-group ">
                                            <label class="control-label">Unit</label>
                                            <input type="text" class="form-control" id='unit_item_1'readonly >
                                        </div>
                                    </div>
                                    <div class="col-md-1">
                                        <div class="form-group ">
                                            <label class="control-label">Qty</label>
                                            <input type="number" min="1" class="form-control" name="diord_qty[]">
                                        </div>
                                    </div>
                                    <div class="col-md-2" style="width: 12%;">
                                        <div class="form-group ">
                                            <label class="control-label">Lote order</label>
                                            <input type="text" class="form-control" name="diord_lot[]">
                                        </div>
                                    </div>
                                    <div class="col-md-2">
                                        <div class="form-group ">
                                            <label class="control-label">Expiration date</label>
                                            <input type="date" class="form-control" name="diord_expiration_date[]" min="<?php echo date('Y-m-d'); ?>"/>
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
                                                    @foreach($document as $item)
                                                        <tr class="text-center">
                                                            <input type="hidden" name="id_doc[]" value="{{ $item->id_doc }}">
                                                            <td class="text-center">{{ $item->doc_description}}</td>
                                                            <td class="text-center">
                                                                <div class="col-md-10">
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
                        <button type="submit" class="btn btn-success btn-sm pull-right">Save</button>
                        <div class="clearfix"></div>
                    {{ Form::close() }}
                </div>
            </div>
        </div>
    </div>
@endif

@endsection

@section('extra-script')
    {{Html::script('assets/dynamic.addel/addel.jquery.js')}}
    <script>
        $(document).ready(function () {
            var cloneCount = 1; 
            $('.addel').addel({
                events: {
                    added: function (event) {
                        var i=$('.addel-target').length;

                        $("#id").attr('id', 'id'+i).after("#id"+i-1);
                        $("#codeitem_1").attr('id', 'codeitem_1'+i).after("#codeitem_1"+i-1);
                        $("#name_item_1").attr('id', 'name_item_1'+i).after("#name_item_1"+i-1);
                        $("#id_item_1").attr('id', 'id_item_1'+i).after("#id_item_1"+i-1);
                        $("#unit_item_1").attr('id', 'unit_item_1'+i).after("#unit_item_1"+i-1);
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
@endsection