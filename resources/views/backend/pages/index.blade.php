@inject('provider', 'App\Http\Controllers\HomeController')


@extends('backend/layouts/starter')

@section('title') Dashboard @endsection

@section('headIncludes')
    <!-- CSS -->
    <!-- Morris chart -->
    <link rel="stylesheet" href="{{ asset('themes/admin/bower_components/morris.js/morris.css') }}">
    <!-- datatable style -->
    <link rel="stylesheet"
          href="{{ asset('themes/admin/bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css') }}">
    <!-- jvectormap -->
    <link rel="stylesheet" href="{{ asset('themes/admin/bower_components/jvectormap/jquery-jvectormap.css') }}">
    <!-- Date Picker -->
    <link rel="stylesheet"
          href="{{ asset('themes/admin/bower_components/bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css') }}">
    <!-- Daterange picker -->
    <link rel="stylesheet"
          href="{{ asset('themes/admin/bower_components/bootstrap-daterangepicker/daterangepicker.css') }}">
    <!-- bootstrap wysihtml5 - text editor -->
    <link rel="stylesheet" href="{{ asset('themes/admin/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.min.css') }}">
@endsection

@section('bodyClass')class="hold-transition skin-blue sidebar-mini"@endsection

@section('contentHeader')
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>Dashboard <small>Control</small></h1>

        <ol class="breadcrumb">
            <li><a href="/admin"><i class="fa fa-dashboard"></i> Dashboard</a></li>
        </ol>
    </section>
@endsection

