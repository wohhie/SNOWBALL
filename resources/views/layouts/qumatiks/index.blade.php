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
<h1> SmartQUMATIK Information <small>all SmartQUMATIK</small>   </h1>

<ol class="breadcrumb">
    <li><a href="/admin"><i class="fa fa-dashboard"></i> Dashboard</a></li>
    <li class="active">SmartQUMATIK Information</li>
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
                            <th>IMEI</th>
                            <th>Community Name</th>
                            <th>Latitude</th>
                            <th>Longitude</th>
                            <th>Status</th>
                            <th>Status Date</th>
                            <th>Action</th>
                        </tr>
                        </thead>
                        <tbody>
                        @forelse($qumatiks as $index=>$qumatik)
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td><b><a href="{{ URL('/email/'. $qumatik->serialNo )}}">{{ $qumatik->imei }}</a></b></td>
								<td>{{ $qumatik->community->name }}</td>

                                <td>{{ $qumatik->latitude }}</td>
                                <td>{{ $qumatik->longitude }}</td>
                                <td><span class="label label-{{ ($qumatik->status == 0) ? 'danger' : 'success' }}">{{ ($qumatik->status == 0) ? 'In Active' : 'Active' }}</span></td>
                                <td>{{ $qumatik->created_at }}</td>
                                <td>


                                    <form action="{{ route('qumatiks.destroy',$qumatik->id) }}" method="POST">
                                        <a class="btn btn-success" href="{{ URL('/email/'.$qumatik->imei )}}"><i class="fa fa-eye"></i></a>
                                        <a class="btn btn-primary" href="{{ route('qumatiks.edit', ['id'=>$qumatik->id]) }}"><i class="fa fa-edit"></i></a>
                                        <a class="btn btn-danger" href="#" data-toggle="modal" data-target=".delete-{{$qumatik->imei}}"><i class="fa fa-trash"></i></a>

                                        <div class="modal fade delete-{{$qumatik->imei}}" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel">
                                            <div class="modal-dialog modal-md" role="document">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                                        <h4 class="modal-title" id="myModalLabel">Delete <b>#{{ $qumatik->imei }}</b>!</h4>
                                                    </div>
                                                    <div class="modal-body">
                                                        <h4>Are you sure you want to delete this QUMATIK <b>#{{ $qumatik->imei }}</b></h4>

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
