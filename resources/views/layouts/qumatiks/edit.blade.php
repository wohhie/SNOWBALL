@extends('backend.layouts.starter')

@section('title') All SmartQUMATIKs @endsection
@section('headIncludes')
    <!-- Custom Style -->
    <link rel="stylesheet" href="{{ asset('css/custom-style.css') }}">
@endsection

@section('bodyClass')class="hold-transition skin-blue sidebar-mini"@endsection
@section('contentHeader')
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>SmartQUMATIKs Information <small>Edit a SmartQUMATIK</small></h1>
        <ol class="breadcrumb">
    <li><a href="/admin"><i class="fa fa-dashboard"></i> Dashboard</a></li>
    <li class="active">SmartQUMATIKs Information</li>
  </ol>

  <div class="row">

<!-- left column -->
<div class="col-md-6">
    <!-- general form elements -->
    <div class="box box-primary">
        <div class="box-header with-border">
            <h3 class="box-title">Edit SmartQUMATIKs</h3>
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
        <form role="form" method="post" action="{{ route('qumatiks.update', $qumatik->id) }}">
            @csrf
            @method('PUT')

            <div class="box-body">

            <div class="form-group">
                    <label for="imei">Serial Number</label>
                    <input type="text" class="form-control" id="imei" name="imei" value="{{ $qumatik->imei }}" placeholder="Update imei number">
                </div>

                <div class="form-group">
                    <label for="community_id">Community Name</label>
                    <select class="form-control" required name="community_id">
                        <option value="0" disabled selected>Select</option>
                        @foreach($communities as $community)
                            <option {{( $qumatik->community_id == $community->id) ? 'selected' : ''}}  value="{{ $community->id }}">{{ $community->name }}</option>
                        @endforeach
                    </select>
                </div>


                <div class="row">
                    <div class="col-lg-6">
                        <div class="form-group">
                            <label for="latitude">Latitude</label>
                            <input type="text" class="form-control" id="latitude" name="latitude" value="{{ $qumatik->latitude }}" placeholder="Update initial latitude">
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="form-group">
                            <label for="longitude">Longitude</label>
                            <input type="text" class="form-control" id="longitude" name="longitude" value="{{ $qumatik->longitude }}" placeholder="Update initial longitude">
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <label for="dropbox_dir">Dropbox Directory</label>
                    <input type="text" class="form-control" id="dropbox_dir" name="dropbox_dir" value="{{ $qumatik->dropbox_dir }}" placeholder="Update Dropbox Directory">
                </div>

                <div class="form-group">
                    <label for="status">Status</label>
                    <select class="form-control" name="status" id="status">
                        <option {{ ($qumatik->status == 0) ? 'selected': '' }} value="0">In Active</option>
                        <option {{ ($qumatik->status == 1) ? 'selected': '' }} value="1">Active</option>
                    </select>
                </div>


                <input type="hidden" name="user_id" value="{{ auth()->id() }}">
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
