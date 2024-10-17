@extends('admin.master')

@section('title')
    
@endsection

@section('content')
    <!--begin::Row-->
    @include('admin.layout.row1')
    <!--end::Row-->

    <!--begin::Table Widget 5-->
     @include('admin.layout.row2')
    <!--end::Table Widget 5-->

    <!--begin::Row-->
    @include('admin.layout.row3')
    <!--end::Row-->
@endsection