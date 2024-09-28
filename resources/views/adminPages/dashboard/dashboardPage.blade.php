@extends('adminLayout.sidenav-layout')
@section('title')
        @include('adminComponents.dashboard.profile_userName')
@endsection
    
@section('content')
    @include('adminComponents.dashboard.summary')
@endsection

