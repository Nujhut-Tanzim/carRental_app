@extends('adminLayout.sidenav-layout')
@section('content')
<div class="container-fluid">
    <div class="card mt-4 p-4 shadow-sm">
        <h5 class="card-title mb-3">Booking Car</h5>
        <form id="save-form">
            <div class="row">
                <input type="hidden" class="form-control" id="carId" value="{{$car->id}}">
            </div>

            <div class="row">
                <div class="col-12 col-md-6 mb-3">
                    <label for="customerName" class="form-label">Customer Name</label>
                    <select id="customerName" class="form-select">
                        <option value="">Select Customer Name</option>
                        @foreach($customers as $customer)
                        <option value="{{ $customer->name }}">{{ $customer->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-12 col-md-6 mb-3">
                    <label for="customerEmail" class="form-label">Customer Email</label>
                    <select id="customerEmail" class="form-select">
                        <option value="">Select Customer Email</option>
                        @foreach($customers as $customer)
                        <option value="{{ $customer->email }}">{{ $customer->email }}</option>
                        @endforeach
                    </select>
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
        const name = document.getElementById("customerName").value;
        const email = document.getElementById("customerEmail").value;
        const car_id = document.getElementById("carId").value;
        const start_date = document.getElementById("startDate").value;
        const end_date = document.getElementById("endDate").value;
        console.log(start_date);
        showLoader();
        try {
            const res = await axios.post("/rentalStore", {
                car_id: car_id,
                name: name,
                email: email,
                start_date: start_date,
                end_date: end_date
            });
            hideLoader();

            if (res.status === 201) {
                successToast("Car Book successfully");
                document.getElementById("save-form").reset();
                window.location.href = '/adminCarPage'; // Redirect to customer list
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
        window.location.href = '/adminCarPage'; // Redirect to customer list
    }
</script>