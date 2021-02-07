@extends('backend.layouts.starter')

@section('title') All Buoys @endsection
@section('headIncludes')
    <!-- Custom Style -->
    <link rel="stylesheet" href="{{ asset('css/custom-style.css') }}">
@endsection

@section('bodyClass')class="hold-transition skin-blue sidebar-mini"@endsection

@section('contentHeader')
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>Users Information<small>all users</small></h1>

        <ol class="breadcrumb">
            <li><a href="/admin"><i class="fa fa-dashboard"></i> Dashboard</a></li>
            <li class="active">Users Information</li>
        </ol>



        <div class="row">
            <div class="col-xs-12">

                <div class="box">
                    <div class="box-header">
                        <h3 class="box-title custom-button">Users Information</h3>
                        <a href="{{ url('registeruser') }}" class="btn btn-success pull-right custom-button">Create New User <i class="fa fa-plus"></i></a>
                    </div>
                    <!-- /.box-header -->
                    <div class="box-body">
                        <table id="example1" class="table table-bordered table-striped">
                            <thead>
                            <tr>
                                <th>SN</th>
                                <th>First Name</th>
                                <th>Last Name</th>
                                <th>Email Address</th>
                                <th>Role</th>
                                <th>Action</th>
                            </tr>
                            </thead>
                            <tbody>
                            @forelse($users as $index =>  $user)
                                <tr>
                                    <td>{{ ++$index }}</td>
                                    <td>{{ $user->firstname }}</td>
                                    <td>{{ $user->lastname }}</td>
                                    <td>{{ $user->email }}</td>
                                    <td>{{ auth()->user()->role  }}</td>
                                </tr>
                            @empty
                                <tr><td colspan="10"><b><center>No information found.</center></b></td></tr>
                            @endforelse

                            </tfoot>
                        </table>
                    </div>
                    <!-- /.box-body -->
                </div>
                <!-- /.box -->
            </div>
            <!-- /.col -->
        </div>
    </section>
@endsection

@section('content')

@endsection

@section('scriptIncludes')
    <!-- Js -->
    <!-- DataTables -->
    <script src="{{ asset('themes/admin/bower_components/datatables.net/js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('themes/admin/bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js') }}"></script>
    <!-- FastClick -->
    <script src="{{ asset('themes/admin/bower_components/fastclick/lib/fastclick.js') }}"></script>
    <!-- AdminLTE for demo purposes -->
    <script src="{{ asset('themes/admin/dist/js/demo.js') }}"></script>


    <script type="text/javascript">
        $(function () {
            $('#featured').DataTable({
                'paging'      : true,
                'lengthChange': false,
                'searching'   : false,
                'ordering'    : true,
                'info'        : true,
                'autoWidth'   : false
            })
        })
    </script>
@endsection
