@extends('welcome')

@section('title')
 
@endsection

@section('extra-css')

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
<div class="row">
    <div class="col-md-offset-1 col-md-10">
        <div class="card">
            <div class="card-header card-header-icon" data-background-color="green">
                <i class="material-icons">library_books</i>
            </div>
            <div class="card-content">
                <h4 class="card-title">New 
                    <small class="category">Information</small>
                </h4>
                <form action="{{ action('InventoryController@store') }}" method="POST"  >
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
                                                    <th><b>Description</b></th>
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
                    <div class="addel">
                        <div class="row">
                            <div class="form-group addel-target" id="id">
                                <div class="row">
                                    <div class="col-md-2 col-md-offset-1">
                                        <div class="form-group ">
                                            <label class="control-label">Date</label>
                                            <input type="date" class="form-control" name="inv_date[]" required/>
                                        </div>
                                    </div>
                                    <div class="col-md-2">
                                        <div class="form-group ">
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
                                    <div class="col-md-2">
                                        <div class="form-group ">
                                            <label class="control-label">Unit</label>
                                            <input type="text" class="form-control" id='unit_item_1'readonly >
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    
                                    <div class="col-md-2 col-md-offset-1">
                                        <div class="form-group ">
                                            <label class="control-label">Qty</label>
                                            <input type="number" step="any" class="form-control" name="inv_qty[]" required>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group ">
                                            <label class="control-label">Lote order</label>
                                            <input type="text" class="form-control" name="inv_lot[]" required>
                                        </div>
                                    </div>
                                    <div class="col-md-2">
                                        <label class="control-label">Status</label>
                                        {!! Form::select('id_status[]', $status, null, ['class' => 'selectpicker form-group unit', 'data-style' => 'select-with-transition', 'data-size' => '7', 'required' => 'true']) !!}
                                    </div>
                                    <div class="col-md-1">
                                        <div class="form-group" style="margin-top: 40px;">
                                            <button type="button" class="btn btn-xs btn-danger pull-right addel-delete">
                                                <i class="fa fa-remove"> </i>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col-md-offset-10" style="margin-top: -67px; margin-right:170px;">
                                <button type="button" class="btn btn-success btn-xs pull-right addel-add">
                                    <i class="fa fa-plus"></i>
                                </button>
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
<script type="text/javascript">
    $(document).ready(function () {
        var cloneCount = 1; 
        $('.addel').addel({

            events: {
                added: function (event) {
                    var i=$('.addel-target').length;

                    $("#id").attr('id', 'id'+i).after("#id"+i-1);
                    $("#codeitem_1").attr('id', 'codeitem_1'+i).after("#codeitem_1"+i-1);
                    $("#name_item_1").attr('id', 'name_item_1'+i).after("#name_item_1"+i-1);
                    $("#unit_item_1").attr('id', 'unit_item_1'+i).after("#unit_item_1"+i-1);
                    $("#id_item_1").attr('id', 'id_item_1'+i).after("#id_item_1"+i-1);
                    $('.selectpicker').data('selectpicker', null)
                    $('.bootstrap-select').remove()
                    $('.selectpicker').selectpicker()

                }
            }
        }).on('addel:delete', function (event) {
            if (!window.confirm('Are you absolutely positive you would like to delete: ' + '"' + event.target.find(':input').val() + '"?')) {
                console.log('Deletion prevented!');
                event.preventDefault();
            }
        });
    });

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
            url: "{{ route('inventory/items') }}",
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