<?php

namespace App\Http\Controllers\Frontend;

use App\Models\Car;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class PageController extends Controller
{
    public function homePage(Request $request)
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
        return view('Home.homePage', compact('cars'));
    }

    public function about()
    {
        return view('Home.about');
    }
    public function contactUs()
    {
        return view('Home.contact');
    }

    public function rentals()
    {
        return view('frontend.rentals');
    }

    public function contact()
    {
        return view('frontend.contact');
    }

    

}
