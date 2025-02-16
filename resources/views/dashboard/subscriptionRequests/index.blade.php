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
                                        <table id="datatable-table" class="table">
                                            <thead>
                                                <tr>
                                                    <th>#</th>
                                                    <th>@lang('user_name')</th>
                                                    <th>@lang('subscription_name')</th>
                                                    <th>@lang('price')</th>
                                                    <th>@lang('payment_method')</th>
                                                    <th>@lang('payment_receipt')</th>
                                                    <th>@lang('trans_number')</th>
                                                    <th>@lang('coupon')</th>
                                                    <th>@lang('date')</th>
                                                    <th>@lang('control')</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($subscriptionRequests as $subscriptionRequest)
                                                    <tr>
                                                        <td>
                                                            {{ $loop->iteration }}
                                                        </td>
                                                        <td>
                                                            <div class="d-flex align-items-center">
                                                                <a
                                                                    href="{{ route('dashboard.users.show', $subscriptionRequest->user_id) }}"><span>{{ $subscriptionRequest->user?->name }}</span></a>
                                                            </div>
                                                        </td>
                                                        <td>
                                                            <div class="d-flex align-items-center">
                                                                <span>{{ $subscriptionRequest->subscription->name }}</span>
                                                            </div>
                                                        </td>
                                                        <td>
                                                            <div class="d-flex align-items-center">
                                                                <span>{{ $subscriptionRequest->price }}</span>
                                                            </div>
                                                        </td>

                                                        <td class="text-wrap">
                                                            <div class="d-flex flex-column">
                                                                <span
                                                                    class="font-weight-bolder mb-25">{{ __($subscriptionRequest->payment->type) }}</span>
                                                            </div>
                                                        </td>

                                                        <td class="text-wrap">
                                                            <div class="d-flex flex-column">
                                                                <span class="font-weight-bolder mb-25">
                                                                    <a target="_blank"
                                                                        href="{{ get_file($subscriptionRequest->payment->receipt) }}">
                                                                        {{ $subscriptionRequest->payment->type == 'bank' ? __('show') : '' }}
                                                                    </a>
                                                                </span>
                                                            </div>
                                                        </td>

                                                        <td class="text-wrap">
                                                            <div class="d-flex flex-column">
                                                                <span
                                                                    class="font-weight-bolder mb-25">{{ $subscriptionRequest->payment->moyassar_payment_id }}</span>
                                                            </div>
                                                        </td>

                                                        <td class="text-wrap">
                                                            <div class="d-flex flex-column">
                                                                <span
                                                                    class="font-weight-bolder mb-25">{{ $subscriptionRequest->coupon}}</span>
                                                            </div>
                                                        </td>

                                                        <td class="text-wrap">
                                                            <div class="d-flex flex-column">
                                                                <span
                                                                    class="font-weight-bolder mb-25">{{ $subscriptionRequest->created_at->format('Y-m-d') }}</span>
                                                            </div>
                                                        </td>

                                                        <td>
                                                            <div class="d-flex align-items-center">
                                                                @can('subscriptionRequests-accept')
                                                                    <a href="{{ route('dashboard.subscriptionRequests.accept', $subscriptionRequest->id) }}"
                                                                        class="btn-sm btn-info m-1">@lang('accept')</a>
                                                                @endcan
                                                                @can('subscriptionRequests-reject')
                                                                    <a style="margin-left: 3px"
                                                                        href="{{ route('dashboard.subscriptionRequests.reject', $subscriptionRequest->id) }}"
                                                                        class="btn-sm btn-danger">@lang('reject')</a>
                                                                @endcan
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
