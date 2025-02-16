<!DOCTYPE html>
<html lang="{{app()->getLocale()}}" dir="{{app()->getLocale() == 'ar' ? 'rtl' : 'ltr'}}">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="{{asset('website')}}/css/bootstrap.min.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Tajawal:wght@200;400;500;700&display=swap" rel="stylesheet">
    <link
        rel="stylesheet"
        href="https://cdn.jsdelivr.net/npm/swiper@8/swiper-bundle.min.css"
    />
    <link rel="stylesheet" href="{{asset('website')}}/css/home.css">
    <link rel="stylesheet" href="{{ asset('website/css/noty.css') }}">
    <script src="{{ asset('website/javascript/noty.min.js') }}"></script>

    <title>@lang('aqarcom')</title>
</head>
<body>
<nav class="navbar navbar-expand-lg fixed-top ">
    <div class="container-fluid">
        <!-- <a class="navbar-brand" href="#">Navbar</a> -->
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul id="primary" class="navbar-nav  mb-2 mb-lg-0">
                <li class="nav-item">
                    <a class="nav-link active" aria-current="page" href="#">@lang('aqarcom')</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{route('home')}}">@lang('home')</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link " href="#about-us" >@lang('who_we_are')</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link " href="#advantages" >@lang('most_estate_services')</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link " href="#" >@lang('support_services')</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link " href="#customer-services" >@lang('consumer_services')</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{route('changeLocale' , changeLocale(app()->getLocale()))}}">@lang(changeLocale(app()->getLocale()))</a>
                </li>

            </ul>
        </div>
    </div>
</nav>

<!-- start header -->
<div class="header" id="header">
    <div class="container">
        <div class="row">
            <div class="col col-lg-12 col-xl-12">
                <h3>@lang('privacy')</h3>
                {!! $privacy->privacy !!}
            </div>

        </div>
    </div>
</div>

<div class="footer">
    <div class="container">
        <div class="row">
            <div class="col-sm-12 col-md col-lg-5">
                <img src="{{asset('website')}}/images/footer_Logo.png" alt="">
                <p>
                   {{$setting?->description}}
                </p>
            </div>
            <div class="col-sm-12 col-md col-lg-4">
                <ul>
                    <li>
                        <a href="#about-us">@lang('who_we_are')</a>
                    </li>

                    <li>
                        <a href="#advantages">@lang('app_features')</a>
                    </li>

                    <li>
                        <a href="#services">@lang('most_estate_services')</a>
                    </li>

                    <li>
                        <a href="#builder-services">@lang('estate_developer_services')</a>
                    </li>
                    <li>
                        <a href="#other-services" >@lang('support_services')</a>
                    </li>
                    <li>
                        <a href="#getApp">@lang('app_images')</a>
                    </li>
                </ul>
            </div>

            <div class="col-sm-12 col-md col-lg-3 contact-details">
                <ul>
                    <li><a>@lang('contact_info')</a></li>
                    <li><a><i class="fa-solid fa-phone"></i><span>{{$setting?->phone}}</span></a></li>
                    <li><a href="mailto:{{$setting?->email}}"><i class="fa-regular fa-envelope"></i><span>{{$setting?->email}}</span></a></li>
                    <li><a href=""><i class="fa-solid fa-location-dot"></i><span>{{$setting?->address}}</span></a></li>
                </ul>
            </div>
        </div>
    </div>
    <div class="copyright">
        <div class="socials">
            <ul>
                <li>
                    <a href="{{$setting?->instagram}}">
                        <i class="fa-brands fa-instagram"></i>
                    </a>
                </li>

                <li>
                    <a href="{{$setting?->snapchat}}">
                        <i class="fa-brands fa-snapchat"></i>
                    </a>
                </li>

                <li>
                    <a href="{{$setting?->linkedin}}">
                        <i class="fa-brands fa-linkedin-in"></i>
                    </a>
                </li>

                <li>
                    <a href="{{$setting?->twitter}}">
                        <i class="fa-brands fa-twitter"></i>
                    </a>
                </li>

                <li>
                    <a href="{{$setting?->facebook}}">
                        <i class="fa-brands fa-facebook"></i>
                    </a>
                </li>
            </ul>
        </div>
        <p>@lang('copy_rights')</p>
    </div>
</div>
<!-- end footer -->

<script src="https://cdn.jsdelivr.net/npm/swiper@8/swiper-bundle.min.js"></script>
@include('partials.errorAlert')
@include('partials.successAlert')
<script src="{{asset('website')}}/javascript/all.min.js"></script>
<script src="{{asset('website')}}/javascript/bootstrap.bundle.min.js"></script>
<script src="{{asset('website')}}/javascript/home.js"></script>
</body>
</html>
