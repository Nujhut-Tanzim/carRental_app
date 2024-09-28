<div class="container-fluid">
    <div class="row">
        <div class="col-md-12 col-sm-12 col-lg-12">
            <div class="card px-5 py-5">
                <div class="row justify-content-between ">
                    <div class="align-items-center col">
                        <h4>Customers</h4>
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
                                <th>Name</th>
                                <th>Email</th>
                                <th>Phone</th>
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
        window.location.href = "/customerCreate";
    }

    getCustomerList();
    async function getCustomerList() {
        showLoader();
        let res = await axios.get("/customerList");
        hideLoader();
        let tableList = $("#tableList");
        let tableData = $("#tableData");
        tableData.DataTable().destroy();
        tableList.empty();

        res.data.forEach(function(item, index) {
            let user_id = item['id'];

            let row = `<tr>
                        <td>${index+1}</td>
                        <td>${item['name']}</td>
                        <td>${item['email']}</td>
                        <td>${item['phone']}</td>
                        <td>
                            <button data-id="${item['id']}" class="btn viewBtn btn-sm btn-outline-success mr-2">View</button>
                            <button data-id="${item['id']}" class="btn editBtn btn-sm btn-outline-success mr-2">Update</button>
                            <button data-id="${item['id']}" class="btn deleteBtn btn-sm btn-outline-danger ms-1">Delete</button>
                
                        </td>
                    </tr>`
            tableList.append(row);

        })

        $(".viewBtn").on('click', async function() {
            let id = $(this).data('id');
            let res1 = await axios.get("/customerById", {
                params: {
                    id: id
                }
            });
            if (res1.status === 200 && res1.data['status'] === "success") {
                let data = res1.data['data'];
                let name = data['name'];
                let email = data['email'];
                let mobile = data['phone'];
                let address = data['address'];

                $("#view-modal").modal("show");
                $("#viewID").val(id);
                $("#customerName").val(name);
                $("#customerEmail").val(email);
                $("#customerMobile").val(mobile);
                $("#customerAddress").val(address);
            } else {
                errorToast("Customer not present");
            }

        })

        $(".editBtn").on('click',async function()
    {
        let id=$(this).data('id');
        let res1=await axios.get("/customerEdit",{params:{id:id}});
        if(res1.status===200 && res1.data['status']==="success")
    {
            let data=res1.data['data'];
            let name=data['name'];
            let email=data['email'];
            let password=data['password'];
            let mobile=data['phone'];
            let address=data['address'];

            $("#update-modal").modal("show");
            $("#updateID").val(id);
            $("#name").val(name);
            $("#email").val(email);
            $("#password").val(password);
            $("#phone").val(mobile);
            $("#address").val(address);
    }
    else
    {
        errorToast("Customer not present");
    }
        
    })

        $(".deleteBtn").on('click', function() {
            let id = $(this).data('id');
            $("#delete-modal").modal("show");
            $("#deleteID").val(id);
        })

        let table = new DataTable('#tableData', {
            order: [
                [0, 'asc']
            ],
            lengthMenu: [5, 10, 15, 20]
        });




    }
</script>