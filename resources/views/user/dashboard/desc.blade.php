<div class="bg-white shadow mt-3">
    <div class="card-body">
        <strong class="d-block text-black">
            <div class="d-flex justify-content-between align-items-center">
                <h5 class="m-0">
                    Your Intro
                </h5>
                <button class="btn link" id="edit-desc">Edit</button>
            </div>
        </strong>
        <div id="first-selector-desc">
            <textarea autocorrect="off" id="desc-input" cols="30" rows="6" >{!!$user->vendor->desc!!}</textarea>
            <div >
                <span id="cancel-desc" class="btn  link">
                    cancel
                </span>
                <span id="next-desc" class=" btn btn-red">
                    Update
                </span>
            </div>
        </div>

    </div>
</div>