@section('content')
    <!-- Dashboard Summery Section -->
    <div class="row">
        <div class="col-lg-3 col-xs-6">
            <!-- small box -->
            <div class="small-box bg-aqua">
                <div class="inner">
                    <h3>{{ $total_buoys }}</h3>

                    <p>Total Buoy</p>
                </div>
                <div class="icon">
                    <i class="ion ion-information"></i>
                </div>
                <a href="#" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
            </div>
        </div>
        <!-- ./col -->
        <div class="col-lg-3 col-xs-6">
            <!-- small box -->
            <div class="small-box bg-green">
                <div class="inner">
                    <h3>{{ $active_buoys }}<sup style="font-size: 20px"></sup></h3>

                    <p>Active Buoy</p>
                </div>
                <div class="icon">
                    <i class="ion ion-stats-bars"></i>
                </div>
                <a href="#" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
            </div>
        </div>
        <!-- ./col -->
        <div class="col-lg-3 col-xs-6">
            <!-- small box -->
            <div class="small-box bg-yellow">
                <div class="inner">
                    <h3>{{ $users }}</h3>

                    <p>Users</p>
                </div>
                <div class="icon">
                    <i class="ion ion-person-add"></i>
                </div>
                <a href="{{ url('users/all/') }}" class="small-box-footer">More info <i
                        class="fa fa-arrow-circle-right"></i></a>
            </div>
        </div>
        <!-- ./col -->
        <div class="col-lg-3 col-xs-6">
            <!-- small box -->
            <div class="small-box bg-red">
                <div class="inner">
                    <h3>{{ $inactive_buoys }}</h3>

                    <p>Total Inactive Buoys</p>
                </div>
                <div class="icon">
                    <i class="ion ion-close"></i>
                </div>
                <a href="#" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
            </div>
        </div>
        <!-- ./col -->
    </div>
    <!-- Dashboard Summery Section -->


    <div class="row">
        <div class="col-xs-12">

            <div class="box">
                <div class="box-header">
                    <h3 class="box-title">Buoy Information</h3>
                </div>
                <!-- /.box-header -->
                <div class="box-body">

                    <!-- Custom tabs (Charts with tabs)-->
                    <div class="nav-tabs-custom">
                        <!-- Tabs within a box -->
                        <ul class="nav nav-tabs custom-nav-list">
                            <li class="active"><a href="#smart-buoys" data-toggle="tab"><i class="fa fa-life-bouy"></i>
                                    SMART BUOYS</a></li>
                            <li><a href="#smart-qumatiks" data-toggle="tab"><i class="fa fa-life-bouy"></i> SMART
                                    QUMATIKS</a></li>
                        </ul>
                        <div class="tab-content no-padding">
                            <!-- Morris chart - Sales -->
                            <div class="chart tab-pane active" id="smart-buoys" style="position: relative;">
                                <table id="buoyTable" class="table table-bordered table-striped">
                                    <thead>
                                    <tr>
                                        <th>Index</th>
                                        <th>IMEI</th>
                                        <th>Community</th>
                                        <th>Serial Number</th>
                                        <th>Status</th>
                                        <th>Total Operations</th>
                                        <th>Processed</th>
                                        <th>Unprocessed</th>
                                        <th>Flagged</th>
                                        {{--                    @if(Auth::user()->hasRole('manager'))--}}
                                        {{--                        <th>Pending Approval</th>--}}
                                        {{--                    @endif--}}

                                        <th>Action</th>
                                    </tr>
                                    </thead>
                                    <tbody>

                                    @forelse($buoys as $index => $buoy)
                                        @if($buoy->status == 1)
                                            <tr>
                                                <td>{{ ++$index }}</td>
                                                <td><b><a href="{{ URL('/email/'.$buoy->imei )}}">{{ $buoy->imei }}</a></b>
                                                </td>
                                                <td>{{ $buoy->community['name'] }}</td>
                                                <td>{{ $buoy->serialNo }}</td>

                                                <td><span
                                                        class="label label-{{ ($buoy->status == 0) ? 'danger' : 'success' }}">{{ ($buoy->status == 0) ? 'Inactive' : 'active' }}</span>
                                                </td>
                                                <td>{{ $provider::getBuoyTotalOperation($buoy->imei, $flag = 0) }}</td>
                                                <td>{{ $provider::getBuoyTotalOperation($buoy->imei, $flag = 1) }}</td>
                                                <td>{{ ($provider::getBuoyTotalOperation($buoy->imei, $flag = 3))  }}</td>
                                                <td>{{ ($provider::getBuoyTotalOperation($buoy->imei, $flag = 2))  }}</td>
                                                {{--                        @if(Auth::user()->hasRole('manager'))--}}
                                                {{--                            @if(($provider::getBuoyTotalOperation($buoy->imei, $flag = 3)) != 0)--}}
                                                {{--                                <td><small class="label label-warning label-sm">{{ $provider::getBuoyTotalOperation($buoy->imei, $flag = 3)  }}</small></td>--}}
                                                {{--                            @else--}}
                                                {{--                                <td></td>--}}
                                                {{--                            @endif--}}
                                                {{--                        @endif--}}
                                                <td>
                                                    <div class="btn-group">
                                                        <a href="{{ URL('/email/'.$buoy->imei )}}"
                                                           class="btn btn-sm btn-primary"><i class="fa fa-eye"></i></a>
                                                        <a href="{{ URL('/buoy/summary/' . $buoy->imei )}}"
                                                           class="btn btn-sm btn-success"><i class="fa fa-list-ul"></i></a>
                                                    </div>
                                                </td>


                                            </tr>
                                        @endif


                                    @empty
                                        <tr>
                                            <td colspan="8"><b>
                                                    <center>No information found.</center>
                                                </b></td>
                                        </tr>
                                    @endforelse
                                    </tbody>

                                </table>
                            </div>
                            <div class="chart tab-pane" id="smart-qumatiks" style="position: relative; height: 300px;">
                                <table id="qumatikTable" class="table table-bordered table-striped">
                                    <thead>
                                    <tr>
                                        <th>Index</th>
                                        <th>Serial Number</th>
                                        <th>Community</th>
                                        <th>Status</th>
                                        <th>Total Operations</th>
                                        <th>Action</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                        @forelse($qumatiks as $index => $qumatik)
                                            @if($qumatik->status == 1)
                                                <tr>
                                                    <td>{{ ++$index }}</td>
                                                    <td>
                                                        <b><a href="{{ route('qumatikdata.show', $qumatik->id) }}">{{ $qumatik->imei}}</a></b>
                                                    </td>
                                                    <td>{{ $qumatik->community['name'] }}</td>

                                                    <td><span
                                                            class="label label-{{ ($qumatik->status == 0) ? 'danger' : 'success' }}">{{ ($qumatik->status == 0) ? 'Inactive' : 'active' }}</span>
                                                    </td>

                                                    <td></td>
                                                    <td>
                                                        <div class="btn-group">
                                                            <a href="/individual" class="btn btn-sm btn-primary"><i
                                                                    class="fa fa-eye"></i></a>
                                                            <a href="/map" class="btn btn-sm btn-success"><i
                                                                    class="fa fa-list-ul"></i></a>
                                                        </div>
                                                    </td>
                                                </tr>
                                            @endif


                                        @empty
                                            <tr>
                                                <td colspan="8"><b>
                                                        <center>No information found.</center>
                                                    </b></td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <!-- /.nav-tabs-custom -->
                </div>
                <!-- /.box-body -->
            </div>
            <!-- /.box -->
        </div>
        <!-- /.col -->
    </div>
