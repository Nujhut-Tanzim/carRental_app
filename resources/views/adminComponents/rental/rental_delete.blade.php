<div class="modal animated zoomIn" id="delete-modal">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-body text-center">
                <h3 class=" mt-3 text-warning">Delete !</h3>
                <p class="mb-3">Once delete, you can't get it back.</p>
                <input class="d-none" id="deleteID"/>
                <input class="d-none" id="statusValue"/>
            </div>
            <div class="modal-footer justify-content-end">
                <div>
                    <button type="button" id="delete-modal-close" class="btn bg-gradient-success mx-2" data-bs-dismiss="modal">Cancel</button>
                    <button onclick="itemDelete()" type="button" id="confirmDelete" class="btn bg-gradient-danger" >Delete</button>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    async function itemDelete()
    {
        let id=document.getElementById("deleteID").value;
        let status=document.getElementById("statusValue").value;
        console.log(status);
        document.getElementById("delete-modal-close").click();
        showLoader();
        let res=await axios.post("/rentalDelete",{id:id,status:status});
        hideLoader();
        if(res.status===200 && res.data['status']==="success")
        {
            successToast("Delete Customer Successfully");
            await getRentalList();
        }
        else
        {
            errorToast(res.data["message"]);
        }
    }

</script>