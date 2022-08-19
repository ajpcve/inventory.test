@extends('welcome')

@section('title')
    Status
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
    <div class="col-md-5">
        <div class="card">
            <div class="card-content">
                <h4 class="card-title">Status </h4>
                <form action="{{ action('StatusController@store') }}" method="POST" id="RegisterValidation">
                    {{ csrf_field() }}
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group label-floating">
                                <label class="control-label">Status</label>
                                <input type="text" class="form-control" name="status" value="{{old('status')}}" maxlength="191" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group label-floating">
                                <label class="control-label">Table</label>
                                <input type="text" class="form-control" name="tabla" value="{{old('tabla')}}" maxlength="191" required>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-offset-10">
                            <button type="submit" class="btn btn-success btn-sm pull-right">Save</button>
                        </div>
                    </div>
                    <div class="clearfix"></div>
                </form>
            </div>
        </div>
    </div>
    <div class="col-md-offset-1 col-md-5">
        <div class="card">
            <div class="card-header card-header-icon" data-background-color="green">
                <i class="material-icons">shuffle</i>
            </div>
            <h4 class="card-title">Status</h4>
            <br>
            <div class="card-content">
                <div class="table-responsive">
                    <table class="table">
                        <thead>
                            <tr>
                                <th class="text-center">#</th>
                                <th>Name</th>
                                <th>Table</th>
                                <th class="text-right">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($status as $item)
                                <tr>
                                    <td class="text-center">{{ $item->id_status}}</td>
                                    <td>{{ $item->status}}</td>
                                    <td>{{ $item->tabla}}</td>
                                    <td class="td-actions text-right">
                                        <a href="#" class="btn btn-simple btn-warning btn-icon" data-toggle="modal" data-target="#myModalExport{{ $item->id_status}}"><i class="material-icons">edit</i></a>
                                        <a class="btn btn-danger btn-simple" onclick="demo.showSwal('{{ $item->id_status }}','{{csrf_token()}}','status/destroy')">
                                            <i class="material-icons">close</i>
                                        </a>
                                    </td>
                                </tr>
                                <!-- Classic Modal -->
                                <div class="modal fade" id="myModalExport{{ $item->id_status}}" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
                                                    <i class="material-icons">clear</i>
                                                </button>
                                                <h4 class="modal-title">Status {{ $item->id_status}} edit</h4>
                                            </div>
                                            <div class="modal-body">
                                                <div class="card-content">
                                                    <form action="{{ url('/admin/status/'. $item->id_status.'/update') }} " method="post" id="RegisterValidation">
                                                    {{ csrf_field() }}
                                                        <div class="row">
                                                            <div class="col-md-4">
                                                                <div class="form-group label-floating">
                                                                    <label class="control-label">Status</label>
                                                                    <input type="text" class="form-control" name="status" value="{{ $item->status}}" maxlength="191" required>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-4">
                                                                <div class="form-group label-floating">
                                                                    <label class="control-label">Table</label>
                                                                    <input type="text" class="form-control" name="tabla" value="{{ $item->tabla}}" maxlength="191" required>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-3">
                                                                <div class="form-group label-floating">
                                                                    <button type="submit" class="btn btn-success btn-sm pull-right">Save</button>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="clearfix"></div>
                                                    </form>
                                                </div>
                                                <div class="clearfix"></div>
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
        </div>
    </div>
</div>
@endsection

@section('extra-script')
    <script type="text/javascript">
        function setFormValidation(id) {
            $(id).validate({
                errorPlacement: function(error, element) {
                    $(element).parent('div').addClass('has-error');
                }
            });
        }

        $(document).ready(function() {
            setFormValidation('#RegisterValidation');
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