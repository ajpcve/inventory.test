@extends('welcome')

@section('title')
    Users
@endsection

@section('extra-css')

@endsection

@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header card-header-icon" data-background-color="green">
                <i class="material-icons">group</i>
            </div>
            <div class="card-content">
                <h4 class="card-title">Users</h4>
                <div class="toolbar text-right" style="margin-top: -45px;">
                    <a href="{{route('/admin/user/create')}}" class="btn btn-success btn-round btn-fab btn-fab-mini" rel="tooltip" data-placement="left" title="Add user">
                        <i class="material-icons">person_add</i>
                    </a>
                </div>
                <br>
                <div class="material-datatables">
                    <table id="datatables" class="table table-striped table-no-bordered table-hover" cellspacing="0" width="100%" style="width:100%">
                        <thead>
                            <tr>
                                <th>Full name</th>
                                <th>Phone</th>
                                <th>Mail</th>
                                <th>Position</th>
                                <th>Status</th>
                                <th class="disabled-sorting text-right">Actions</th>
                            </tr>
                        </thead>
                        <tfoot>
                            <tr>
                                <th>Full name</th>
                                <th>Phone</th>
                                <th>Mail</th>
                                <th>Position</th>
                                <th>Status</th>
                                <th class="disabled-sorting text-right">Actions</th>
                            </tr>
                        </tfoot>
                        <tbody>
                            @foreach($user as $item)
                                <tr>
                                    <td>{{ $item->name}}</td>
                                    <td>{{ $item->phone}}</td>
                                    <td>{{ $item->email}}</td>
                                    <td>{{ $item->position}}</td>
                                    <td>{{ $item->statu->status}}</td>
                                    <td class=" text-right">
                                        <a href="#" class="btn btn-simple btn-warning btn-icon" data-toggle="modal" data-target="#myModal{{ $item->id}}"><i class="material-icons">edit</i></a>
                                        <a href="#" class="btn btn-simple btn-info btn-icon" rel="tooltip" data-placement="left" title="Detail"><i class="material-icons">find_in_page</i></a>
                                    </td>
                                </tr>
                                <!-- Classic Modal -->
                                <div class="modal fade" id="myModal{{ $item->id}}" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                                    <div class="modal-dialog modal-lg">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
                                                    <i class="material-icons">clear</i>
                                                </button>
                                                <h4 class="modal-title">User #{{ $item->id}} Details</h4>
                                            </div>
                                            <div class="modal-body">
                                                <div class="card-content">
                                                    <form action="{{ url('/admin/user/'. $item->id.'/update') }} " method="post">
                                                        {{ csrf_field() }}
                                                        <div class="row">
                                                            <div class="col-md-3 col-md-offset-1">
                                                                <div class="form-group label-floating">
                                                                    <label class="control-label">Full Name</label>
                                                                    <input id="name" type="text" class="form-control" name="name" value="{{ $item->name }}" required autofocus>
                                                                    @if ($errors->has('name'))
                                                                        <span class="help-block">
                                                                            <strong>{{ $errors->first('name') }}</strong>
                                                                        </span>
                                                                    @endif
                                                                </div>
                                                            </div>
                                                            <div class="col-md-3">
                                                                <div class="form-group label-floating">
                                                                    <label class="control-label">Phone</label>
                                                                    <input type="text" name="phone" class="form-control date" data-mask="+(99)(999) 999-9999" value="{{ $item->phone }}" required />
                                                                </div>
                                                            </div>
                                                            <div class="col-md-3">
                                                                <div class="form-group label-floating">
                                                                    <label class="control-label">Mail</label>
                                                                    <input id="email" type="email" class="form-control" name="email" value="{{ $item->email }}" required>
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
                                                                {!! Form::select('position', ['Admin' => 'Admin', 'User' => 'User'], $item->position, ['class' => 'selectpicker form-group', 'data-style' => 'select-with-transition', 'title' => 'Position', 'data-size' => '7', 'required' => 'true']) !!}
                                                            </div>
                                                            <div class="col-md-2">
                                                                {!! Form::select('id_status', $status, $item->id_status, ['class' => 'selectpicker form-group', 'data-style' => 'select-with-transition', 'title' => 'Status', 'data-size' => '7', 'required' => 'true']) !!}
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