<div class="modal animated zoomIn" id="update-modal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Update Car</h5>
            </div>
            <div class="modal-body">
                <form id="update-form">
                    <div class="container">
                        <div class="row">
                            <div class="col-12 p-1">
                                <label class="form-label mt-2">Name</label>
                                <input type="text" class="form-control" id="carNameUpdate">

                                <label class="form-label mt-2">Brand</label>
                                <input type="text" class="form-control" id="carBrandUpdate">

                                <label class="form-label mt-2">Model</label>
                                <input type="text" class="form-control" id="carModelUpdate">
                                <label class="form-label mt-2">Year</label>
                                <input type="text" class="form-control" id="carYearUpdate">
                                <label class="form-label mt-2">Car Type</label>
                                <input type="text" class="form-control" id="car_typeUpdate">
                                <label class="form-label mt-2">Price rent</label>
                                <input type="text" class="form-control" id="carDailyPriceRentUpdate">
                                <br />
                                <img class="w-15" id="oldImg" src="{{asset('images/default.jpg')}}" />
                                <br />
                                <label class="form-label mt-2">Image</label>
                                <input oninput="oldImg.src=window.URL.createObjectURL(this.files[0])" type="file" class="form-control" id="carImgUpdate">

                                <input type="text" class="d-none" id="updateID">
                                <input type="text" class="d-none" id="filePath">


                            </div>
                        </div>
                    </div>
                </form>
            </div>

            <div class="modal-footer">
                <button id="update-modal-close" class="btn bg-gradient-primary" data-bs-dismiss="modal" aria-label="Close">Close</button>
                <button onclick="update()" id="update-btn" class="btn bg-gradient-success">Update</button>
            </div>

        </div>
    </div>
</div>


<script>
    async function FillUpUpdateForm(id, filePath) {

        document.getElementById('updateID').value = id;
        document.getElementById('filePath').value = filePath;
        document.getElementById('oldImg').src = filePath;


        showLoader();
        let res = await axios.get("/carEdit", {
            params: {
                id: id
            }
        });
        hideLoader();
            document.getElementById('carNameUpdate').value = res.data['name'];
            document.getElementById('carBrandUpdate').value = res.data['brand'];
            document.getElementById('carModelUpdate').value = res.data['model'];
            document.getElementById('carYearUpdate').value = res.data['year'];
            document.getElementById('car_typeUpdate').value = res.data['car_type'];
            document.getElementById('carDailyPriceRentUpdate').value = res.data['daily_rent_price'];
        

    }



    async function update() {

        let carNameUpdate = document.getElementById('carNameUpdate').value;
        let carModelUpdate = document.getElementById('carModelUpdate').value;
        let carBrandUpdate = document.getElementById('carBrandUpdate').value;
        let carYearUpdate = document.getElementById('carYearUpdate').value;
        let car_typeUpdate = document.getElementById('car_typeUpdate').value;
        let carDailyRentPriceUpdate = document.getElementById('carDailyPriceRentUpdate').value;
        let updateID = document.getElementById('updateID').value;
        let filePath = document.getElementById('filePath').value;
        let carImgUpdate = document.getElementById('carImgUpdate').files[0];
        console.log(carNameUpdate);


        if (carNameUpdate.length === 0) {
            errorToast("Name is Required !")
        } else if (carBrandUpdate.length === 0) {
            errorToast("Brand is  Required !")
        } else if (carModelUpdate.length === 0) {
            errorToast("Model is  Required !")
        } else if (carYearUpdate.length === 0) {
            errorToast("Year is  Required !")
        } else if (car_typeUpdate.length === 0) {
            errorToast("Car Type is  Required !")
        } else if (carDailyRentPriceUpdate.length === 0) {
            errorToast("Daily Price Rent is  Required !")
        } else {

            document.getElementById('update-modal-close').click();

            let formData = new FormData();
            formData.append('img', carImgUpdate)
            formData.append('id', updateID)
            formData.append('name', carNameUpdate)
            formData.append('brand', carBrandUpdate)
            formData.append('model', carModelUpdate)
            formData.append('year', carYearUpdate)
            formData.append('car_type', car_typeUpdate)
            formData.append('daily_rent_price', carDailyRentPriceUpdate)
            formData.append('file_path', filePath)

            const config = {
                headers: {
                    'content-type': 'multipart/form-data'
                }
            }

            showLoader();
            let res = await axios.post("/carUpdate", formData, config)
            hideLoader();

            if (res.status===200 && res.data['status']==="success") {
                successToast('Request completed');
                document.getElementById("update-form").reset();
                await getCarList();
            } else {
                errorToast("Request fail !")
            }
        }
    }
</script>