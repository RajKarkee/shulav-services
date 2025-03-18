<div class="modal fade" id="add-review" tabindex="-1" aria-labelledby="add-review-modal" aria-hidden="true">
    <div class="modal-dialog modal-lg	modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="add-review-modal">Add Review</h5>
                <button type="button" id="close-add-review" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="{{route('user.review.add')}}" id="add-review-form" method="post">
                    @csrf
                    <input type="hidden" name="vendor_id" value="{{$vendor->id}}">
                    <textarea name="desc" id="desc" maxlength="160"
                        style="min-height:200px;background: #FFEEEF;width:100%;outline:var(--red-primary);border:var(--red-primary);padding:10px;"
                        placeholder="Enter Review Here" required></textarea>
                    <hr>
                    <div class="text-center">
                        How was your experience working with {{ $vendor->name }}.
                    </div>
                    <div class=" mt-3 row justify-content-center m-0">

                        @for ($i = 1; $i <= 5; $i++)

                            <span class="col-4 col-md-2 text-center">
                                <label for="rate-{{ $i }}" style="white-space: nowrap;font-weight:600;">
                                    {{ \App\Helper::ratings[$i] }}
                                </label>
                                <br>
                                <input type="radio" id="rate-{{ $i }}" name="rate"
                                    {{ $i == 1 ? 'required' : '' }} value="{{$i}}">
                            </span>
                        @endfor
                    </div>
                    <hr>
                    <div class="py-2 text-end">
                        <button  class="btn btn-primary">Save Review</button>
                    </div>
                </form>
            </div>

        </div>
    </div>
</div>
