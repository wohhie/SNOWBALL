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
        <h1>Buoys Information <small>Edit new buoy</small></h1>

        <ol class="breadcrumb">
            <li><a href="/admin"><i class="fa fa-dashboard"></i> Dashboard</a></li>
            <li class="active">Buoys Information</li>
        </ol>


        <div class="row">

            <!-- left column -->
            <div class="col-md-6">
                <!-- general form elements -->
                <div class="box box-primary">
                    <div class="box-header with-border">
                        <h3 class="box-title">Edit Buoy</h3>
                    </div>
                    <!-- /.box-header -->
                    <!-- form start -->
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div><br />
                    @endif
                    <form role="form" method="post" action="{{ route('buoys.update', ['id'=>$buoy->id]) }}">
                        @csrf
                        @method('PUT')

                        <div class="box-body">
                            <div class="form-group">
                                <label for="imei">IMEI NO</label>
                                <input type="text" class="form-control" id="imei" name="imei" placeholder="Update imei number" value="{{$buoy->imei}}">
                            </div>

                            <div class="form-group">
                                <label for="communityID">Community Name</label>
                                <select class="form-control" required name="communityID">
                                    <option value="0" disabled selected>Select</option>
                                    @foreach($communities as $community)
                                        <option {{( $buoy->communityID == $community->id) ? 'selected' : ''}}  value="{{ $community->id }}">{{ $community->name }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="form-group">
                                <label for="serialNo">Serial Number</label>
                                <input type="text" class="form-control" id="serialNo" name="serialNo" value="{{ $buoy->serialNo }}" placeholder="Update serial number">
                            </div>

                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label for="latitude">Latitude</label>
                                        <input type="text" class="form-control" id="latitude" name="latitude" value="{{ $buoy->latitude }}" placeholder="Update initial latitude">
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label for="longitude">Longitude</label>
                                        <input type="text" class="form-control" id="longitude" name="longitude" value="{{ $buoy->longitude }}" placeholder="Update initial longitude">
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="plan">Plan</label>
                                <select class="form-control" name="plan" id="plan">
                                    <option selected value="1">A</option>
                                    <option value="2">B</option>
                                    <option value="3">C</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="back_office">Back to Office</label>
                                <select class="form-control" name="back_office" id="back_office">
                                    <option selected value="1">Yes</option>
                                    <option value="0">No</option>
                                </select>
                            </div>

                            <div class="form-group">
                                <label for="status">Status</label>
                                <select class="form-control" name="status" id="status">
                                    <option {{ ($buoy->status == 0) ? 'selected': '' }} value="0">In Active</option>
                                    <option {{ ($buoy->status == 1) ? 'selected': '' }} value="1">Active</option>
                                </select>
                            </div>
                        </div>
                        <!-- /.box-body -->

                        <div class="box-footer">
                            <button type="submit" class="btn btn-primary">Submit</button>
                        </div>
                    </form>
                </div>
                <!-- /.box -->
            </div>
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
