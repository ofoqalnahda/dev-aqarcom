@extends('dashboard.layouts.app')
@section('styles')
<style>
    span.class-withdraw {
        padding: 5px 10px;
        background: #42000038;
        border-radius: 10px;
        color: #6a0000;
        font-weight: 800;
        border: 1px #6a000087 solid;
    }
    span.class-deposit {
        padding: 5px 10px;
        background: #00423038;
        border-radius: 10px;
        color: #006a52;
        font-weight: 800;
        border: 1px #006a5287 solid;
    }
    span.class-completed {
        padding: 5px 10px;
        background: #276e61;
        border-radius: 10px;
        color: #ffffff;
        font-weight: 800;
        border: 1px #00606a87 solid;
    }
    span.class-pending {
        padding: 5px 10px;
        background: #766d0452;
        border-radius: 10px;
        color: #b59600;
        font-weight: 800;
        border: 1px #6a5d0087 solid;
    }
    html[lang='ar'] th{
        text-align: center !important;
    }
    td, th {
        text-align: center !important;
    }


    /*span.item-title {*/
    /*    font-size: 16px;*/
    /*    font-weight: 600;*/
    /*    color: #000;*/
    /*}*/
    .item-cost {
        padding: 5px 10px;
        border: 1px solid;
        border-radius: 5px;
    }
    .item-balance{
        background-color: #026e1440;
        color: #026e14 !important;
        font-size: 15px;
        font-weight: 700;
    }
    .item-total-withdrawals{
        background-color: rgba(110, 2, 2, 0.25);
        color: #6e0202 !important;
        font-size: 15px;
        font-weight: 700;
    }
    .item-total-deposits-pending {
        background-color: rgb(195 186 4 / 25%);
        color: #bfaf00 !important;
        font-size: 15px;
        font-weight: 700;
    }
    .item-total-withdrawals-pending{
        background-color: rgba(0, 0, 0, 0.25);
        color: #000000 !important;
        font-size: 15px;
        font-weight: 700;
    }
</style>
@endsection
@section('content')
    <!-- BEGIN: Content-->
    <div class="app-content content ">
        <div class="content-overlay"></div>
        <div class="header-navbar-shadow"></div>
        <div class="content-wrapper container-xxl p-0">
            <div class="content-header row">
                <div class="col-md-3 col-6">
                    <div class="item-cost item-balance">
                        <span class="item-title">
                            {{__('balance')}}:
                        </span>
                        <span class="item-value ">
                            {{$marketer->balance}} {{__('RS')}}
                        </span>
                    </div>

                </div>
                <div class="col-md-3 col-6">
                    <div class="item-cost item-total-withdrawals">
                        <span class="item-title ">
                            {{__('total_withdrawals')}}:
                        </span>
                        <span class="item-value ">
                            {{$marketer->total_withdrawals}} {{__('RS')}}
                        </span>
                    </div>
                </div>

                <div class="col-md-3 col-6 ">
                    <div class="item-cost item-total-deposits-pending">
                        <span class="item-title ">
                            {{__('total_deposits_pending')}}:
                        </span>
                        <span class="item-value ">
                            {{$marketer->total_deposits_pending}} {{__('RS')}}
                        </span>
                    </div>
                </div>
                <div class="col-md-3 col-6">
                    <div class="item-cost item-total-withdrawals-pending">
                        <span class="item-title  ">
                            {{__('total_withdrawals_pending')}}:
                        </span>
                        <span class="item-value">
                            {{$marketer->total_withdrawals_pending}} {{__('RS')}}
                        </span>
                    </div>
                </div>
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
                                        <table id="datatable-table" class="table">
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
                                                            {{$subscriptionRequest->id}}
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
                                        <table id="datatable-table2"  class="table">
                                            <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>@lang('transaction_id')</th>
                                                <th>@lang('type')</th>
                                                <th>@lang('status')</th>
                                                <th>@lang('amount')</th>
                                                <th>@lang('date')</th>
                                                <th>@lang('action')</th>

                                            </tr>
                                            </thead>
                                            <tbody>
                                                @foreach($draws as $draw)
                                                    <tr>
                                                        <td>
                                                            {{$loop->iteration}}
                                                        </td>
                                                        <td>
                                                            {{$draw->transaction_id}}
                                                        </td>
                                                        <td>
                                                            <span class="class-{{$draw->transaction_type}}">
                                                                {{__($draw->transaction_type)}}
                                                            </span>

                                                        </td>
                                                        <td>
                                                            <span class="class-{{$draw->status}}">
                                                                {{__($draw->status)}}
                                                            </span>
                                                        </td>
                                                        <td class="text-nowrap">
                                                            <div class="d-flex flex-column">
                                                                <span class="font-weight-bolder mb-25">{{number_format($draw->amount,2)}} @lang('sar')</span>
                                                            </div>
                                                        </td>
                                                        <td>
                                                            <div class="d-flex align-items-center">
                                                                <span>{{$draw->created_at->format('Y/m/d')}}</span>
                                                            </div>
                                                        </td>
                                                        <td>

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
