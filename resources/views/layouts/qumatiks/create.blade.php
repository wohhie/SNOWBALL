@extends('backend.layouts.starter')

@section('title') All SmartQUMATIK @endsection


@section('bodyClass')class="hold-transition skin-blue sidebar-mini"@endsection

<!-- content header section -->
@section('contentHeader')
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>SmartQUMATIK Information <small>create new qumatik</small></h1>

        <ol class="breadcrumb">
            <li><a href="/admin"><i class="fa fa-dashboard"></i> Dashboard</a></li>
            <li class="active">SmartQUMATIK Information</li>
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
                    <h3 class="box-title">Create SmartQUMATIK</h3>
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
                <form id="smartQUMATIK" role="form" method="POST" action="{{ route('qumatiks.store') }}">
                    @csrf

                    <div class="box-body">
                        <div class="row">
                            <div class="col-lg-6">
                            <div class="form-group">
                                    <label for="imei">{{ __('IMEI Number') }} <span class="asterisk">*</span></label>
                                    <input type="text" class="form-control" id="imei" name="imei" placeholder="Enter imei number" required>
                                </div>
                            </div>


                            <div class="col-lg-2">
                                <div class="form-group">
                                    <label for="version">{{ __('Version') }}</label>
                                    <select class="form-control" name="version" id="version">
                                        @for($index = 1.0; $index < 9.0; $index++)
                                            <option value="{{ $index . ".0" }}">{{ $index . ".0" }}</option>
                                        @endfor
                                    </select>
                                </div>
                            </div>


                            <div class="col-lg-4">
                                <div class="form-group">
                                    <label for="imei">{{ __('Manufacturing Year') }}</label>
                                    <select class="form-control" name="manufacturing_year" id="manufacturing_year">
                                        @for($index = 2015; $index <= 2035; $index++)
                                            <option value="">{{ $index }}</option>
                                        @endfor
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-lg-4">
                                <div class="form-group">
                                    <label for="community_id">{{ __('Community Name') }}</label>
                                    <select class="form-control" required name="community_id">
                                        <option value="0" disabled selected>Select</option>
                                        @foreach($communities as $community)
                                            <option value="{{ $community->id }}">{{ $community->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <div class="form-group">
                                    <label for="latitude">{{ __('Latitude') }}</label>
                                    <input type="text" class="form-control" id="latitude" name="latitude" placeholder="Enter initial latitude">
                                </div>
                            </div>

                            <div class="col-lg-4">
                                <div class="form-group">
                                    <label for="longitude">{{ __('Longitude') }}</label>
                                    <input type="text" class="form-control" id="longitude" name="longitude" placeholder="Enter initial longitude">
                                </div>
                            </div>
                        </div>

                        <div class="row">

                            <div class="col-lg-4">
                                <div class="form-group">
                                    <label for="back_office">{{ __('Back to Office') }}</label>
                                    <select class="form-control" name="back_office" id="back_office">
                                        <option selected value="1">Yes</option>
                                        <option value="0">No</option>
                                    </select>
                                </div>
                            </div>

                            <div class="col-lg-4">
                                <div class="form-group">
                                    <label for="status">{{ __("Status") }}</label>
                                    <select class="form-control" name="status" id="status">
                                        <option value="0">In Active</option>
                                        <option selected value="1">Active</option>
                                    </select>
                                </div>
                            </div>

                            <div class="col-lg-4">
                                <div class="form-group">
                                    <label for="dropbox_dir">{{ __("Dropbox Directory") }}</label>
                                    <input type="text" class="form-control" id="dropbox_dir" name="dropbox_dir" placeholder="" required>
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

        $("#smartQUMATIK").validator({
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
