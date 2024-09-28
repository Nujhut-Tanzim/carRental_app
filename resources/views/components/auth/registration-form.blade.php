<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10 col-lg-10 center-screen">
            <div class="card animated fadeIn w-100 p-3">
                <div class="card-body">
                    <h4>Sign Up</h4>
                    <hr/>
                    <div class="container-fluid m-0 p-0">
                        <div class="row m-0 p-0">
                            <div class="col-md-4 p-2">
                                <label>Email Address</label>
                                <input id="email" placeholder="User Email" class="form-control" type="email"/>
                            </div>
                            <div class="col-md-4 p-2">
                                <label>Name</label>
                                <input id="Name" placeholder="First Name" class="form-control" type="text"/>
                            </div>
                            <div class="col-md-4 p-2">
                                <label>Mobile Number</label>
                                <input id="mobile" placeholder="Mobile" class="form-control" type="mobile"/>
                            </div>
                            <div class="col-md-4 p-2">
                                <label>Password</label>
                                <input id="password" placeholder="User Password" class="form-control" type="password"/>
                            </div>
                            <div class="col-md-4 p-2">
                                <label>Address</label>
                                <input id="address" placeholder="User Address" class="form-control" type="text"/>
                            </div>
                        </div>
                        <div class="row m-0 p-0">
                            <div class="col-md-4 p-2">
                                <button onclick="onRegistration()" class="btn mt-3 w-100  bg-gradient-primary">Complete</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    async function onRegistration()
    {
        let email=document.getElementById('email').value;
        let name=document.getElementById('Name').value;
        let mobile=document.getElementById('mobile').value;
        let password=document.getElementById('password').value;
        let address=document.getElementById('address').value;

        if(email.length===0)
        {
            errorToast("Email is required");
        }
        else if(name.length===0)
        {
            errorToast("Name is required");
        }

        else if(mobile.length===0)
        {
            errorToast("Mobile Number is required");
        }
        else if(password.length===0)
        {
            errorToast("Password is required");
        }
        else if(address.length===0)
        {
            errorToast("Address is required");
        }
        
        else
        {
            showLoader();
            let res=await axios.post("/user-registration",{
                name:name,
                email:email,
                password:password,
                phone:mobile,
                address:address
                
            });
            hideLoader();
            if(res.status===200 && res.data['status']==='success')
            {
                successToast(res.data['message'])
                setTimeout(function()
                {
                    window.location.href="/userLogin";
                },2000)
                
            }
            else
            {
                errorToast(res.data['message']);
            }

        }



    }
</script>