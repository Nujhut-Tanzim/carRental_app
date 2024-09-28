@extends('Home.homeLayout')
@section('title')
        @include('customerComponents.dashboard.profile_userName')
@endsection
    
@section('content')
    @include('customerComponents.dashboard.profileForm')
@endsection

