<style>
    #citychooser {
        display: block;
        position: fixed;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        padding: 50px 150px;
        z-index: 100;
        background-color: rgba(0, 0, 0, 0.2)
    }

    #citychooser .inner {
        background: white;
        border-radius: 10px;
        height: 100%;
        overflow-y:auto;
    }
    #citychooser .inner .inner-header {
        position: sticky;
        top:0px;
        background: rgba(255  ,  255 , 255, 0.9);
        padding: 15px;
        border-bottom: 1px solid rgba(96, 96, 96, 0.9);
        color: var(--blue-primary);
    }

    #citychooser .skip {
        color:var(--blue-primary);
        cursor: pointer;
    }
    #citychooser .single-city {
        cursor: pointer;
        color: var(--blue-primary);
    }
    #citychooser .single-city:hover {
        
        background-color: var(--red-primary);
        color:white;
    }
    @media (max-width:425px){
        #citychooser {
          
            padding: 80px 10px 10px 10px;
         
        }

        #citychooser .inner{
            border-radius: 5px;
        }
    }
</style>
<div id="citychooser">
    <div class="inner" onclick="event.stopPropagation();">
        <h6 class="d-flex justify-content-between align-items-center inner-header">
            <span class="mb-0">
                Choose A City
            </span>
            <span class="skip text-red-hover" onclick="x_skip()">
                Skip For Now
            </span>
        </h6>
        <div class="p-3">

            <div class="row" >
                @foreach ($cities as $city)
                    <div class="col-md-3 mb-3 ">
                        <div onclick="x_chooseCity({{$city->id}},'{{$city->name}}');" class="shadow p-3 d-flex align-items-center  justify-content-center single-city">
                            {{ $city->name }}
                        </div>
                    </div>
                @endforeach
            </div>
       
        </div>
    </div>

</div>
