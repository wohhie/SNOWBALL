@extends('backend.layouts.starter')
@section('title') All SmartQUMATIK
@endsection
@section('headIncludes')
    <!-- Custom Style -->
    <link rel="stylesheet" href="{{ asset('css/custom-style.css') }}">
    <script src="https://polyfill.io/v3/polyfill.min.js?features=default"></script>
    <style type="text/css">
        /* Always set the map height explicitly to define the size of the div
         * element that contains the map. */
        .map {
            height: 600px;
            width: 100%;
            margin: 0px;
            padding: 0px
        }
    </style>
@endsection

@section('bodyClass')class="hold-transition skin-blue sidebar-mini"@endsection
@section('contentHeader')
<!-- Content Header (Page header) -->
<section class = "content-header">
<h1> Arctic Bay <small>all SmartQUMATIK</small></h1>

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
                                    <a href="#location_modal"
                                       id="location_modal"
                                       class="btn btn-success btn-xs location__modal"
                                       data-filename="{{ $data->filename }}"
                                       data-filepath="{{ $data->filepath }}"
                                       data-id="{{ $data->id }}"
                                       data-toggle="modal"
                                       data-keyboard="true"
                                       data-backdrop="true"
                                       data-target="#location_modal_{{ $data->id }}">
                                        <i class="fa fa-location-arrow"></i>
                                    </a>

                                    <div class="modal fade" id="location_modal_{{ $data->id }}" data-id="{{ $data->id }}" tabindex="-1" role="dialog" aria-labelledby="Distance calculator" aria-hidden="true" data-backdrop="static" data-keyboard="false">
                                        <div class="modal-dialog modal-xl" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                                    <h4 class="modal-title" id="myModalLabel">{{ str_replace(".txt", "", $data->filename) }}</h4>
                                                </div>
                                                <div class="modal-body">
                                                    <div id="overlay_{{ $data->id }}">
                                                        <div class="cv-spinner">
                                                            <span class="spinner"></span>
                                                        </div>
                                                    </div>

                                                    <div class="map" id="map_{{ $data->id }}"></div>

                                                    <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                                                    <button type="submit" class="btn btn-danger">Delete Now</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>



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
    // This example creates a 2-pixel-wide red polyline showing the path of
    // the first trans-Pacific flight between Oakland, CA, and Brisbane,
    // Australia which was made by Charles Kingsford Smith.

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

        $(document).on("click", ".location__modal", function (e) {
            let filepath = $(this).data('filepath')
            let id = $(this).data('id')
            // Add remove loading class on body element based on Ajax request status
            $(document).on({
                ajaxStart: function(){
                    $("#overlay_" + id).fadeIn(300);
                },
                ajaxStop: function(){
                    $("#overlay_" + id).fadeOut(300);
                }
            });


            $.ajax({
                url: "/qumatiksdata/location",
                type: "get",
                data: { filepath },
                success:function(response){
                    const coordinates = JSON.parse(response)


                    const map = new google.maps.Map(document.getElementById("map_" + id), {
                        zoom: 8,
                        center: coordinates[0],
                        mapTypeId: "terrain",
                    });


                    const flightPath = new google.maps.Polyline({
                        path: coordinates,
                        geodesic: true,
                        strokeColor: "#ff0000",
                        strokeOpacity: 1.0,
                        strokeWeight: 2,
                    });

                    flightPath.setMap(map);

                },
            })
        })

    })
</script>
<!-- Async script executes immediately and must be after any DOM elements used in callback. -->
<script
    src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAvAoYI_rnWiNJUpta8_heKO-CHSp18HLQ&libraries=&v=weekly"
    async
></script>

@endsection
