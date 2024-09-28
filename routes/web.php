<?php

use App\Models\Car;

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Middleware\AdminMiddleware;
use App\Http\Middleware\CustomerMiddleware;
use App\Http\Controllers\Admin\CarController;
use App\Http\Controllers\Frontend\PageController;
use App\Http\Controllers\Admin\CustomerController;
use App\Http\Middleware\TokenVerificationMiddleware;
use App\Http\Middleware\TokenVerificationPassMiddleware;
use App\Http\Controllers\Admin\RentalController as adminRentalController;
use App\Http\Controllers\Frontend\CarController as customerCarController;
use App\Http\Controllers\Frontend\RentalController as customerRentalController;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/home', [PageController::class,'homePage'])->name("home");
Route::post('/carInfo', [customerCarController::class,'CarInfo'])->name("carInfo");
Route::get('/carTypes', [customerCarController::class, 'getCarTypes'])->name('carTypes');
Route::get('/carBrands', [customerCarController::class, 'getCarBrands'])->name('carBrands');
Route::get('/about', [PageController::class, 'about'])->name('about');
Route::get('/contact', [PageController::class, 'contactUs'])->name('contact');

Route::get('/userLogin',[UserController::class,'LoginPage']);
Route::get('/userRegistration',[UserController::class,'RegistrationPage']);
Route::get('/sendOtp',[UserController::class,'SendOtpPage']);
Route::get('/verifyOtp',[UserController::class,'VerifyOTPPage']);
Route::get('/resetPassword',[UserController::class,'ResetPasswordPage'])->middleware(middleware: [TokenVerificationPassMiddleware::class]);

//Route::get('/searchCar', [CarController::class, 'carSearch'])->name('searchCar');;
Route::post('/user-registration', [UserController::class, 'UserRegistration']);
Route::post('/user-login', [UserController::class, 'UserLogin']);
Route::post('/send-otp', [UserController::class, 'SendOTPCode']);
Route::post('/verify-otp', [UserController::class, "VerifyOTP"]);
Route::post('/reset-password', [UserController::class, 'ResetPass'])->middleware([TokenVerificationPassMiddleware::class]);
Route::get('/user-profile',[UserController::class,'UserProfile'])->middleware([TokenVerificationMiddleware::class]);
Route::post('/user-update',[UserController::class,'UpdateProfile'])->middleware([TokenVerificationMiddleware::class]);
Route::get('/userProfile',[UserController::class,'ProfilePage'])->middleware([TokenVerificationMiddleware::class]);
Route::get('/logout', [UserController::class, 'UserLogout'])->middleware([TokenVerificationMiddleware::class]);


Route::middleware([TokenVerificationMiddleware::class,AdminMiddleware::class])->group(function () {

Route::get('/adminDashboard', [CustomerController::class, 'dashboard'])->name("adminDashboard");

//adminCustomer
Route::get('/totalCustomer', [CustomerController::class, 'totalCustomer']);
Route::post('/totalSale', [adminRentalController::class, 'totalSale']);
Route::get('/adminCustomerPage', [CustomerController::class, 'CustomerPage']);
Route::get('/customerList', [CustomerController::class, 'index']);
Route::get('/customerCreate', [CustomerController::class, 'create']);
Route::post('/customerStore', [CustomerController::class, 'store']);
Route::get('/customerEdit', [CustomerController::class, 'edit'])->name("customerEdit");
Route::post('/customerUpdate', [CustomerController::class, 'update']);
Route::post('/customerDelete', [CustomerController::class, 'delete']);
Route::get('/customerById', [CustomerController::class, 'CustomerById']);

//adminCar
Route::get('/totalCar', [CarController::class, 'totalCar']);
Route::get('/totalAvailableCar', [CarController::class, 'totalAvailableCar']);
Route::get('/adminCarPage', [CarController::class, 'CarPage']);
Route::get('/carList', [CarController::class, 'index']);
Route::get('/carCreate', [CarController::class, 'create']);
Route::post('/carStore', [CarController::class, 'store']);
Route::get('/carEdit', [CarController::class, 'edit']);
Route::post('/carUpdate', [CarController::class, 'update']);
Route::post('/carDelete', [CarController::class, 'delete']);
Route::get('/carById', [CarController::class, 'CarById']);

Route::get('/totalRental', [adminRentalController::class, 'totalRental']);
Route::get('/totalSale', [adminRentalController::class, 'totalSale']);
Route::get('/adminRentalPage', [adminRentalController::class, 'rentalPage']);
Route::get('/rentalList', [adminRentalController::class, 'index']);
Route::get('/rentalCreate', [adminRentalController::class, 'create'])->name("rentalCreate");
Route::post('/rentalStore', [adminRentalController::class, 'store']);
Route::get('/rentalEdit', [adminRentalController::class, 'edit']);
Route::post('/rentalUpdate', [adminRentalController::class, 'update']);
Route::post('/rentalDelete', [adminRentalController::class, 'delete']);
Route::get('/rentalById', [adminRentalController::class, 'RentalById']);
Route::post('/getTotalCost',[adminRentalController::class,'getTotalCost']);
});


Route::middleware([TokenVerificationMiddleware::class,CustomerMiddleware::class])->group(function () {


Route::post('/carBook', [customerRentalController::class,'create'])->name("carBook")->middleware(middleware: [TokenVerificationMiddleware::class]);;
//customer
Route::get('/customerRentalPage', [customerRentalController::class, 'rentalPage'])->middleware([TokenVerificationMiddleware::class]);
Route::get('/customerRentalList', [customerRentalController::class, 'index'])->middleware([TokenVerificationMiddleware::class]);
Route::post('/customerRentalStore', [customerRentalController::class, 'store'])->middleware([TokenVerificationMiddleware::class]);
Route::get('/customerRentalEdit', [customerRentalController::class, 'edit'])->middleware([TokenVerificationMiddleware::class]);
Route::post('/customerRentalUpdate', [customerRentalController::class, 'update'])->middleware([TokenVerificationMiddleware::class]);
Route::post('/customerRentalDelete', [customerRentalController::class, 'delete'])->middleware([TokenVerificationMiddleware::class]);
Route::get('/customerRentalById', [customerRentalController::class, 'RentalById'])->middleware([TokenVerificationMiddleware::class]);
Route::post('/customerGetTotalCost',[customerRentalController::class,'getTotalCost']);
});