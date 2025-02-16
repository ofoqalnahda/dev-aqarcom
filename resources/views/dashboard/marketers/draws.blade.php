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
                                <div class="card-header">
                                    <h4 class="card-title">@lang('subscriptions')</h4>
                                </div>
                                <div class="card-body p-0">
                                    <div class="table-responsive">
                                        <table class="table">
                                            <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>@lang('user_name')</th>
                                                <th>@lang('subscription_name')</th>
                                                <th>@lang('price')</th>
                                                <th>@lang('date')</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                                @foreach($subscriptionRequests as $subscriptionRequest)
                                                    <tr>
                                                        <td>
                                                            {{$loop->iteration}}
                                                        </td>
                                                        <td>
                                                            @can('users-show')
                                                            <div class="d-flex align-items-center">
                                                                <a href="{{route('dashboard.users.show' , $subscriptionRequest->user_id)}}"><span>{{ $subscriptionRequest->user_id .'-'.$subscriptionRequest->user->name}}</span></a>
                                                            </div>
                                                            @endcan
                                                        </td>
                                                        <td>
                                                            <div class="d-flex align-items-center">
                                                                <span>{{$subscriptionRequest->subscription->name}}</span>
                                                            </div>
                                                        </td>

                                                        <td class="text-wrap">
                                                            <div class="d-flex flex-column">
                                                                <span class="font-weight-bolder mb-25">{{$subscriptionRequest->amount}}</span>
                                                            </div>
                                                        </td>

                                                        <td class="text-wrap">
                                                            <div class="d-flex flex-column">
                                                                <span class="font-weight-bolder mb-25">{{$subscriptionRequest->created_at->format('Y-m-d')}}</span>
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
                                <div class="card-header">
                                    <h4 class="card-title">@lang('draws')</h4>
                                </div>
                                <div class="card-body p-0">
                                    <div class="table-responsive">
                                        <table class="table">
                                            <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>@lang('date')</th>
                                                <th>@lang('amount')</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                                @foreach($draws as $draw)
                                                    <tr>
                                                        <td>
                                                            {{$loop->iteration}}
                                                        </td>
                                                        <td>
                                                            <div class="d-flex align-items-center">
                                                                <span>{{$draw->created_at->format('Y/m/d')}}</span>
                                                            </div>
                                                        </td>
                                                        <td class="text-nowrap">
                                                            <div class="d-flex flex-column">
                                                                <span class="font-weight-bolder mb-25">{{number_format($draw->balance,2)}} @lang('sar')</span>
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