@endsection

@section('scriptIncludes')
    <!-- JS -->
    <!-- jQuery UI 1.11.4 -->
    <script src="{{ asset('themes/admin/bower_components/jquery-ui/jquery-ui.min.js') }}"></script>
    <script>
        $.widget.bridge('uibutton', $.ui.button);
    </script>


    <!-- DataTables -->
    <script src="{{ asset('themes/admin/bower_components/datatables.net/js/jquery.dataTables.min.js') }}"></script>
    <script
        src="{{ asset('themes/admin/bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js') }}"></script>

    <!-- Morris.js charts -->
    <script src="{{ asset('themes/admin/bower_components/raphael/raphael.min.js') }}"></script>
    <script src="{{ asset('themes/admin/bower_components/morris.js/morris.min.js') }}"></script>

    <!-- Sparkline -->
    <script src="{{ asset('themes/admin/bower_components/jquery-sparkline/dist/jquery.sparkline.min.js') }}"></script>

    <!-- jvectormap -->
    <script src="{{ asset('themes/admin/plugins/jvectormap/jquery-jvectormap-1.2.2.min.js') }}"></script>
    <script src="{{ asset('themes/admin/plugins/jvectormap/jquery-jvectormap-world-mill-en.js') }}"></script>

    <!-- jQuery Knob Chart -->
    <script src="{{ asset('themes/admin/bower_components/jquery-knob/dist/jquery.knob.min.js') }}"></script>

    <!-- daterangepicker -->
    <script src="{{ asset('themes/admin/bower_components/moment/min/moment.min.js') }}"></script>
    <script src="{{ asset('themes/admin/bower_components/bootstrap-daterangepicker/daterangepicker.js') }}"></script>

    <!-- datepicker -->
    <script
        src="{{ asset('themes/admin/bower_components/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js') }}"></script>

    <!-- Bootstrap WYSIHTML5 -->
    <script src="{{ asset('themes/admin/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.all.min.js') }}"></script>

    <!-- Slimscroll -->
    <script src="{{ asset('themes/admin/bower_components/jquery-slimscroll/jquery.slimscroll.min.js') }}"></script>

    <!-- FastClick -->
    <script src="{{ asset('themes/admin/bower_components/fastclick/lib/fastclick.js') }}"></script>

    <!-- AdminLTE dashboard demo (This is only for demo purposes) -->
    <script src="{{ asset('themes/admin/dist/js/pages/dashboard.js') }}"></script>

    <!-- AdminLTE for demo purposes -->
    <script src="{{ asset('themes/admin/dist/js/demo.js') }}"></script>

    <!-- page script -->
    <script>
        $(function () {
            $('#buoyTable #qumatikTable').DataTable({
                'paging': true,
                'lengthChange': true,
                "pageLength": 50,
                'searching': true,
                'ordering': true,
                'info': true,
                'autoWidth': true,
                "bSort": true,
            })


        })


        $(function () {
            $('[data-toggle="tooltip"]').tooltip()
        })
    </script>
@endsection
