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
                            <th>Community Name</th>
                            <th>Serial No</th>
                            <th>Latitude</th>
                            <th>Longitude</th>
                            <th>Status</th>
                            <th>Status Date</th>
                            <th>Action</th>
                        </tr>
                        </thead>
                        <tbody>
                        @forelse($buoys as $index=>$buoy)
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td>
                                    <b><a href="{{ URL('/email/'.$buoy['imei'] )}}">{{ $buoy['imei'] }}</a></b>
                                </td>
								<td>{{ $buoy->community->name }}</td>
                                <td>{{ $buoy->serialNo }}</td>
                                <td>{{ $buoy->latitude }}</td>
                                <td>{{ $buoy->longitude }}</td>
                                <td><span class="label label-{{ ($buoy->status == 0) ? 'danger' : 'success' }}">{{ ($buoy->status == 0) ? 'In Active' : 'Active' }}</span></td>
                                <td>{{ $buoy->created_at }}</td>
                                <td>


                                    <form action="{{ route('buoys.destroy',$buoy->id) }}" method="POST">
                                        <a class="btn btn-success" href="{{ URL('/email/'.$buoy->imei )}}"><i class="fa fa-eye"></i></a>
                                        <a class="btn btn-primary" href="{{ route('buoys.edit', $buoy->id) }}"><i class="fa fa-edit"></i></a>
                                        <a class="btn btn-danger" href="#" data-toggle="modal" data-target=".delete-{{$buoy->imei}}"><i class="fa fa-trash"></i></a>

                                        <div class="modal fade delete-{{$buoy->imei}}" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel">
                                            <div class="modal-dialog modal-md" role="document">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                                        <h4 class="modal-title" id="myModalLabel">Delete <b>#{{ $buoy->imei }}</b>!</h4>
                                                    </div>
                                                    <div class="modal-body">
                                                        <h4>Are you sure you want to delete this buoy <b>#{{ $buoy->imei }}</b></h4>

                                                        @csrf
                                                        @method('DELETE')

                                                        <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                                                        <button type="submit" class="btn btn-danger">Delete Now</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        {{-- <a class="btn btn-primary" href="{{ route('students.edit',$student->id) }}">Edit</a>--}}


                                    </form>
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
