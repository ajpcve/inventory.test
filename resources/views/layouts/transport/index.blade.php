@extends('welcome')

@section('title')
    Transport
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
                <i class="material-icons">local_shipping</i>
            </div>
            <div class="card-content">
                <h4 class="card-title">New Transportation</h4>
                <form action="{{ action('TransportController@store') }}" method="POST"  >
                    {{ csrf_field() }}
                    <div class="row">
                        <div class="col-md-offset-1 col-md-3">
                            <div class="form-group label-floating">
                                <label class="control-label">Company</label>
                                <input type="text" class="form-control" name="trans_company" value="{{old('trans_company')}}" maxlength="191" required>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group label-floating">
                                <label class="control-label">Phone</label>
                                <input type="text" name="trans_phone" class="form-control date" data-mask="+(99)(999) 999-9999"  value="{{old('trans_phone')}}"required />
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group label-floating">
                                <label class="control-label">Email</label>
                                <input id="email" type="email" class="form-control" name="trans_email" value="{{old('trans_email')}}" maxlength="191" required>
                                @if ($errors->has('email'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group label-floating">
                                <label class="control-label">Contact name</label>
                                <input type="text" class="form-control" name="trans_contact" value="{{old('trans_contact')}}" maxlength="191" required>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-offset-1 col-md-8">
                            <div class="form-group label-floating">
                                <label class="control-label">Address</label>
                                <input type="text" class="form-control" name="trans_address" value="{{old('trans_address')}}" maxlength="191" required>
                            </div>
                        </div>
                        <div class="col-md-2">
                            {!! Form::select('id_status', $status, null, ['class' => 'selectpicker form-group', 'data-style' => 'select-with-transition', 'title' => 'Status', 'data-size' => '7', 'required' => 'true']) !!}
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
                <i class="material-icons">commute</i>
            </div>
            <div class="card-content">
                <h4 class="card-title">Transport</h4>
                <div class="toolbar">
                    <!--        Here you can write extra buttons/actions for the toolbar              -->
                </div>
                <div class="material-datatables">
                    <table id="datatables" class="table table-striped table-no-bordered table-hover" cellspacing="0" width="100%" style="width:100%">
                        <thead>
                            <tr>
                                <th>Company</th>
                                <th>Phone</th>
                                <th>Address</th>
                                <th>Email</th>
                                <th>Contact Person</th>
                                <th>Status</th>
                                <th class="disabled-sorting text-right">Actions</th>
                            </tr>
                        </thead>
                        <tfoot>
                            <tr>
                                <th>Company</th>
                                <th>Phone</th>
                                <th>Address</th>
                                <th>Email</th>
                                <th>Contact Person</th>
                                <th>Status</th>
                                <th class="disabled-sorting text-right">Actions</th>
                            </tr>
                        </tfoot>
                        <tbody>
                            @foreach($transport as $item)
                                <tr>
                                    <td>{{ $item->trans_company}}</td>
                                    <td>{{ $item->trans_phone}}</td>
                                    <td>{{ $item->trans_address}}</td>
                                    <td>{{ $item->trans_email}}</td>
                                    <td>{{ $item->trans_contact}}</td>
                                    <td>{{ $item->statu->status}}</td>
                                    <td class=" text-right">
                                        <a href="#" class="btn btn-simple btn-warning btn-icon" data-toggle="modal" data-target="#myModal{{ $item->id_transport}}"><i class="material-icons">edit</i></a>

                                        <a class="btn btn-danger btn-simple btn-icon" rel="tooltip" data-placement="left" title="Remove item" onclick="demo.showSwal('{{ $item->id_transport }}','{{csrf_token()}}','transport/destroy')">
                                            <i class="material-icons">close</i>
                                        </a>
                                    </td>
                                </tr>
                                <!-- Classic Modal -->
                                <div class="modal fade" id="myModal{{ $item->id_transport}}" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                                    <div class="modal-dialog modal-lg">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
                                                    <i class="material-icons">clear</i>
                                                </button>
                                                <h4 class="modal-title">Transport company {{ $item->trans_company}} Details</h4>
                                            </div>
                                            <div class="modal-body">
                                                <div class="card-content">
                                                    <form action="{{ url('/master/transport/'. $item->id_transport.'/update') }} " method="post">
                                                        {{ csrf_field() }}
                                                        <div class="row">
                                                            <div class="col-md-offset-1 col-md-3">
                                                                <div class="form-group label-floating">
                                                                    <label class="control-label">Company</label>
                                                                    <input type="text" class="form-control" name="trans_company" value="{{ $item->trans_company}}" maxlength="191" required>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-3">
                                                                <div class="form-group label-floating">
                                                                    <label class="control-label">Phone</label>
                                                                    <input type="text" name="trans_phone" class="form-control date" data-mask="+(99)(999) 999-9999" placeholder="Phone" value="{{ $item->trans_phone}}" required />
                                                                </div>
                                                            </div>
                                                            <div class="col-md-4">
                                                                <div class="form-group label-floating">
                                                                    <label class="control-label">Address</label>
                                                                    <input type="text" class="form-control" name="trans_address" value="{{ $item->trans_address}}" maxlength="191" required>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="row">
                                                            <div class="col-md-offset-1 col-md-3">
                                                                <div class="form-group label-floating">
                                                                    <label class="control-label">Email</label>
                                                                    <input id="email" type="email" class="form-control" name="trans_email" value="{{$item->trans_email}}" maxlength="191" required>
                                                                    @if ($errors->has('email'))
                                                                        <span class="help-block">
                                                                            <strong>{{ $errors->first('email') }}</strong>
                                                                        </span>
                                                                    @endif
                                                                </div>
                                                            </div>
                                                            <div class="col-md-3">
                                                                {!! Form::select('id_status', $status, $item->id_status, ['class' => 'selectpicker form-group label-floating', 'data-style' => 'select-with-transition', 'data-size' => '7']) !!}
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