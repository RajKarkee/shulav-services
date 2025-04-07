<div class="p-4" id="first-selector-image">
    <div  class="image">
        <img id="image-display" src="#" alt="">
        <div id="overlay-image" class="overlay" onclick="$('#image-input')[0].click();">
            <img class="overlay-image" src="/front/camera.svg" alt="" id="image-display">

        </div>
        <div id="overlay-image-spinner" class="overlay">
            <img class="overlay-image" src="{{asset('front/loading.svg')}}" alt="">
        </div>
    </div>
</div>
<form id="image-form" class="d-none">
    @csrf
    <input type="file"  id="image-input" accept="image/*">
</form>
<div id="second-selector-image" style="display: none;" class="mb-3">
    <div id="image-holder" >
        <img src="" id="image-resize" alt="" style="width: 766px">
    </div>
    <div class="d-flex justify-content-between">
        <span id="cancel-image" class="btn  link">
            cancel
        </span>
        <span id="next-image" class=" btn btn-red">
            Update
        </span>
    </div>
    <hr>
</div>
