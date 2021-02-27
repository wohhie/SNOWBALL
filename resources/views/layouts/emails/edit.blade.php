@extends('backend/layouts/starter')
@section('title') Dashboard @endsection

@section('headIncludes')
<!-- CSS -->
<!-- jvectormap -->
<link rel="stylesheet" href="{{ asset('css/custom-style.css') }}">
<link rel="stylesheet" href="{{ asset('themes/admin/bower_components/jvectormap/jquery-jvectormap.css') }}">
@endsection

@section('bodyClass')class="hold-transition skin-blue sidebar-mini"@endsection

@section('content-header')
<!-- Content Header (Page header) -->
<section class="contentHeader">
    <h1>Dashboard <small>Welcome...</small></h1>

    <ol class="breadcrumb">
        <li><a href="/admin"><i class="fa fa-dashboard"></i> Dashboard</a></li>
    </ol>
</section>
@endsection






@section('content')
<!-- Content Header (Page header) -->
<section class="content-header">

    <a href="{{ url('email', $dataInfos[0]->buoy_id ) }}" class="btn btn-default"><i class="fa fa-arrow-left"></i> Back</a>
    <h1>Buoys Information <small>all Buoys</small></h1>

    <ol class="breadcrumb">
        <li><a href="/admin"><i class="fa fa-dashboard"></i> Dashboard</a></li>
        <li class="active">Data Information</li>
    </ol>

    <div class="row">
        <div class="col-xs-12">

            <div class="box">
                <div class="box-header">
                    <h3 class="box-title custom-button"> Data Information
                        {{--                            <span class="label label-{{ ($dataInfos[0]->status == 0) ? 'warning': 'success' }}">{{ ($dataInfos[0]->status == 0) ? 'Unprocessed': 'Processed' }}</span>--}}
                    </h3>

                    {{-- $summaries status 1 = updated to SIKU and 0 = pending for manager--}}
                    @if(($summaries))
                    @if($summaries->status == 1)
                    <div class="alert alert-success fade-alert" role="alert">
                        <p><b>Successfully Processed & Approved</b></p>
                    </div>
                    @endif
                    @endif
                    <!-- if user is manager & summary status is 0 means pending
                        display the confirmation dialog  -->
                    @if(Auth::user()->hasRole('manager') and (\App\Http\Controllers\DataController::checkStatus($dataInfos[0]->uniqueID)) == 0)
{{--                    <a href="#" class="btn btn-success btn-sm pull-right custom-btn" data-toggle="modal" data-target=".approval-modal"><i class="fa fa-check"></i> </a>--}}



                    <div class="modal fade approval-modal" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel">
                        <div class="modal-dialog modal-md" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                    <h4 class="modal-title" id="myModalLabel">Confirmation!</h4>
                                </div>
                                <div class="modal-body">
                                    <h4>Do you want to approve this process and forward to
                                        <img class=" siku" src="{{ asset('images/siku_splash_logo.png') }}" alt="">
                                    </h4>

                                    <form role="form" method="POST" action="{{ route('summery.approval',
                                                    ['imei'=>$dataInfos[0]->buoy_id,
                                                    'operationID' => $dataInfos[0]->uniqueID ]) }}">
                                        @csrf
                                        @method('POST')

                                        <input type="hidden" name="imei" id="imei" value="{{ $dataInfos[0]->buoy_id }}">
                                        <input type="hidden" name="rmcDate" id="rmcDate" value="{{ $dataInfos[0]->rmcDate }}">
                                        <input type="hidden" name="rmcTime" id="rmcTime" value="{{ $dataInfos[0]->rmcTime }}">
                                        <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                                        <button type="submit" class="btn btn-success">Apporve & Forword</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                    @elseif((\App\Http\Controllers\DataController::checkStatus($dataInfos[0]->buoy_id, $dataInfos[0]->rmcDate, $dataInfos[0]->rmcTime)) == 0)
                    <a href="#" disabled="" class="btn btn-warning btn-sm pull-right custom-btn" data-toggle="modal" data-target=".approval-modal"><i class="fa a fa-spinner fa-spin fa-1x fa-fw"></i> Pending for Approval</a>
                    @endif


                </div>
                <!-- /.box-header -->
                <div class="box-body">
                    <table id="emailSectionTable" class="table table-bordered table-responsive table-striped">
                        <thead>
                        <tr>
                            <th>SN</th>
                            <th>IMEI / BuoyID</th>
                            <th>Message/Transmission</th>
                            <th>Trans. No</th>
                            <th>RMC Date</th>
                            <th>RMC Time</th>
                            <th>Latitude</th>
                            <th>Longitude</th>
                            <th>Device ID</th>
                            <th>Boot ID</th>
                            <th>Map URL</th>
                            <th>Download File</th>
                        </tr>
                        </thead>
                        <tbody>

                        @foreach($dataInfos as $dataInfo)
                        <tr>
                            <td>{{ $no++ }}</td>
                            <td><b><a href="#">{{ $dataInfo->buoy_id }}</a></b></td>
                            <td>
                                @if($dataInfo->messageID == 6)
                                <b>Conductivity</b>
                                @elseif($dataInfo->messageID == 1)
                                <b>Temperature</b>
                                @endif
                            </td>

                            <td><b>{{ substr($dataInfo->filename, 16, 6) }}</b></td>
                            {{--                                    <td><b><a href="#">{{ $dataInfo->filename }}</a></b></td>--}}
                            <td>{{ '20' . substr($dataInfo->rmcDate, 4, 2) .'-'. substr($dataInfo->rmcDate, 2, 2) .'-'. substr($dataInfo->rmcDate, 0, 2)  }}</td>
                            <td>{{ substr($dataInfo->rmcTime, 0, 2) .':'. substr($dataInfo->rmcTime, 2, 2)  }}</td>
                            <td>{{ $dataInfo->lat1 }}</td>
                            <td>{{ $dataInfo->lon1 }}</td>
                            <td>{{ $dataInfo->deviceID }}</td>
                            <td>{{ $dataInfo->bootID }}</td>
                            <td><a class="custom-url map-marker" target="_blank" href="http://maps.google.com/maps?q={{ $dataInfo->lat1 }},{{ $dataInfo->lon1 }}" data-toggle="modal" data-target=".{{ substr($dataInfo->filename, 16, 6) }}" data-placement="top" title="Location on Google Map"><i class="fa fa-map-marker"></i></a></td>
                            <!-- Large modal -->

                            <!-- modal for google map -->
                            <div class="modal fade {{substr($dataInfo->filename, 16, 6)}}" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel">
                                <div class="modal-dialog modal-lg" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                            <h4 class="modal-title" id="myModalLabel"><i class="fa fa-map-marker"></i> Google Map</h4>
                                        </div>
                                        <div class="modal-body">
                                            <div id="map2"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- modal for google map -->
                            <td><a class="custom-url icon-download" target="_blank" href="download/{{ $dataInfo->filename  }}" data-toggle="tooltip" data-placement="top" title="Download File"><i class="fa fa-download"></i></a></td>

                        </tr>
                        @endforeach

                        </tfoot>
                    </table>
                </div>
                <!-- /.box-body -->
            </div>
            <!-- /.box -->

            <!-- Summary Section -->
            @if($summaries)
            <div class="row">
                <div class="col-lg-12 col-md-12">
                    <div class="box">
                        <div class="box-header with-header">
                            <h3 class="box-title"><i class="fa fa-life-ring"></i> Summary</h3>
                        </div>

                        <div class="box-body">
                            <table id="emailTable" class="table table-bordered table-striped">
                                <thead>
                                <tr>
                                    <th>Operation ID</th>
                                    <th>Data Used</th>
                                    <th>Lat & Long</th>
                                    <th>Top of Snow (cm)</th>
                                    <th>Top of Ice (cm)</th>
                                    <th>Bottom of Ice (cm)</th>
                                    <th style="background: #EF5350; color: #fff;">Depth of Snow (cm)</th>
                                    <th style="background: #4CAF50; color: #fff;">Thickness of Ice (cm)</th>
                                </tr>
                                </thead>
                                <tbody>

                                <tr>
                                    <td> <b>{{ $summaries->operationID }}</b></td>
                                    <td> {{ ($summaries->dataUsed == 1) ? "Temperature" : "Conductivity" }}</td>
                                    <td> {{ $summaries->latitude }}, {{ $summaries->longitude }} <a  href="#"  data-toggle="modal" data-target=".{{ $summaries->operationID }}" class="map-marker" data-toggle="tooltip" data-placement="top" title="Location on Google Map"><i class="fa fa-map-marker"></i></a></td>
                                    <!-- google map -->
                                    <!-- modal for google map -->
                                    <div class="modal fade {{ $summaries->operationID }}" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel">
                                        <div class="modal-dialog modal-lg" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                                    <h4 class="modal-title" id="myModalLabel"><i class="fa fa-map-marker"></i> Google Map</h4>
                                                </div>
                                                <div class="modal-body">
                                                    <div id="map1"></div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- modal for google map -->
                                    <!-- google map -->
                                    <td>{{ $summaries->top_snow }}</td>
                                    <td>{{ $summaries->top_ice }}</td>
                                    <td>{{ $summaries->bottom_ice }}</td>
                                    <td style="background: #FFCDD2; color: #313131"><b>{{ $summaries->top_ice - $summaries->top_snow }}</b></td>
                                    <td style="background: #C8E6C9; color: #313131"><b>{{ $summaries->bottom_ice - $summaries->top_ice }}</b></td>
                                </tr>

                                </tfoot>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            @endif





            <div class="box">
                <div class="box-header">
                    <h3 class="box-title custom-button"><i class="fa fa-clipboard"></i> Datas</h3>
                </div>
                <!-- /.box-header -->
                <div class="box-body">
                    <div class="scrollme">
                        <table id="dataTables" class="table table-bordered table-responsive table-striped">
                            <thead>
                            <tr>
                                <th>Message ID</th>
                                <th>Data1</th>
                                <th>Data2</th>
                                <th>Data3</th>
                                <th>Data4</th>
                                <th>Data5</th>
                                <th>Data6</th>
                                <th>Data7</th>
                                <th>Data8</th>
                                <th>Data9</th>
                                <th>Data10</th>
                                <th>Data11</th>
                                <th>Data12</th>
                                <th>Data13</th>
                                <th>Data14</th>
                                <th>Data15</th>
                                <th>Data16</th>
                                <th>Data17</th>
                                <th>Data18</th>
                                <th>Data19</th>
                                <th>Data20</th>
                                <th>Data21</th>
                                <th>Data22</th>
                                <th>Data23</th>
                                <th>Data24</th>
                                <th>Data25</th>
                                <th>Data26</th>
                                <th>Data27</th>
                                <th>Data28</th>
                                <th>Data29</th>
                                <th>Data30</th>
                                <th>Data31</th>
                                <th>Data32</th>
                                <th>Data33</th>
                                <th>Data34</th>
                                <th>Data35</th>
                                <th>Data36</th>
                                <th>Data37</th>
                                <th>Data38</th>
                                <th>Data39</th>
                                <th>Data40</th>
                                <th>Data41</th>
                                <th>Data42</th>
                                <th>Data43</th>
                                <th>Data44</th>
                                <th>Data45</th>
                                <th>Data46</th>
                                <th>Data47</th>
                                <th>Data48</th>
                                <th>Data49</th>
                                <th>Data50</th>
                                <th>Data51</th>
                                <th>Data52</th>
                                <th>Data53</th>
                                <th>Data54</th>
                                <th>Data55</th>
                                <th>Data56</th>
                                <th>Data57</th>
                                <th>Data58</th>
                                <th>Data59</th>
                                <th>Data60</th>
                            </tr>
                            </thead>
                            <tbody>


                            <tr>
                                <td><b>Thermistor</b></td>
                                @for($i = 1; $i < 61; $i++)
                                <td>{{ $i }}</td>
                                @endfor
                            </tr>

                            <tr>
                                <td><b>Position (from thermistor)</b></td>
                                @for($i = 0; $i < 60*4; $i = $i + 4)
                                <td>{{ $i }}</td>
                                @endfor
                            </tr>


                            {{----}}

                            @foreach($dataInfos as $index => $dataInfo)
                            {{--                                <tr>--}}
                                {{--                                    <td><b>{{ ($index == 0) ? 'Temperature' : 'Conductivity' }}</b></td>--}}
                                {{--                                    <td>{{ hexdec($dataInfo->data1) }}</td>--}}
                                {{--                                    <td>{{ hexdec($dataInfo->data2) }}</td>--}}
                                {{--                                    <td>{{ hexdec($dataInfo->data3) }}</td>--}}
                                {{--                                    <td>{{ hexdec($dataInfo->data4) }}</td>--}}
                                {{--                                    <td>{{ hexdec($dataInfo->data5) }}</td>--}}
                                {{--                                    <td>{{ hexdec($dataInfo->data6) }}</td>--}}
                                {{--                                    <td>{{ hexdec($dataInfo->data7) }}</td>--}}
                                {{--                                    <td>{{ hexdec($dataInfo->data8) }}</td>--}}
                                {{--                                    <td>{{ hexdec($dataInfo->data9) }}</td>--}}
                                {{--                                    <td>{{ hexdec($dataInfo->data10) }}</td>--}}
                                {{--                                    <td>{{ hexdec($dataInfo->data11) }}</td>--}}
                                {{--                                    <td>{{ hexdec($dataInfo->data12) }}</td>--}}
                                {{--                                    <td>{{ hexdec($dataInfo->data13) }}</td>--}}
                                {{--                                    <td>{{ hexdec($dataInfo->data14) }}</td>--}}
                                {{--                                    <td>{{ hexdec($dataInfo->data15) }}</td>--}}
                                {{--                                    <td>{{ hexdec($dataInfo->data16) }}</td>--}}
                                {{--                                    <td>{{ hexdec($dataInfo->data17) }}</td>--}}
                                {{--                                    <td>{{ hexdec($dataInfo->data18) }}</td>--}}
                                {{--                                    <td>{{ hexdec($dataInfo->data19) }}</td>--}}
                                {{--                                    <td>{{ hexdec($dataInfo->data20) }}</td>--}}
                                {{--                                    <td>{{ hexdec($dataInfo->data21) }}</td>--}}
                                {{--                                    <td>{{ hexdec($dataInfo->data22) }}</td>--}}
                                {{--                                    <td>{{ hexdec($dataInfo->data23) }}</td>--}}
                                {{--                                    <td>{{ hexdec($dataInfo->data24) }}</td>--}}
                                {{--                                    <td>{{ hexdec($dataInfo->data25) }}</td>--}}
                                {{--                                    <td>{{ hexdec($dataInfo->data26) }}</td>--}}
                                {{--                                    <td>{{ hexdec($dataInfo->data27) }}</td>--}}
                                {{--                                    <td>{{ hexdec($dataInfo->data28) }}</td>--}}
                                {{--                                    <td>{{ hexdec($dataInfo->data29) }}</td>--}}
                                {{--                                    <td>{{ hexdec($dataInfo->data30) }}</td>--}}
                                {{--                                    <td>{{ hexdec($dataInfo->data31) }}</td>--}}
                                {{--                                    <td>{{ hexdec($dataInfo->data32) }}</td>--}}
                                {{--                                    <td>{{ hexdec($dataInfo->data33) }}</td>--}}
                                {{--                                    <td>{{ hexdec($dataInfo->data34) }}</td>--}}
                                {{--                                    <td>{{ hexdec($dataInfo->data35) }}</td>--}}
                                {{--                                    <td>{{ hexdec($dataInfo->data36) }}</td>--}}
                                {{--                                    <td>{{ hexdec($dataInfo->data37) }}</td>--}}
                                {{--                                    <td>{{ hexdec($dataInfo->data38) }}</td>--}}
                                {{--                                    <td>{{ hexdec($dataInfo->data39) }}</td>--}}
                                {{--                                    <td>{{ hexdec($dataInfo->data40) }}</td>--}}
                                {{--                                    <td>{{ hexdec($dataInfo->data41) }}</td>--}}
                                {{--                                    <td>{{ hexdec($dataInfo->data42) }}</td>--}}
                                {{--                                    <td>{{ hexdec($dataInfo->data43) }}</td>--}}
                                {{--                                    <td>{{ hexdec($dataInfo->data44) }}</td>--}}
                                {{--                                    <td>{{ hexdec($dataInfo->data45) }}</td>--}}
                                {{--                                    <td>{{ hexdec($dataInfo->data46) }}</td>--}}
                                {{--                                    <td>{{ hexdec($dataInfo->data47) }}</td>--}}
                                {{--                                    <td>{{ hexdec($dataInfo->data48) }}</td>--}}
                                {{--                                    <td>{{ hexdec($dataInfo->data49) }}</td>--}}
                                {{--                                    <td>{{ hexdec($dataInfo->data50) }}</td>--}}
                                {{--                                    <td>{{ hexdec($dataInfo->data51) }}</td>--}}
                                {{--                                    <td>{{ hexdec($dataInfo->data52) }}</td>--}}
                                {{--                                    <td>{{ hexdec($dataInfo->data53) }}</td>--}}
                                {{--                                    <td>{{ hexdec($dataInfo->data54) }}</td>--}}
                                {{--                                    <td>{{ hexdec($dataInfo->data55) }}</td>--}}
                                {{--                                    <td>{{ hexdec($dataInfo->data56) }}</td>--}}
                                {{--                                    <td>{{ hexdec($dataInfo->data57) }}</td>--}}
                                {{--                                    <td>{{ hexdec($dataInfo->data58) }}</td>--}}
                                {{--                                    <td>{{ hexdec($dataInfo->data59) }}</td>--}}
                                {{--                                    <td>{{ hexdec($dataInfo->data60) }}</td>--}}
                                {{--                                </tr>--}}


                            <tr>
                                <td><b>{{ ($dataInfo->messageID == 6) ? 'Conductivity' : 'Temperature' }}</b></td>
                                @if($index == 0)
                                <td>{{  (581-$dataInfo->data1)/12.16 }}</td>
                                <td>{{  (581-$dataInfo->data2)/12.16 }}</td>
                                <td>{{  (581-$dataInfo->data3)/12.16 }}</td>
                                <td>{{  (581-$dataInfo->data4)/12.16 }}</td>
                                <td>{{  (581-$dataInfo->data5)/12.16 }}</td>
                                <td>{{  (581-$dataInfo->data6)/12.16 }}</td>
                                <td>{{  (581-$dataInfo->data7)/12.16 }}</td>
                                <td>{{  (581-$dataInfo->data8)/12.16 }}</td>
                                <td>{{  (581-$dataInfo->data9)/12.16 }}</td>
                                <td>{{  (581-$dataInfo->data10)/12.16 }}</td>
                                <td>{{  (581-$dataInfo->data11)/12.16 }}</td>
                                <td>{{  (581-$dataInfo->data12)/12.16 }}</td>
                                <td>{{  (581-$dataInfo->data13)/12.16 }}</td>
                                <td>{{  (581-$dataInfo->data14)/12.16 }}</td>
                                <td>{{  (581-$dataInfo->data15)/12.16 }}</td>
                                <td>{{  (581-$dataInfo->data16)/12.16 }}</td>
                                <td>{{  (581-$dataInfo->data17)/12.16 }}</td>
                                <td>{{  (581-$dataInfo->data18)/12.16 }}</td>
                                <td>{{  (581-$dataInfo->data19)/12.16 }}</td>
                                <td>{{  (581-$dataInfo->data20)/12.16 }}</td>
                                <td>{{  (581-$dataInfo->data21)/12.16 }}</td>
                                <td>{{  (581-$dataInfo->data22)/12.16 }}</td>
                                <td>{{  (581-$dataInfo->data23)/12.16 }}</td>
                                <td>{{  (581-$dataInfo->data24)/12.16 }}</td>
                                <td>{{  (581-$dataInfo->data25)/12.16 }}</td>
                                <td>{{  (581-$dataInfo->data26)/12.16 }}</td>
                                <td>{{  (581-$dataInfo->data27)/12.16 }}</td>
                                <td>{{  (581-$dataInfo->data28)/12.16 }}</td>
                                <td>{{  (581-$dataInfo->data29)/12.16 }}</td>
                                <td>{{  (581-$dataInfo->data30)/12.16 }}</td>
                                <td>{{  (581-$dataInfo->data31)/12.16 }}</td>
                                <td>{{  (581-$dataInfo->data32)/12.16 }}</td>
                                <td>{{  (581-$dataInfo->data33)/12.16 }}</td>
                                <td>{{  (581-$dataInfo->data34)/12.16 }}</td>
                                <td>{{  (581-$dataInfo->data35)/12.16 }}</td>
                                <td>{{  (581-$dataInfo->data36)/12.16 }}</td>
                                <td>{{  (581-$dataInfo->data37)/12.16 }}</td>
                                <td>{{  (581-$dataInfo->data38)/12.16 }}</td>
                                <td>{{  (581-$dataInfo->data39)/12.16 }}</td>
                                <td>{{  (581-$dataInfo->data40)/12.16 }}</td>
                                <td>{{  (581-$dataInfo->data41)/12.16 }}</td>
                                <td>{{  (581-$dataInfo->data42)/12.16 }}</td>
                                <td>{{  (581-$dataInfo->data43)/12.16 }}</td>
                                <td>{{  (581-$dataInfo->data44)/12.16 }}</td>
                                <td>{{  (581-$dataInfo->data45)/12.16 }}</td>
                                <td>{{  (581-$dataInfo->data46)/12.16 }}</td>
                                <td>{{  (581-$dataInfo->data47)/12.16 }}</td>
                                <td>{{  (581-$dataInfo->data48)/12.16 }}</td>
                                <td>{{  (581-$dataInfo->data49)/12.16 }}</td>
                                <td>{{  (581-$dataInfo->data50)/12.16 }}</td>
                                <td>{{  (581-$dataInfo->data51)/12.16 }}</td>
                                <td>{{  (581-$dataInfo->data52)/12.16 }}</td>
                                <td>{{  (581-$dataInfo->data53)/12.16 }}</td>
                                <td>{{  (581-$dataInfo->data54)/12.16 }}</td>
                                <td>{{  (581-$dataInfo->data55)/12.16 }}</td>
                                <td>{{  (581-$dataInfo->data56)/12.16 }}</td>
                                <td>{{  (581-$dataInfo->data57)/12.16 }}</td>
                                <td>{{  (581-$dataInfo->data58)/12.16 }}</td>
                                <td>{{  (581-$dataInfo->data59)/12.16 }}</td>
                                <td>{{  (581-$dataInfo->data60)/12.16 }}</td>
                                @else



                                <td>{{  ($dataInfo->data1) }}</td>
                                <td>{{  ($dataInfo->data2) }}</td>
                                <td>{{  ($dataInfo->data3) }}</td>
                                <td>{{  ($dataInfo->data4) }}</td>
                                <td>{{  ($dataInfo->data5) }}</td>
                                <td>{{  ($dataInfo->data6) }}</td>
                                <td>{{  ($dataInfo->data7) }}</td>
                                <td>{{  ($dataInfo->data8) }}</td>
                                <td>{{  ($dataInfo->data9) }}</td>
                                <td>{{  ($dataInfo->data10) }}</td>
                                <td>{{  ($dataInfo->data11) }}</td>
                                <td>{{  ($dataInfo->data12) }}</td>
                                <td>{{  ($dataInfo->data13) }}</td>
                                <td>{{  ($dataInfo->data14) }}</td>
                                <td>{{  ($dataInfo->data15) }}</td>
                                <td>{{  ($dataInfo->data16) }}</td>
                                <td>{{  ($dataInfo->data17) }}</td>
                                <td>{{  ($dataInfo->data18) }}</td>
                                <td>{{  ($dataInfo->data19) }}</td>
                                <td>{{  ($dataInfo->data20) }}</td>
                                <td>{{  ($dataInfo->data21) }}</td>
                                <td>{{  ($dataInfo->data22) }}</td>
                                <td>{{  ($dataInfo->data23) }}</td>
                                <td>{{  ($dataInfo->data24) }}</td>
                                <td>{{  ($dataInfo->data25) }}</td>
                                <td>{{  ($dataInfo->data26) }}</td>
                                <td>{{  ($dataInfo->data27) }}</td>
                                <td>{{  ($dataInfo->data28) }}</td>
                                <td>{{  ($dataInfo->data29) }}</td>
                                <td>{{  ($dataInfo->data30) }}</td>
                                <td>{{  ($dataInfo->data31) }}</td>
                                <td>{{  ($dataInfo->data32) }}</td>
                                <td>{{  ($dataInfo->data33) }}</td>
                                <td>{{  ($dataInfo->data34) }}</td>
                                <td>{{  ($dataInfo->data35) }}</td>
                                <td>{{  ($dataInfo->data36) }}</td>
                                <td>{{  ($dataInfo->data37) }}</td>
                                <td>{{  ($dataInfo->data38) }}</td>
                                <td>{{  ($dataInfo->data39) }}</td>
                                <td>{{  ($dataInfo->data40) }}</td>
                                <td>{{  ($dataInfo->data41) }}</td>
                                <td>{{  ($dataInfo->data42) }}</td>
                                <td>{{  ($dataInfo->data43) }}</td>
                                <td>{{  ($dataInfo->data44) }}</td>
                                <td>{{  ($dataInfo->data45) }}</td>
                                <td>{{  ($dataInfo->data46) }}</td>
                                <td>{{  ($dataInfo->data47) }}</td>
                                <td>{{  ($dataInfo->data48) }}</td>
                                <td>{{  ($dataInfo->data49) }}</td>
                                <td>{{  ($dataInfo->data50) }}</td>
                                <td>{{  ($dataInfo->data51) }}</td>
                                <td>{{  ($dataInfo->data52) }}</td>
                                <td>{{  ($dataInfo->data53) }}</td>
                                <td>{{  ($dataInfo->data54) }}</td>
                                <td>{{  ($dataInfo->data55) }}</td>
                                <td>{{  ($dataInfo->data56) }}</td>
                                <td>{{  ($dataInfo->data57) }}</td>
                                <td>{{  ($dataInfo->data58) }}</td>
                                <td>{{  ($dataInfo->data59) }}</td>
                                <td>{{  ($dataInfo->data60) }}</td>

                                @endif
                            </tr>
                            @endforeach

                            </tfoot>
                        </table>
                    </div>
                </div>
                <!-- /.box-body -->
            </div>
            <!-- /.box -->
        </div>
        <!-- /.col -->
    </div>






    <div class="row">
        <div class="col-md-12">
            <div class="box">
                <div class="box-header with-border">
                    <h3 class="box-title">Buoy Status</h3>

                    <div class="box-tools pull-right">
                        <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                        </button>
                        <div class="btn-group">
                            <button type="button" class="btn btn-box-tool dropdown-toggle" data-toggle="dropdown">
                                <i class="fa fa-wrench"></i></button>
                            <ul class="dropdown-menu" role="menu">
                                <li><a href="#">Action</a></li>
                                <li><a href="#">Another action</a></li>
                                <li><a href="#">Something else here</a></li>
                                <li class="divider"></li>
                                <li><a href="#">Separated link</a></li>
                            </ul>
                        </div>
                        <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
                    </div>
                </div>
                <!-- /.box-header -->
                <div class="box-body">
                    <div class="row">
                        <div class="col-md-10">

                            <div id="reportPage">
                                <h4 class="text-center">
                                    <strong>Temperature Data: {{ '20' . substr($dataInfo->rmcDate, 4, 2) .'-'. substr($dataInfo->rmcDate, 2, 2) .'-'. substr($dataInfo->rmcDate, 0, 2)  }} Time: {{ substr($dataInfo->rmcTime, 0, 2) .':'. substr($dataInfo->rmcTime, 2, 2)  }} </strong>
                                </h4>
                                <div class="chart">
                                    <canvas id="temperatureChart"></canvas>
                                    <p class="x-axis">Thermistors Distance (cm)</p>
                                </div>

                                <hr>

                                <h4 class="text-center">
                                    <strong>Conductivity Data:  {{ '20' . substr($dataInfo->rmcDate, 4, 2) .'-'. substr($dataInfo->rmcDate, 2, 2) .'-'. substr($dataInfo->rmcDate, 0, 2)  }} Time: {{ substr($dataInfo->rmcTime, 0, 2) .':'. substr($dataInfo->rmcTime, 2, 2)  }}</strong>
                                </h4>

                                <div class="chart">
                                    <canvas id="conductivityChart"></canvas>
                                    <p class="x-axis">Thermistors Distance (cm)</p>
                                </div>
                            </div>
                        </div>
                        <!-- /.col -->

                        <div class="col-md-2">
                            @if ($errors->any())
                            <div class="alert alert-danger">
                                <ul>
                                    @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div><br />
                            @endif
                            <p class="text-center">
                                <strong>Process Information</strong>
                            </p>



                            <form role="form" method="post" action="{{ route('summery.update', $dataInfos[0]->uniqueID) }}">
                                @csrf
                                @method('PUT')

                                <input type="text" id="imei" name="imei" hidden="hidden" value="{{ $dataInfos[0]->buoy_id }}">
                                <input type="text" id="operationID" name="operationID" hidden="hidden" value="{{ $dataInfos[0]->uniqueID }}">
                                <input type="text" id="filename" name="filename" hidden="hidden" value="{{ $dataInfos[0]->filename }}">
                                <input type="text" id="rmcDate" name="rmcDate" hidden="hidden" value="{{ $dataInfos[0]->rmcDate }}">
                                <input type="text" id="rmcTime" name="rmcTime" hidden="hidden" value="{{ $dataInfos[0]->rmcTime }}">
                                <input type="text" id="latitude" name="latitude" hidden="hidden" value="{{ $dataInfos[0]->lat1 }}">
                                <input type="text" id="longitude" name="longitude" hidden="hidden" value="{{ $dataInfos[0]->lon1 }}">
                                <input type="text" id="user_id" name="user_id" hidden="hidden" value="{{ Auth::user()->id }}">

                                <!-- ice level -->
                                <div class="form-group">
                                    <label for="top_snow">Data Using</label>
                                    <select class="form-control" id="dataUsed" name="dataUsed">
                                        <option value="1">Temperature</option>
                                        <option value="6">Conductivity</option>
                                    </select>
                                </div>

                                <!-- ice level -->
                                <div class="form-group">
                                    <label for="top_snow">Top of Snow</label>
                                    <input type="text" class="form-control delectLevel" id="top_snow" name="top_snow" value="{{ $summaries->top_snow }}" placeholder="Top of Snow">
                                </div>
                                <!-- snow level -->
                                <div class="form-group">
                                    <label for="top_ice">Top of Ice</label>
                                    <input type="text" class="form-control delectLevel" id="top_ice" name="top_ice" value="{{ $summaries->top_ice }}" placeholder="Top of Ice">
                                </div>

                                <!-- water level -->
                                <div class="form-group">
                                    <label for="bottom_ice">Bottom of Ice</label>
                                    <input type="text" class="form-control delectLevel" id="bottom_ice" value="{{ $summaries->bottom_ice }}" name="bottom_ice" placeholder="Bottom of Ice">
                                </div>
                                <!-- <button type="submit" class="btn btn-success">Update Information</button> -->


                                <input type="hidden" id="depth_of_snow" name="depth_of_snow">
                                <input type="hidden" id="ice_thickness" name="ice_thickness">

                                <!-- Button trigger modal -->
                                <a type="button" id="update_information" class="btn btn-primary" data-toggle="modal" data-target="#myModal">
                                    Update & Approve Now
                                </a>
                                <p class="error-red" id="error">* Ice thickness cannot be negative.</p>

                                <!-- Modal -->
                                <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                                    <div class="modal-dialog" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                                <h4 class="modal-title" id="myModalLabel">Confirmation</h4>
                                            </div>
                                            <div class="modal-body">
                                                <h4>Do you want to approve this process and forward to
                                                    <img class=" siku" src="{{ asset('images/siku_splash_logo.png') }}" alt="">
                                                </h4>
                                                <p>Check again if you made any misstates</p>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                                                <button type="submit" class="btn btn-success">Update</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </form>


                            <div class="margin-bottom"></div>


                            <div class="progress-group">
                                <span class="progress-text">Depth of Snow(cm)</span>
                                <span class="progress-number" id="depth_snow"></span>

                                <div class="progress sm">
                                    <div class="progress-bar progress-bar-aqua" id="depth_of_snow_width"></div>
                                </div>
                            </div>

                            <!-- /.progress-group -->
                            <div class="progress-group">
                                <span class="progress-text">Ice thikness(cm)</span>
                                <span class="progress-number" id="ice_thikness"></span>

                                <div class="progress sm">
                                    <div class="progress-bar progress-bar-red" id="ice_thikness_width"></div>
                                </div>
                            </div>

                        </div>

                        <!-- /.col -->
                    </div>
                    <!-- /.row -->
                </div>

            </div>
            <!-- /.box -->
        </div>
        <!-- /.col -->
    </div>
    <!-- /.row -->


