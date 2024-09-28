@extends('Home.homeLayout')
@section('content')
    @include('customerComponents.rental.rental_list')
    @include('customerComponents.rental.rental_view')
    @include('customerComponents.rental.rental_delete')
    @include('customerComponents.rental.rental_update')

@endsection

