<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <link rel="icon" type="image/png" href="{{URL::asset('assets/img/logo.png')}}" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
    <meta content='width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0' name='viewport' />
    <meta name="viewport" content="width=device-width" />

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Inventario - Bufalinda USA</title>

    <!-- Canonical SEO -->
    <link rel="canonical" href="https://www.creative-tim.com/product/material-dashboard-pro" />
    <!--  Social tags      -->
    <meta name="keywords" content="material dashboard, bootstrap material admin, bootstrap material dashboard, material design admin, material design, creative tim, html dashboard, html css dashboard, web dashboard, freebie, free bootstrap dashboard, css3 dashboard, bootstrap admin, bootstrap dashboard, frontend, responsive bootstrap dashboard, premiu material design admin">
    <meta name="description" content="Material Dashboard PRO is a Premium Material Bootstrap Admin with a fresh, new design inspired by Google's Material Design.">
    <!-- Schema.org markup for Google+ -->
    <meta itemprop="name" content="Material Dashboard PRO by Creative Tim | Premium Bootstrap Admin Template">
    <meta itemprop="description" content="Material Dashboard PRO is a Premium Material Bootstrap Admin with a fresh, new design inspired by Google's Material Design.">
    <meta itemprop="image" content="s3.amazonaws.com/creativetim_bucket/products/51/opt_mdp_thumbnail.jpg">
    <!-- Twitter Card data -->
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:site" content="@creativetim">
    <meta name="twitter:title" content="Material Dashboard PRO by Creative Tim | Premium Bootstrap Admin Template">
    <meta name="twitter:description" content="Material Dashboard PRO is a Premium Material Bootstrap Admin with a fresh, new design inspired by Google's Material Design.">
    <meta name="twitter:creator" content="@creativetim">
    <meta name="twitter:image" content="s3.amazonaws.com/creativetim_bucket/products/51/opt_mdp_thumbnail.jpg">
    <!-- Open Graph data -->
    <meta property="fb:app_id" content="655968634437471">
    <meta property="og:title" content="Material Dashboard PRO by Creative Tim | Premium Bootstrap Admin Template" />
    <meta property="og:type" content="article" />
    <meta property="og:url" content="http://www.creative-tim.com/product/material-dashboard-pro" />
    <meta property="og:image" content="s3.amazonaws.com/creativetim_bucket/products/51/opt_mdp_thumbnail.jpg" />
    <meta property="og:description" content="Material Dashboard PRO is a Premium Material Bootstrap Admin with a fresh, new design inspired by Google's Material Design." />
    <meta property="og:site_name" content="Creative Tim" />

    @section('css')
    <!-- Bootstrap core CSS -->
    {{ Html::style('assets/css/bootstrap.min.css') }}
    <!--  Material Dashboard CSS -->
    {{ Html::style('assets/css/material-dashboard.css') }}
    <!--  CSS for Demo Purpose, don't include it in your project -->
    {{ Html::style('assets/css/demo.css') }}
    <!--     Fonts and icons -->    
    {{ Html::style('assets/css/font-awesome.css') }}
    {{ Html::style('assets/css/google-roboto-300-700.css') }}
    @show

    @yield('extra-css')

</head>
<body>
    <nav class="navbar navbar-primary navbar-transparent navbar-absolute">
        <div class="container">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#navigation-example-2">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="#">Inventory</a>
            </div>

            <div class="collapse navbar-collapse">
                <ul class="nav navbar-nav navbar-right">
                    @if (Auth::guest())
                    {{--<a href="{{ route('register') }}"> Logout </a>--}}
                    @else
                        <li class="dropdown">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
                                {{ Auth::user()->name }} <span class="caret"></span>
                            </a>

                            <ul class="dropdown-menu" role="menu">
                                <li>
                                    <a href="{{ route('logout') }}"
                                        onclick="event.preventDefault();
                                                 document.getElementById('logout-form').submit();">
                                        Logout
                                    </a>
                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                        {{ csrf_field() }}
                                    </form>
                                </li>
                            </ul>
                        </li>
                    @endif
                </ul>
            </div>
        </div>
    </nav>
    <div class="wrapper wrapper-full-page">
        <div class="full-page login-page" data-image="{{URL::asset('assets/img/logoin.jpg')}}">
            <!--   you can change the color of the filter page using: data-color="blue | purple | green | orange | red | rose " -->
            <div class="content">
                @yield('content')
            </div>
            <footer class="footer">
                @include('layouts.partials.footer') 
            </footer>
        </div>
    </div>
</body>
<!--   Core JS Files  -->
{{Html::script('assets/js/jquery-3.1.1.min.js')}}
{{Html::script('assets/js/jquery-ui.min.js')}}
{{Html::script('assets/js/bootstrap.min.js')}}
{{Html::script('assets/js/material.min.js')}}
{{Html::script('assets/js/perfect-scrollbar.jquery.min.js')}}
<!-- Forms Validations Plugin -->
{{Html::script('assets/js/jquery.validate.min.js')}}
<!--  Plugin for Date Time Picker and Full Calendar Plugin -->
{{Html::script('assets/js/moment.min.js')}}
<!--  Charts Plugin 
<script src="assets/js/chartist.min.js"></script>-->
<!--  Plugin for the Wizard -->
{{Html::script('assets/js/jquery.bootstrap-wizard.js')}}
<!--  Notifications Plugin -->
{{Html::script('assets/js/bootstrap-notify.js')}}
<!--   Sharrre Library    
<script src="assets/js/jquery.sharrre.js"></script> -->
<!-- DateTimePicker Plugin  -->
{{Html::script('assets/js/bootstrap-datetimepicker.js')}}
<!-- Vector Map plugin 
<script src="assets/js/jquery-jvectormap.js"></script>-->
<!-- Sliders Plugin  -->
{{Html::script('assets/js/nouislider.min.js')}}
<!--  Google Maps Plugin    -->
<!--<script src="https://maps.googleapis.com/maps/api/js"></script>-->
<!-- Select Plugin -->
{{Html::script('assets/js/jquery.select-bootstrap.js')}}
<!--  DataTables.net Plugin  -->
{{Html::script('assets/js/jquery.datatables.js')}}
<!-- Sweet Alert 2 plugin -->
{{Html::script('assets/js/sweetalert2.js')}}
<!--    Plugin for Fileupload, full documentation here: http://www.jasny.net/bootstrap/javascript/#fileinput  -->
{{Html::script('assets/js/jasny-bootstrap.min.js')}}
<!--  Full Calendar Plugin -->
{{Html::script('assets/js/fullcalendar.min.js')}}
<!-- TagsInput Plugin -->
{{Html::script('assets/js/jquery.tagsinput.js')}}
<!-- Material Dashboard javascript methods -->
{{Html::script('assets/js/material-dashboard.js')}}
<!-- Material Dashboard DEMO methods, don't include it in your project! -->
{{Html::script('assets/js/demo.js')}}
<script type="text/javascript">
    $().ready(function() {
        demo.checkFullPageBackgroundImage();

        setTimeout(function() {
            // after 1000 ms we add the class animated to the login/register card
            $('.card').removeClass('card-hidden');
        }, 700)
    });
</script>
</html>
