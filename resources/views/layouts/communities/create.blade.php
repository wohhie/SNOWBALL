@extends('backend.layouts.starter')

@section('title') Create a new Community @endsection
@section('headIncludes')
    <!-- Custom Style -->
    <link rel="stylesheet" href="{{ asset('css/custom-style.css') }}">
@endsection

@section('bodyClass')class="hold-transition skin-blue sidebar-mini"@endsection

<!-- content header section -->
@section('contentHeader')
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>Communities Information <small>create a new Community</small></h1>

        <ol class="breadcrumb">
            <li><a href="/admin"><i class="fa fa-dashboard"></i> Dashboard</a></li>
            <li class="active">Community Information</li>
        </ol>
    </section>
@endsection
<!-- content header section -->

@section('content')
    <div class="row">
        <!-- left column -->
        <div class="col-md-12">
            <!-- general form elements -->
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="box-title">Create Community</h3>
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
                <form role="form" method="POST" action="{{ route('communities.store') }}">
                    @csrf

                    <div class="box-body">



                        <div class="row">
                            <div class="col-lg-4">
                                <div class="form-group">
                                    <label for="name">Community Name</label>
                                    <input type="text" class="form-control" id="name" name="name" placeholder="Enter initial name">

                                </div>
                            </div>
                            <div class="col-lg-4">
                                <div class="form-group">
                                    <label for="latitude">Latitude</label>
                                    <input type="text" class="form-control" id="latitude" name="latitude" placeholder="Enter initial latitude">
                                </div>
                            </div>

                            <div class="col-lg-4">
                                <div class="form-group">
                                    <label for="longitude">Longitude</label>
                                    <input type="text" class="form-control" id="longitude" name="longitude" placeholder="Enter initial longitude">
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
@endsection

@section('scriptIncludes')
    <!-- Js -->
    <!-- FastClick -->
    <script src="{{ asset('themes/admin/bower_components/fastclick/lib/fastclick.js') }}"></script>
    <!-- AdminLTE for demo purposes -->
    <script src="{{ asset('themes/admin/dist/js/demo.js') }}"></script>


    <!-- iCheck -->
    <script src="{{ asset('js/validator.js') }}"></script>
    <script>

        $('form').validator({
            // the delay in milliseoncds
            delay: 500,

            // allows html inside the error messages
            html: false,

            // disable submit button if there's invalid form
            disable: true,

            // <a href="https://www.jqueryscript.net/tags.php?/Scroll/">Scroll</a> to and focus the first field with an error upon validation of the form.
            focus: true,

            // define your custom validation rules
            custom: {},

            // default errof messages
            errors: {
                match: 'Does not match',
                minlength: 'Not long enough'
            },

            // feedback CSS classes
            feedback: {
                success: 'glyphicon-ok',
                error: 'glyphicon-remove'
            }

        })
    </script>
@endsection
