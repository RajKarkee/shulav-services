<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="Responsive Admin Dashboard Template">
    <meta name="keywords" content="admin,dashboard">
    <meta name="author" content="stacks">
    <!-- The above 6 meta tags *must* come first in the head; any other head content must come *after* these tags -->

    <!-- Title -->
    <title>{{env('APP_NAME')}} @yield('title')</title>

    <!-- Styles -->
    <link href="https://fonts.googleapis.com/css?family=Lato:400,700,900&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Montserrat:400,500,700&display=swap" rel="stylesheet">
    <link
        href="https://fonts.googleapis.com/css?family=Material+Icons|Material+Icons+Outlined|Material+Icons+Two+Tone|Material+Icons+Round|Material+Icons+Sharp"
        rel="stylesheet">
    <link href="{{ asset('admin/plugins/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('admin/plugins/font-awesome/css/all.min.css') }}" rel="stylesheet">
    @yield('css-include')

    <!-- Theme Styles -->
    <link href="{{ asset('admin/css/connect.min.css') }}" rel="stylesheet">
    <link href="{{ asset('admin/css/dark_theme.css') }}" rel="stylesheet">
    <link href="{{ asset('admin/css/custom.css') }}" rel="stylesheet">
    @yield('css')
    @yield('css1')
    @yield('css2')
    @yield('css3')
    <style>
        .btn-table{
            font-size: 18px;
        }
        .btn-table *{
            font-size: 18px;
        }
        label{
            color:rgb(49, 49, 49);
        }

    </style>
    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
        <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
        <![endif]-->
</head>

<body>
    <div class='loader'>
        <div class='spinner-grow text-primary' role='status'>
            <span class='sr-only'>Loading...</span>
        </div>
    </div>
    <div class="connect-container align-content-stretch d-flex flex-wrap">
        @include('admin.layout.includes.sidebar')
        <div class="page-container">
            <div class="page-header">
                @include('admin.layout.includes.header')
            </div>
            <div class="page-content">
                <div class="page-info">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="/">Dashboard</a></li>
                            @yield('s-title')
                        </ol>
                    </nav>
                    <div class="page-options">
                        @yield('page-option')

                    </div>
                </div>
                <div class="main-wrapper">
                    @yield('content')
                </div>
            </div>
            <div class="page-footer">
                <div class="row">
                    <div class="col-md-12">
                        <span class="footer-text"> <script>
                            var CurrentYear = new Date().getFullYear()
                            document.write(CurrentYear)
                        </script> © {{env('copyright','NeedTech')}}

                      </span>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Javascripts -->
    <script src="{{ asset('admin/plugins/jquery/jquery-3.4.1.min.js') }}"></script>
    <script src="{{ asset('admin/plugins/bootstrap/popper.min.js') }}"></script>
    <script src="{{ asset('admin/plugins/bootstrap/js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('admin/plugins/jquery-slimscroll/jquery.slimscroll.min.js') }}"></script>
    <script src="{{ asset('admin/plugins/blockui/jquery.blockUI.js') }}"></script>
    <script src="{{ asset('admin/js/connect.js') }}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/axios/0.24.0/axios.min.js" integrity="sha512-u9akINsQsAkG9xjc1cnGF4zw5TFDwkxuc9vUp5dltDWYCSmyd0meygbvgXrlc/z7/o4a19Fb5V0OUE58J7dcyw==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="{{ asset('admin/js/custom.js') }}"></script>
    @include('toastr.index')
    @yield('script')
    @yield('script1')
    @yield('script2')
    @yield('script3')
    <script>
     window.onload = function() {
            $('#accordion-menu a').each(function (index, element) {
                if(element.href== window.location.href){
                    console.log(element.href,window.location.href);
                    const n1=element.parentNode;
                    if($(n1).hasClass('sub-item')){
                        const n2=n1.parentNode;
                        const n3=n2.parentNode;
                        $(n2).removeAttr('style');
                        $(n3).addClass('active-page open');

                    }else{
                        $(n1).addClass('active-page');
                    }
                    $(element).addClass('active');
                }

            });
        };
    </script>
</body>

</html>
