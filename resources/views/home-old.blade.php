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
    <style>
        .sponsors{
                margin-top: 0!important;
        }
        .other-services {
            margin-bottom: 100px;
        }
    </style>
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
                    <a class="nav-link" href="#">@lang('home')</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link " href="#about-us" >@lang('who_we_are')</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link " href="#advantages" >@lang('most_estate_services')</a>
                </li>
                @if($setting->status_support_services)
                <li class="nav-item">
                    <a class="nav-link " href="#" >@lang('support_services')</a>
                </li>
                @endif
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
            <div class="col col-lg-4 col-xl-3">
{{--                <img src="{{asset('website')}}/images/header-phone.png" alt="">--}}
                <img src="{{get_file($about_app?->images?->first()?->image)}}" alt="">
            </div>
            <div class="col col-lg-8 col-xl-9">
                <h3><span>@lang('about_app')</span><span class="yellow"> @lang('aqarcom') </span></h3>

                   {!!$setting?->about_us!!}

            </div>

        </div>
    </div>
</div>
<!-- end header -->
<!-- start about us -->
<div class="about-us" id="about-us">
    <div class="container">
        <h3> @lang('who_we_are')  </h3>
        <div class="row">
            <div class="col-12 col-md-6">
                <div class="image">
                    <img src="{{get_file($our_message?->images?->first()?->image)}}" alt="">
                </div>
                <h4>@lang('our_message')</h4>
                <p>{{$setting?->our_message}}</p>
            </div>
            <div class="col-12 col-md-6">
                <div class="image">
                    <img src="{{get_file($our_vision?->images?->first()?->image)}}" alt="">
                </div>
                <h4>@lang('our_vision')</h4>
                <p>{{$setting?->our_vision}}</p>
            </div>
        </div>
    </div>
</div>
<!-- end about us -->
<!-- start website advantages -->
<div class="advantages" id="advantages">
    <div class="container">
        <h3>@lang('app_features')</h3>
        <div class="row">
            <div class="col-12 col-lg-4 col-xl-3">
                @foreach($features as $feature)
                    @continue($loop->iteration >6)
                    <div class="text">
                        {{$feature->title}}
                    </div>
                @endforeach
            </div>
            <div class="col-12 col-lg-4 col-xl-3">
                @foreach($features as $feature)
                    @continue($loop->iteration != 7)
                    <div class="text">
                        {{$feature->title}}
                    </div>
                @endforeach
                <img src="{{get_file($app_features?->images?->first()?->image)}}" alt="">
                @foreach($features as $feature)
                    @continue($loop->iteration != 8)
                    <div class="text">
                        {{$feature->title}}
                    </div>
                @endforeach
            </div>
            <div class="col-12 col-lg-4 col-xl-3">
                @foreach($features as $feature)
                    @continue($loop->iteration < 9 || $loop->iteration > 14)
                    <div class="text">
                        {{$feature->title}}
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</div>
<!-- end website advantages -->
<!-- start services -->
<div class="services" id="services">
    <div class="container">
        <h3>@lang('most_estate_services')</h3>
        <div class="Allservices">
            @foreach($services as $service)
                <div>
                    <img src="{{get_file($service->image)}}" alt="">
                    <p>
                        {{$service->name}}
                    </p>
                </div>
            @endforeach
        </div>
    </div>
</div>
<!-- end services -->
@if($setting->status_support_services)
<!-- start other services -->
<div class="other-services">
    <div class="container">
        <h3>@lang('support_services')</h3>
        <div class="row justify-content-between">
            <div class="images col col-xl-6 d-flex">
                <div>
                    @foreach((array)$support_services?->images->toArray() as $image)
                        @continue($loop->iteration>3)
                        <img class="support-image-1" src="{{get_file($image['image'])}}" alt="">
                    @endforeach
                </div>
                <div>
                    @foreach((array)$support_services?->images->toArray() as $index => $image)
                        @continue($loop->iteration<=3 || $loop->iteration >5)
                        <img class="support-image-2" style="" src="{{get_file($image['image'])}}" alt="">
                    @endforeach
                </div>
            </div>
            <div class="col col-xl-5">
                <div class="sections row">
                    <div class="col col-xl-6">
                        @foreach($supportServices as $service)
                            @continue($loop->iteration > 10)
                            <div>
                                <img src="{{get_file($service->image)}}" alt="">
                                <p>{{$service->title}}</p>
                            </div>
                        @endforeach
                    </div>
                    <div class="col col-xl-6">
                        @foreach($supportServices as $service)
                            @continue($loop->iteration < 11 || $loop->iteration > 20)
                            <div>
                                <img src="{{get_file($service->image)}}" alt="">
                                <p>{{$service->title}}</p>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- end other services -->