</section>
@endsection

@section('scriptIncludes')
<!-- JS -->
<!-- FastClick -->
<script src="{{ asset('themes/admin/bower_components/fastclick/lib/fastclick.js') }}"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/1.3.2/jspdf.min.js"></script>

<!-- Sparkline -->
<script src="{{ asset('themes/admin/bower_components/jquery-sparkline/dist/jquery.sparkline.min.js') }}"></script>

<!-- jvectormap  -->
<script src="{{ asset('themes/admin/plugins/jvectormap/jquery-jvectormap-1.2.2.min.js') }}"></script>
<script src="{{ asset('themes/admin/plugins/jvectormap/jquery-jvectormap-world-mill-en.js') }}"></script>

<!-- SlimScroll -->
<script src="{{ asset('themes/admin/bower_components/jquery-slimscroll/jquery.slimscroll.min.js') }}"></script>

<!-- ChartJS -->
<script src="{{ asset('themes/admin/bower_components/chart.js/Chart.js') }}"></script>
{{--    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.7.3/Chart.js"></script>--}}

<!-- AdminLTE dashboard demo (This is only for demo purposes) -->
{{--    <script src="{{ asset('themes/admin/dist/js/pages/dashboard2.js') }}"></script>--}}

<!-- AdminLTE for demo purposes -->
<script src="{{ asset('themes/admin/dist/js/demo.js') }}"></script>


<!-- google map -->
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDLSZOGsqj2TZZOacrgQ7OZMvtH7ARGZjo&callback=initMap"
        async defer></script>

<script type="text/javascript">

    // var map1, map2;
    // function drawMap() {
    //
    //     var mapOptions = {
    //         zoom: 13,
    //         mapTypeId: google.maps.MapTypeId.ROADMAP,
    //         mapTypeControl: true,
    //         fullscreenControl: false
    //     }
    //     mapOptions.center = new google.maps.LatLng(51.509865, -0.118092); // London
    //     map1 = new google.maps.Map(document.getElementById("mapCanvas1"), mapOptions);
    //
    //     mapOptions.center = new google.maps.LatLng(52.370216, 4.895168); // Amsterdam
    //     map2 = new google.maps.Map(document.getElementById("mapCanvas2"), mapOptions);
    // }

    var map1, map2;
    function initMap() {
        map1 = new google.maps.Map(document.getElementById('map1'), {
            center: {lat: -34.397, lng: 150.644},
            zoom: 12
        });

        map2 = new google.maps.Map(document.getElementById('map2'), {
            center: {lat: -34.397, lng: 150.644},
            zoom: 12
        });


    }
</script>

<script type="text/javascript">
    function generateLabels() {
        var labels = [];
        for (var i = 0; i < 60 * 4; i = i + 4) {
            labels.push(i);
        }
        return labels;

    }

    function conductivityLabels() {
        var labels = [];
        for (var i = 2; i < 60 * 4; i = i + 4) {
            labels.push(i);
        }

        console.log(labels);
        return labels;

    }

    conductivityLabels();


    var drawHorizontalLine = function (ctx, chartWidth, dataset, scale, label, index, color) {
        var point = dataset.points[index];
        var scale = scale;

        // draw line
        ctx.beginPath();
        ctx.moveTo(scale.startPoint + 20, point.y);
        ctx.strokeStyle = color;
        ctx.lineTo(chartWidth, point.y); //this.chart.width
        ctx.stroke();

        // write label
        ctx.textAlign = 'center';
        ctx.fillStyle = 'black';
        ctx.textBaseline = 'middle';
        ctx.fillText(label, scale.startPoint + 45, point.y - 10);
    };


    var drawVerticalLine = function (ctx, dataset, scale, label, index, color) {
        var point = dataset.points[index];
        var scale = scale;

        // draw line
        ctx.beginPath();
        ctx.moveTo(point.x, scale.startPoint + 20);
        ctx.strokeStyle = color;
        ctx.lineTo(point.x, scale.endPoint);
        ctx.stroke();

        // write label
        ctx.textAlign = 'center';
        ctx.fillStyle = color;
        ctx.textBaseline = 'middle';
        ctx.fillText(label, point.x, scale.startPoint + 10);
    };



    Chart.types.Line.extend({
        name: "LineAlt",
        initialize: function (data) {
            var strokeColors = [];

            Chart.types.Line.prototype.initialize.apply(this, arguments);

            var self = this;

        },

        draw: function () {
            Chart.types.Line.prototype.draw.apply(this, arguments);


            // from Chart.js library code
            var hasValue = function (item) {
                    return item.value !== null;
                },
                nextPoint = function (point, collection, index) {
                    return Chart.helpers.findNextWhere(collection, hasValue, index) || point;
                },
                previousPoint = function (point, collection, index) {
                    return Chart.helpers.findPreviousWhere(collection, hasValue, index) || point;
                };

            var ctx = this.chart.ctx;
            var conductivity = this.chart.ctx;
            var self = this;
            var firstDataSet = self.datasets[0];

            // Draw Today Lini
            drawVerticalLine(ctx, firstDataSet, self.scale, self.options.topOfIceLabel, self.options.topOfIceIndex, '#1B5E20');
            drawVerticalLine(ctx, firstDataSet, self.scale, self.options.topOfSnowLabel, self.options.topOfSnowIndex, '#E65100');
            drawVerticalLine(ctx, firstDataSet, self.scale, self.options.bottomOfIceLabel, self.options.bottomOfIceIndex, '#00BFA5');



            // Draw Today Line
            drawVerticalLine(conductivity, firstDataSet, self.scale, self.options.topOfIceLabel, self.options.topOfIceIndex, '#1B5E20');
            drawVerticalLine(conductivity, firstDataSet, self.scale, self.options.topOfSnowLabel, self.options.topOfSnowIndex, '#E65100');
            drawVerticalLine(conductivity, firstDataSet, self.scale, self.options.bottomOfIceLabel, self.options.bottomOfIceIndex, '#00BFA5');
            //drawHorizontalLine(ctx, this.chart.width, firstDataSet, self.scale, self.options.topOfSnowLabel, self.options.topOfSnowIndex, '#ff0000');
            // drawHorizontalLine(ctx, this.chart.width, firstDataSet, self.scale, self.options.topOfIceLabel, self.options.topOfIceIndex, '#81ACF2');
            // drawHorizontalLine(ctx, this.chart.width, firstDataSet, self.scale, self.options.bottomOfIceLabel, self.options.bottomOfIceIndex, '#C5E5F3');

            ctx.save();
            ctx.restore();


            conductivity.save();
            conductivity.restore();
        }
    });


    var temperatures = "{{ json_encode($temperatures) }}";
    var conductivities = "{{ json_encode($conductivities) }}".replace(/&quot;/g,'');
    var data = {
        labels: generateLabels(),
        type: 'scatter',
        datasets: [{
            label: "Oracle",
            fillColor: "rgba(151,187,205,0)",
            strokeColor: "#EC407A",
            pointColor: "rgba(151,187,205,0)",
            pointStrokeColor: "rgba(151,187,205,0)",
            pointHighlightFill: "rgba(151,187,205,0)",
            pointHighlightStroke: "rgba(151,187,205,0)",
            data: JSON.parse('{{ json_encode($temperatures) }}'),
            dottedFromLabel: "week8"
        }],
        options: {
            labelString: 'Welcome',
            scales: {
                xAxes: [{
                    scaleLabel: {
                        display: true,
                        labelString: 'probability'
                    },
                    ticks: {
                        beginAtZero: true,
                        max: 100,
                        min: 0,
                        stepSize: 20
                    },
                    gridLines: {
                        display: true,
                    }
                }],
                yAxes: [{
                    ticks: {
                        beginAtZero: false,
                        max: 100,
                        min: 0,
                        stepSize: 20
                    }
                }]
            }
        },

    };

    var conductivity_data = {
        labels: conductivityLabels(),
        type: 'scatter',
        datasets: [{
            label: "Oracle",
            fillColor: "rgba(151,187,205,0)",
            strokeColor: "#EC407A",
            pointColor: "rgba(151,187,205,0)",
            pointStrokeColor: "rgba(151,187,205,0)",
            pointHighlightFill: "rgba(151,187,205,0)",
            pointHighlightStroke: "rgba(151,187,205,0)",
            data: JSON.parse(conductivities),
            dottedFromLabel: "week8"
        }],
        options: {
            labelString: 'Welcome',
            scales: {
                xAxes: [{
                    scaleLabel: {
                        display: true,
                        labelString: 'probability'
                    },
                    ticks: {
                        beginAtZero: true,
                        max: 100,
                        min: 0,
                        stepSize: 20
                    },
                    gridLines: {
                        display: true,
                    }
                }],
                yAxes: [{
                    ticks: {
                        beginAtZero: false,
                        max: 100,
                        min: 0,
                        stepSize: 20
                    }
                }]
            }
        },

    };




    var ctx = document.getElementById("temperatureChart").getContext("2d");
    var conductivityChart = document.getElementById("conductivityChart").getContext("2d");


    var options = {

        title: true,
        bezierCurve: false,
        topOfSnowIndex: data.labels.indexOf({{ ($summaries) ? $summaries->top_snow : 8 }}),
    topOfSnowLabel: 'Top of Snow',

        topOfIceIndex: data.labels.indexOf({{ ($summaries) ? $summaries->top_ice : 88 }}),
    topOfIceLabel: 'Top of Ice',

        bottomOfIceIndex: data.labels.indexOf({{ ($summaries) ? $summaries->bottom_ice : 204 }}),
    bottomOfIceLabel: 'Bottom of Ice',
    };


    // top_of_snow
    // top_of_ice
    // bottom_of_ice




    $('.delectLevel').on('keyup', function () {

        var inputID = $(this).attr('id');
        // check if the value is 'empty' then set == 0
        var topOfSnow = parseInt(($("#top_snow").val() > 0) ? $("#top_snow").val() : 0);
        var topOfIce = parseInt(($("#top_ice").val() > 0) ? $("#top_ice").val() : 0);
        var bottomOfIce = parseInt(($("#bottom_ice").val() > 0) ? $("#bottom_ice").val() : 0);


        var items = generateLabels();


        var options = {
            bezierCurve: false,
            topOfSnowIndex: items.indexOf(topOfSnow),
            topOfSnowLabel: 'Top of Snow',

            topOfIceIndex: items.indexOf(topOfIce),
            topOfIceLabel: 'Top of Ice',

            bottomOfIceIndex: items.indexOf(bottomOfIce),
            bottomOfIceLabel: 'Bottom of Ice',
        };


        // setting the result in display
        var depthOfSnow =  parseInt(items.indexOf(topOfIce)) - parseInt(items.indexOf(topOfSnow));
        var iceThikness = parseInt(items.indexOf(bottomOfIce)) - parseInt(items.indexOf(topOfIce));



        // and it will wait till the result is 0
        if (iceThikness == undefined || iceThikness < 0){
            $("#update_information").attr("disabled", true);
            $("#update_information").prop("disabled", true);

            //display error
            $("#error").css("display", "block");
        }else{
            $("#update_information").removeAttr("disabled");
            $("#update_information").removeProp("disabled");

            // hide error
            $("#error").css("display", "none");
        }




        $("#depth_snow").html("<b>" + data.labels[depthOfSnow] + "</b>");
        $("#depth_of_snow_width").width(data.labels[depthOfSnow] + "%");

        $("#ice_thikness").html("<b>" + data.labels[iceThikness] + "</b>");
        $("#ice_thikness_width").width(data.labels[iceThikness] + "%");

        $("#ice_thickness").val(data.labels[iceThikness]);
        $("#depth_of_snow").val(data.labels[depthOfSnow]);

        new Chart(ctx).LineAlt(data, options);
        new Chart(conductivityChart).LineAlt(conductivity_data, options);

    });



    new Chart(ctx).LineAlt(data, options);
    new Chart(conductivityChart).LineAlt(conductivity_data, options);










    // Download PDF file
    //=================================================================
    $('#downloadPdf').click(function(event) {
        // get size of report page
        var reportPageHeight = $('#reportPage').innerHeight();
        var reportPageWidth = $('#reportPage').innerWidth();

        // create a new canvas object that we will populate with all other canvas objects
        var pdfCanvas = $('<canvas />').attr({
            id: "canvaspdf",
            width: reportPageWidth,
            height: reportPageHeight
        });

        // keep track canvas position
        var pdfctx = $(pdfCanvas)[0].getContext('2d');
        var pdfctxX = 0;
        var pdfctxY = 0;
        var buffer = 100;

        // for each chart.js chart
        $("canvas").each(function(index) {
            // get the chart height/width
            var canvasHeight = $(this).innerHeight();
            var canvasWidth = $(this).innerWidth();

            // draw the chart into the new canvas
            pdfctx.drawImage($(this)[0], pdfctxX, pdfctxY, canvasWidth, canvasHeight);
            pdfctxX += canvasWidth + buffer;

            // our report page is in a grid pattern so replicate that in the new canvas
            if (index % 2 === 1) {
                pdfctxX = 0;
                pdfctxY += canvasHeight + buffer;
            }
        });

        // create new pdf and add our new canvas as an image
        var pdf = new jsPDF('l', 'pt', [reportPageWidth, reportPageHeight]);
        pdf.addImage($(pdfCanvas)[0], 'PNG', 0, 0);

        // download the pdf
        pdf.save('filename.pdf');
    });


</script>

@endsection
