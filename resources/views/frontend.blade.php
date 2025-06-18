<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="layout-navbar-fixed layout-menu-fixed">
@php
$settings = [
'app_name' => App\Models\Settings::where(['key' => 'app_name'])->first()->value,
'app_description' => App\Models\Settings::where(['key' => 'app_description'])->first()->value,
'app_keywords' => '',
'app_author' => '',
'app_favicon' => App\Models\Settings::where(['key'=>'app_favicon'])->first()->value,
'app_logo' => '',
];
@endphp

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0" />

    <title inertia>{{ $settings['app_name'] }}</title>
    <link rel="icon" type="image/x-icon" href="{{env('APP_URL')}}{{ $settings['app_favicon'] }}">


    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">


    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link href="https://fonts.googleapis.com/css2?family=Public+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,500;1,600;1,700&display=swap" rel="stylesheet" />

    <!-- Icons -->
    <link rel="stylesheet" href="{{ asset('backend/assets/fonts/boxicons.css') }}" />
    <link rel="stylesheet" href="{{ asset('backend/assets/fonts/fontawesome.css') }}" />
    <link rel="stylesheet" href="{{ asset('backend/assets/fonts/flag-icons.css') }}" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css"
      integrity="sha512-SnH5WK+bZxgPHs44uWIX+LLJAJ9/2PkPKZ5QiAj6Ta86w+fsb2TkcmfRyVX3pBnMFcV7oQPJkl9QevSCWr3W6A=="
      crossorigin="anonymous" referrerpolicy="no-referrer" />

    <link rel="stylesheet" href="{{asset('frontend/css/icons.css')}}">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/gh/lipis/flag-icons@6.6.6/css/flag-icons.min.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css" integrity="sha384-vp86vTRFVJgpjF9jiIGPEEqYqlDwgyBgEF109VFjmqGmIY/Y4HV4d3Gp2irVfcrp" crossorigin="anonymous">

    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <!-- Stylesheet ============================================= -->
    <link rel="stylesheet" href="{{ asset('frontend/css/custom-style.css') }}">
    <link rel="stylesheet" href="{{ asset('frontend/css/all.min.css') }}">
    <link rel="stylesheet" href="{{ asset('frontend/css/owl.carousel.min.css') }}">
    <link rel="stylesheet" href="{{ asset('frontend/css/owl.theme.default.min.css') }}">
    <link rel="stylesheet" href="{{ asset('frontend/css/hotel-datepicker.css') }}">


    <link rel="stylesheet" href="{{ asset('frontend/css/flag-icons.min.css') }}">
    <link rel="stylesheet" href="{{ asset('frontend/css/flag-icons.css') }}">
    <link rel="stylesheet" href="{{ asset('frontend/css/icons.css') }}">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/lightbox2/2.11.4/css/lightbox.min.css" integrity="sha512-ZKX+BvQihRJPA8CROKBhDNvoc2aDMOdAlcm7TUQY+35XYtrd3yh95QOOhsPDQY9QnKE0Wqag9y38OIgEvb88cA==" crossorigin="anonymous" referrerpolicy="no-referrer" />

    {{-- <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" /> --}}

    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>


    <!-- Owl Carousel -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.carousel.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.theme.default.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/owl.carousel.min.js"></script>
    <!-- swiper carousel -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />
    <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>

    <!-- Slick Slider Styles -->
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.css" />
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick-theme.css" />

    <!-- Slick Slider Script -->
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.min.js"></script>


    <!-- price range filter -->
    <!-- <link rel="stylesheet" href="https://code.jquery.com/mobile/1.4.5/jquery.mobile-1.4.5.min.css"> -->

    <!-- magnific-popup css cdn link  -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/magnific-popup.js/1.1.0/magnific-popup.min.css">

    <!-- custom css file link  -->
    <link rel="stylesheet" href="{{asset('frontend/css/custom-style.css')}}">

    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.5.0/css/font-awesome.min.css">

    <link href="
https://cdn.jsdelivr.net/npm/sweetalert2@11.12.4/dist/sweetalert2.min.css
" rel="stylesheet">

<link href="https://cdn.jsdelivr.net/npm/choices.js/public/assets/styles/choices.min.css" rel="stylesheet">

    @php
        if(request()->input('type')) {
            echo '<style>.mainNavBar{display:none;} .mainFooter{display:none;}</style>';
        }
    @endphp

    <!-- Scripts -->
    @routes
    @vite(['resources/js/Frontend/app.js'])
    @inertiaHead
</head>

<body>
    @inertia
  <!--Use the below code snippet to provide real time updates to the live chat plugin without the need of copying and paste each time to your website when changes are made via PBX-->
<!-- <call-us-selector phonesystem-url="https://nikoba.3cx.jp" party="LiveChat348139"></call-us-selector> -->
 
<!--Incase you don't want real time updates to the live chat plugin when options are changed, use the below code snippet. Please note that each time you change the settings you will need to copy and paste the snippet code to your website--> 
<!--<call-us 
phonesystem-url="https://nikoba.3cx.jp" 
style="position:fixed;font-size:16px;line-height:17px;z-index: 99999;--call-us-main-accent-color:#3397D4;--call-us-main-background-color:#FFFFFF;--call-us-plate-background-color:#373737;--call-us-plate-font-color:#E6E6E6;--call-us-main-font-color:#292929;--call-us-agent-bubble-color:#29292910;right: 20px; bottom: 20px;" 
id="wp-live-chat-by-3CX" 
minimized="true" 
animation-style="noanimation" 
party="LiveChat348139" 
minimized-style="bubbleright" 
allow-call="true" 
allow-video="false" 
allow-soundnotifications="true" 
enable-mute="true" 
enable-onmobile="true" 
offline-enabled="true" 
enable="true" 
ignore-queueownership="false" 
authentication="both" 
operator-name="Nikoba.com" 
show-operator-actual-name="true" 
aknowledge-received="true" 
gdpr-enabled="false" 
message-userinfo-format="both" 
message-dateformat="both" 
lang="browser" 
button-icon-type="default" 
greeting-visibility="none" 
greeting-offline-visibility="none" 
chat-delay="2000" 
enable-direct-call="true" 
enable-ga="false" 
></call-us>--> 
<script defer src="https://downloads-global.3cx.com/downloads/livechatandtalk/v1/callus.js" id="tcx-callus-js" charset="utf-8"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/choices.js/public/assets/scripts/choices.min.js"></script>
    <script src="
https://cdn.jsdelivr.net/npm/sweetalert2@11.12.4/dist/sweetalert2.all.min.js
"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    {{-- <script src="path/to/lightbox.js"></script> --}}
</body>

</html>