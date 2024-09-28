@extends('Home.homeLayout')

@section('content')
<div class="container-fluid">
    @if($cars->isNotEmpty())
    <div class="row">
        @foreach($cars as $car)
        <div class="col-sm-6 col-md-4 col-lg-4 mb-4">
            <div class="card" style="width: 100%; height: 440px;">
                <img src="{{ asset($car->image) }}" class="card-img-top mt-2 w-100" alt="{{ $car->name }}" style="height: 190px;object-fit: cover;">
                <div class="card-body text-center" style="height: calc(440px - 190px);">
                    <h5 class="card-title">{{ $car->name }}</h5>
                    <hr>
                    <div class="row">
                        <div class="col-6">
                            <p class="card-text">Brand: {{ $car->brand }}</p>
                        </div>
                        <div class="col-6">
                            <p class="card-text">Type: {{ $car->car_type }}</p>
                        </div>
                    </div>
                    <div class="row mt-1">
                        <div class="col-6">
                            <p class="card-text">Daily Rent: ${{ $car->daily_rent_price }}</p>
                        </div>
                        <div class="col-6">
                            @if($car->availability==1)
                            <p class="card-text">Availability: Yes</p>
                            @else
                            <p class="card-text">Availability: No</p>
                            @endif
                        </div>
                    </div>
                    <hr>
                    <div class="row mt-2">
                        <div class="col-6">
                            <form action="{{ route('carInfo') }}" method="POST">
                                @csrf
                                <input type="hidden" name="id" value="{{ $car->id }}" id="id">
                                <button type="submit" class="btn btn-primary" style="width:100%">
                                    More Info
                                </button>
                            </form>
                        </div>
                        <div class="col-6">
                        <form action="{{ route('carBook') }}" method="POST">
                                @csrf
                                <input type="hidden" name="id" value="{{ $car->id }}" id="id">
                                <button type="submit" class="btn btn-primary" style="width:100%">
                                    Booking
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @endforeach
    </div>
    @else
    <div class="col-12">
        <p class="text-center">No results found.</p>
    </div>
    @endif
</div>

@endsection