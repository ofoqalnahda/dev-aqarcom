@extends('dashboard.layouts.app')

@section('content')
@php
        $platform= $ad->platform()->first();
       $platform_data = json_decode($platform->data, true);


@endphp
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
                                                    <td>
                                                        @can('ads-changeStatus')
                                                            <div class="d-flex custom-control custom-control-primary custom-switch">
                                                                <input type="checkbox" class="custom-control-input" id="customSwitch{{$ad->id}}" {{$ad->active? 'checked' : ''}} />
                                                                <label class="custom-control-label changeStatus" for="customSwitch{{$ad->id}}" data-id="{{$ad->id}}"></label>
                                                            </div>
                                                        @endcan
                                                    </td>
                                                    <td>
                                                        <div class="d-flex align-items-center">
                                                            
                                                            @can('ads-destroy')
                                                            <form action="{{route('dashboard.ads.destroy' , $ad->id)}}" method="post">
                                                                @csrf
                                                                @method('delete')
                                                                <button type="submit" class="btn btn-sm btn-danger m-1"><i data-feather="trash"></i></button>
                                                            </form>
                                                            @endcan
                                                        </div>
                                                    </td>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <td class="title-table">@lang('user')</td>
                                                    <td>
                                                        <a href="{{route('dashboard.users.show' , $ad->user_id)}}"> {{$ad->user_id}}  {{$ad->user?->name}}</a>
                                                    </td>
                                                    <td class="title-table">@lang('phone')</td>
                                                    <td><a href="https://wa.me/966{{$ad->user?->phone}}?text=%D8%A7%D9%84%D8%B3%D9%84%D8%A7%D9%85%20%D8%B9%D9%84%D9%8A%D9%83%D9%85" target="_blank">{{$ad->user?->phone}}</a></td>
                                                </tr>
                                                <tr>
                                                    <td>@lang('changeStatus_date_expiry')</td>
                                                    <td>{{$platform_data['endDate']}}</td>
                                                </tr>
                                                <tr>
                                                    <td>@lang('estate_area')</td>
                                                    <td>{{$ad->estateArea?->name}}</td>
                                                </tr>
                                                <tr>
                                                    <td>@lang('city')</td>
                                                    <td>{{$ad->city?->name}}</td>
                                                </tr>
                                                <tr>
                                                    <td>@lang('neighborhood')</td>
                                                    <td>{{$ad->neighborhood?->name}}</td>
                                                </tr>
                                                <tr>
                                                    <td>@lang('main_type')</td>
                                                    <td>{{__($ad->main_type)}}</td>
                                                </tr>
                                                <tr>
                                                    <td>@lang('ad_type')</td>
                                                    <td>{{$ad->adType?->name}}</td>
                                                </tr>
                                                <tr>
                                                    <td>@lang('estate_type')</td>
                                                    <td>{{$ad->estateType?->name}}</td>
                                                </tr>
                                                <tr>
                                                    <td>@lang('usage_type')</td>
                                                    <td>{{$ad->usageType?->name}}</td>
                                                </tr>
                                                <tr>
                                                    <td>@lang('description')</td>
                                                    <td>{{$ad->description}}</td>
                                                </tr>


                                                @if($ad->main_type == 'sell')
                                                    <tr>
                                                        <td>@lang('price')</td>
                                                        <td>{{number_format($ad->price , 2)}}</td>
                                                    </tr>
                                                    <tr>
                                                        <td>@lang('area')</td>
                                                        <td>{{number_format($ad->area , 2)}}</td>
                                                    </tr>
                                                    <tr>
                                                        <td>@lang('location')</td>
                                                        <td>{{$ad->address}}</td>
                                                    </tr>
                                                @else
                                                    <tr>
                                                        <td>@lang('min_price')</td>
                                                        <td>{{number_format($ad->min_price , 2)}}</td>
                                                    </tr>
                                                    <tr>
                                                        <td>@lang('max_price')</td>
                                                        <td>{{number_format($ad->max_price , 2)}}</td>
                                                    </tr>
                                                    <tr>
                                                        <td>@lang('min_area')</td>
                                                        <td>{{number_format($ad->min_area , 2)}}</td>
                                                    </tr>
                                                    <tr>
                                                        <td>@lang('max_area')</td>
                                                        <td>{{number_format($ad->max_area , 2)}}</td>
                                                    </tr>
                                                @endif
                                                <tr>
                                                    <td>@lang('special')</td>
                                                    <td>{{$ad->special ? __('yes') : __('no')}}</td>
                                                </tr>

                                                <tr>
                                                    <td>@lang('advertiser_orientation')</td>
                                                    <td>{{$ad->advertiserOrientation?->name}}</td>
                                                </tr>

                                                <tr>
                                                    <td>@lang('advertiser_type')</td>
                                                    <td>{{__($ad->advertiser_type)}}</td>
                                                </tr>

                                                @if($ad->advertiser_type == 'delegate')
                                                    <tr>
                                                        <td>@lang('advertiser_registration_number')</td>
                                                        <td>{{$ad->advertiser_registration_number}}</td>
                                                    </tr>

                                                    <tr>
                                                        <td>@lang('delegation_number')</td>
                                                        <td>{{$ad->delegation_number}}</td>
                                                    </tr>
                                                @endif

                                                <tr>
                                                    <td>@lang('date')</td>
                                                    <td>{{$ad->created_at->format('Y-m-d')}}</td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                            <div class="card card-company-table">
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
                                            @foreach($ad->options as $option)
                                                <tr>
                                                    <td>{{$option->name}}</td>
                                                    <td>
                                                        @foreach((array)json_decode($option->pivot->values) as $value)
                                                            <span class="badge badge-dark">{{is_string($value) ?__($value) : $value->{app()->getLocale()} }}</span>
                                                        @endforeach
                                                    </td>
                                                </tr>
                                            @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                            <div class="card card-company-table">
                                <div class="card-body p-0">
                                    <div class="table-responsive">
                                        <h2 style="font-size: 30px;font-weight: bold; padding: 15px;">@lang('attachments')</h2>
                                        <hr style="    margin-top: -15px;width: 98%;">
                                        <div class="row">
                                            @foreach($ad->attachments as $attachment)
                                                @if(preg_match('(.mp4|.avi)', $attachment->link) === 1)
                                                    <div style="width: 300px;margin: 15px;height: 300px;display: inline-block;" class="attachments col-md-3">
                                                        <video style="width: 100%;height: 100%;object-fit: cover;" controls>
                                                            <source src="{{get_file($attachment->link)}}" >
                                                            Your browser does not support the video tag.
                                                        </video>
                                                    </div>
                                                @else
                                                    <div style="margin: 15px" class="attachments col-md-3">
                                                        <img style="height: 300px;width: 300px;" src="{{get_file($attachment->link)}}" class="img-thumbnail" alt="Cinque Terre">
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
     @push('scripts')
        <script>
            $('.changeStatus').on('click' , function (){
                var id = $(this).data('id');
                var url = '{{route("dashboard.ads.changeStatus" , ":id")}}';
                url = url.replace(':id' , id);

                $.ajax({
                    url: url,
                    method: "get",
                    dataType: 'json',
                    cache: false,
                    contentType: false,
                    processData: false,
                    success: function (response) {
                        new Noty({
                            type: 'success',
                            layout: 'topRight',
                            text: response.success,
                            timeout: 2000,
                            killer: true
                        }).show();
                    },
                    error: function (response) {
                        console.log(response.responseJSON);
                        new Noty({
                            type: 'error',
                            layout: 'topRight',
                            text: response.responseJSON.error,
                            timeout: 2000,
                            killer: true
                        }).show();
                    }
                });
            });
        </script>
    @endpush
@endsection
