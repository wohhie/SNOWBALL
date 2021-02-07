@extends('backend.layouts.starter')

@section('title') All communities @endsection
@section('headIncludes')
    <!-- Custom Style -->
    <link rel="stylesheet" href="{{ asset('css/custom-style.css') }}">
@endsection

@section('bodyClass')class="hold-transition skin-blue sidebar-mini"@endsection
@section('contentHeader')
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>Community Information <small>Edit a Community</small></h1>
        <ol class="breadcrumb">
    <li><a href="/admin"><i class="fa fa-dashboard"></i> Dashboard</a></li>
    <li class="active">Community Information</li>
  </ol>

  <div class="row">

<!-- left column -->
<div class="col-md-6">
    <!-- general form elements -->
    <div class="box box-primary">
        <div class="box-header with-border">
            <h3 class="box-title">Edit Community</h3>
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
        <form role="form" method="post" action="{{ route('communities.update', ['id'=>$community->id]) }}">
            @csrf
            @method('PUT')

            <div class="box-body">



                <div class="form-group">
                    <label for="name">Community Name</label>
                    <input type="text" class="form-control" id="name" name="name" value="{{ $community->name }}" placeholder="Update initial name">

                </div>


                <div class="row">
                    <div class="col-lg-6">
                        <div class="form-group">
                            <label for="latitude">Latitude</label>
                            <input type="text" class="form-control" id="latitude" name="latitude" value="{{ $community->latitude }}" placeholder="Update initial latitude">
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="form-group">
                            <label for="longitude">Longitude</label>
                            <input type="text" class="form-control" id="longitude" name="longitude" value="{{ $community->longitude }}" placeholder="Update initial longitude">
                        </div>
                    </div>
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
