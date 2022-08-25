@extends('welcome')

@section('title')
    MyProfile
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
                    <h4 class="card-title">Edit Data</h4>
                    <form action="{{ url('profile/update/'.Auth::user()->id) }} " method="post">
                        {{ csrf_field() }}
                        <div class="row">
                            <div class="col-md-4 col-md-offset-1">
                                <div class="form-group label-floating">
                                    <label class="control-label">Full Name</label>
                                    <input id="name" type="text" class="form-control" name="name"
                                           value="{{ Auth::user()->name }}" required autofocus>
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
                                    <input type="text" name="phone" class="form-control date"
                                           data-mask="+(99)(999) 999-9999" value="{{ Auth::user()->phone }}"
                                           required/>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group label-floating">
                                    <label class="control-label">Mail</label>
                                    <input id="email" type="email" class="form-control" name="email"
                                           value="{{ Auth::user()->email }}" required>
                                    @if ($errors->has('email'))
                                        <span class="help-block">
                                                                            <strong>{{ $errors->first('email') }}</strong>
                                                                        </span>
                                    @endif
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-7 col-md-offset-1">
                                <div class="form-group label-floating">
                                    <label class="control-label">Address</label>
                                    <input id="address" type="text" class="form-control" name="address"
                                           value="{{ Auth::user()->address }}">
                                    @if ($errors->has('address'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('address') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group label-floating">
                                    <div class="form-group label-floating">
                                        <label class="control-label">Country</label>
                                        <input id="country" type="text" class="form-control" name="country"
                                               value="{{ Auth::user()->country }}">
                                        @if ($errors->has('country'))
                                            <span class="help-block">
                                            <strong>{{ $errors->first('country') }}</strong>
                                        </span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-3 col-md-offset-1">
                                <label class="control-label">Type User</label>
                                {!! Form::select('position', ['Admin' => 'Admin', 'User' => 'User'], Auth::user()->position, ['class' => 'selectpicker form-group', 'data-style' => 'select-with-transition', 'title' => 'Position', 'data-size' => '7','disabled']) !!}
                            </div>
                            <div class="col-md-2">
                                <label class="control-label">Status User</label>
                                {!! Form::select('id_status', $status, Auth::user()->id_status, ['class' => 'selectpicker form-group', 'data-style' => 'select-with-transition', 'title' => 'Status', 'data-size' => '7','disabled']) !!}
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

@endsection

@section('extra-script')
    <script type="text/javascript">
        $(document).ready(function () {

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
        demo.showUpdateSuccess('top', 'center');

        @php
            Session::forget('update');
        @endphp
        @endif

        @if(Session::has('store'))
        demo.showSaveSuccess('top', 'center');

        @php
            Session::forget('store');
        @endphp
        @endif
    </script>
@endsection