@extends('welcome')

@section('title')
    New Users
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
                <i class="material-icons">person_add</i>
            </div>
            <div class="card-content">
                <h4 class="card-title">New User</h4>
                <form action="{{ action('UserController@store') }}" method="POST"  >
                    {{ csrf_field() }}
                    <div class="row">
                        <div class="col-md-3">
                            <div class="form-group label-floating">
                                <label class="control-label">Full Name</label>
                                <input id="name" type="text" class="form-control" name="name" value="{{ old('name') }}" required autofocus>
                                @if ($errors->has('name'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('name') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group label-floating">
                                <label class="control-label">Phone</label>
                                <input type="text" name="phone" class="form-control date" data-mask="+(99)(999) 999-9999"  required />
                            </div>
                        </div>

                        <div class="col-md-3">
                            <div class="form-group label-floating">
                                <label class="control-label">Mail</label>
                                <input id="email" type="email" class="form-control" name="email" value="{{ old('email') }}" required>
                                @if ($errors->has('email'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group label-floating">
                                <label class="control-label">Password</label>
                                <input id="password" type="password" class="form-control" name="password" required>
                                @if ($errors->has('password'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                        <div class="col-md-2">
                            {!! Form::select('position', ['Admin' => 'Admin', 'User' => 'User'], null, ['class' => 'selectpicker form-group', 'data-style' => 'select-with-transition', 'title' => 'Position', 'data-size' => '7', 'required' => 'true']) !!}
                        </div>
                        <div class="col-md-2">
                            {!! Form::select('id_status', $status, null, ['class' => 'selectpicker form-group', 'data-style' => 'select-with-transition', 'title' => 'Status', 'data-size' => '7', 'required' => 'true']) !!}
                        </div>
                    </div>
                    <br>
                    <button type="submit" class="btn btn-success  btn-sm pull-right">Save</button>
                    <a href="{{route('/admin/user')}}" class="btn btn-success  btn-sm pull-left">Back</a>
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
    
@endsection