<?php

namespace App\Http\Controllers\Frontend;

use Carbon\Carbon;
use App\Models\Car;
use App\Models\User;
use App\Models\Rental;
use Illuminate\Http\Request;
use App\Mail\OwnerNotification;
use App\Mail\RentalNotification;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Mail;

class RentalController extends Controller
{
    function rentalPage()
    {
        return view('customerPages.rental.rentalPage');
    }
    public function index(Request $request)
    {
        $customer_id = $request->header('id');
        $rentals = Rental::with('user', 'car')->where('user_id', '=', $customer_id)->get();

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

        return $rentals;
    }

    public function create(Request $request)
    {
        $car_id = $request->input("id");
        $user_id = $request->header('id');
        $car = Car::where('id', $car_id)->first();
        $customer = User::where('role', 'customer')->where('id', '=', $user_id)->first();
        return view('customerComponents.rental.rental_book', compact('car', 'customer'));
    }

    public function store(Request $request)
    {

        $carId = $request->car_id;
        $userId = $request->customer_id;
        $user_name = $request->input("name");
        $user_email = $request->input("email");
        $startDate = $request->start_date;
        $endDate = $request->end_date;

        $rentals = Rental::where('car_id', $carId)
            ->whereIn('status', ["Pending", "Ongoing"])
            ->get();

        $isAvailable = true;
        if ($rentals->isNotEmpty()) {

            foreach ($rentals as $rental) {
                if (
                    ($startDate <= $rental->start_date && $endDate >= $rental->start_date) ||
                    ($startDate <= $rental->end_date && $endDate >= $rental->end_date) ||
                    ($rental->start_date <= $startDate && $rental->end_date >= $startDate) ||
                    ($rental->start_date <= $endDate && $rental->end_date >= $endDate)

                ) {
                    $isAvailable = false;
                    break;
                }
            }
        }

        if ($isAvailable == false) {
            return response()->json(
                [
                    'status' => "failed",
                    "message" => 'Rental Date is not available.'
                ],
                404
            );
        } else {

            $car = Car::findOrFail($carId);
            $days = Carbon::parse($startDate)->diffInDays(Carbon::parse($endDate));
            $days = $days + 1;
            $totalCost = $car->daily_rent_price * $days;


            $rental = new Rental();
            $rental->user_id = $userId;
            $rental->car_id = $carId;
            $rental->start_date = $startDate;
            $rental->end_date = $endDate;
            $rental->total_cost = $totalCost;
            $rental->status = "Pending";
            $rental->save();
            Mail::to($rental->user->email)->send(new RentalNotification($rental));
            $adminEmail = 'nujhattanzim@gmail.com';
            Mail::to($adminEmail)->send(new OwnerNotification($rental));

            return response()->json(
                [
                    'status' => "success",
                    "message" => 'Rental created successfully.'
                ],
                201
            );
        }
    }

    public function edit(Request $request)
    {

        $rental = Rental::with('car')->where("id", "=", $request->input("id"))->first();
        return response()->json(
            [
                'status' => "success",
                "message" => 'Rental show successfully.',
                "data" => $rental
            ],
            200
        );
    }

    public function update(Request $request)
    {
        $car_id = $request->car_id;
        $rental_id = $request->input("id");
        $startDate = $request->start_date;
        $endDate = $request->end_date;
        $rentals =  Rental::where("car_id", "=", $car_id)->where('id', '!=', $rental_id)->get();

        $isAvailable = true;

        foreach ($rentals as $rental) {
            if (
                ($startDate <= $rental->start_date && $endDate >= $rental->start_date) ||
                ($startDate <= $rental->end_date && $endDate >= $rental->end_date) ||
                ($rental->start_date <= $startDate && $rental->end_date >= $startDate) ||
                ($rental->start_date <= $endDate && $rental->end_date >= $endDate)

            ) {
                $isAvailable = false;
                break;
            }
        }
        if (!$isAvailable) {
            return response()->json(
                [
                    'status' => "failed",
                    "message" => 'Rental Date is not available.'
                ],
                200
            );
        }

        $rental = Rental::with("car")->where("id", "=", $rental_id)->first();
        $currentDate = Carbon::now()->toDateString();
        if ($currentDate === $rental->end_date) {

            if ($endDate < $rental->end_date) {

                return response()->json([
                    'message' => 'Cannot update the end date.'
                ], 200);
            }
        }

        $days = Carbon::parse($startDate)->diffInDays(Carbon::parse($endDate));
        $days = $days + 1;

        $totalCost = $days * $rental->car->daily_rent_price;


        $currentDate = Carbon::now()->toDateString();
        if ($request->status === 'Canceled' && $currentDate >= $startDate) {
            return response()->json([
                'status' => 'failed',
                'message' => 'You cannot cancel the rental after the start date.'
            ], 200);
        }
        $rental = Rental::findOrFail($rental_id);


        $rental->update([
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
            'total_cost' => $totalCost,
            'status' => $request->status
        ]);


        if ($request->status === 'Ongoing') {
            $rental->car->update(['availability' => false]);
        } else {
            $rental->car->update(['availability' => true]);
        }

        Mail::to($rental->user->email)->send(new RentalNotification($rental));
        $adminEmail = 'nujhattanzim@gmail.com';
        Mail::to($adminEmail)->send(new OwnerNotification($rental));

        return response()->json(
            [
                'status' => 'success',
                'message' => 'Rental updated successfully.'
            ],
            200
        );
    }

    public function delete(Request $request)
    {
        $id = $request->input("id");
        $status = $request->input("status");
        if ($status === "Canceled") {
            Rental::where("id", "=", $id)->delete();
            return response()->json([
                "status" => "success",
                "message" => "Delete successfully"
            ], 200);
        } else {
            return response()->json([
                "status" => "failed",
                "message" => "First Canceled the Booking"
            ], 200);
        }
    }

    function RentalById(Request $request)
    {
        $rental_id = $request->input('id');
        $rental = Rental::with('user', 'car')->where('id', '=', $rental_id)->first();

        return response()->json([
            'status' => 'success',
            'message' => 'Request Successful',
            'data' => $rental,
        ], 200);
    }

    function getTotalCost(Request $request)
    {
        $car_id = $request->input("id");
        $startDate = $request->start_date;
        $endDate = $request->end_date;
        $car = Car::where('id', '=', $car_id)->first();
        $days = Carbon::parse($startDate)->diffInDays(Carbon::parse($endDate));
        $days = $days + 1;
        $totalCost = $days * $car->daily_rent_price;
        return response()->json([
            'status' => 'success',
            'message' => 'Request Successful',
            'data' => $totalCost
        ], 200);
    }
}
