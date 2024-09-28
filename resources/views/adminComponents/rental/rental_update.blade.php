<div class="modal animated zoomIn" id="update-modal1" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-md modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Update Rental</h5>
            </div>
            <div class="modal-body">
                <form id="update-form">
                    <div class="container">
                        <div class="row">
                            <div class="col-12 p-1">
                                <label class="form-label">Status</label>
                                <input type="text" class="form-control" id="showStatus" name="showStatus" readonly>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12 p-1">
                                <label class="form-label"> Change Status *</label>
                                <select class="form-select" id="status_value">
                                    <option>Select an option</option>
                                    <option value="Pending">Pending</option>
                                    <option value="Ongoing">Ongoing</option>
                                    <option value="Completed">Completed</option>
                                    <option value="Canceled">Canceled</option>
                                </select>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12 p-1">
                                <label class="form-label">Start Date *</label>
                                <input type="date" class="form-control" id="startDate" name="startDate" onchange="totalCost()">
                                <input class="d-none" id="updateID">
                                <input class="d-none" id="carID">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12 p-1">
                                <label class="form-label">End Date *</label>
                                <input type="date" class="form-control" id="endDate" name="endDate" onchange="totalCost()">
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-12 p-1">
                                <label class="form-label">Total Cost</label>
                                <input type="text" class="form-control" id="total_cost" readonly>
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
        try {
            let id = document.getElementById("updateID").value;
            let car_id = document.getElementById("carID").value;
            let start_date = document.getElementById("startDate").value;
            let end_date = document.getElementById("endDate").value;
            let status = document.getElementById("status_value").value;
            let oldStatus = document.getElementById("showStatus").value;
            console.log(status);


            if (start_date.length === 0) {
                errorToast("Start_Date is required");
            } else if (end_date.length === 0) {
                errorToast("End Date is required");
            } else {

                document.getElementById("update-modal-close").click();
                showLoader();
                if (status == "Select an option") {
                    let res = await axios.post("/rentalUpdate", {
                        car_id: car_id,
                        id: id,
                        start_date: start_date,
                        end_date: end_date,
                        status: oldStatus
                    });
                    hideLoader();
                    if (res.status === 200 && res.data['status'] === "success") {
                        successToast("Update Successful");
                        document.getElementById("update-form").reset();
                        await getRentalList();
                    } else {
                        errorToast(res.data['message']);
                    }

                } else {
                    let res = await axios.post("/rentalUpdate", {
                        car_id: car_id,
                        id: id,
                        start_date: start_date,
                        end_date: end_date,
                        status: status
                    });
                    hideLoader();
                    if (res.status === 200 && res.data['status'] === "success") {
                        successToast("Update Successful");
                        document.getElementById("update-form").reset();
                        await getRentalList();
                    } else {
                        errorToast(res.data['message']);
                    }
                }
            }
        } catch (error) {
            hideLoader();
            if (error.response) {
                errorToast(error.response.data.message || "An error occurred. Please try again.");
            } else {
                errorToast("No response from server. Please try again.");
            }
        }
    }

    async function totalCost() {
        try {
            let start_date = document.getElementById("startDate").value;
            let end_date = document.getElementById("endDate").value;
            let id = document.getElementById("carID").value;
            let res1 = await axios.post("/getTotalCost", {
                id: id,
                start_date: start_date,
                end_date: end_date
            });
            if (res1.status === 200 && res1.data['status'] === "success") {
                let data = res1.data;
                let price = data['data'];
                document.getElementById("total_cost").value = price;
            } else {
                errorToast(res1.data['message']);
            }
        } catch (error) {
            hideLoader();
            if (error.response) {
                errorToast(error.response.data.message || "An error occurred. Please try again.");
            } else {
                errorToast("No response from server. Please try again.");
            }
        }
    }
</script>