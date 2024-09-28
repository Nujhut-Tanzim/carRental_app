<h6 id="userName"></h6>

<script>
    getUserName();
    async function getUserName()
    {
        let res=await axios.get("/user-profile");
        if(res.status===200 && res.data['status']==='success')
    {
            let data=res.data['data'];
            let name=data['name'];
            document.getElementById("userName").textContent=name;
    }
    else
    {
        errorToast(res.data['message']);
    }
}
</script>