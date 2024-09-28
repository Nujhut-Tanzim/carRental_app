<div class="container-fluid">
    <div class="row">
        <div class="col-md-12 col-sm-12 col-lg-12">
            <div class="card px-5 py-5">
                <div class="row justify-content-between ">
                    <div class="align-items-center col">
                        <h4>Cars Rentals</h4>
                    </div>
                </div>
                <hr class="bg-secondary" />
                <div class="table-responsive">
                    <table class="table" id="tableData">
                        <thead>
                            <tr class="bg-light">
                                <th>No</th>
                                <th>Customer Name</th>
                                <th>Car Name</th>
                                <th>Start Date</th>
                                <th>End Date</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody id="tableList">

                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    getRentalList();
    async function getRentalList() {
        showLoader();
        let res = await axios.get("/customerRentalList");
        hideLoader();
        let tableList = $("#tableList");
        let tableData = $("#tableData");
        tableData.DataTable().destroy();
        tableList.empty();

        res.data.forEach(function(item, index) {
            let row = `<tr>
                        <td>${index+1}</td>
                        <td>${item.user['name']}</td>
                        <td>${item.car['name']}</td>
                        <td>${item['start_date']}</td>
                        <td>${item['end_date']}</td>
                        <td>${item['status']}</td>
                        <td>
                            <button data-id="${item['id']}" class="btn viewBtn btn-sm btn-outline-success" >View</button>
                            <button  data-id="${item['id']}" class="btn editBtn btn-sm btn-outline-success" >Edit</button>
                            <button data-status="${item['status']}" data-id="${item['id']}" class="btn deleteBtn btn-sm btn-outline-danger">Delete</button>
                        </td>
                    </tr>`
            tableList.append(row);

        });
        $(".viewBtn").on('click', async function() {
            let id = $(this).data('id');
            let res1 = await axios.get("/customerRentalById", {
                params: {
                    id: id
                }
            });
            if (res1.status === 200 && res1.data['status'] === "success") {
                let data = res1.data['data'];
                let customerName = data.user['name'];
                let carName = data.car['name'];
                let brand = data.car['brand'];
                let start_date = data['start_date'];
                let end_date = data['end_date'];
                let price = data['total_cost'];
                let status = data['status'];

                $("#view-modal1").modal("show");
                $("#customerName").val(customerName);
                $("#carName").val(carName);
                $("#brand").val(brand);
                $("#start_date").val(start_date);
                $("#end_date").val(end_date);
                $("#price").val(price);
                $("#status").val(status);


            } else {
                errorToast("Car not present");
            }

        });

        $(".editBtn").on('click', async function() {
            let id = $(this).data('id');
            let res1 = await axios.get("/customerRentalEdit", {
                params: {
                    id: id
                }
            });
            if (res1.status === 200 && res1.data['status'] === "success") {
                let data = res1.data['data'];
                let start_date = data['start_date'];
                let end_date = data['end_date'];
                let statusvalue = data['status'];
                let cost = data['total_cost'];
                let car_id = data.car['id'];

                console.log(start_date);

                $("#update-modal1").modal("show");
                $("#updateID").val(id);
                $("#carID").val(car_id);
                $("#startDate").val(start_date);
                $("#endDate").val(end_date);
                $("#total_cost").val(cost);
                $("#showStatus").val(statusvalue);
            } else {
                errorToast("Rental not present");
            }


        })

        $(".deleteBtn").on('click', function() {
            let id = $(this).data('id');
            let status1 = $(this).data('status');
            $("#delete-modal").modal("show");
            $("#deleteID").val(id);
            $("#statusValue").val(status1);

        })

        let table = new DataTable('#tableData', {
            order: [
                [0, 'asc']
            ],
            lengthMenu: [5, 10, 15, 20]
        });





    }
</script>