<!doctype html>
<html lang="en">

<!-- Mirrored from demos.creative-tim.com/material-dashboard-pro/examples/dashboard.html by HTTrack Website Copier/3.x [XR&CO'2014], Mon, 20 Mar 2017 21:29:18 GMT -->

<head>
    <meta charset="utf-8" />
    <link rel="apple-touch-icon" sizes="76x76" href="{{URL::asset('assets/img/apple-icon.png')}}" />
    <link rel="icon" type="image/png" href="{{URL::asset('assets/img/logo.png')}}" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
    <title>
        Inventario - Bufalinda USA
    </title>
    <meta content='width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0' name='viewport' />
    <meta name="viewport" content="width=device-width" />
    <!--  Social tags      -->
    <meta name="keywords" content="material dashboard, bootstrap material admin, bootstrap material dashboard, material design admin, material design, creative tim, html dashboard, html css dashboard, web dashboard, freebie, free bootstrap dashboard, css3 dashboard, bootstrap admin, bootstrap dashboard, frontend, responsive bootstrap dashboard, premiu material design admin">
    <meta name="description" content="Material Dashboard PRO is a Premium Material Bootstrap Admin with a fresh, new design inspired by Google's Material Design.">
    @section('css')
    <!-- Bootstrap core CSS    <link href="assets/css/bootstrap.min.css" rel="stylesheet" />-->
    {{ Html::style('assets/css/bootstrap.min.css') }}
    <!--  Material Dashboard CSS   <link href="assets/css/material-dashboard.css" rel="stylesheet" /> -->
    {{ Html::style('assets/css/material-dashboard.css') }}
    <!--  CSS for Demo Purpose, don't include it in your project    <link href="assets/css/demo.css" rel="stylesheet" /> -->
    {{ Html::style('assets/css/demo.css') }}
    
    <!--     Fonts and icons     <link href="assets/css/font-awesome.css" rel="stylesheet" />
    <link href="assets/css/google-roboto-300-700.css" rel="stylesheet" />-->
    
    {{ Html::style('assets/css/font-awesome.css') }}
    {{ Html::style('assets/css/google-roboto-300-700.css') }}
    @show

    @yield('extra-css')
</head>

<body>
    <div class="page-loader-wrapper hide">
        <div class="loader text-center">
            <i class="fa fa-spinner fa-spin text-success"></i>
            <p>Please wait...</p>        
        </div>
    </div>
    <div class="wrapper">
        @include('layouts.partials.sidebar')
        <div class="main-panel">
            @include('layouts.partials.main')
            <div class="content">
                <div class="container-fluid">
                    @yield('content', 'Mi sitio')
                </div>
            </div>
            <footer class="footer">
               @include('layouts.partials.footer') 
            </footer>
        </div>
    </div>
    <div class="fixed-plugin">
        {{-- @include('layouts.partials.left-sidebar')--}}
    </div>
</body>
@section('script')
<!--   Core JS Files   
<script src="assets/js/jquery-3.1.1.min.js" type="text/javascript"></script>
<script src="assets/js/jquery-ui.min.js" type="text/javascript"></script>
<script src="assets/js/bootstrap.min.js" type="text/javascript"></script>
<script src="assets/js/material.min.js" type="text/javascript"></script>
<script src="assets/js/perfect-scrollbar.jquery.min.js" type="text/javascript"></script>-->
{{Html::script('assets/js/jquery-3.1.1.min.js')}}
{{Html::script('assets/js/jquery-ui.min.js')}}
{{Html::script('assets/js/bootstrap.min.js')}}
{{Html::script('assets/js/material.min.js')}}
{{Html::script('assets/js/perfect-scrollbar.jquery.min.js')}}
<!-- Forms Validations Plugin 
<script src="assets/js/jquery.validate.min.js"></script>-->
{{Html::script('assets/js/jquery.validate.min.js')}}
<!--  Plugin for Date Time Picker and Full Calendar Plugin
<script src="assets/js/moment.min.js"></script>-->
{{Html::script('assets/js/moment.min.js')}}
<!--  Charts Plugin 
<script src="assets/js/chartist.min.js"></script>-->
<!--  Plugin for the Wizard 
<script src="assets/js/jquery.bootstrap-wizard.js"></script>-->
{{Html::script('assets/js/jquery.bootstrap-wizard.js')}}
<!--  Notifications Plugin    
<script src="assets/js/bootstrap-notify.js"></script>-->
{{Html::script('assets/js/bootstrap-notify.js')}}
<!--   Sharrre Library    
<script src="assets/js/jquery.sharrre.js"></script>--> 
<!-- DateTimePicker Plugin 
<script src="assets/js/bootstrap-datetimepicker.js"></script>-->
{{Html::script('assets/js/bootstrap-datetimepicker.js')}}
<!-- Vector Map plugin 
<script src="assets/js/jquery-jvectormap.js"></script>-->
<!-- Sliders Plugin 
<script src="assets/js/nouislider.min.js"></script>-->
{{Html::script('assets/js/nouislider.min.js')}}
<!--  Google Maps Plugin    
<script src="assets/js/jquery.select-bootstrap.js"></script>-->
<!-- Select Plugin 
<script src="assets/js/jquery.select-bootstrap.js"></script> {{Html::script('assets/js/jquery.select-bootstrap.js')}} <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.7.7/js/bootstrap-select.js"></script>-->
{{Html::script('assets/js/jquery.select-bootstrap-1.7.js')}}

<!--  DataTables.net Plugin    
<script src="assets/js/jquery.datatables.js"></script>-->
{{Html::script('assets/js/jquery.datatables.js')}}
<!-- Sweet Alert 2 plugin 
<script src="assets/js/sweetalert2.js"></script>-->
{{Html::script('assets/js/sweetalert2.js')}}
<!--    Plugin for Fileupload, full documentation here: http://www.jasny.net/bootstrap/javascript/#fileinput 
<script src="assets/js/jasny-bootstrap.min.js"></script>-->
{{Html::script('assets/js/jasny-bootstrap.min.js')}}
<!--  Full Calendar Plugin    
<script src="assets/js/fullcalendar.min.js"></script>-->
{{Html::script('assets/js/fullcalendar.min.js')}}
<!-- TagsInput Plugin 
<script src="assets/js/jquery.tagsinput.js"></script>-->
{{Html::script('assets/js/jquery.tagsinput.js')}}
<!-- Material Dashboard javascript methods
<script src="assets/js/material-dashboard.js"></script> -->
{{Html::script('assets/js/material-dashboard.js')}}
<!-- Material Dashboard DEMO methods, don't include it in your project! 
<script src="assets/js/demo.js"></script>-->
{{Html::script('assets/js/demo.js')}}

@show 

@yield('extra-script')

<!-- Mirrored from demos.creative-tim.com/material-dashboard-pro/examples/dashboard.html by HTTrack Website Copier/3.x [XR&CO'2014], Mon, 20 Mar 2017 21:32:16 GMT -->
</html>