@endif
<!-- start sponsors -->
<div class="sponsors">
    <div class="container">
        <h3>@lang('sponsors')</h3>
    </div>
    <div class="swiper mySwiper">
        <div class="swiper-wrapper">
            @foreach($sponsors as $sponsor)
                <div class="swiper-slide"><img src="{{$sponsor->image}}" alt=""></div>
            @endforeach
        </div>
        <!-- <div class="swiper-pagination"></div> -->
    </div>
</div>
<!-- end sponsors -->
<!-- start customer services -->
<div class="customer-services">
    <div class="container">
        <h3>@lang('pre_purchase_services')</h3>
        <div class="row">
            <div class="col-12 col-md-6">
                @foreach($prePurchaseServices as $service)
                <div>
                    <img style=""  src="{{get_file($service->image)}}" alt="">
                    <p>{{$service->title}}</p>
                </div>
                @endforeach
            </div>
            <div class="col-12 col-md-6">
                <div class="image">
                    <img src="{{get_file($pre_purchase_services?->images?->first()?->image)}}" alt="">
                </div>
            </div>
        </div>
    </div>
</div>
<!-- end customer services -->
<!-- start customer services -->
<div class="customer-services services-2">
    <div class="container">
        <h3> @lang('post_purchase_services')</h3>
        <div class="row">
            <div class="col-12 col-md-6">
                @foreach($postPurchaseServices as $service)
                    <div>
                        <img style=""  src="{{get_file($service->image)}}" alt="">
                        <p>{{$service->title}}</p>
                    </div>
                @endforeach
            </div>
            <div class="col-12 col-md-6">
                <div class="image">
                    <img src="{{get_file($post_purchase_services?->images?->first()?->image)}}" alt="">
                </div>
            </div>
        </div>
    </div>
</div>
<!-- end customer services -->
<!-- start builder services -->
<div class="builder-services" id="builder-services">
    <div class="container">
        <h3>@lang('estate_developer_services')</h3>
        <div class="projects">
            @foreach($estateDevelopersServices as $service)
                <div class="project">
                    <div class="image">
                        <img style="" src="{{get_file($service->image)}}" alt="">
                    </div>
                    <p>{{$service->title}}</p>
                </div>
            @endforeach
        </div>
    </div>
</div>
<!-- end builder services -->
<!-- start customer services -->
<div class="customer-services services-after-sell" id="customer-services">
    <div class="container">
        <h3>@lang('after_sell_services')</h3>
        <div class="row">
            <div class="col-12 col-md-6">
                @foreach($afterSellServices as $service)
                    <div>
                        <img style=""  src="{{get_file($service->image)}}" alt="">
                        <p>{{$service->title}}</p>
                    </div>
                @endforeach
            </div>
            <div class="col-12 col-md-6">
                <div class="image">
                    <img src="{{get_file($after_sell_services?->images?->first()?->image)}}" alt="">
                </div>
            </div>
        </div>
    </div>
</div>
<!-- end customer services -->
<!-- start get app -->
<div class="getApp" id="getApp">
    <div class="container">
        <div class="row">
            <div class="col col-lg-6">
                <div>
                    <img class="getApp-logo" src="{{get_file($setting?->logo)}}" alt="">
                    <div>
                        <h2>@lang('aqarcom')</h2>
                    </div>
                </div>
                <h2>@lang('download_app_now')</h2>
                <div>
                    <a href="{{$setting?->google_play}}">
                        <img src="{{asset('website')}}/images/googleplay.png" alt="">
                    </a>

                    <a href="{{$setting?->app_store}}">
                        <img src="{{asset('website')}}/images/appstore.png" alt="">
                    </a>
                    
                    <a href="{{$setting?->huawei_store}}">
                        <img style="width:183px" src="{{asset('website')}}/images/huaweitore.png" alt="">
                    </a>
                </div>
            </div>
            <div class="col col-lg-5">
                <img class="getApp-image" src="{{get_file($app_images?->images?->first()?->image)}}" alt="">
            </div>
        </div>
    </div>
</div>
<!-- end get app -->
<!-- start footer -->
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
                    @if($setting->status_support_services)
                    <li>
                        <a href="#other-services" >@lang('support_services')</a>
                    </li>
                    @endif
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
