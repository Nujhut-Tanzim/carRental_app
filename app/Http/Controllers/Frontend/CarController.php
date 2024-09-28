<?php

namespace App\Http\Controllers\Frontend;

use App\Models\Car;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CarController extends Controller
{

    public function filter(Request $request)
    {
        $query = Car::query()->where('availability', true);

        if ($request->filled('car_type')) {
            $query->where('car_type', $request->car_type);
        }

        if ($request->filled('brand')) {
            $query->where('brand', $request->brand);
        }

        if ($request->filled('min_price') && $request->filled('max_price')) {
            $query->whereBetween('daily_rent_price', [$request->min_price, $request->max_price]);
        }

        $cars = $query->get();
        return response()->json($cars);
    }

    public function getCarTypes()
    {
        
        $carTypes = Car::select('car_type')->distinct()->get();
        return response()->json($carTypes);
    }
    public function getCarBrands()
    {
        
        $carBrands = Car::select('brand')->distinct()->get();
        return response()->json($carBrands);
    }

    function CarById(Request $request)
    {
        $car_id = $request->input('id');
        $car=Car::where('id', '=', $car_id)->first();

        return response()->json([
            'status' => 'success',
            'message' => 'Request Successful',
            'data' => $car,
        ], 200);
    }
    function CarInfo(Request $request)
    {
        $car_id = $request->input('id');
        $car=Car::where('id', '=', $car_id)->first();
        return view("Home.carInfo",compact("car"));
        
    }
}
