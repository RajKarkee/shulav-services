@extends('front.page')
@section('css')
    <link rel="stylesheet" href="{{ asset('front/auth.css') }}">
    <style>
  :root {
    --primary-color: #4361ee;
    --primary-hover: #3a56d4;
    --secondary-color: #f8f9fa;
    --text-color: #2b2d42;
    --light-text: #8d99ae;
    --danger-color: #ef233c;
    --success-color: #2a9d8f;
    --border-radius: 12px;
    --box-shadow: 0 10px 30px rgba(0, 0, 0, 0.08);
    --transition: all 0.3s ease;
}

body {
    font-family: 'Inter', sans-serif;
    color: var(--text-color);
    background-color: #f5f7fa;
}

#page-login {
    min-height: 100vh;
    padding: 4vh 0;
    display: flex;
    justify-content: center;
    align-items: center;
    background: linear-gradient(135deg, #f5f7fa 0%, #e4e8f0 100%);
}

#page-login .holder {
    box-shadow: var(--box-shadow);
    width: 90%;
    max-width: 1200px;
    background: white;
    border-radius: var(--border-radius);
    overflow: hidden;
    position: relative;
    display: flex;
}

#page-login .holder .image {
    background: linear-gradient(135deg, #4361ee 0%, #3a56d4 100%);
    flex: 4;
    position: relative;
    display: flex;
    flex-direction: column;
    justify-content: center;
    align-items: center;
    padding: 40px;
    text-align: center;
}

#page-login .holder .image img {
    max-width: 80%;
    max-height: 120px;
    object-fit: contain;
    margin-bottom: 30px;
}

#page-login .holder .image h3 {
    color: white;
    font-weight: 600;
    margin-top: 20px;
    font-size: 1.5rem;
}

#page-login .holder .image p {
    color: rgba(255, 255, 255, 0.85);
    margin-top: 15px;
    font-size: 1rem;
    line-height: 1.6;
}

#page-login .holder .login-form {
    background: white;
    padding: 40px;
    max-width: 100%;
    flex: 5;
}

.login-form h2 {
    font-weight: 700;
    color: var(--text-color);
    margin-bottom: 15px;
    font-size: 2rem;
}

.login-form h5 {
    color: var(--light-text);
    font-weight: 400;
    margin-bottom: 30px;
    font-size: 1.05rem;
    line-height: 1.5;
}

.type-selector {
    padding: 18px 16px;
    border: 2px solid #e9ecef;
    text-align: center;
    border-radius: var(--border-radius);
    cursor: pointer;
    font-weight: 600;
    color: var(--text-color);
    transition: var(--transition);
    box-shadow: 0 2px 8px rgba(0,0,0,0.03);
    height: 100%;
    display: flex;
    flex-direction: column;
    justify-content: center;
    align-items: center;
}

.type-selector:hover {
    transform: translateY(-3px);
    box-shadow: 0 6px 12px rgba(0,0,0,0.08);
    border-color: #d8e0f0;
}

.type-selector.selected {
    border: 2px solid var(--primary-color);
    color: white;
    background: var(--primary-color);
    font-weight: 700;
}

.type-selector i {
    font-size: 2rem;
    margin-bottom: 12px;
}

.control.join {
    margin-bottom: 22px !important;
}

.control.join label {
    display: block;
    font-weight: 500;
    color: var(--text-color);
    margin-bottom: 8px;
    font-size: 0.9rem;
}

.control.join label.required::after {
    content: "*";
    color: var(--danger-color);
    margin-left: 4px;
}

.control.join input, .control.join select {
    width: 100%;
    height: 50px;
    padding: 8px 16px;
    border: 1px solid #dee2e6;
    border-radius: var(--border-radius);
    font-size: 0.95rem;
    transition: var(--transition);
}

.control.join input:focus, .control.join select:focus {
    border-color: var(--primary-color);
    box-shadow: 0 0 0 3px rgba(67, 97, 238, 0.15);
    outline: none;
}

.btn-red {
    background-color: var(--primary-color);
    color: white;
    border: none;
    border-radius: var(--border-radius);
    padding: 14px 20px;
    font-weight: 600;
    cursor: pointer;
    transition: var(--transition);
    height: 52px;
    text-transform: uppercase;
    letter-spacing: 0.5px;
}

