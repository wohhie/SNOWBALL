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
        <h1>Download Satellite Data<small>all Buoys</small></h1>

        <ol class="breadcrumb">
            <li><a href="/admin"><i class="fa fa-dashboard"></i> Dashboard</a></li>
            <li class="active">Download Buoy Information</li>
        </ol>



        <div class="row">
            <div class="col-xs-12">

                <div class="box">
                    <div class="box-header">
                        <h3 class="box-title custom-button">Buoy Information</h3>
                        <a href="{{ route('buoys.create') }}" class="btn btn-success pull-right custom-button">Create New Buoy <i class="fa fa-plus"></i></a>
                    </div>
                    <!-- /.box-header -->
                    <div class="box-body">
                        <table id="example1" class="table table-bordered table-striped">
                            <thead>
                            <tr>
                                <th>SN</th>
                                <th>IMEI</th>
                                <th>Status</th>
                                <th>Status Date</th>
                                <th>Last Updated Date</th>
                                <th>Action</th>
                            </tr>
                            </thead>
                            <tbody>
                            @forelse($buoys as $buoy)
                                <tr>
                                    <td>{{ 1 }}</td>
                                    <td><b><a href="{{ URL('/email/'.$buoy->imei )}}">{{ $buoy->imei }}</a></b></td>
                                    <td><span class="label label-{{ ($buoy->status == 0) ? 'danger' : 'success' }}">{{ ($buoy->status == 0) ? 'In Active' : 'Active' }}</span></td>
                                    <td>2018-12-10 19:30:30</td>
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


{{--    <script type="text/javascript">--}}
{{--        $(function () {--}}
{{--            $('#featured').DataTable({--}}
{{--                'paging'      : true,--}}
{{--                'lengthChange': false,--}}
{{--                'searching'   : false,--}}
{{--                'ordering'    : true,--}}
{{--                'info'        : true,--}}
{{--                'autoWidth'   : false--}}
{{--            })--}}
{{--        })--}}
{{--    </script>--}}
@endsection
