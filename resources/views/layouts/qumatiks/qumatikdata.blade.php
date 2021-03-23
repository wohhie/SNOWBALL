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
                                       data-minimumicethickness="{{$data->min_ice_thickness}}"
                                       data-maxicethickness = "{{$data->max_ice_thickness}}"
                                       data-starttime="{{date('Y/m/d h:i:s', strtotime($data->start_time))}}"
                                       data-endtime="{{date('Y/m/d h:i:s', strtotime($data->end_time))}}"
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

                                                    <div class="row">

                                                        <div class="col-md-4">
                                                            <div class="box box-success box-solid">
                                                                <div class="box-header with-border">
                                                                    <h3 class="box-title">Total Distance</h3>

                                                                    <div class="box-tools pull-right">

                                                                    </div>
                                                                    <!-- /.box-tools -->
                                                                </div>
                                                                <!-- /.box-header -->
                                                                <div class="box-body" id = "distance_{{ $data->id }}">
                                                                </div>
                                                                <!-- /.box-body -->
                                                            </div>
                                                            <!-- /.box -->
                                                        </div>
                                                        <div class="col-md-4">
                                                            <div class="box box-warning box-solid">
                                                                <div class="box-header with-border">
                                                                    <h3 class="box-title">Ice Thickness</h3>

                                                                    <div class="box-tools pull-right">

                                                                    </div>
                                                                    <!-- /.box-tools -->
                                                                </div>
                                                                <!-- /.box-header -->
                                                                <div class="box-body" id ="mini_ice_{{$data->id}}">
                                                                </div>
                                                                <!-- /.box-body -->
                                                            </div>
                                                            <!-- /.box -->
                                                        </div>
                                                        <div class="col-md-4">
                                                            <div class="box box-danger box-solid">
                                                                <div class="box-header with-border">
                                                                    <h3 class="box-title">Total Time</h3>

                                                                    <div class="box-tools pull-right">

                                                                    </div>
                                                                    <!-- /.box-tools -->
                                                                </div>
                                                                <!-- /.box-header -->
                                                                <div class="box-body" id ="time_{{$data->id}}">
                                                                </div>
                                                                <!-- /.box-body -->
                                                            </div>
                                                            <!-- /.box -->
                                                        </div>

                                                    </div>

                                                    <div class="map" id="map_{{ $data->id }}"></div>

                                                    <br/>
                                                    <br/>
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
        let temp = [];

        $(document).on("click", ".location__modal", function (e) {
            let filepath = $(this).data('filepath');
            let id = $(this).data('id')
            let min_ice_thickness = $(this).data('minimumicethickness');
            let max_ice_thickness = $(this).data('maxicethickness');
            let start_time = $(this).data("starttime");
            let end_time = $(this).data("endtime");


            // let diffInMilliSeconds = Math.abs(new Date(end_time) - new Date(start_time)) / 1000;
            //
            // // calculate days
            // const days = Math.floor(diffInMilliSeconds / 86400);
            // diffInMilliSeconds -= days * 86400;
            // console.log('calculated days', days);
            //
            // // calculate hours
            // const hours = Math.floor(diffInMilliSeconds / 3600) % 24;
            // diffInMilliSeconds -= hours * 3600;
            // console.log('calculated hours', hours);
            //
            // // calculate minutes
            // const minutes = Math.floor(diffInMilliSeconds / 60) % 60;
            // diffInMilliSeconds -= minutes * 60;
            // console.log('minutes', minutes);


            var startTime = new Date(start_time);
            var endTime = new Date(end_time);
            var difference = endTime.getTime() - startTime.getTime(); // This will give difference in milliseconds
            var Minutes = (difference / 60000).toFixed(2);
            var Hours = (difference/3600000).toFixed(2);



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

                    var max = "Maximum:&nbsp".bold();
                    var min = "Minimum:&nbsp".bold();
                    var start = "Start:&nbsp".bold();
                    var end = "End:&nbsp".bold()
                    var miles = "Miles:&nbsp".bold();
                    var kilometer = "Kilometers:&nbsp".bold();
                    var hour = "Hours:&nbsp".bold();
                    var minute = "Minutes:&nbsp".bold();

                    document.getElementById("time_"+ id).innerHTML = start+start_time+ "&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp"+end+end_time+"\n" +hour+Hours+ "&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp"+minute +Minutes;

                    document.getElementById("mini_ice_"+ id).innerHTML = min+min_ice_thickness + " (cm)" + "&nbsp &nbsp&nbsp&nbsp"+max+max_ice_thickness + " (cm)";
                    // check the camera zoom

                    const coordinates = JSON.parse(response)
                    let count = coordinates.length
                    var distance = 0 ;



                    for (i = 0; i < coordinates.length -1; i++) {

                    var latLong1 = Object.values(coordinates[i])+'';
                    var latLong2 = Object.values(coordinates[i+1])+ '';
                    var mk1 = latLong1.split(",");
                    var mk2 = latLong2.split(",");

                    distance  += calculateDistance(mk1,mk2);
                    }
                    document.getElementById("distance_"+ id).innerHTML = miles + distance.toFixed(2) + "&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp"+kilometer + (distance.toFixed(2) * 1.6).toFixed(2);

                    function calculateDistance(mk1, mk2) {

                        var R = 3958.8; // Radius of the Earth in miles
                        var rlat1 = parseFloat(mk1[0])* (Math.PI/180); // Convert degrees to radians
                        var rlat2 = parseFloat(mk2[0])* (Math.PI/180); // Convert degrees to radians
                        const difflat = Math.abs(rlat2 - rlat1); // Radian difference (latitudes)
                        var difflon = (parseFloat(mk2[1])- parseFloat(mk1[1])) * (Math.PI/180); // Radian difference (longitudes)
                        var d = 2 * R * Math.asin(Math.sqrt(Math.sin(difflat/2)*Math.sin(difflat/2)+Math.cos(rlat1)*Math.cos(rlat2)*Math.sin(difflon/2)*Math.sin(difflon/2)));
                       // console.log(d);
                        return d;

                    }

                    const map = new google.maps.Map(document.getElementById("map_" + id), {
                        zoom: count > 100000 ? 7 : 18,
                        center: coordinates[0],
                        mapTypeId: "terrain",
                    });

                    new google.maps.Marker({
                        position : coordinates[0],
                        map,
                        title:'Start Point',
                        icon:'http://maps.google.com/mapfiles/kml/paddle/grn-circle.png'
                    });

                    new google.maps.Marker({
                        position : coordinates[coordinates.length -1 ],
                        map,
                        title:'End Point',
                        icon:'http://maps.google.com/mapfiles/kml/paddle/red-circle.png'
                    });


                    const flightPath = new google.maps.Polyline({
                        path: coordinates,
                        geodesic: true,
                        strokeColor: "#ff0000",
                        strokeOpacity: 1.0,
                        strokeWeight: 2,
                    });

                    flightPath.setMap(map);


                    // let directionsService = new google.maps.DirectionsService();
                    // let directionsRenderer = new google.maps.DirectionsRenderer();
                    // directionsRenderer.setMap(map); // Existing map object displays directions
                    // Create route from existing points used for markers
                    // const route = {
                    //     origin: coordinates[0],
                    //     destination: coordinates[coordinates.length-1],
                    //     travelMode: 'DRIVING'
                    // }

                    // directionsService.route(route,
                    //     function(response, status) { // anonymous function to capture directions
                    //         if (status !== 'OK') {
                    //             window.alert('Directions request failed due to ' + status);
                    //             return;
                    //         } else {
                    //             directionsRenderer.setDirections(response); // Add route to the map
                    //             var directionsData = response.routes[0].legs[0]; // Get data about the mapped route
                    //             if (!directionsData) {
                    //                 window.alert('Directions request failed');
                    //                 return;
                    //             }
                    //             else {
                    //                 document.getElementById('msg_'+id).innerHTML = "";
                    //                 document.getElementById('msg_'+id).innerHTML += " Driving distance is " + directionsData.distance.text + " (" + directionsData.duration.text + ").";
                    //             }
                    //         }
                    //     });

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
