@extends('dashboard.layouts.app')

@section('content')
    <!-- BEGIN: Content-->
    <div class="app-content content ">
        <div class="content-overlay"></div>
        <div class="header-navbar-shadow"></div>
        <div class="content-wrapper container-xxl p-0">
            <div class="content-header row">
            </div>
            <div class="content-body">
                <!-- dashboard_files Ecommerce Starts -->
                <section id="dashboard_files-ecommerce">
                    <div class="row match-height">
                        <!-- Company Table Card -->
                        <div class="col-lg-12 col-12">
                            <div class="card card-company-table">
                                <div class="card-body p-0">
                                    <div class="table-responsive">
                                        <table class="table">
                                            <thead>
                                                <tr style="background-color: #f3f2f7">
                                                    <td style="width: 30%;">@lang('details')</td>
                                                    <td>@lang('values')</td>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <td>@lang('user_name')</td>
                                                    <td><a href="{{route('dashboard.users.show' , $ad->user_id)}}">{{$ad->user?->name}}</a></td>
                                                </tr>
                                                <tr>
                                                    <td>@lang('estate_area')</td>
                                                    <td>{{$ad->area?->name}}</td>
                                                </tr>
                                                <tr>
                                                    <td>@lang('city')</td>
                                                    <td>{{$ad->city?->name}}</td>
                                                </tr>
{{--                                                <tr>--}}
{{--                                                    <td>@lang('neighborhood')</td>--}}
{{--                                                    <td>{{$ad->neighborhood?->name}}</td>--}}
{{--                                                </tr>--}}
                                                <tr>
                                                    <td>@lang('main_type')</td>
                                                    <td>{{__($ad->supportService?->title)}}</td>
                                                </tr>
                                                <tr>
                                                    <td>@lang('title')</td>
                                                    <td>{{$ad->title}}</td>
                                                </tr>
                                                <tr>
                                                    <td>@lang('description')</td>
                                                    <td>{{$ad->description}}</td>
                                                </tr>



                                                <tr>
                                                    <td>@lang('date')</td>
                                                    <td>{{$ad->created_at->format('Y-m-d')}}</td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                            {{--<div class="card card-company-table">
                                <div class="card-body p-0">
                                    <div class="table-responsive">
                                        <h2 style="font-size: 30px;font-weight: bold; padding: 15px;">@lang('properties')</h2>
                                        <hr style="    margin-top: -15px;width: 98%;">
                                        <table class="table">
                                            <thead>
                                            <tr style="background-color: #f3f2f7">
                                                <td style="width: 30%;">@lang('property')</td>
                                                <td>@lang('value')</td>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            --}}{{--@foreach($ad->options as $option)
                                                <tr>
                                                    <td>{{$option->name}}</td>
                                                    <td>
                                                        @foreach((array)json_decode($option->pivot->values) as $value)
                                                            <span class="badge badge-dark">{{is_string($value) ?__($value) : $value->{app()->getLocale()} }}</span>
                                                        @endforeach
                                                    </td>
                                                </tr>
                                            @endforeach--}}{{--
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>--}}
                            <div class="card card-company-table">
                                <div class="card-body p-0">
                                    <div class="table-responsive">
                                        <h2 style="font-size: 30px;font-weight: bold; padding: 15px;">@lang('attachments')</h2>
                                        <hr style="    margin-top: -15px;width: 98%;">
                                        <div class="row">
{{--                                            @dd($ad->attachments)--}}
                                            @foreach($ad->attachments as $attachment)
{{--                                                @dd($attachment->path)--}}
                                                @if(preg_match('(.mp4|.avi)', $attachment->path) === 1)
                                                    <div style="width: 300px;margin: 15px;height: 300px;display: inline-block;" class="attachments col-md-3">
                                                        <video style="width: 100%;height: 100%;object-fit: cover;" controls>
                                                            <source src="{{get_file($attachment->path)}}" >
                                                            Your browser does not support the video tag.
                                                        </video>
                                                    </div>
                                                @else
                                                    <div style="margin: 15px" class="attachments col-md-3">
                                                        <img style="height: 300px;width: 300px;" src="{{get_file($attachment->path)}}" class="img-thumbnail" alt="Cinque Terre">
                                                    </div>

                                                @endif
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!--/ Company Table Card -->
                    </div>
                </section>
                <!-- dashboard_files Ecommerce ends -->

            </div>
        </div>
    </div>
    <!-- END: Content-->
@endsection
