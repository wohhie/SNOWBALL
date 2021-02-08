@extends('backend.layouts.starter')
@section('title') All SmartQUMATIK
@endsection
@section('headIncludes')
    <!-- Custom Style -->
    <link rel="stylesheet" href="{{ asset('css/custom-style.css') }}">

@endsection

@section('bodyClass')class="hold-transition skin-blue sidebar-mini"@endsection
@section('contentHeader')
<!-- Content Header (Page header) -->
<section class = "content-header">
<h1> Arctic Bay <small>all SmartQUMATIK</small>   </h1>

<ol class="breadcrumb">
    <li><a href="/admin"><i class="fa fa-dashboard"></i> Dashboard</a></li>
    <li class="active">Arctic Bay</li>
  </ol>

  <div class = 'row'>
     <div class="col-xs-12">

        <div class = "box">
        <div class="box-header">
                    <h3 class="box-title custom-button">SmartQUMATIK Information</h3>
                    <a href="{{ route('qumatiks.create') }}" class="btn btn-success pull-right custom-button">Create New SmartQUMATIK <i class="fa fa-plus"></i></a>
                </div>

                <div class="box-body">
                    <table id="example1" class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>SN</th>
                            <th>File Name</th>
                            <th>rho0</th>
                            <th>rho1</th>
                            <th>rho2</th>
                            <th>em31Height</th>
                            <th>Minimum Ice Thickness</th>
                            <th>Average Ice Thickness</th>
                            <th>Maximum Ice Thickness</th>
                            <th>Start Time</th>
                            <th>End Time</th>
                            <th>File Size</th>
                            <th>Action</th>
                        </tr>
                        </thead>
                        <tbody>
                        @forelse($qumatikDatas as $index => $data)
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td><strong data-toggle="tooltip" data-placement="top" title="{{ $data->filepath }}">{{ $data->filename }}</strong></td>
                                <td>{{ $data->rho0 }}</td>
                                <td>{{ $data->rho1 }}</td>
                                <td>{{ $data->rho2 }}</td>
                                <td>{{ $data->em31Height }}</td>
                                <td>{{ round($data->min_ice_thickness , 2)}}</td>
                                <td>{{ round($data->avg_ice_thickness , 2)}}</td>
                                <td>{{ round($data->max_ice_thickness , 2)}}</td>
                                <td>{{ $data->start_time }}</td>
                                <td>{{ $data->end_time }}</td>
                                <td><span class="badge badge-primary">{{ ceil($data->filesize / 1048576) }} MB</span></td>
                                <td>
                                    @if (!isset($data->rho0))
                                        <a href="#" class="btn btn-primary  btn-xs"><i class="fa fa-download"></i></a>
                                    @endif
                                </td>
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
    </div>
</section>
@endsection

@section('content')
<?php
    $test = "chinal";
?>
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
        $('#example1').DataTable({
            'paging'      : true,
            'lengthChange': true,
            'searching'   : true,
            'ordering'    : true,
            'info'        : true,
            'autoWidth'   : true,
            'pageLength'  : 25,
        })
    })



</script>
@endsection
