<div class="title">
    <strong>See</strong> How it works?
</div>
<div class="row">
    @php
        $i=1;
    @endphp
    @foreach ($steps as $step)
        <div class="col-md-3  p-0">
            <div class="how">
                <div class="num">

                        <img src="{{asset('front/check_second.svg')}}" alt="" >

                    <div>
                        {{$i++}}
                    </div>
                </div>
                <div class="text">
                    <div class="text-title">
                       {{$step->title}}
                    </div>
                    <div class="text-desc">
                        {{$step->text}}
                    </div>
                </div>
            </div>
            @if ($i<4)
            <hr class="d-block d-md-none">
            @endif
        </div>
    @endforeach

</div>
<div class="line"></div>
