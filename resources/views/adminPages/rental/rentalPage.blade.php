@extends('adminLayout.sidenav-layout')
@section('title')
        @include('adminComponents.dashboard.profile_userName')
@endsection
@section('content')
    @include('adminComponents.rental.rental_list')
    @include('adminComponents.rental.rental_view')
    @include('adminComponents.rental.rental_delete')
    @include('adminComponents.rental.rental_update')

@endsection

