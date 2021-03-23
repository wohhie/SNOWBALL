@extends('backend.layouts.starter')
@section('title') The Reports @endsection
@section('headIncludes')
    <!-- Custom Style -->
    <link rel="stylesheet" href="{{ asset('css/custom-style.css') }}">
@endsection
@section('bodyClass')class="hold-transition skin-blue sidebar-mini"@endsection

@section('contentHeader')
    <section class="content-header">

        <h1>Reports Information <small>All Reports</small></h1>

        <ol class="breadcrumb">
            <li><a href="/admin"><i class="fa fa-dashboard"></i> Dashboard</a></li>
            <li class="active">Report Information</li>
        </ol>

    </section>
@endsection

@section('content')
    <div class="row">

        <div class="col-xs-12">

            <div class="box">

                <div class="box-header">

{{--                    <h3 class="box-title custom-button">All Reports</h3>--}}

                    <form role="form" method="POST" action=" ">
                        <div class="box-body">
                            <div class="box-body">

                                <div class="row">
                                    <div class="col-lg-2">
                                        <div class="form-group">
                                            <label for="name">Location </label>
                                            <select class="form-control" required name="locationID">
                                                <option value="0" disabled selected>Select</option>

                                                @foreach($communities as $community)
                                                    <option value="{{ $community->id }}">{{ $community->name }}</option>
                                                @endforeach

                                            </select>

                                        </div>
                                    </div>
                                    <div class="col-lg-3">
                                        <div class="form-group">
                                            <label for="latitude">Start Date</label>

                                            <div class='input-group date' id='datetimepicker1'>
                                                <input type='text' class="form-control"/>
                                                <span class="input-group-addon">
                                                 <span class="glyphicon glyphicon-calendar"></span>
                                                 </span>
                                            </div>

                                        </div>
                                    </div>

                                    <div class="col-lg-3">
                                        <div class="form-group">
                                            <label for="latitude">End Date</label>

                                            <div class='input-group date' id='datetimepicker2'>
                                                <input type='text' class="form-control"/>
                                                <span class="input-group-addon">
                                                 <span class="glyphicon glyphicon-calendar"></span>
                                                 </span>
                                            </div>

                                        </div>
                                    </div>

                                    <div class="col-lg-2">
                                        <div class="form-group">
                                            <button type="submit" class="btn btn-primary" style="margin-top: 25px">
                                                Submit
                                            </button>

                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </form>

                    <div class="row">

                        <div class="col-xs-12">

                        <div class="box-header">
                            <h3 style="alignment: center; text-align: center; "><u>Report</u></h3>

                        </div>
                            <div class="box-body">
                                <a href="#" class="btn btn-primary btn-right">Download</a>
                                    <table id="example1" class="table table-bordered table-striped">

                                        <thead>
                                        <tr>
                                            <th style=" text-align: center; ">SQumatik</th>
                                            <th style=" text-align: center; ">Smart Bouy</th>
                                        </tr>
                                        </thead>

                                        <tbody>

                                        <tr>
                                            <td>Min. Ice Thickness:</td>
                                            <td>Min. Ice Thickness:</td>
                                        </tr>

                                        <tr>
                                            <td>Max. Ice Thickness:</td>
                                            <td>Max. Ice Thickness:</td>
                                        </tr>

                                        <tr>
                                            <td>Air Temperature:</td>
                                            <td>Air Temperature:</td>
                                        </tr>
                                        </tbody>

                                    </table>


                            </div>

                        </div>

                    </div>

                </div>

            </div>


        </div>


    </div>
@endsection

@section('scriptIncludes')

    <script src="{{ asset('themes/admin/bower_components/bootstrap-datepicker/js/bootstrap-datepicker.js') }}"></script>

    <!-- FastClick -->
    <script src="{{ asset('themes/admin/bower_components/fastclick/lib/fastclick.js') }}"></script>
    <!-- AdminLTE for demo purposes -->
    <script src="{{ asset('themes/admin/dist/js/demo.js') }}"></script>

    <script type="text/javascript">
        $(function () {
            $('#datetimepicker1').datepicker();
            $('#datetimepicker2').datepicker();
        });
    </script>

@endsection
