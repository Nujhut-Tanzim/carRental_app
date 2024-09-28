@extends('adminLayout.sidenav-layout')
@section('title')
        @include('adminComponents.dashboard.profile_userName')
@endsection
    
@section('content')
    @include('adminComponents.customer.customer_list')
    @include('adminComponents.customer.customer_view')
    @include('adminComponents.customer.customer_update')
    @include('adminComponents.customer.customer_delete')
@endsection

