@extends('adminLayout.sidenav-layout')
@section('content')
<div class="container-fluid">
    <div class="card mt-4 p-4">
        <h5>Create Car</h5>
        <form id="save-form">
            <div class="row">
                <div class="col-12 col-md-6 p-1">
                    <label class="form-label">Name</label>
                    <input type="text" class="form-control" id="name" required>
                </div>
                <div class="col-12 col-md-6 p-1">
                    <label class="form-label">Brand</label>
                    <input type="email" class="form-control" id="brand" required>
                </div>
            </div>
            <div class="row">
                <div class="col-12 col-md-6 p-1">
                    <label class="form-label">Model</label>
                    <input type="text" class="form-control" id="model" required>
                </div>
                <div class="col-12 col-md-6 p-1">
                    <label class="form-label">Car Type</label>
                    <input type="text" class="form-control" id="car_type" required>
                </div>
            </div>
            <div class="row">
                <div class="col-6 p-1">
                    <label class="form-label">Year</label>
                    <input type="text" class="form-control" id="year" required>
                </div>
                <div class="col-6 p-1">
                    <label class="form-label">Rent Price</label>
                    <input type="text" class="form-control" id="daily_rent_price" required>
                </div>
            </div>
            <div class="row">
                <div class="col-6 p-1">
                    <br />
                    <img class="w-15" id="newImg" src="{{asset('images/default.jpg')}}" />
                    <br />
                    <label class="form-label">Image</label>
                    <input oninput="newImg.src=window.URL.createObjectURL(this.files[0])" type="file" class="form-control" id="carImg">
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
    async function Save()
    {
        let name=document.getElementById("name").value;
        let brand=document.getElementById("brand").value;
        let model=document.getElementById("model").value;
        let car_type=document.getElementById("car_type").value;
        let year=document.getElementById("year").value;
        let daily_rent_price=document.getElementById("daily_rent_price").value;

        let carImg=document.getElementById("carImg").files[0];

        if(!name)
        {
            errorToast("Name is required");
        }
        else if(brand.length===0)
        {
            errorToast("Brand is required");
        }
        else if(model.length===0)
        {
            errorToast("Model is required");
        }
        else if(car_type.length===0)
        {
            errorToast("Type is required");
        }
        else if(year.length===0)
        {
            errorToast("Year is required");
        }
        else if(daily_rent_price.length===0)
        {
            errorToast("Rent price is required");
        }
        else if(!carImg)
        {
            errorToast("Car Image is required");
        }
        else
        {
        let formData=new FormData();
        formData.append('name',name);
        formData.append('brand',brand);
        formData.append('model',model);
        formData.append('year',year);
        formData.append('car_type',car_type);
        formData.append('daily_rent_price',daily_rent_price);
        formData.append('image',carImg);

        const config={
            headers:{
                'content-type':'multipart/form-data'
            }
        }

        showLoader();

        let res=await axios.post("/carStore",formData,config);
        hideLoader();
        if(res.status===201)
        {
            successToast("Add car Successfully");
            document.getElementById("save-form").reset();
            window.location.href = '/adminCarPage'; 
        }
        else
        {
            errorToast("Add Car Failed");
        }
    }
}

    function Close() {
        window.location.href = '/adminCarPage';
    }
</script>