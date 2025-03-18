@extends('front.page')
@section('css')
<link rel="stylesheet" href="{{asset('front/auth.css')}}">
<style>

</style>
@endsection
@section('title',"Sign Up")
@section('jumbotron')
    <li>Sign Up</li>
@endsection
@section('content')
    <div id="page-login">
        <div class="holder join">

            <div class="login-form join">

                {{-- <div class="heading-logo mb-3">
                    <img src="{{asset('front/khazom.png')}}" alt="" srcset="">
                </div> --}}

                {{-- <div class="header">
                    <span class="active join-type"  data-id="normal">
                        Register As Normal User
                        <div class="normal">
                            Lorem ipsum dolor, sit amet consectetur adipisicing elit. Aut obcaecati esse itaque iste necessitatibus nisi dignissimos animi ea placeat provident voluptates labore rerum possimus excepturi laborum similique, harum asperiores amet.
                        </div>
                    </span>

                    <span class="join-type" data-id="professional">
                        Register As  Professional
                        <div class="normal">
                            Lorem ipsum dolor, sit amet consectetur adipisicing elit. Aut obcaecati esse itaque iste necessitatibus nisi dignissimos animi ea placeat provident voluptates labore rerum possimus excepturi laborum similique, harum asperiores amet.
                        </div>
                    </span>
                </div> --}}
                <div class="my-2 p-2 shadow  " id="errors">
                    <div class="row mx-0">
                        @if($errors->any())

                        @endif
                    </div>
                </div>
                <form action="{{route('join')}}"  id="join" autocomplete="off" method="post">
                    @csrf
                    <input type="hidden" name="type" id="type" value="normal">
                    <input type="hidden" name="hooked" class="hooked" value="">

                    <div class="controls " >
                        <div class="row">
                            <div class="col-md-6">
                                <div class="control join mb-3">
                                        <label for="name" class="required">Name </label>
                                        <input type="text" id="name" name="name" value="{{old('name')}}"  placeholder="Enter Your Name " aria-label="Name" aria-describedby="Email" autocomplete="off" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="control join mb-3">
                                        <label for="email" class="required">
                                            Email
                                            <span class="text-danger" id="email-error"></span>
                                        </label>
                                        <input type="email" id="email" name="email"  value="{{old('email')}}" placeholder="Enter Email Address" aria-label="Email" aria-describedby="Email" autocomplete="off" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="control join mb-3">
                                        <label for="phone" class="required">
                                            Phone
                                            <span class="text-danger" id="phone-error"></span>
                                        </label>
                                        <input type="number" minlength="10" maxlength="10" id="phone" name="phone" value="{{old('phone')}}"  placeholder="Enter Your Phone Number " aria-label="phone" aria-describedby="phone" autocomplete="off" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="control join mb-3">
                                        <label for="city" class="required">city </label>
                                        <select  min="10" max="10" id="city" name="city_id"  aria-label="city" aria-describedby="city" autocomplete="off">
                                            @foreach (\App\Models\City::all(['id','name']) as $city)
                                                <option value="{{$city->id}}" {{old('city_id')==$city->id?'selected':''}}>{{$city->name}}</option>
                                            @endforeach
                                        </select>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="control join mb-3">
                                    <label for="address" class="required">Street Address </label>
                                    <input type="text" name="address" id="address"  value="{{old('address')}}"   placeholder="Enter Street Address" aria-label="Address" aria-describedby="Address" autocomplete="off" required>
                                </div>
                            </div>
                            {{-- <div class="col-md-6 switch professional d-none">
                                <div class="control join mb-3 ">
                                        <label for="category" class="required">Profession Type </label>
                                        <select  min="10" max="10" id="category" name="category_id"  aria-label="category" aria-describedby="category" autocomplete="off">
                                            @foreach (\App\Models\Category::all(['id','name']) as $category)
                                                <option value="{{$category->id}}" {{old('category_id')==$category->id?'selected':''}}>{{$category->name}}</option>
                                            @endforeach
                                        </select>
                                </div>
                            </div> --}}
                            {{-- <div class="col-md-6 switch professional d-none">
                                <div class="control join mb-3">
                                        <label for="service" class="required">Profession  </label>
                                        <select  min="10" max="10" id="service" name="service_id"  aria-label="service" aria-describedby="service" autocomplete="off">

                                        </select>
                                </div>
                            </div> --}}

                            <div class="col-md-6">
                                <div class="control join mb-3">
                                    <label for="dob" >Date Of Birth </label>
                                    <input type="date" name="dob" id="dob"  value="{{old('dob')}}"   placeholder="Date of Birth" aria-label="Date of Birth" aria-describedby="Date of Birth" autocomplete="off">
                                </div>
                            </div>
                            <div class="col-md-6 ">
                                <div class="control join mb-3">
                                        <label for="gender" {{--class="required"--}}>Gender  </label>
                                        <select  min="10" max="10" id="gender" name="gender_id"  aria-label="gender" aria-describedby="gender" autocomplete="off">
                                            <option value="1" {{old('gender')==1?'selected':''}}>Male</option>
                                            <option value="2" {{old('gender')==2?'selected':''}}>Female</option>
                                            <option value="3" {{old('gender')==3?'selected':''}}>Others</option>
                                        </select>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="control join mb-3">
                                    <label for="password" class="required">
                                        Password
                                        <span class="text-danger" id="password-error"></span>
                                    </label>
                                    <input type="password" name="password" id="password"  placeholder="Enter Password" aria-label="Email" aria-describedby="Email" autocomplete="off" minlength="6" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="control join mb-3">
                                    <label for="repassword" class="required">
                                        Retype Password
                                        <span class="text-danger" id="repassword-error"></span>
                                    </label>
                                    <input type="password" name="password_confirmation" id="repassword"  placeholder="Verify Password" aria-label="verify password" aria-describedby="verify password" autocomplete="off" minlength="6" required>
                                </div>
                            </div>
                        </div>


                        <div class="d-flex justify-content-between">
                            <div >
                                <a href="{{route('login')}}" class="link btn btn-link">
                                    Already have A Account? <strong class="text-red">Login</strong>
                                </a>
                            </div>
                            <div id="join-now" >
                                <img src="{{asset('front/loading.svg')}}" alt="" style="display: none;width:50px">
                                <button class="btn btn-red">
                                    join Now
                                </button>
                            </div>
                        </div>
                    </div>
                </form>

            </div>
        </div>

    </div>
