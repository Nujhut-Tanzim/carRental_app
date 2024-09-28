<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Exception;
use App\Models\Rental;

class CustomerController extends Controller
{
    function dashboard()
    {
        return view("adminPages.dashboard.dashboardPage");
    }
    function CustomerPage()
    {
        return view("adminPages.customer.customerPage");
    }

    function totalCustomer()
    {
        $count=User::where('role', 'customer')->count();

        return response()->json(["count"=>$count]);

    }

    function index(Request $request)
    {
        return User::where("role","=","customer")->get();
    }

    function create()
    {
        return view('adminComponents.customer.customer_create');
    }

    function store(Request $request)
    {
        $name = $request->input('name');
        $email = $request->input('email');
        $password = $request->input('password');
        $phone = $request->input('phone');
        $address = $request->input('address');
            User::create([
            'name' => $name,
            'email' => $email,
            'password' => $password,
            'phone'=>$phone,
            'address'=>$address
        ]);

        return response()->json([
            "status"=>"success",
            "message"=>"Add Customer Successful"
        ],201);
    }

    function edit(Request $request)
    {
        $customer=User::where("id","=",$request->input("id"))->first();

        return response()->json([
            'status' => 'success',
            'message' => 'Request Successful',
            'data' => $customer,
        ], 200);
    }
    function update(Request $request)
    {
        $id = $request->input('id');
        $name = $request->input('name');
        $email = $request->input('email');
        $password = $request->input('password');
        $phone = $request->input('phone');
        $address = $request->input('address');
        User::where('id', '=', $id)->update([
            'name' => $name,
            'email' => $email,
            'password' => $password,
            'phone'=>$phone,
            'address'=>$address
        ]);
        return response()->json([
            'status' => 'success',
            'message' => 'Update Successful'
        ], 200);
        
    }

    function delete(Request $request)
    {
    
        $id = $request->input('id');
        if (Rental::where('user_id', $id)->exists()) {
            return response()->json(['message' => 'Cannot delete customer with active rentals.'], 200);
        }
        User::where('id', '=', $id)->delete();
        return response()->json([
            'status' => 'success',
            'message' => 'Delete Successful'
        ], 200);
    }

    function customerById(Request $request)
    {
        try{
            $id = $request->query('id');
            $Customer = User::where('id', '=', $id)->first();
            return response()->json([
                'status' => 'success',
                'message' => 'Request Successful',
                'data' => $Customer,
            ], 200);
        } catch (Exception $e) {
            return response()->json([
                'status' => 'failed',
                'message' => 'Request failed',
            ], 200);
        }
    }

}
