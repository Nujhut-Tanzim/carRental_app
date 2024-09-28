@extends('adminLayout.sidenav-layout')
@section('title')
        @include('adminComponents.dashboard.profile_userName')
@endsection
    
@section('content')
    @include('adminComponents.car.car_list')
    @include('adminComponents.car.car_view')
    @include('adminComponents.car.car_delete')
    @include('adminComponents.car.car_update')

@endsection

