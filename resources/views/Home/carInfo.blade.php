@extends('Home.homeLayout')

@section('content')
<div class="container-fluid mt-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            @if($car)
            <div class="card shadow-lg mt-4">
                <div class="card-header d-flex justify-content-between align-items-center bg-primary text-white " style="height: 60px;">
                    <a href="{{ route('home') }}" class="" style="color:black"><b>Back</b></a>
                    <h2 class="text-center flex-grow-1">Car Information</h2>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6 text-center mb-3">
                            <img src="{{ asset($car->image) }}" class="img-fluid rounded" alt="Car Image">
                        </div>
                        <!-- Car Details -->
                        <div class="col-md-6">
                            <h4 class="card-title">Car Name: {{ $car->name }}</h4>
                            <p><strong>Brand:</strong> {{ $car->brand }}</p>
                            <p><strong>Model:</strong> {{ $car->model }}</p>
                            <p><strong>Car Type:</strong> {{ $car->car_type }}</p>
                            <p><strong>Year:</strong> {{ $car->year }}</p>
                            @if($car->availability==1)
                            <p class="card-text"><strong>Availability:</strong> Yes</p>
                            @else
                            <p class="card-text"><strong>Availability:</strong> No</p>
                            @endif
                            <p><strong>Cost Per Day:</strong> ${{ $car->daily_rent_price }}</p>
                        </div>
                    </div>
                </div>
            </div>
            @else
            <div class="alert alert-danger text-center">
                <strong>Error:</strong> Car not found.
            </div>
            @endif
        </div>
    </div>
</div>
@endsection