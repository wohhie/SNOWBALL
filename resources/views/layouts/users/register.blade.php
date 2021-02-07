@extends('backend/layouts/starter')

@section('title') Register User @endsection

@section('bodyClass')class="hold-transition skin-blue sidebar-mini"@endsection

@section('contentHeader')
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>Register User <small>create new account</small></h1>

        <ol class="breadcrumb">
            <li><a href="/admin"><i class="fa fa-dashboard"></i> Dashboard</a></li>
            <li class="active">Register User</li>
        </ol>
    </section>
@endsection

@section('content')
    <!-- Default box -->
    <div class="row">

        <!-- left column -->
        <div class="col-md-6">
            <!-- general form elements -->
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="box-title">Create User</h3>
                </div>
                <!-- /.box-header -->
                <!-- form start -->
                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div><br />
                @endif
                <form role="form" method="POST" action="{{ route('register') }}">
                    @csrf

                    <div class="box-body">
                        <div class="form-group">
                            <label for="firstname">First Name</label>
                            <input type="text" class="form-control" id="firstname" name="firstname" placeholder="Enter First Name">
                        </div>
                        <div class="form-group">
                            <label for="lastname">Last Name</label>
                            <input type="text" class="form-control" id="lastname" name="lastname" placeholder="Enter Last Name">
                        </div>
                        <div class="form-group">
                            <label for="email">Email Address</label>
                            <input type="text" class="form-control" id="email" name="email" placeholder="Enter Email Address">
                        </div>
                        <div class="form-group">
                            <label for="password">Password</label>
                            <input type="text" class="form-control" id="password" name="password" placeholder="Enter Password">
                        </div>

                        <div class="form-group">
                            <label for="password_confirmation">Confirm Password</label>
                            <input type="text" class="form-control" id="password_confirmation" name="password_confirmation" placeholder="Confirm Password">
                        </div>


                        <div class="form-group">
                            <label for="asset_name">User Role</label>
                            <select class="form-control" name="role">
                                <option value="0">-Select-</option>
                                @foreach($roles as $role)
                                    <option value="{{ $role->id }}">{{ ucfirst($role->name) }}</option>
                                @endforeach
                            </select>
                        </div>

                    </div>
                    <!-- /.box-body -->

                    <div class="box-footer">
                        <button type="submit" class="btn btn-primary">Register User</button>
                    </div>
                </form>
            </div>
            <!-- /.box -->
        </div>
    </div>
    <!-- /.box -->
@endsection

@section('scriptIncludes')
    <!-- Js -->
    <!-- SlimScroll -->
    <script src="{{ asset('themes/admin/bower_components/jquery-slimscroll/jquery.slimscroll.min.js') }}"></script>
    <!-- FastClick -->
    <script src="{{ asset('themes/admin/bower_components/fastclick/lib/fastclick.js') }}"></script>
    <!-- AdminLTE for demo purposes -->
    <script src="{{ asset('themes/admin/dist/js/demo.js') }}"></script>
    <script>
        $(document).ready(function () {
            $('.sidebar-menu').tree()
        })
    </script>
@endsection
