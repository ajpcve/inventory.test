@extends('welcome')

@section('title')
    Item
@endsection

@section('extra-css')

@endsection

@section('content')
@if (count($errors) > 0)
    <div class="alert alert-danger">
        <p>Corrige los siguientes errores:</p>
        <ul>
            @foreach ($errors->all() as $message)
                <li>{{ $message }}</li>
            @endforeach
        </ul>
    </div>
@endif
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header card-header-icon" data-background-color="green">
                <i class="material-icons">grade</i>
            </div>
            <div class="card-content">
                <h4 class="card-title">New Item</h4>
                {{ Form::open(array('action' => 'ItemController@store', 'files' => true)) }}
                    {{ csrf_field() }}
                
                    <div class="row">
                        <div class="col-md-2">
                            <div class="form-group label-floating">
                                <label class="control-label">Code</label>
                                <input type="text" class="form-control" name="item_code" value="{{old('item_code')}}" maxlength="191" required>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group label-floating">
                                <label class="control-label">Name</label>
                                <input type="text" class="form-control" name="item_name" value="{{old('item_name')}}" maxlength="191" required>
                            </div>
                        </div>
                        <div class="col-md-2">
                            {!! Form::select('id_unit', $unit, null, ['class' => 'selectpicker form-group', 'data-style' => 'select-with-transition', 'title' => 'Unit ', 'data-size' => '7']) !!}
                        </div>
                        <div class="col-md-2">
                            {!! Form::select('id_status', $status, null, ['class' => 'selectpicker form-group', 'data-style' => 'select-with-transition', 'title' => 'Status', 'data-size' => '7']) !!}
                        </div>
                        <div class="col-md-3">
                            <div class="form-group label-floating">
                                <div class="fileinput fileinput-new " data-provides="fileinput">
                                    <div class="fileinput-preview fileinput-exists thumbnail"></div>
                                    
                                    <div>
                                        <span class="btn btn-rose btn-xs btn-file">
                                            <span class="fileinput-new">Select image</span>
                                            <span class="fileinput-exists">Change</span>
                                            {!! Form::file('item_ruta') !!}
                                        </span>
                                        <a href="#pablo" class="btn btn-danger btn-xs fileinput-exists" data-dismiss="fileinput"><i class="fa fa-times"></i> Remove</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-success  btn-sm pull-right">Save</button>
                    <div class="clearfix"></div>
                {{ Form::close() }}
            </div>
            <!-- end content-->
        </div>
        <!--  end card  -->
    </div>
    <!-- end col-md-12 -->
</div>
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header card-header-icon" data-background-color="green">
                <i class="material-icons">stars</i>
            </div>
            <div class="card-content">
                <h4 class="card-title">Item</h4>
                <div class="toolbar">
                    <!--        Here you can write extra buttons/actions for the toolbar              -->
                </div>
                <div class="material-datatables">
                    <table id="datatables" class="table table-striped table-no-bordered table-hover table-shopping" cellspacing="0" width="100%" style="width:100%">
                        <thead>
                            <tr>
                                <th>Image</th>
                                <th>Code</th>
                                <th>Name</th>
                                <th>Unit</th>
                                <th>Status</th>
                                <th class="disabled-sorting text-right">Actions</th>
                            </tr>
                        </thead>
                        <tfoot>
                            <tr>
                                <th>Image</th>
                                <th>Code</th>
                                <th>Name</th>
                                <th>Unit</th>
                                <th>Status</th>
                                <th class="disabled-sorting text-right">Actions</th>
                            </tr>
                        </tfoot>
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
                                <td>{{ $item->statu->status}}</td>                              
                                <td class=" text-right">
                                    <a href="#" class="btn btn-simple btn-warning btn-icon" data-toggle="modal" data-target="#myModal{{ $item->id_item}}"><i class="material-icons">edit</i></a>
                                    <a class="btn btn-danger btn-simple btn-icon" rel="tooltip" data-placement="left" title="Remove item" onclick="demo.showSwal('{{ $item->id_item }}','{{csrf_token()}}','item/destroy')">
                                        <i class="material-icons">close</i>
                                    </a>
                                </td>
                            </tr>
                            <!-- Classic Modal -->
                            <div class="modal fade" id="myModal{{ $item->id_item}}" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                                <div class="modal-dialog modal-lg">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
                                                <i class="material-icons">clear</i>
                                            </button>
                                            <h4 class="modal-title">Item #{{ $item->item_code}} Details</h4>
                                        </div>
                                        <div class="modal-body">
                                            <div class="card-content">
                                                <form action="{{ url('/master/item/'. $item->id_item.'/update') }} " method="post" enctype="multipart/form-data">
                                                    {{ csrf_field() }}
                                                    <div class="row">
                                                        <div class="col-md-2">
                                                            <div class="form-group label-floating">
                                                                <label class="control-label">Code</label>
                                                                <input type="text" class="form-control" name="item_code" value="{{ $item->item_code}}" maxlength="191" required>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-4">
                                                            <div class="form-group label-floating">
                                                                <label class="control-label">Name</label>
                                                                <input type="text" class="form-control" name="item_name" value="{{ $item->item_name}}" maxlength="191" required>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-2">
                                                            {!! Form::select('id_unit', $unit, $item->id_unit, ['class' => 'selectpicker form-group', 'data-style' => 'select-with-transition', 'title' => 'Measurement unit ', 'data-size' => '7']) !!}
                                                        </div>
                                                        <div class="col-md-2">
                                                            {!! Form::select('id_status', $status, $item->id_status, ['class' => 'selectpicker form-group label-floating', 'data-style' => 'select-with-transition', 'data-size' => '7']) !!}
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-md-2">
                                                            <div class="form-group label-floating">
                                                                <div class="fileinput fileinput-exists" data-provides="fileinput">
                                                                    <div class="fileinput-preview fileinput-exists thumbnail">
                                                                        <img src="../inv_img/{{ $item->item_ruta}}" alt="...">
                                                                    </div>
                                                                    <div>
                                                                        <span class="btn btn-rose btn-xs btn-file">
                                                                            <span class="fileinput-new">Select image</span>
                                                                            <span class="fileinput-exists">Change</span>
                                                                            {!! Form::file('item_ruta') !!}
                                                                        </span>
                                                                        <a href="#" class="btn btn-danger btn-xs fileinput-exists" data-dismiss="fileinput"><i class="fa fa-times"></i> Remove</a>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            
                                                        </div>
                                                    </div>
                                                    <button type="submit" class="btn btn-success  btn-sm pull-right">Save</button>
                                                    <div class="clearfix"></div>
                                                </form>
                                            </div>
                                        </div>
                                        
                                    </div>
                                </div>
                            </div>
                            <!--  End Modal -->
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            <!-- end content-->
        </div>
        <!--  end card  -->
    </div>
    <!-- end col-md-12 -->
</div>
@endsection

@section('extra-script')
    {{Html::script('assets/Inputmask-4.x/dist/jquery.inputmask.bundle.js')}}
    <script type="text/javascript">
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

            $('.card .material-datatables label').addClass('form-group');
        });
        @if(Session::has('update'))
            demo.showUpdateSuccess('top','center');

            @php
                Session::forget('update');
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