.btn-red:hover {
    background-color: var(--primary-hover);
    transform: translateY(-2px);
    box-shadow: 0 6px 12px rgba(67, 97, 238, 0.25);
}

.form-info {
    padding: 18px;
    background-color: #e9f5fb;
    border-radius: var(--border-radius);
    margin-bottom: 25px;
    font-size: 0.95rem;
    display: flex;
    align-items: center;
}

.form-info i {
    color: #0092ca;
    margin-right: 12px;
    font-size: 1.2rem;
    flex-shrink: 0;
}

.phone-display, .email-display {
    font-weight: 500;
    color: var(--primary-color);
    background-color: #f8f9fa;
    padding: 14px 18px;
    border-radius: var(--border-radius);
    display: flex;
    align-items: center;
    border: 1px solid #e9ecef;
}

.phone-display i, .email-display i {
    margin-right: 12px;
    color: var(--light-text);
    font-size: 1.05rem;
}

/* Better Mobile Experience */
@media (max-width: 992px) {
    #page-login .holder {
        width: 92%;
        flex-direction: column;
    }

    #page-login .holder .image {
        padding: 30px;
    }
    
    #page-login .holder .image img {
        max-height: 80px;
        margin-bottom: 15px;
    }
    
    #page-login .holder .image h3 {
        font-size: 1.3rem;
        margin-top: 10px;
    }
    
    #page-login .holder .image p {
        font-size: 0.9rem;
        margin-bottom: 0;
    }

    #page-login .holder .login-form {
        padding: 30px 25px;
    }
    
    .login-form h2 {
        font-size: 1.7rem;
    }
    
    .login-form h5 {
        font-size: 1rem;
    }
}

@media (max-width: 768px) {
    #page-login {
        padding: 0;
    }
    
    #page-login .holder {
        width: 100%;
        border-radius: 0;
        box-shadow: none;
    }
    
    #page-login .holder .image {
        padding: 25px 20px;
    }
    
    #page-login .holder .image h3,
    #page-login .holder .image p {
        display: none;
    }
    
    .login-form h2 {
        font-size: 1.5rem;
        margin-bottom: 10px;
    }
    
    .login-form h5 {
        font-size: 0.9rem;
        margin-bottom: 20px;
    }
    
    .form-info {
        padding: 15px;
        font-size: 0.9rem;
    }

    .type-selector {
        padding: 16px 12px;
    }
    
    .type-selector i {
        font-size: 1.8rem;
        margin-bottom: 8px;
    }
    
    .control.join {
        margin-bottom: 16px !important;
    }
    
    .btn-red {
        height: 48px;
    }
}

@media (max-width: 480px) {
    #page-login .holder .image img {
        max-height: 60px;
    }
    
    #page-login .holder .login-form {
        padding: 25px 15px;
    }
    
    .controls.px-3 {
        padding-left: 8px !important;
        padding-right: 8px !important;
    }
}
    </style>
    <!-- Add Font Awesome for icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- Add Google Font: Inter -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
@endsection
@section('title', 'Complete Your Profile')
@section('jumbotron')
    <li>Setup Profile</li>
@endsection
@section('content')
@php
    $data =
            App\Helper::getSetting('minor') ??
            (object) [
                'logo' => '',
                'footer_logo' => '',
            ];
