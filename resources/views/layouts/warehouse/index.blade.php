@extends('welcome')

@section('title')
    Warehouse 
@endsection

@section('extra-css')
@endsection

@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header card-header-icon" data-background-color="green">
                <i class="material-icons">store</i>
            </div>
            <div class="card-content">
                <h4 class="card-title">New Warehouse</h4>
                <form action="{{ action('WarehouseController@store') }}" class="validate-form form-horizontal"  method="POST"  >
                {{ csrf_field() }}
                    <div class="row">
                        <div class="col-md-offset-1 col-md-3">
                            <div class="form-group label-floating">
                                <label class="control-label">Company</label>
                                <input type="text" class="form-control" name="house_name" value="{{old('house_name')}}" maxlength="191" required>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group label-floating">
                                <label class="control-label">Phone</label>
                                <input type="text" name="house_phone" class="form-control date" data-mask="+(99)(999) 999-9999" value="{{old('house_phone')}}" required />
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group label-floating">
                                <label class="control-label">Phone 2 (Optional)</label>
                                <input type="text" name="house_phone_two" class="form-control date" data-mask="+(99)(999) 999-9999" value="{{old('house_phone_two')}}" />
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group label-floating">
                                <label class="control-label">Contact person</label>
                                <input type="text" class="form-control" name="house_person" value="{{old('house_person')}}" maxlength="191" required>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-3 col-md-offset-1">
                            <div class="form-group label-floating">
                                <label class="control-label">Email</label>
                                <input id="email" type="email" class="form-control" name="house_email" value="{{old('house_email')}}" maxlength="191" required>
                                @if ($errors->has('email'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group label-floating">
                                <label class="control-label">Email 2 (Optional)</label>
                                <input id="email" type="email" class="form-control" name="house_email_two" value="{{old('house_email_two')}}" maxlength="191">
                                @if ($errors->has('email'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group label-floating">
                                <label class="control-label">Email 3 (Optional)</label>
                                <input id="email" type="email" class="form-control" name="house_email_three" value="{{old('house_email_three')}}" maxlength="191">
                                @if ($errors->has('email'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class=" col-md-offset-1 col-md-5">
                            <div class="form-group label-floating">
                                <label class="control-label">Description</label>
                                <input type="text" class="form-control" name="house_description" value="{{old('house_description')}}" maxlength="191" required>
                            </div>
                        </div>
                        <div class="col-md-2">
                            {!! Form::select('id_status', $status, null, ['class' => 'selectpicker form-group', 'data-style' => 'select-with-transition', 'data-size' => '7', 'required' => 'required']) !!}
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-offset-1 col-md-8">
                            <div class="form-group label-floating">
                                <label class="control-label">Address</label>
                                <input type="text" class="form-control" name="house_address" value="{{old('house_address')}}" maxlength="191" required>
                            </div>
                        </div>
                    </div>
                    <br>
                    <div class="row ">
                        <label class="col-md-2 label-on-left">Activity</label>
                        <div class="col-md-10">
                            <div class="checkbox checkbox-inline">
                                <label>
                                    <input type="checkbox" name="optionsCheckboxes[]" value="Sale">Sale
                                </label>
                            </div>
                            <div class="checkbox checkbox-inline">
                                <label>
                                    <input type="checkbox" name="optionsCheckboxes[]" value="Transfer">Transfer
                                </label>
                            </div>
                            <div class="checkbox checkbox-inline">
                                <label>
                                    <input type="checkbox" name="optionsCheckboxes[]" value="Entry">Entry
                                </label>
                            </div>
                            <div class="checkbox checkbox-inline">
                                <label>
                                    <input type="checkbox" name="optionsCheckboxes[]"value="Output" >Output
                                </label>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <label class="col-sm-2 label-on-left">Step</label>
                        <div class="col-sm-1">
                            <div class="form-group label-floating is-empty">
                                <label class="control-label"></label>
                                <input type="number" class="form-control" name="step">
                            </div>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-success  btn-sm pull-right">Save</button>
                    <div class="clearfix"></div>
                </form>
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
                <i class="material-icons">location_city</i>
            </div>
            <div class="card-content">
                <h4 class="card-title">Warehouse</h4>
                <div class="toolbar">
                    <!--        Here you can write extra buttons/actions for the toolbar              -->
                </div>
                <div class="material-datatables">
                    <table id="datatables" class="table table-striped table-no-bordered table-hover" cellspacing="0" width="100%" style="width:100%">
                        <thead>
                            <tr>
                                <th>Company</th>
                                <th>Description</th>
                                <th>Address</th>
                                <th width="200">Phone</th>
                                <th>Contact Person</th>
                                <th>Email</th>
                                <th>Status</th>
                                <th>Activity</th>
                                <th>Step</th>
                                <th class="disabled-sorting text-right">Actions</th>
                            </tr>
                        </thead>
                        <tfoot> 
                            <tr>
                                <th>Company</th>
                                <th>Description</th>
                                <th>Address</th>
                                <th>Phone</th>
                                <th>Contact Person</th>
                                <th>Email</th>
                                <th>Status</th>
                                <th>Activity</th>
                                <th>Step</th>
                                <th class="disabled-sorting text-right">Actions</th>
                            </tr>
                        </tfoot>
                        <tbody>
                            @foreach($warehouse as $item)
                                <tr>
                                    <td>{{ $item->house_name}}</td>
                                    <td>{{ $item->house_description}}</td>
                                    <td>{{ $item->house_address}}</td>
                                    <td>{{ $item->house_phone}}
                                        @if(isset($item->house_phone_two))
                                        <br>
                                        {{ $item->house_phone_two}}
                                        @endif
                                    </td>
                                    <td>{{ $item->house_person}}</td>
                                    <td>{{ $item->house_email}}
                                        @if(isset($item->house_email_two))
                                        <br>
                                        {{ $item->house_email_two}}
                                        @endif
                                        @if(isset($item->house_email_three))
                                        <br>
                                        {{ $item->house_email_three}}
                                        @endif
                                    </td>
                                    <td>{{ $item->statu->status}}</td>
                                    <td><?PHP echo str_replace(',','<br>', $item->house_activity);?></td>
                                    <td>{{ $item->house_step}}</td>                                   
                                    <td class=" text-right">
                                        <a href="#" class="btn btn-simple btn-warning btn-icon" data-toggle="modal" data-target="#myModal{{ $item->id_warehouse}}"><i class="material-icons">edit</i></a>
                                        <a class="btn btn-danger btn-simple btn-icon" rel="tooltip" data-placement="left" title="Remove item" onclick="demo.showSwal('{{ $item->id_warehouse }}','{{csrf_token()}}','warehouse/destroy')">
                                            <i class="material-icons">close</i>
                                        </a>
                                    </td>
                                </tr>
                                <!-- Classic Modal -->
                                <div class="modal fade" id="myModal{{ $item->id_warehouse}}" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                                    <div class="modal-dialog modal-lg">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
                                                    <i class="material-icons">clear</i>
                                                </button>
                                                <h4 class="modal-title">Warehouse #{{ $item->house_name}} Details</h4>
                                            </div>
                                            <div class="modal-body">
                                                <div class="card-content">
                                                    <form action="{{ url('/master/warehouse/'. $item->id_warehouse.'/update') }} " method="post" >
                                                    {{ csrf_field() }}
                                                        <div class="row">
                                                            <div class="col-md-3">
                                                                <div class="form-group label-floating">
                                                                    <label class="control-label">Name</label>
                                                                    <input type="text" class="form-control" name="house_name" value="{{ $item->house_name}}" maxlength="191" required>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-3">
                                                                <div class="form-group label-floating">
                                                                    <label class="control-label">Phone</label>
                                                                    <input type="text" name="house_phone" class="form-control date" data-mask="+(99)(999) 999-9999" value="{{ $item->house_phone}}" required />
                                                                </div>
                                                            </div>
                                                            <div class="col-md-3">
                                                                <div class="form-group label-floating">
                                                                    <label class="control-label">Phone 2 (Optional)</label>
                                                                    <input type="text" name="house_phone_two" class="form-control date" data-mask="+(99)(999) 999-9999" value="{{ $item->house_phone_two}}"/>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-3">
                                                                <div class="form-group label-floating">
                                                                    <label class="control-label">Contact Person</label>
                                                                    <input type="text" class="form-control" name="house_person" value="{{ $item->house_person}}" maxlength="191" required>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="row">
                                                            <div class="col-md-3">
                                                                <div class="form-group label-floating">
                                                                    <label class="control-label">Email</label>
                                                                    <input id="email" type="email" class="form-control" name="house_email" value="{{$item->house_email}}" maxlength="191" required>
                                                                    @if ($errors->has('email'))
                                                                        <span class="help-block">
                                                                            <strong>{{ $errors->first('email') }}</strong>
                                                                        </span>
                                                                    @endif
                                                                </div>
                                                            </div>
                                                            <div class="col-md-3">
                                                                <div class="form-group label-floating">
                                                                    <label class="control-label">Email 2 (Optional)</label>
                                                                    <input id="email" type="email" class="form-control" name="house_email_two" value="{{$item->house_email_two}}" maxlength="191">
                                                                    @if ($errors->has('email'))
                                                                        <span class="help-block">
                                                                            <strong>{{ $errors->first('email') }}</strong>
                                                                        </span>
                                                                    @endif
                                                                </div>
                                                            </div>
                                                            <div class="col-md-3">
                                                                <div class="form-group label-floating">
                                                                    <label class="control-label">Email 3 (Optional)</label>
                                                                    <input id="email" type="email" class="form-control" name="house_email_three" value="{{$item->house_email_three}}" maxlength="191">
                                                                    @if ($errors->has('email'))
                                                                        <span class="help-block">
                                                                            <strong>{{ $errors->first('email') }}</strong>
                                                                        </span>
                                                                    @endif
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="row">
                                                            <div class="col-md-6">
                                                                <div class="form-group label-floating">
                                                                    <label class="control-label">Description</label>
                                                                    <input type="text" class="form-control" name="house_description" value="{{ $item->house_description}}" maxlength="191" required>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-2">
                                                                {!! Form::select('id_status', $status, $item->id_status, ['class' => 'selectpicker form-group label-floating', 'data-style' => 'select-with-transition', 'data-size' => '7']) !!}
                                                            </div>
                                                        </div>
                                                        <div class="row">
                                                            <div class="col-md-6">
                                                                <div class="form-group label-floating">
                                                                    <label class="control-label">Address</label>
                                                                    <input type="text" class="form-control" name="house_address" value="{{ $item->house_address}}" maxlength="191" required>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <br>
                                                        <div class="row form-horizontal">
                                                            <label class="col-md-2 label-on-left">Activity</label>
                                                            <div class="col-md-10" style="margin-top: -20px;">
                                                                <div class="checkbox checkbox-inline">
                                                                    <label>
                                                                        <input type="checkbox" name="optionsCheckboxes[]" value="Sale">Sale
                                                                    </label>
                                                                </div>
                                                                <div class="checkbox checkbox-inline">
                                                                    <label>
                                                                        <input type="checkbox" name="optionsCheckboxes[]" value="Transfer">Transfer
                                                                    </label>
                                                                </div>
                                                                <div class="checkbox checkbox-inline">
                                                                    <label>
                                                                        <input type="checkbox" name="optionsCheckboxes[]" value="Entry">Entry
                                                                    </label>
                                                                </div>
                                                                <div class="checkbox checkbox-inline">
                                                                    <label>
                                                                        <input type="checkbox" name="optionsCheckboxes[]"value="Output" >Output
                                                                    </label>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="row form-horizontal">
                                                            <br>
                                                            <label class="col-md-2 label-on-left">Stet</label>
                                                            <div class="col-md-3" style="margin-top: -20px;">
                                                                <div class="form-group label-floating is-empty">
                                                                    <label class="control-label"></label>
                                                                    <input type="number" class="form-control" name="step" value="{{ $item->house_step}}">
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
        });
    </script>
@endsection