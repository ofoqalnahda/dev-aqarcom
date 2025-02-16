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
                <section id="dashboard-ecommerce">
                    <div class="row match-height">
                        <!-- Company Table Card -->
                        <div class="col-lg-12 col-12">
                            <div class="card card-company-table">
                                <div class="card-body p-0">
                                    <div class="table-responsive">
                                        <table id="datatable-table"  class="table">
                                            <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>@lang('name')</th>
                                                <th>@lang('city')</th>
                                                <th>@lang('subscription')</th>
                                                <th>@lang('premium')</th>
                                                <th>@lang('price')</th>
                                                <th>@lang('coupon')</th>
                                                <th>@lang('payment_method')</th>
                                                <th>@lang('payment_id')</th>
                                                <th>@lang('date')</th>
                                                <th>@lang('left_period')</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                                @foreach($subscriptions as $subscription)
                                                    <tr>
                                                        <td>
                                                            {{$loop->iteration}}
                                                        </td>
                                                        <td>
                                                            <div class="d-flex align-items-center">
                                                                <a href="{{route('dashboard.users.show' , $subscription->user_id )}}"><span>{{$subscription->user?->name}}</span></a>
                                                            </div>
                                                        </td>
{{--                                                        @dd($subscription->city?->name)--}}
                                                        <td class="text-nowrap">
                                                            <div class="d-flex">
                                                                <span>{{$subscription->city?->name}}</span>
                                                            </div>
                                                        </td>
                                                        <td>
                                                            <div class="d-flex align-items-center">
                                                                <span>{{$subscription->subscription?->name}}</span>
                                                            </div>
                                                        </td>
                                                        <td>
                                                            <div class="d-flex align-items-center">
                                                                <span>{{$subscription->subscription?->premium ? __('yes') : __('no')}}</span>
                                                            </div>
                                                        </td>
                                                        <td class="text-wrap">
                                                            <div class="d-flex flex-column">
                                                                <span class="font-weight-bolder mb-25">{{$subscription->price }}</span>
                                                            </div>
                                                        </td>
                                                        <td class="text-wrap">
                                                            <div class="d-flex flex-column">
                                                                <span class="font-weight-bolder mb-25">{{$subscription->coupon}}</span>
                                                            </div>
                                                        </td>

                                                        <td class="text-wrap">
                                                            <div class="d-flex flex-column">
                                                                <span class="font-weight-bolder mb-25">{{$subscription->payment?->type}} </span>
                                                            </div>
                                                        </td>
                                                        <td class="text-wrap">
                                                            <div class="d-flex flex-column">
                                                                <span class="font-weight-bolder mb-25">{{$subscription->payment?->moyassar_payment_id ? $subscription->payment->moyassar_payment_id : __('bank')}} </span>
                                                            </div>
                                                        </td>

                                                        <td class="text-wrap">
                                                            <div class="d-flex flex-column">
                                                                <span class="font-weight-bolder mb-25">{{$subscription->created_at->format('Y-m-d H:i A')}}</span>
                                                            </div>
                                                        </td>
                                                        <td class="text-wrap">
                                                            <div class="d-flex flex-column">
                                                                <span class="font-weight-bolder mb-25">{{$subscription->days_left}} {{__("day")}}</span>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
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
