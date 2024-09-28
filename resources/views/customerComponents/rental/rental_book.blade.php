@extends('adminLayout.sidenav-layout')
@section('content')
<div class="container-fluid">
    <div class="card mt-4 p-4 shadow-sm">
        <h5 class="card-title mb-3">Booking Car</h5>
        <form id="save-form">
            <div class="row">
                <input type="hidden" class="form-control" id="carId" value="{{$car->id}}">
                <input type="hidden" class="form-control" id="customerId" value="{{$customer->id}}">
            </div>

            <div class="row">
                <div class="col-12 col-md-6 mb-3">
                    <label for="customerName" class="form-label">Customer Name</label>
                    <input type="text"class="form-select" id="customer_name" value="{{$customer->name}}" readonly>
                </div>
                <div class="col-12 col-md-6 mb-3">
                    <label for="customerEmail" class="form-label">Customer Email</label>
                    <input type="email" id="customerEmail" class="form-select" value="{{ $customer->email }}" readonly>
                </div>
            </div>

            <div class="row">
                <div class="col-12 col-md-6 mb-3">
                    <label for="carName" class="form-label">Car Name</label>
                    <input type="text" class="form-control" id="carName" value="{{$car->name}}" readonly>
                </div>
                <div class="col-12 col-md-6 mb-3">
                    <label for="carBrand" class="form-label">Car Brand</label>
                    <input type="text" class="form-control" id="carBrand" value="{{$car->brand}}" readonly>
                </div>
            </div>

            <div class="row">
                <div class="col-12 col-md-6 mb-3">
                    <label for="carPrice" class="form-label">Daily Rent Price</label>
                    <input type="text" class="form-control" id="carPrice" value="{{$car->daily_rent_price}}" readonly>
                </div>
            </div>

            <div class="row">
                <div class="col-12 col-md-6 mb-3">
                    <label for="startDate" class="form-label">Start Date</label>
                    <input type="date" id="startDate" name="startDate" class="form-control">
                </div>
                <div class="col-12 col-md-6 mb-3">
                    <label for="endDate" class="form-label">End Date</label>
                    <input type="date" id="endDate" name="endDate" class="form-control">
                </div>
            </div>

            <div class="mt-3">
                <button type="button" onclick="Close()" class="btn btn-secondary">Close</button>
                <button type="button" onclick="Save()" class="btn btn-success ms-1">Save</button>
            </div>
        </form>
    </div>

</div>
@endsection

<script>
    async function Save() {
        const car_id = document.getElementById("carId").value;
        const customer_id = document.getElementById("customerId").value;
        const start_date = document.getElementById("startDate").value;
        const end_date = document.getElementById("endDate").value;
        console.log(start_date);
        showLoader();
        try {
            const res = await axios.post("/customerRentalStore", {
                car_id: car_id,
                customer_id:customer_id,
                start_date: start_date,
                end_date: end_date
            });
            hideLoader();

            if (res.status === 201) {
                successToast("Car Book successfully");
                document.getElementById("save-form").reset();
                window.location.href = '/customerRentalPage'; // Redirect to customer list
            }  
           else
           {
               errorToast("Car Book failed");
           }
    }
        catch (error) {
            hideLoader();
            if (error.response) {
            errorToast(error.response.data.message || "An error occurred. Please try again.");
        } else {
            errorToast("No response from server. Please try again.");
        }
        }
    }

    function Close() {
        window.location.href = '/customerRentalPage'; // Redirect to customer list
    }
</script>