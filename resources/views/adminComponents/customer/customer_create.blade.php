@extends('adminLayout.sidenav-layout')
@section('content')
<div class="container-fluid">
    <div class="card mt-4 p-4">
        <h5>Create Customer</h5>
        <form id="save-form">
            <div class="row">
                <div class="col-12 col-md-6 p-1">
                    <label class="form-label">Name</label>
                    <input type="text" class="form-control" id="name" required>
                </div>
                <div class="col-12 col-md-6 p-1">
                    <label class="form-label">Email</label>
                    <input type="email" class="form-control" id="email" required>
                </div>
            </div>
            <div class="row">
                <div class="col-12 col-md-6 p-1">
                    <label class="form-label">Password</label>
                    <input type="password" class="form-control" id="password" required>
                </div>
                <div class="col-12 col-md-6 p-1">
                    <label class="form-label">Mobile</label>
                    <input type="text" class="form-control" id="phone" required>
                </div>
            </div>
            <div class="row">
                <div class="col-6 p-1">
                    <label class="form-label">Address</label>
                    <input type="text" class="form-control" id="address" required>
                </div>
            </div>
            <div class="text-start mt-3">
                <button type="button" onclick="Close()" class="btn bg-gradient-secondary">Close</button>
                <button type="button" onclick="Save()" class="btn bg-gradient-success">Save</button>
            </div>
        </form>
    </div>
</div>
@endsection

<script>
    async function Save() {
        const name = document.getElementById("name").value;
        const email = document.getElementById("email").value;
        const password = document.getElementById("password").value;
        const phone = document.getElementById("phone").value;
        const address = document.getElementById("address").value;

        // No need for length checks if using required attribute

        showLoader();
        try {
            const res = await axios.post("/customerStore", {
                name: name,
                email: email,
                password: password,
                phone: phone,
                address: address
            });
            hideLoader();

            if (res.status === 201) {
                successToast("Customer added successfully");
                document.getElementById("save-form").reset();
                window.location.href = '/adminCustomerPage'; // Redirect to customer list
            } else {
                errorToast("Add Customer Failed");
            }
        } catch (error) {
            hideLoader();
            errorToast("An error occurred. Please try again.");
        }
    }

    function Close() {
       window.location.href = '/adminCustomerPage'; // Redirect to customer list
    }
</script>
