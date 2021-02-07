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
  <h1>Buoys Information <small>all Buoys</small></h1>
  
  <ol class="breadcrumb">
    <li><a href="/admin"><i class="fa fa-dashboard"></i> Dashboard</a></li>
    <li class="active">Buoys Information</li>
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
                            <th>Asset Name</th>
                            <th>Latitude</th>
                            <th>Longitude</th>
                            <th>Plan</th>
                            <th>Back Office Status</th>
                            <th>Status</th>
                            <th>Status Date</th>
                            <th>Action</th>
                        </tr>
                        </thead>
                        <tbody>

                        @foreach($buoys as $buoy)
                            <tr>
                                <td>{{ $no++ }}</td>
                                <td><b><a href="#">{{ $buoy->imei }}</a></b></td>
                                <td>{{ $buoy->asset_name }}</td>
                                <td>{{ $buoy->latitude }}</td>
                                <td>{{ $buoy->longitude }}</td>
                                <td>{{ $buoy->plan }}</td>
                                <td><span class="label label-danger">x</span></td>
                                <td><span class="label label-{{ ($buoy->status == '0') ? 'danger' : 'success' }}">{{ ($buoy->status == '0') ? 'In Active' : 'Active' }}</span></td>
                                <td>2018-12-10 19:30:30</td>
                                <td>
                                    <form action="{{ route('buoys.destroy',$buoy->id) }}" method="POST">

                                        <a class="btn btn-primary" href="{{ route('buoys.edit', ['id'=>$buoy->id]) }}"><i class="fa fa-edit"></i></a>
                                        {{-- <a class="btn btn-primary" href="{{ route('students.edit',$student->id) }}">Edit</a>--}}

                                        @csrf
                                        @method('DELETE')

                                        <button type="submit" class="btn btn-danger">Delete</button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach

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
 <!-- FastClick -->
 <script src="{{ asset('themes/admin/bower_components/fastclick/lib/fastclick.js') }}"></script>
 <!-- AdminLTE for demo purposes -->
 <script src="{{ asset('themes/admin/dist/js/demo.js') }}"></script>
@endsection