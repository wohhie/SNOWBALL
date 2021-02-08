@extends('backend.layouts.starter')
@section('title') Google Map @endsection

@section('headIncludes')
    <!-- Custom Style -->
    <link rel="stylesheet" href="{{ asset('css/custom-style.css') }}">
    {!! $map['js']!!}
@endsection

@section('bodyClass')class="hold-transition skin-blue sidebar-mini"@endsection

@section('contentHeader')
    <!-- Content Header (Page header) -->
    <section class="content-header">

        {!! $map['html']!!}

        <div id="directionsDiv"></div>

    </section>
@endsection
