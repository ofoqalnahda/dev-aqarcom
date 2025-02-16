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
                                                    <th>@lang('account_type')</th>
                                                    <th>@lang('identity_owner_name')</th>
                                                    <th>@lang('commercial_name')</th>
                                                    <th>@lang('commercial_number')</th>
                                                    <th>@lang('commercial_image')</th>
                                                    <th>@lang('identity_image')</th>
                                                    <th>@lang('payment_method')</th>
                                                    <th>@lang('payment_receipt')</th>
                                                    <th>@lang('trans_number')</th>
                                                    <th>@lang('control')</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($users as $user)
                                                    <tr>
                                                        <td>
                                                            {{ $loop->iteration }}
                                                        </td>
                                                        <td>
                                                            <div class="d-flex align-items-center">
                                                                <a
                                                                    href="{{ route('dashboard.users.show', $user->id) }}"><span>{{ $user->name }}</span></a>
                                                            </div>
                                                        </td>
                                                        <td>
                                                            <div class="d-flex align-items-center">
                                                                <span>{{ $user->accountType?->name }}</span>
                                                            </div>
                                                        </td>
                                                        <td>
                                                            <div class="d-flex align-items-center">
                                                                <span>{{ $user->identity_owner_name }}</span>
                                                            </div>
                                                        </td>

                                                        <td>
                                                            <div class="d-flex align-items-center">
                                                                <span>{{ $user->commercial_number }}</span>
                                                            </div>
                                                        </td>

                                                        <td>
                                                            <div class="d-flex align-items-center">
                                                                <span>{{ $user->identity_owner_name }}</span>
                                                            </div>
                                                        </td>

                                                        <td>
                                                            <div class="d-flex align-items-center">
                                                                <span><a href="{{ get_file($user->commercial_image) }}"
                                                                        class="btn-sm btn-dark">
                                                                        @lang('show')</a></span>
                                                            </div>
                                                        </td>

                                                        <td>
                                                            <div class="d-flex align-items-center">
                                                                <span>
                                                                    <a href="{{ get_file($user->identity_image) }}"
                                                                        class="btn-sm btn-dark">
                                                                        @lang('show')</a>
                                                                </span>
                                                            </div>
                                                        </td>

                                                        <td class="text-wrap">
                                                            <div class="d-flex flex-column">
                                                                <span
                                                                    class="font-weight-bolder mb-25">{{ __($user->payment->type) }}</span>
                                                            </div>
                                                        </td>

                                                        <td class="text-wrap">
                                                            <div class="d-flex flex-column">
                                                                <span class="font-weight-bolder mb-25">
                                                                    <a target="_blank"
                                                                        href="{{ get_file($user->payment->receipt) }}">
                                                                        {{ $user->payment->type == 'bank' ? __('show') : '' }}
                                                                    </a>
                                                                </span>
                                                            </div>
                                                        </td>

                                                        <td class="text-wrap">
                                                            <div class="d-flex flex-column">
                                                                <span
                                                                    class="font-weight-bolder mb-25">{{ $user->payment->moyassar_payment_id }}</span>
                                                            </div>
                                                        </td>

                                                        <td>
                                                            <div class="d-flex align-items-center">
                                                                @can('authenticationRequests-accept')
                                                                    <a href="{{ route('dashboard.authenticationRequests.accept', $user->id) }}"
                                                                        class="btn-sm btn-info m-1">@lang('accept')</a>
                                                                @endcan
                                                                @can('authenticationRequests-reject')
                                                                    <a style="margin-left: 3px"
                                                                        href="{{ route('dashboard.authenticationRequests.reject', $user->id) }}"
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
