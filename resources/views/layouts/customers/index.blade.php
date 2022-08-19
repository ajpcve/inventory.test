@extends('welcome')

@section('title')
    Customers 
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
                <i class="material-icons">assignment_ind</i>
            </div>
            <div class="card-content">
                <h4 class="card-title">New Customers</h4>
                <form action="{{ action('CustomersController@store') }}" method="POST"  >
                {{ csrf_field() }}
                    <div class="row">
                        <div class="col-md-offset-1 col-md-3">
                            <div class="form-group label-floating">
                                <label class="control-label">Name or Company</label>
                                <input type="text" class="form-control" name="cust_company[]" value="{{old('cust_company')}}" maxlength="191" required>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group label-floating">
                                <label class="control-label">Phone</label>
                                <input type="text" name="cust_phone[]" class="form-control" data-mask="+(99)(999) 999-9999" value="{{old('cust_phone')}}" required />
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group label-floating">
                                <label class="control-label">Email</label>
                                <input id="email" type="email" class="form-control" name="cust_email[]" value="{{old('cust_email')}}" maxlength="191" required>
                                @if ($errors->has('email'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                        <div class="col-md-2">
                            <select class="selectpicker form-group id_status" name="id_status[]" title="Status" data-size="7" data-style="select-with-transition" required>
                                @foreach($status as $sta)
                                    <option value="{{$sta->id_status}}">{{$sta->status}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-offset-1 col-md-8">
                            <div class="form-group label-floating">
                                <label class="control-label">Address</label>
                                <input type="text" class="form-control" name="cust_address[]" value="{{old('cust_address')}}" maxlength="191" required>
                            </div>
                        </div>
                        
                    </div>
                    <div class="row">
                        <div class="col-md-offset-1 col-md-3">
                            <div class="form-group label-floating">
                                <label class="control-label">Resale Tax ID #</label>
                                <input type="text" class="form-control" name="cust_tax[]" data-mask="99-999 9999" value="{{old('cust_tax')}}" maxlength="191">
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group label-floating">
                                <label class="control-label">Contact name</label>
                                <input type="text" class="form-control" name="cust_contact[]" value="{{old('cust_contact')}}" maxlength="191">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <br>
                            <div class="checkbox">
                                <label>
                                    <input type="checkbox" name="cust_sucursal[]" value="C">Does customer have branch offices?
                                </label>
                            </div>
                        </div>
                    </div>
                    <div id="div1">
                        <div class="addel">
                            <div class="form-group addel-target">
                                <div class="row">
                                    <input type="hidden" name="cust_sucursal[]">
                                    <div class="col-md-offset-1 col-md-3">
                                        <div class="form-group label-floating">
                                            <label class="control-label">Name or Company</label>
                                            <input type="text" class="form-control cust_company" name="cust_company[]" value="{{old('cust_company')}}" maxlength="191">
                                        </div>
                                    </div>
                                    <div class="col-md-2">
                                        <div class="form-group label-floating">
                                            <label class="control-label">Phone</label>
                                            <input type="text" name="cust_phone[]" class="form-control cust_phone" data-mask="+(99)(999) 999-9999" value="{{old('cust_phone')}}"/>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group label-floating">
                                            <label class="control-label">Email</label>
                                            <input id="email" type="email" class="form-control cust_email" name="cust_email[]" value="{{old('cust_email')}}" maxlength="191">
                                            @if ($errors->has('email'))
                                                <span class="help-block">
                                                    <strong>{{ $errors->first('email') }}</strong>
                                                </span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-md-2">
                                        <select class="selectpicker form-group id_status" name="id_status[]" title="Status" data-size="7" data-style="select-with-transition">
                                            @foreach($status as $sta)
                                                <option value="{{$sta->id_status}}">{{$sta->status}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-offset-1 col-md-8">
                                        <div class="form-group label-floating">
                                            <label class="control-label">Address</label>
                                            <input type="text" class="form-control cust_address" name="cust_address[]" value="{{old('cust_address')}}" maxlength="191">
                                        </div>
                                    </div>
                                    
                                </div>
                                <div class="row">
                                    <div class="col-md-offset-1 col-md-3">
                                        <div class="form-group label-floating">
                                            <label class="control-label">Resale Tax ID #</label>
                                            <input type="text" class="form-control cust_tax" data-mask="99-999 9999" name="cust_tax[]" value="{{old('cust_tax')}}" maxlength="191">
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group label-floating">
                                            <label class="control-label">Contact name</label>
                                            <input type="text" class="form-control cust_contact" name="cust_contact[]" value="{{old('cust_contact')}}" maxlength="191">
                                        </div>
                                    </div>
                                    <div class="col-md-1 pull-right">
                                        <div class="form-group" style="margin-top: 40px;">
                                            <button type="button" class="btn btn-xs btn-danger pull-right addel-delete">
                                                <i class="fa fa-remove"> </i>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group pull-right" style="margin-right: 100px;margin-top: -55px;">
                                    <button type="button" class="btn btn-success btn-xs pull-right addel-add" onclick="addNew(1)">
                                        <i class="fa fa-plus"></i>
                                    </button>
                                </div>
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
                <i class="material-icons">folder_shared</i>
            </div>
            <div class="card-content">
                <h4 class="card-title">Customers</h4>
                <div class="toolbar">
                    <!--        Here you can write extra buttons/actions for the toolbar              -->
                </div>
                <div class="material-datatables">
                    <table id="datatables" class="table table-striped table-no-bordered table-hover" cellspacing="0" width="100%" style="width:100%">
                        <thead>
                            <tr>
                                <th>Person or Company</th>
                                <th width="150">Phone</th>
                                <th>Address</th>
                                <th>Email</th>
                                <th>Resale Tax ID</th>
                                <th>Contact name</th>
                                <th>Sucursal</th>
                                <th>Status</th>
                                <th class="disabled-sorting text-right">Actions</th>
                            </tr>
                        </thead>
                        <tfoot>
                            <tr>
                                <th>Person or Company</th>
                                <th>Phone</th>
                                <th>Address</th>
                                <th>Email</th>
                                <th>Resale Tax ID</th>
                                <th>Contact name</th>
                                <th>Sucursal</th>
                                <th>Status</th>                                
                                <th class="disabled-sorting text-right">Actions</th>
                            </tr>
                        </tfoot>
                        <tbody>
                            @foreach($customer as $item)
                                <tr>
                                    <td>{{ $item->cust_company}}</td>
                                    <td>{{ $item->cust_phone}}</td>
                                    <td>{{ $item->cust_address}}</td>
                                    <td>{{ $item->cust_email}}</td>
                                    <td>{{ $item->cust_tax}}</td>
                                    <td>{{ $item->cust_contact}}</td>
                                    <td>
                                        @if($custo == 0)
                                        @else
                                        @foreach($custo as $key_cust => $cust)
                                            @if( $key_cust == $item->cust_num_sucursal && $item->cust_sucursal != 'C')
                                            {{ $cust}}
                                            @endif                                        
                                        @endforeach
                                        @endif
                                    </td>
                                    <td>{{ $item->statu->status}}</td> 
                                    <td class=" text-right">
                                        <a href="#" class="btn btn-simple btn-warning btn-icon" data-toggle="modal" data-target="#myModal{{ $item->id_customer}}"><i class="material-icons">edit</i></a>
                                        <a class="btn btn-danger btn-simple btn-icon" rel="tooltip" data-placement="left" title="Remove item" onclick="demo.showSwal('{{ $item->id_customer }}','{{csrf_token()}}','customers/destroy')">
                                            <i class="material-icons">close</i>
                                        </a>
                                    </td>
                                </tr>
                                <!-- Classic Modal -->
                                <div class="modal fade" id="myModal{{ $item->id_customer}}" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                                    <div class="modal-dialog modal-lg">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
                                                    <i class="material-icons">clear</i>
                                                </button>
                                                <h4 class="modal-title">Customer {{ $item->cust_company}} Details</h4>
                                            </div>
                                            <div class="modal-body">
                                                <div class="card-content">
                                                    <form action="{{ url('/master/customers/'. $item->id_customer.'/update') }} " method="post">
                                                        {{ csrf_field() }}
                                                        <div class="row">
                                                            <div class="col-md-3">
                                                                <div class="form-group label-floating">
                                                                    <label class="control-label">Company</label>
                                                                    <input type="text" class="form-control" name="cust_company" value="{{ $item->cust_company}}" maxlength="191" required>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-3">
                                                                <div class="form-group label-floating">
                                                                    <label class="control-label">Phone</label>
                                                                    <input type="text" name="cust_phone" class="form-control date" data-mask="+(99)(999) 999-9999" value="{{ $item->cust_phone}}" required />
                                                                </div>
                                                            </div>
                                                            <div class=" col-md-3">
                                                                <div class="form-group label-floating">
                                                                    <label class="control-label">Email</label>
                                                                    <input id="email" type="email" class="form-control" name="cust_email" value="{{$item->cust_email}}" maxlength="191" required>
                                                                    @if ($errors->has('email'))
                                                                        <span class="help-block">
                                                                            <strong>{{ $errors->first('email') }}</strong>
                                                                        </span>
                                                                    @endif
                                                                </div>
                                                            </div>
                                                            <div class="col-md-2">
                                                                <div class="form-group label-floating">
                                                                    <label class="control-label">Resale Tax ID</label>
                                                                    <input type="text" name="cust_tax" class="form-control date" data-mask="99-999 9999" value="{{ $item->cust_tax}}"/>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="row">
                                                            <div class="col-md-7">
                                                                <div class="form-group label-floating">
                                                                    <label class="control-label">Address</label>
                                                                    <input type="text" class="form-control" name="cust_address" value="{{ $item->cust_address}}" maxlength="191" required>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-2">
                                                                <div class="form-group label-floating">
                                                                    <label class="control-label">Contact Person</label>
                                                                    <input type="text" name="cust_contact" class="form-control date" value="{{ $item->cust_contact}}" required />
                                                                </div>
                                                            </div>
                                                            <div class="col-md-2">
                                                                {!! Form::select('id_status', $status_modal, $item->id_status, ['class' => 'selectpicker form-group label-floating', 'data-style' => 'select-with-transition', 'data-size' => '7']) !!}
                                                            </div>
                                                        </div>
                                                        @if($item->cust_sucursal == 'U')
                                                        <div class="row form-horizontal">
                                                            <br>
                                                            <label class="col-md-2 label-on-left"> The client 
                                                            </label>
                                                            <div class="col-md-8" style="margin-top: -20px;">
                                                                <div class="radio checkbox-inline">
                                                                    <label>
                                                                        <input type="radio" name="sucursal_checked"  value="C" onclick="removehiddentiene('{{ $item->id_customer }}')">Does have branch offices?
                                                                    </label>
                                                                </div>
                                                                <div class="radio checkbox-inline">
                                                                    <label>
                                                                        <input type="radio" name="sucursal_checked" value="Es" onclick="removehiddenes('{{ $item->id_customer }}')">Is branch office?
                                                                    </label>
                                                                </div>
                                                                <div class="radio checkbox-inline">
                                                                    <label>
                                                                        <input type="radio" name="sucursal_checked" value="No" checked="true" onclick="remove('{{ $item->id_customer }}')">No is branch office?
                                                                    </label>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="row">
                                                            <br>
                                                            <div class="col-md-offset-2 col-md-2" style="margin-top: -25px;">
                                                                <div class="modal_hidden_tiene_{{ $item->id_customer }}" hidden>
                                                                    {!! Form::select('sucursal_tiene', $cust_sucur_tiene, null, ['class' => 'selectpicker form-group', 'data-style' => 'select-with-transition', 'title' => 'Branch', 'data-size' => '7']) !!}
                                                                </div>
                                                            </div>
                                                            <div class="col-md-offset-5 col-md-2" style="margin-top: -25px;">
                                                                <div class="modal_hidden_es_{{ $item->id_customer }}" hidden>
                                                                    {!! Form::select('sucursal_es', $cust_sucur_es, null, ['class' => 'selectpicker form-group', 'data-style' => 'select-with-transition', 'title' => 'Branch', 'data-size' => '7']) !!}
                                                                </div>
                                                            </div>
                                                        </div>
                                                        @else
                                                        <div class="row form-horizontal">
                                                            <br>
                                                            <label class="col-md-3 label-on-left">
                                                                Is the customer a branch
                                                                @foreach($custo as $key_cust => $cust)
                                                                    @if( $key_cust == $item->cust_num_sucursal && $item->cust_sucursal != 'C')
                                                                        {{ $cust}}
                                                                    @endif 
                                                                @endforeach 
                                                            ? </label>
                                                            <div class="col-md-4" style="margin-top: -20px;">
                                                                <div class="radio checkbox-inline">
                                                                    <label>
                                                                        <input type="radio" name="sucursal_checked" checked="true" value="Yes" onclick="addhidden('{{ $item->id_customer }}')">Yes
                                                                    </label>
                                                                </div>
                                                                <div class="radio checkbox-inline">
                                                                    <label>
                                                                        <input type="radio" name="sucursal_checked" value="No" onclick="addhidden('{{ $item->id_customer }}')">No
                                                                    </label>
                                                                </div>
                                                                <div class="radio checkbox-inline">
                                                                    <label>
                                                                        <input type="radio" class="other_{{ $item->id_customer }}" name="sucursal_checked" value="Other" onclick="removehidden('{{ $item->id_customer }}')">Other
                                                                    </label>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-2" style="margin-top: -25px;">
                                                                <div class="modal_hidden_{{ $item->id_customer }}" hidden>
                                                                    {!! Form::select('sucursal_es', $cust_sucursal, null, ['class' => 'selectpicker form-group', 'data-style' => 'select-with-transition', 'title' => 'Branch', 'data-size' => '7']) !!}
                                                                </div>
                                                            </div>
                                                        </div>
                                                        @endif
                                                        
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
        $("#div1").hide();
        
        $('input[type="checkbox"]').on('change', function(e){
            if (this.checked) {

                $("#div1").show();
                $(".cust_company").attr("required", true);
                $(".cust_phone").attr("required", true);
                $(".cust_email").attr("required", true);
                $(".id_status").attr("required", true);
                $(".cust_address").attr("required", true);
                //$(".cust_tax").attr("required", true);
                $(".cust_contact").attr("required", true);
            } else {
                $("#div1").hide();
                $(".cust_company").removeAttr("required");
                $(".cust_phone").removeAttr("required");
                $(".cust_email").removeAttr("required");
                $(".id_status").removeAttr("required");
                $(".cust_address").removeAttr("required");
                //$(".cust_tax").removeAttr("required");
                $(".cust_contact").removeAttr("required");
            }
        });
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

    function removehidden(a) {
        $(".modal_hidden_"+a).removeAttr("hidden");
    }

    function addhidden(a) {
        $(".modal_hidden_"+a).attr("hidden", true);
    }

    function removehiddentiene(a) {
        $(".modal_hidden_tiene_"+a).removeAttr("hidden");
        $(".modal_hidden_es_"+a).attr("hidden", true);
    }
    function removehiddenes(a) {
        $(".modal_hidden_es_"+a).removeAttr("hidden");
        $(".modal_hidden_tiene_"+a).attr("hidden", true);
    }
    function remove(a) {
        $(".modal_hidden_es_"+a).attr("hidden", true);
        $(".modal_hidden_tiene_"+a).attr("hidden", true);
    }
</script>
<script>
    $(".id_status").click(function() { 
        console.log('a');
    });

    function addNew(i){
        var x = 0;
        x = i+1;
        var status = JSON.parse('<?php echo json_encode($status); ?>');
        console.log('<?php echo json_encode($status); ?>',status);
        var options = '';
        for (var i = 0; i < status.length; i++) {
            if(options == ''){
                options = '<option value="'+status[i].id_status+'">'+status[i].status+'</option>';  
            }else{
                options = options+'<option value="'+status[i].id_status+'">'+status[i].status+'</option>'; 
            }            
        }
        console.log(options);
        var html = `<div class="addel`+x+`">
                            <div class="form-group addel-target">
                                <div class="row">
                                    <input type="hidden" name="cust_sucursal[]">
                                    <div class="col-md-offset-1 col-md-3">
                                        <div class="form-group label-floating">
                                            <label class="control-label">Name or Company</label>
                                            <input type="text" class="form-control cust_company" name="cust_company[]"  maxlength="191" required>
                                        </div>
                                    </div>
                                    <div class="col-md-2">
                                        <div class="form-group label-floating">
                                            <label class="control-label">Phone</label>
                                            <input type="text" name="cust_phone[]" class="form-control cust_phone" data-mask="+(99)(999) 999-9999" required/>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group label-floating">
                                            <label class="control-label">Email</label>
                                            <input id="email" type="email" class="form-control cust_email" name="cust_email[]"  maxlength="191" required>                                            
                                        </div>
                                    </div>
                                    <div class="col-md-2">
                                        <select class="selectpickerNew form-group id_status" name="id_status[]" title="Status" data-size="7" data-style="select-with-transition" required>
                                            `+options+`
                                        </select>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-offset-1 col-md-8">
                                        <div class="form-group label-floating">
                                            <label class="control-label">Address</label>
                                            <input type="text" class="form-control cust_address" name="cust_address[]" maxlength="191" required>
                                        </div>
                                    </div>
                                    
                                </div>
                                <div class="row">
                                    <div class="col-md-offset-1 col-md-3">
                                        <div class="form-group label-floating">
                                            <label class="control-label">Resale Tax ID #</label>
                                            <input type="text" class="form-control" name="cust_tax[]" value="{{old('cust_tax')}}" data-mask="99-999 9999" maxlength="191">
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group label-floating">
                                            <label class="control-label">Contact name</label>
                                            <input type="text" class="form-control" name="cust_contact[]" value="{{old('cust_contact')}}" maxlength="191">
                                        </div>
                                    </div>
                                    <div class="col-md-1 pull-right">
                                        <div class="form-group" style="margin-top: 40px;">
                                            <button type="button" class="btn btn-xs btn-danger pull-right addel-delete" onclick="removeForm('addel`+x+`')">
                                                <i class="fa fa-remove"> </i>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group pull-right" style="margin-right: 100px;margin-top: -55px;">
                                    <button type="button" class="btn btn-success btn-xs pull-right addel-add" onclick="addNew(`+x+`)">
                                        <i class="fa fa-plus"></i>
                                    </button>
                                </div>
                            </div>
                        </div>`;
        $('#div1').append(html);
        $('.selectpickerNew').selectpicker();
    }
    function removeForm(nombre){
        console.log(nombre);
        var empresa = $('.'+nombre+' .cust_company').val();
        console.log(empresa);
        if(confirm('Are you absolutely positive you would like to delete: '+empresa)){
            $('.'+nombre).remove();
        }       
    }
</script>
@endsection