@endsection
@section('js')
    <script>
        var ok=1;
        var loading=false;
        // const services={!! \App\Models\Service::all(['name','id','category_id'])->groupBy('category_id')!!};


        // setInterval(() => {
        //     if(loading){
        //         $('#join-now>img').show();
        //         $('#join-now>button').hide();
        //         $('#join').addClass('loading');
        //     }else{
        //         $('#join-now>img').hide();
        //         $('#join').removeClass('loading');
        //         $('#join-now>button').show();
        //     }
        // }, 100);
        function checkEmail(ele,email,phone) {
            console.log(ele.action);
            if(!loading){
                loading=true;
                axios.post('{{route('checkEmail')}}',{"email":email,"phone":phone})
                .then((res)=>{
                    loading=false;
                    if(res.data.email && res.data.phone){
                        loading=true;
                        ok=2;
                        // const fd=new FormData(ele)
                        // axios.post
                        $('#join')[0].submit();
                    }else{
                        $('html, body').animate({scrollTop: 0}, 0);
                        if(!res.data.email){
                            $('#email-error').html('(Email Is Already in Use)');
                            $('#email')[0].focus();
                            var targetOffset =( $('#email').offset().top)- 150 ;
                        }
                        if(!res.data.phone){
                            $('#phone-error').html('(Phone No Is Already in Use)');
                            $('#phone')[0].focus();
                            // $("#phone-error").get(0).scrollIntoView();

                        }
                    }

                })
                .catch((err)=>{
                    loading=false;
                });
            }
        }

        $(document).ready(function () {
            // $('.join-type').click(function (e) {
            //     e.preventDefault();
            //     $('#type').val(this.dataset.id);
            //     $('.join-type').removeClass('active');
            //     $('.switch').addClass('d-none');
            //     $('.'+this.dataset.id).removeClass('d-none');
            //     $(this).addClass('active');

            // });

            $('#join').submit(function (e) {
                console.log(this.action);

                if(ok===1){
                    e.preventDefault();
                    if($('#password').val()==$('#repassword').val()){
                        checkEmail(this,$('#email').val(),$('#phone').val());
                    }else{
                        $('#password-error').html('Please Confirm Password');
                        $('#repassword-error').html('Please Confirm Password');
                    }
                }else{
                    // axios.post(this.action)
                }

            });

            // $('#category').change(function (e) {
            //     e.preventDefault();
            //     selService();
            // });
            // selService();

        });

        // function selService() {
        //     const category=$('#category').val();
        //     const data=services[''+category+''];
        //     let html='';
        //     data.forEach(element => {
        //         html+='<option value="'+element.id+'">'+element.name+'</option>';
        //     });
        //     $('#service').html(html);
        // }
    </script>
@endsection