@endphp
    <div id="page-login">
        <div class="holder">
            <div class="image">
                <img src="{{ $data->logo ? asset($data->logo) : asset('default-logo.png') }}" alt="Logo">
                <h3>Welcome to Our Platform</h3>
                <p>Complete your profile and start connecting with services that match your needs.</p>
            </div>
            <div class="login-form">
                <h2>Complete Your Profile</h2>
                <h5>Please provide the following information to set up your account and personalize your experience</h5>

                <div class="form-info mb-4">
                    <i class="fas fa-info-circle"></i> 
                    <span>Your information is secure and helps us provide you with better service recommendations</span>
                </div>

                <div class="controls px-3">
                    <form action="{{route('setupUser')}}" method="post">
                        @csrf
                        <div class="row mb-4">
                            <input type="hidden" name="type" value="2" id="type">
                            <div class="col-md-6 mb-3 mb-md-0">
                                <div class="type-selector selected type-selector-2" onclick="sel(2)">
                                    <i class="fas fa-handshake"></i>
                                    Sell Service
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="type-selector type-selector-3" onclick="sel(3)">
                                    <i class="fas fa-shopping-cart"></i>
                                    Buy Service
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="control join mb-3">
                                    <label for="name" class="required">Full Name</label>
                                    <input type="text" id="name" name="name"
                                        placeholder="Enter your full name" aria-label="Name" aria-describedby="Email"
                                        autocomplete="off" required value="{{$localUser->name}}">
                                </div>
                            </div>
                           @if ($setup==2)
                           <div class="col-md-12">
                                <div class="control join mb-3">
                                    <label for="phone" class="required">Email</label>
                                    <div class="email-display">
                                        <i class="fas fa-envelope"></i>{{ $email }}
                                    </div>
                                </div>
                            </div>
                            @else
                            <div class="col-md-12">
                                <div class="control join mb-3">
                                    <label for="phone" class="required">Phone Number</label>
                                    <div class="phone-display">
                                        <i class="fas fa-phone"></i>{{ $phone }}
                                    </div>
                                </div>
                            </div>
                           @endif
                            <div class="col-md-6">
                                <div class="control join mb-3">
                                    <label for="city" class="required">City</label>
                                    <select min="10" max="10" id="city" name="city_id" aria-label="city"
                                        aria-describedby="city" autocomplete="off">
                                        @foreach ($cities as $city)
                                            <option value="{{ $city->id }}" {{ old('city_id') == $city->id ? 'selected' : '' }}>
                                                {{ $city->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="control join mb-3">
                                    <label for="location" class="required">Location</label>
                                    <select min="10" max="10" id="location" name="location_id" aria-label="location"
                                        aria-describedby="location" autocomplete="off">
                                        <!-- Will be populated via JavaScript -->
                                    </select>
                                </div>
                            </div>

                            <div class="col-md-12">
                                <div class="control join mb-3">
                                    <label for="address">Street Address</label>
                                    <input type="text" name="address" id="address" value="{{ old('address') }}"
                                        placeholder="Enter your street address" aria-label="Address" aria-describedby="Address"
                                        autocomplete="off" >
                                </div>
                            </div>
                            
                            <div class="col-md-6 options option-2">
                                <div class="control join mb-3">
                                    <label for="city" class="required">Service Category</label>
                                    <select min="10" max="10" id="cat" name="category_id" aria-label="city"
                                        aria-describedby="Category" autocomplete="off">
                                        <option>Please select a service category</option>
                                        @foreach ($cats as $cat)
                                            <option value="{{ $cat->id }}" {{ old('category_id') == $cat->id ? 'selected' : '' }}>
                                                {{ $cat->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            
                            <div class="col-md-6 options option-2">
                                <div class="control join mb-3">
                                    <label for="service" class="required">Service</label>
                                    <select min="10" max="10" id="service" name="service_id" aria-label="service"
                                        aria-describedby="service" autocomplete="off">
                                        <!-- Will be populated via JavaScript -->
                                    </select>
                                </div>
                            </div>
                            
                            <div class="col-md-12 mt-4">
                                <button class="btn btn-red w-100">
                                    @if ($redirect==null)
                                        <i class="fas fa-check-circle me-2"></i>Complete Setup
                                    @else
                                        <i class="fas fa-arrow-right me-2"></i>Continue
                                    @endif
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('js')
    <script>
        const services={!! json_encode($services) !!};
        const locations={!! json_encode($locations) !!};

        $(document).ready(function() {
            if(typeof x_city !== 'undefined' && x_city !== null){
                $('#city').val(x_city.id).change();
            }

            // Trigger change on page load to populate dropdowns
            $('#city').trigger('change');
            $('#cat').trigger('change');

            $('#cat').change(function(){
                $('#service').html(
                    services.filter(o=>o.category_id==$('#cat').val()).map(o=>`<option value="${o.id}">${o.name}</option>`)
                );
            });

            $('#city').change(function(){
                $('#location').html(
                locations.filter(o=>o.city_id==$('#city').val()).map(o=>`<option value="${o.id}">${o.name}</option`)
                );
            });
        });

        function sel(type){
            $('.type-selector').removeClass('selected');
            $('.type-selector-'+type).addClass('selected');

            $('.options').addClass('d-none');
            $('.option-'+type).removeClass('d-none');
            $('#type').val(type);
        }
    </script>
@endsection