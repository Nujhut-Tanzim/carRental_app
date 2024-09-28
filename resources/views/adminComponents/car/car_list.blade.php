<div class="container-fluid">
    <div class="row">
        <div class="col-md-12 col-sm-12 col-lg-12">
            <div class="card px-5 py-5">
                <div class="row justify-content-between ">
                    <div class="align-items-center col">
                        <h4>Cars</h4>
                    </div>
                    <div class="align-items-center col text-end">
                        <button type="button" class="btn m-0 bg-gradient-primary" onclick="create()">Create</button>
                    </div>
                </div>
                <hr class="bg-secondary" />
                <div class="table-responsive">
                    <table class="table" id="tableData">
                        <thead>
                            <tr class="bg-light">
                                <th>No</th>
                                <th>Image</th>
                                <th>Name</th>
                                <th>Availability</th>
                                <th>Daily_price</th>
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
    function create() {
        window.location.href = "/carCreate";
    }

    getCarList();
    async function getCarList() {
        showLoader();
        let res = await axios.get("/carList");
        hideLoader();
        let tableList = $("#tableList");
        let tableData = $("#tableData");
        tableData.DataTable().destroy();
        tableList.empty();

        res.data.forEach(function(item, index) {
            let availabilityText = item['availability'] == 1 ? 'Yes' : 'No';
            let row = `<tr>
                        <td>${index+1}</td>
                        <td><img class="w-90 h-auto" alt="" src="${item['image']}"></td>
                        <td>${item['name']}</td>
                        <td>${availabilityText}</td>
                        <td>${item['daily_rent_price']}</td>
                        <td>
                            <button data-id="${item['id']}" class="btn bookBtn btn-sm btn-outline-success">Book</button>
                            <button data-id="${item['id']}" class="btn viewBtn btn-sm btn-outline-success" >View</button>
                            <button data-path="${item['image']}" data-id="${item['id']}" class="btn editBtn btn-sm btn-outline-success" >Edit</button>
                            <button data-path="${item['image']}"data-id="${item['id']}" class="btn deleteBtn btn-sm btn-outline-danger">Delete</button>
                        </td>
                    </tr>`
            tableList.append(row);

        })
        $(".viewBtn").on('click', async function() {
            let id = $(this).data('id');
            let res1 = await axios.get("/carById", {
                params: {
                    id: id
                }
            });
            if (res1.status === 200 && res1.data['status'] === "success") {
                let data = res1.data['data'];
                let name = data['name'];
                let brand = data['brand'];
                let model = data['model'];
                let year = data['year'];
                let type = data['car_type'];
                let price = data['daily_rent_price'];
                let availability = data['availability'];

                let image = data['image'];
                console.log(image);

                //console.log(carImageUrl);

                $("#view-modal").modal("show");
                $("#name").text(name);
                $("#brand").text("Brand: " + brand);
                $("#model").text("Model: " + model);
                $("#year").text("Year: " + year);
                $("#car_type").text("Car Type: " + type);
                $("#daily_rent_price").text("Rent Price: " + price);
                $("#availability").text("Availability: " + availability);
                $("#imageElement").attr("src", image);

            } else {
                errorToast("Car not present");
            }

        })

        $(".editBtn").on('click', async function() {
            let id = $(this).data('id');
            let filePath = $(this).data('path');
            await FillUpUpdateForm(id, filePath);
            $("#update-modal").modal('show');


        })
        $(".bookBtn").on('click', async function() {
            let id = $(this).data('id');
            console.log("Using ID: ", id);
            window.location.href = `/rentalCreate?id=${id}`;
        });


        $(".deleteBtn").on('click', function() {
            let id = $(this).data('id');
            let filePath = $(this).data('path');
            $("#delete-modal").modal("show");
            $("#deleteID").val(id);
            $("#deleteFilePath").val(filePath);
        })

        let table = new DataTable('#tableData', {
            order: [
                [0, 'asc']
            ],
            lengthMenu: [5, 10, 15, 20]
        });





    }

    
</script>