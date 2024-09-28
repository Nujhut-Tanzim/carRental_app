<div class="modal animated zoomIn" id="update-modal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-md modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Update Customer</h5>
            </div>
            <div class="modal-body">
                <form id="update-form">
                    <div class="container">
                        <div class="row">
                            <div class="col-12 p-1">
                                <label class="form-label">Customer Name *</label>
                                <input type="text" class="form-control" id="name">
                                <input class="d-none" id="updateID">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12 p-1">
                                <label class="form-label">Customer Email *</label>
                                <input type="text" class="form-control" id="email">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12 p-1">
                                <label class="form-label">Customer password *</label>
                                <input type="password" class="form-control" id="password">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12 p-1">
                                <label class="form-label">Customer Mobile *</label>
                                <input type="text" class="form-control" id="phone">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12 p-1">
                                <label class="form-label">Customer Address *</label>
                                <input type="text" class="form-control" id="address">
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button id="update-modal-close" class="btn bg-gradient-primary" data-bs-dismiss="modal" aria-label="Close">Close</button>
                <button onclick="Update()" id="update-btn" class="btn bg-gradient-success">Update</button>
            </div>
        </div>
    </div>
</div>

<script>
    async function Update() {
        let id = document.getElementById("updateID").value;
        let name = document.getElementById("name").value;
        let email = document.getElementById("email").value;
        let password = document.getElementById("password").value;
        let phone = document.getElementById("phone").value;
        let address = document.getElementById("address").value;

        if (name.length === 0) {
            errorToast("Name is required");
        } else if (email.length === 0) {
            errorToast("Email is required");
        } else if (password.length === 0) {
            errorToast("password is required");
        } else if (phone.length === 0) {
            errorToast("Mobile is required");
        } else if (address.length === 0) {
            errorToast("Address is required");
        } else {

            document.getElementById("update-modal-close").click();
            showLoader();
            let res = await axios.post("/customerUpdate", {
                id: id,
                name: name,
                email: email,
                password: password,
                phone: phone,
                address: address
            });
            hideLoader();
            if (res.status === 200 && res.data['status'] === "success") {
                successToast("Update Successful");
                document.getElementById("update-form").reset();
                await getCustomerList();
            } else {
                errorToast("Update Failed");
            }
        }
    }
</script>