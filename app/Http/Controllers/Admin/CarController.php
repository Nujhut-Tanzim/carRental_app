<?php

namespace App\Http\Controllers\Admin;

use Carbon\Carbon;
use App\Models\Car;
use App\Models\Rental;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\File;

class CarController extends Controller
{



    function totalCar()
    {
        $count = Car::count();

        return response()->json(["count" => $count]);
    }

    function totalAvailableCar()
    {
        $query = Car::query()->where('availability', true);
        $countCar = $query->count();
        return response()->json(["count" => $countCar]);
    }
    function CarPage()
    {
        return view('adminPages.Car.carPage');
    }

    function index(Request $request)
    {
        $rentals = Rental::with('user', 'car')->get();

        $currentDate = Carbon::now()->toDateString();

        foreach ($rentals as $rental) {

            $startDate = $rental->start_date;
            $endDate = $rental->end_date;
            if ($rental->status === 'Pending' && $currentDate >= $startDate && $currentDate <= $endDate) {

                $rental->update(['status' => 'Ongoing']);


                if ($rental->car->availability) {
                    $rental->car->availability = false;
                    $rental->car->save();
                }
            }

            if ($rental->status === 'Ongoing' && $currentDate > $endDate) {

                $rental->update(['status' => 'Completed']);


                $ongoingRentals = Rental::where('car_id', $rental->car_id)
                    ->where('status', 'Ongoing')
                    ->where('id', '!=', $rental->id)
                    ->exists();


                if (!$ongoingRentals) {
                    $rental->car->availability = true;
                    $rental->car->save();
                }
            }
        }
        return Car::all();
    }

    public function create()
    {
        return view('adminComponents.car.car_create');
    }

    function store(Request $request)
    {
        $user_id = $request->header('id');
        $img = $request->file('image');
        $t = time();
        $file_name = $img->getClientOriginalName();
        $img_name = "{$user_id}-{$t}-{$file_name}";
        $img_url = "uploads/{$img_name}";

        $img->move(public_path('uploads'), $img_name);

        $name = $request->input('name');
        $brand = $request->input('brand');
        $model = $request->input('model');
        $year = $request->input('year');
        $car_type = $request->input('car_type');
        $daily_rent_price = $request->input('daily_rent_price');
        Car::create([
            'name' => $name,
            'brand' => $brand,
            'model' => $model,
            'year' => $year,
            'car_type' => $car_type,
            'daily_rent_price' => $daily_rent_price,
            'image' => $img_url
        ]);
        return response()->json([
            "status" => "success",
            "message" => "Add Car Successful"
        ], 201);
    }

    public function edit(Request $request)
    {
        $id = $request->input("id");
        return Car::where("id", "=", $id)->first();
    }

    function update(Request $request)
    {
        $user_id = $request->header('id');
        $car_id = $request->input('id');
        $name = $request->input('name');
        $brand = $request->input('brand');
        $model = $request->input('model');
        $year = $request->input('year');
        $car_type = $request->input('car_type');
        $daily_rent_price = $request->input('daily_rent_price');

        if ($request->hasFile('img')) {
            $img = $request->file('img');
            $t = time();
            $file_name = $img->getClientOriginalName();
            $img_name = "{$user_id}-{$t}-{$file_name}";
            $img_url = "uploads/{$img_name}";

            $img->move(public_path('uploads'), $img_name);
            $filePath = $request->input("file_path");
            File::delete($filePath);

            Car::where('id', '=', $car_id)->update([
                'name' => $name,
                'brand' => $brand,
                'model' => $model,
                'year' => $year,
                'car_type' => $car_type,
                'daily_rent_price' => $daily_rent_price,
                'image' => $img_url

            ]);
            return response()->json([
                'status' => 'success',
                'message' => 'Request Successful',
            ], 200);
        } else {

            Car::where('id', '=', $car_id)->update([
                'name' => $name,
                'brand' => $brand,
                'model' => $model,
                'year' => $year,
                'car_type' => $car_type,
                'daily_rent_price' => $daily_rent_price
            ]);

            return response()->json([
                'status' => 'success',
                'message' => 'Request Successful',
            ], 200);
        }
    }
    function delete(Request $request)
    {
        $car_id = $request->input('id');
        $filePath = $request->input("file_path");
        File::delete($filePath);

        if (Rental::where('car_id', $car_id)->exists()) {
            return response()->json(['message' => 'Cannot delete car with active rentals.'], 200);
        }

        Car::where('id', '=', $car_id)->delete();
        return response()->json([
            'status' => 'success',
            'message' => 'Request Successful',
        ], 200);
    }

    function CarById(Request $request)
    {
        $car_id = $request->input('id');
        $car = Car::where('id', '=', $car_id)->first();

        return response()->json([
            'status' => 'success',
            'message' => 'Request Successful',
            'data' => $car,
        ], 200);
    }
}
