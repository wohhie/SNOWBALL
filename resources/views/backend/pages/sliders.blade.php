@extends('backend/layouts/starter')

@section('title') UI Sliders @endsection

@section('headIncludes')
<!-- CSS -->
 <!-- bootstrap slider -->
 <link rel="stylesheet" href="{{ asset('themes/admin/plugins/bootstrap-slider/slider.css') }}">
@endsection

@section('bodyClass')class="hold-transition skin-blue sidebar-mini"@endsection

@section('contentHeader')
<!-- Content Header (Page header) -->
<section class="content-header">
  <h1>UI Sliders <small>Preview...</small></h1>
  
  <ol class="breadcrumb">
    <li><a href="/admin"><i class="fa fa-dashboard"></i> Dashboard</a></li>
    <li class="active">UI Sliders</li>
  </ol>
</section>
@endsection

@section('content')
<div class="row">
  <div class="col-xs-12">
    <div class="box box-primary">
      <div class="box-header">
        <h3 class="box-title">Bootstrap Slider</h3>
      </div>
      <!-- /.box-header -->
      <div class="box-body">
        <div class="row margin">
          <div class="col-sm-6">
            <input type="text" value="" class="slider form-control" data-slider-min="-200" data-slider-max="200"
                   data-slider-step="5" data-slider-value="[-100,100]" data-slider-orientation="horizontal"
                   data-slider-selection="before" data-slider-tooltip="show" data-slider-id="red">

            <p>data-slider-id="red"</p>
            <input type="text" value="" class="slider form-control" data-slider-min="-200" data-slider-max="200"
                   data-slider-step="5" data-slider-value="[-100,100]" data-slider-orientation="horizontal"
                   data-slider-selection="before" data-slider-tooltip="show" data-slider-id="blue">

            <p>data-slider-id="blue"</p>
            <input type="text" value="" class="slider form-control" data-slider-min="-200" data-slider-max="200"
                   data-slider-step="5" data-slider-value="[-100,100]" data-slider-orientation="horizontal"
                   data-slider-selection="before" data-slider-tooltip="show" data-slider-id="green">

            <p>data-slider-id="green"</p>
            <input type="text" value="" class="slider form-control" data-slider-min="-200" data-slider-max="200"
                   data-slider-step="5" data-slider-value="[-100,100]" data-slider-orientation="horizontal"
                   data-slider-selection="before" data-slider-tooltip="show" data-slider-id="yellow">

            <p>data-slider-id="yellow"</p>
            <input type="text" value="" class="slider form-control" data-slider-min="-200" data-slider-max="200"
                   data-slider-step="5" data-slider-value="[-100,100]" data-slider-orientation="horizontal"
                   data-slider-selection="before" data-slider-tooltip="show" data-slider-id="aqua">

            <p>data-slider-id="aqua"</p>
            <input type="text" value="" class="slider form-control" data-slider-min="-200" data-slider-max="200"
                   data-slider-step="5" data-slider-value="[-100,100]" data-slider-orientation="horizontal"
                   data-slider-selection="before" data-slider-tooltip="show" data-slider-id="purple">

            <p style="margin-top: 10px">data-slider-id="purple"</p>
          </div>
          <div class="col-sm-6 text-center">
            <input type="text" value="" class="slider form-control" data-slider-min="-200" data-slider-max="200"
                   data-slider-step="5" data-slider-value="[-100,100]" data-slider-orientation="vertical"
                   data-slider-selection="before" data-slider-tooltip="show" data-slider-id="red">
            <input type="text" value="" class="slider form-control" data-slider-min="-200" data-slider-max="200"
                   data-slider-step="5" data-slider-value="[-100,100]" data-slider-orientation="vertical"
                   data-slider-selection="before" data-slider-tooltip="show" data-slider-id="blue">
            <input type="text" value="" class="slider form-control" data-slider-min="-200" data-slider-max="200"
                   data-slider-step="5" data-slider-value="[-100,100]" data-slider-orientation="vertical"
                   data-slider-selection="before" data-slider-tooltip="show" data-slider-id="green">
            <input type="text" value="" class="slider form-control" data-slider-min="-200" data-slider-max="200"
                   data-slider-step="5" data-slider-value="[-100,100]" data-slider-orientation="vertical"
                   data-slider-selection="before" data-slider-tooltip="show" data-slider-id="yellow">
            <input type="text" value="" class="slider form-control" data-slider-min="-200" data-slider-max="200"
                   data-slider-step="5" data-slider-value="[-100,100]" data-slider-orientation="vertical"
                   data-slider-selection="before" data-slider-tooltip="show" data-slider-id="aqua">
            <input type="text" value="" class="slider form-control" data-slider-min="-200" data-slider-max="200"
                   data-slider-step="5" data-slider-value="[-100,100]" data-slider-orientation="vertical"
                   data-slider-selection="before" data-slider-tooltip="show" data-slider-id="purple">
          </div>
        </div>
      </div>
      <!-- /.box-body -->
    </div>
    <!-- /.box -->
  </div>
  <!-- /.col -->
</div>
<!-- /.row -->
@endsection

@section('scriptIncludes')
<!-- Js -->
 <!-- FastClick -->
 <script src="{{ asset('themes/admin/bower_components/fastclick/lib/fastclick.js') }}"></script>
 <!-- AdminLTE for demo purposes -->
 <script src="{{ asset('themes/admin/dist/js/demo.js') }}"></script>
 <!-- Bootstrap slider -->
 <script src="{{ asset('themes/admin/plugins/bootstrap-slider/bootstrap-slider.js') }}"></script>
 <script>
  $(function () {
    /* BOOTSTRAP SLIDER */
    $('.slider').slider()
  })
 </script>
@endsection