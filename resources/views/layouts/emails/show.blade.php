@extends('backend.layouts.starter')

@section('title') All Buoys @endsection
@section('headIncludes')
    <!-- datatable style -->
    <link rel="stylesheet" href="{{ asset('themes/admin/bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css') }}">
    <!-- Custom Style -->
    <link rel="stylesheet" href="{{ asset('css/custom-style.css') }}">
@endsection

@section('bodyClass') class="hold-transition skin-blue sidebar-mini"@endsection

@section('contentHeader')
<!-- Content Header (Page header) -->
<section class="content-header">
  <h1>Transmissions <small class="label label-success bold">{{ $buoyID }}</small></h1>

  <ol class="breadcrumb">
    <li><a href="/admin"><i class="fa fa-dashboard"></i> Dashboard</a></li>
    <li class="active">Transmissions Information</li>
  </ol>

    <div class="row">
        <div class="col-xs-12">
		{{ count($dataInfos) }}, {{ count($flagged) }}, {{ count($approved) }}


            <div class="box">
                <div class="box-header">
                    <h3 class="box-title custom-button">All Transmissions</h3>
                </div>

                <!-- /.box-header -->
                <div class="box-body">

                    <div class="nav-tabs-custom">
                        <ul class="nav nav-tabs custom-nav-list">
                            <li class="active unprocessed"><a href="#unprocessed" data-toggle="tab"><i class="fa fa-tasks"></i> Unprocessed Data <span class="badge label-warning">{{ count($dataInfos) }}</span></a></li>
                            
                            <li><a href="#flagged" data-toggle="tab"><i class="fa fa-flag"></i> Flagged Data <span class="badge label-danger">{{ count($flagged) }}</span></a></li>
                            <li><a href="#approved" data-toggle="tab"><i class="fa fa-check-square"></i> Approved <span class="badge label-success">{{ count($approved) }}</span></a></li>
                        </ul>
                        <div class="tab-content">
                            <div class="active tab-pane" id="unprocessed">

                                <table id="emailTable" class="table table-bordered table-striped table-responsive">
                                    <thead>
                                    <tr>
                                        <th>SN</th>
                                        <th>IMEI</th>
                                        <th>OperationID</th>
                                        <th>RMC Date</th>
                                        <th>RMC Time</th>
                                        <th>Latitude & Longitude</th>
                                        <th>Status</th>
                                        <th>Approval</th>
                                        <th>Action</th>
                                    </tr>
                                    </thead>
                                    <tbody>

                                    @forelse($dataInfos as $index => $dataInfo)
                                        <tr>
                                            <td>{{ ++$index }}
                                            </td>
                                            <td><b><a href="/data/show/{{$dataInfo->uniqueID}}">{{ $dataInfo->buoy_id }}</a></b></td>
                                            <td><b>{{ $dataInfo->uniqueID }}</b></td>
                                            <td>{{ '20' . substr($dataInfo->rmcDate, 4, 2) .'-'. substr($dataInfo->rmcDate, 2, 2) .'-'. substr($dataInfo->rmcDate, 0, 2)  }}</td>
                                            <td>{{ substr($dataInfo->rmcTime, 0, 2) .':'. substr($dataInfo->rmcTime, 2, 2)  }}</td>
                                            <td>{{ $dataInfo->lat1 }}, {{ $dataInfo->lon1 }}<a class="custom-url map-marker" data-toggle="modal" data-lat="{{ $dataInfo->lat1 }}" data-lng="{{ $dataInfo->lon1 }}" target="_blank" href="http://maps.google.com/maps?q=loc:{{ $dataInfo->lat1 }},{{ $dataInfo->lon1 }}"><i class="fa fa-map-marker"></i></a></td>



                                            <td>
                                                <span class="label label-{{ ($dataInfo->status == 0) ? 'warning' : 'success' }}">{{ ($dataInfo->status == 0) ? 'Unprocessed' : 'Processed' }}</span>
                                            </td>

                                            <td>
                                                @if (\App\Http\Controllers\DataController::checkStatus($dataInfo->uniqueID) == 0)
                                                    <span class="label label-warning">
                                            Pending
                                        </span>
                                                @elseif(\App\Http\Controllers\DataController::checkStatus($dataInfo->uniqueID) == 1)
                                                    <span class="label label-success">
                                            Approved
                                        </span>
                                                @else
                                                    <span></span>
                                                @endif
                                            </td>
                                            @if($dataInfo->status == 0)
                                                <td>
                                                    <div class="btn-group">
                                                        <a class="btn btn-warning btn-xs" href="/data/show/{{$dataInfo->uniqueID}}">Start Processing</a>
                                                        <a class="btn btn-danger btn-xs" href="/data/flagged/{{$dataInfo->uniqueID}}"><i class="fa fa-flag"></i></a>
                                                    </div>

                                                </td>
                                            @elseif($dataInfo->status == 1)
                                                <td>
                                                    @if(Auth::user()->hasRole('manager') and (\App\Http\Controllers\DataController::checkStatus($dataInfo->uniqueID)) == 0)
                                                        <a class="btn btn-success btn-xs" href="/data/show/{{$dataInfo->uniqueID}}">Approve</a>
                                                        <a class="btn btn-info btn-xs" href="/data/edit/{{$dataInfo->uniqueID}}">Edit</a>
                                                    @elseif(Auth::user()->hasRole('operator'))
                                                        <a class="btn btn-primary btn-xs" href="/data/show/{{$dataInfo->uniqueID}}"> View</a>
                                                    @endif
                                                </td>
											@else
												<td>
												<td>
                                            @endif
                                        </tr>
                                    @empty
                                        <tr><td colspan="9"><b><center>No information found.</center></b></td></tr>
                                    @endforelse

                                    </tfoot>
                                </table>
                            </div>

							

                            <div class="tab-pane" id="flagged">
                                <table id="flaggedTable" class="table table-bordered table-striped table-responsive">
                                    <thead>
                                    <tr>
                                        <th>SN</th>
                                        <th>IMEI</th>
                                        <th>OperationID</th>
                                        <th>RMC Date</th>
                                        <th>RMC Time</th>
                                        <th>Latitude & Longitude</th>
                                        <th>Status</th>
                                        <th>Action</th>
                                    </tr>
                                    </thead>
                                    <tbody>

                                    @forelse($flagged as $index => $flag)
                                        <tr>
                                            <td>{{ ++$index }}
                                            </td>
                                            <td><b><a href="/data/show/{{$flag->uniqueID}}">{{ $flag->buoy_id }}</a></b></td>
                                            <td><b>{{ $flag->uniqueID }}</b></td>
                                            <td>{{ '20' . substr($flag->rmcDate, 4, 2) .'-'. substr($flag->rmcDate, 2, 2) .'-'. substr($flag->rmcDate, 0, 2)  }}</td>
                                            <td>{{ substr($flag->rmcTime, 0, 2) .':'. substr($flag->rmcTime, 2, 2)  }}</td>
                                            <td>{{ $flag->lat1 }}, {{ $flag->lon1 }}<a class="custom-url map-marker" data-toggle="modal" data-lat="{{ $flag->lat1 }}" data-lng="{{ $flag->lon1 }}" target="_blank" href="http://maps.google.com/maps?q=loc:{{ $flag->lat1 }},{{ $flag->lon1 }}"><i class="fa fa-map-marker"></i></a></td>



                                            <td>
                                                <span class="label label-{{ ($flag->status == 5) ? 'danger' : 'success' }}">{{ ($flag->status == 5) ? 'Flagged' : null }}</span>
                                            </td>


                                            @if($flag->status == 5)
                                                <td>
                                                    <div class="btn-group">
                                                        <a class="btn btn-warning btn-xs" href="/data/show/{{$flag->uniqueID}}">Start Processing</a>
                                                    </div>

                                                </td>
                                            @elseif($flag->status == 1)
                                            @endif
                                        </tr>
                                    @empty
                                        <tr><td colspan="8"><b><center>No information found.</center></b></td></tr>
                                    @endforelse

                                    </tfoot>
                                </table>
                            </div>
                            <div class="tab-pane" id="approved">
                                <table id="approvedTable" class="table table-bordered table-striped">
                                    <thead>
                                    <tr>
                                        <th>SN</th>
                                        <th>IMEI</th>
                                        <th>OperationID</th>
                                        <th>RMC Date</th>
                                        <th>RMC Time</th>
                                        <th>Latitude & Longitude</th>
                                        <th>Status</th>
                                    </tr>
                                    </thead>
                                    <tbody>

                                    @forelse($approved as $index => $approve)
                                        <tr>
                                            <td>{{ ++$index }}
                                            </td>
                                            <td><b><a href="/data/show/{{$approve->uniqueID}}">{{ $approve->buoy_id }}</a></b></td>
                                            <td><b>{{ $approve->uniqueID }}</b></td>
                                            <td>{{ '20' . substr($approve->rmcDate, 4, 2) .'-'. substr($approve->rmcDate, 2, 2) .'-'. substr($approve->rmcDate, 0, 2)  }}</td>
                                            <td>{{ substr($approve->rmcTime, 0, 2) .':'. substr($approve->rmcTime, 2, 2)  }}</td>
                                            <td>{{ $approve->lat1 }}, {{ $approve->lon1 }}<a class="custom-url map-marker" data-toggle="modal" data-lat="{{ $approve->lat1 }}" data-lng="{{ $approve->lon1 }}" target="_blank" href="http://maps.google.com/maps?q=loc:{{ $approve->lat1 }},{{ $approve->lon1 }}"><i class="fa fa-map-marker"></i></a></td>



                                            <td>
                                                <span class="label label-{{ ($approve->status == 4) ? 'success' : 'danger' }}">{{ ($approve->status == 4) ? 'Approved' : null }}</span>
                                            </td>

                                        </tr>
                                    @empty
                                        <tr><td colspan="7"><b><center>No information found.</center></b></td></tr>
                                    @endforelse

                                    </tfoot>
                                </table>
                            </div>
                        </div>
                        <!-- /.tab-content -->
                    </div>

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

 <script src="{{ asset('themes/admin/bower_components/jquery-ui/jquery-ui.min.js') }}"></script>
<script src="{{ asset('themes/admin/bower_components/datatables.net/js/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('themes/admin/bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js') }}"></script>
 <script src="{{ asset('themes/admin/bower_components/fastclick/lib/fastclick.js') }}"></script>
 <!-- AdminLTE for demo purposes -->
 <script src="{{ asset('themes/admin/dist/js/demo.js') }}"></script>
<!-- page script -->

@include('flashy::message')
<script>
    $(function () {
		

        $('#approvedTable').DataTable({
            'paging'      : true,
            'lengthChange': true,
            'searching'   : true,
            'ordering'    : true,
            'info'        : true,
            'autoWidth'   : true,
            "bSort"       : true,
        });
		
		
        $('#flaggedTable').DataTable({
            'paging'      : true,
            'lengthChange': true,
            'searching'   : true,
            'ordering'    : true,
            'info'        : true,
            'autoWidth'   : true,
            "bSort"       : true,
        });
		
        $('#emailTable').DataTable({
            'paging'      : true,
            'lengthChange': true,
            'searching'   : true,
            'ordering'    : true,
            'info'        : true,
            'autoWidth'   : true,
            "bSort"       : true,
        });

		
    });




</script>

@endsection
