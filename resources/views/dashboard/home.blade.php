@extends('dashboard.layouts.app')

@section('content')
    <!-- BEGIN: Content-->
    @can('home')
    <div class="app-content content ">
        <div class="content-overlay"></div>
        <div class="header-navbar-shadow"></div>
        <div class="content-wrapper container-xxl p-0">
            <div class="content-header row">
            </div>
            <div class="content-body">
                <!-- dashboard_files Ecommerce Starts -->
                <section id="dashboard_files-ecommerce">
                    <div class="card-container d-flex">
                        <div class="row">

                            <div class="col-xl-2 col-md-4 col-sm-6 flex-fill">
                                <div class="card text-center">
                                    <a href="{{ route('dashboard.users.index') }}">
                                        <div class="card-body">
                                            <div class="avatar bg-light-info p-50 mb-1">
                                                <div class="avatar-content">
                                                    <i data-feather="zap" class="font-medium-5"></i>
                                                </div>
                                            </div>
                                            <h2 class="font-weight-bolder">{{ \App\Models\User::count() }}</h2>
                                            <p class="card-text">@lang('users')</p>
                                        </div>
                                    </a>
                                </div>
                            </div>
                            <div class="col-xl-2 col-md-4 col-sm-6 flex-fill">
                                <div class="card text-center">
                                    <a href="{{ route('dashboard.users.index',['nafath_verified'=>'1']) }}">
                                        <div class="card-body">
                                            <div class="avatar bg-light-info p-50 mb-1">
                                                <div class="avatar-content">
                                                    <i data-feather="zap" class="font-medium-5"></i>
                                                </div>
                                            </div>
                                            <h2 class="font-weight-bolder">{{ \App\Models\User::where('is_nafath_verified',1)->count() }}</h2>
                                            <p class="card-text">@lang('users_nafath_verified')</p>
                                        </div>
                                    </a>
                                </div>
                            </div>
                            @foreach (\App\Models\AdType::all() as $adType)
                                <div class="col-xl-2 col-md-4 col-sm-6 flex-fill">
                                    <div class="card text-center">
                                        <a href="{{ route('dashboard.ads.index', ['type' => 'sell', 'ad_type_id' => $adType->id]) }} ">
                                            <div class="card-body">
                                                <div class="avatar bg-light-info p-50 mb-1">
                                                    <div class="avatar-content">
                                                        <i data-feather="zap" class="font-medium-5"></i>
                                                    </div>
                                                </div>
                                                <h2 class="font-weight-bolder">
                                                    {{ \App\Models\Ad::where('ad_type_id', $adType->id)->where('main_type', 'sell')->count() }}
                                                </h2>

                                                <p class="card-text">@lang('sell_ads') ( {{ __($adType->name) }} )</p>
                                            </div>
                                        </a>
                                    </div>
                                </div>
                            @endforeach
                            <div class="col-xl-2 col-md-4 col-sm-6 flex-fill">
                                <div class="card text-center">
                                    <a href="{{ route('dashboard.ads.index', ['type' => 'buy']) }}">
                                        <div class="card-body">
                                            <div class="avatar bg-light-info p-50 mb-1">
                                                <div class="avatar-content">
                                                    <i data-feather="zap" class="font-medium-5"></i>
                                                </div>
                                            </div>
                                            <h2 class="font-weight-bolder">
                                                {{ \App\Models\Ad::where('main_type', 'buy')->count() }}</h2>
                                            <p class="card-text">@lang('buy_ads')</p>
                                        </div>
                                    </a>
                                </div>
                            </div>
                            <div class="col-xl-2 col-md-4 col-sm-6 flex-fill">
                                <div class="card text-center">
                                    <a href="{{ route('dashboard.subscriptions.index') }}">
                                        <div class="card-body">
                                            <div class="avatar bg-light-info p-50 mb-1">
                                                <div class="avatar-content">
                                                    <i data-feather="zap" class="font-medium-5"></i>
                                                </div>
                                            </div>
                                            <h2 class="font-weight-bolder">{{ \App\Models\Subscription::count() }}</h2>
                                            <p class="card-text">@lang('subscriptions')</p>
                                        </div>
                                    </a>
                                </div>
                            </div>
                            <div class="col-xl-2 col-md-4 col-sm-6 flex-fill">
                                <div class="card text-center">
                                    <a href="{{ route('dashboard.cities.index') }}">
                                        <div class="card-body">
                                            <div class="avatar bg-light-info p-50 mb-1">
                                                <div class="avatar-content">
                                                    <i data-feather="zap" class="font-medium-5"></i>
                                                </div>
                                            </div>
                                            <h2 class="font-weight-bolder">{{ \App\Models\City::count() }}</h2>
                                            <p class="card-text">@lang('cities')</p>
                                        </div>
                                    </a>
                                </div>
                            </div>
                            <div class="col-xl-2 col-md-4 col-sm-6 flex-fill">
                                <div class="card text-center">
                                    <a href="{{ route('dashboard.neighborhoods.index') }}">
                                        <div class="card-body">
                                            <div class="avatar bg-light-info p-50 mb-1">
                                                <div class="avatar-content">
                                                    <i data-feather="zap" class="font-medium-5"></i>
                                                </div>
                                            </div>
                                            <h2 class="font-weight-bolder">{{ \App\Models\Neighborhood::count() }}</h2>
                                            <p class="card-text">@lang('neighborhoods')</p>
                                        </div>
                                    </a>
                                </div>
                            </div>
                            
                            <div class="col-xl-2 col-md-4 col-sm-6 flex-fill">
                                <div class="card text-center">
                                    <a href="{{ route('dashboard.services.index') }}">
                                        <div class="card-body">
                                            <div class="avatar bg-light-info p-50 mb-1">
                                                <div class="avatar-content">
                                                    <i data-feather="zap" class="font-medium-5"></i>
                                                </div>
                                            </div>
                                            <h2 class="font-weight-bolder">{{ \App\Models\Service::count() }}</h2>
                                            <p class="card-text">@lang('services')</p>
                                        </div>
                                    </a>
                                </div>
                            </div>
                            <div class="col-xl-2 col-md-4 col-sm-6 flex-fill">
                                <div class="card text-center">
                                    <a href="{{ route('dashboard.blogs.index') }}">
                                        <div class="card-body">
                                            <div class="avatar bg-light-info p-50 mb-1">
                                                <div class="avatar-content">
                                                    <i data-feather="zap" class="font-medium-5"></i>
                                                </div>
                                            </div>
                                            <h2 class="font-weight-bolder">{{ \App\Models\Blog::count() }}</h2>
                                            <p class="card-text">@lang('blogs')</p>
                                        </div>
                                    </a>
                                </div>
                            </div>
                            <div class="col-xl-2 col-md-4 col-sm-6 flex-fill">
                                <div class="card text-center">
                                    <a href="{{ route('dashboard.adTypes.index') }}">
                                        <div class="card-body">
                                            <div class="avatar bg-light-info p-50 mb-1">
                                                <div class="avatar-content">
                                                    <i data-feather="zap" class="font-medium-5"></i>
                                                </div>
                                            </div>
                                            <h2 class="font-weight-bolder">{{ \App\Models\AdType::count() }}</h2>
                                            <p class="card-text">@lang('ad_types')</p>
                                        </div>
                                    </a>
                                </div>
                            </div>
                            <div class="col-xl-2 col-md-4 col-sm-6 flex-fill">
                                <div class="card text-center">
                                    <a href="{{ route('dashboard.subscriptionRequests.index') }}">
                                        <div class="card-body">

                                            <div class="avatar bg-light-info p-50 mb-1">
                                                <div class="avatar-content">
                                                    <i data-feather="zap" class="font-medium-5"></i>
                                                </div>
                                            </div>

                                            <h2 class="font-weight-bolder">
                                                {{ \App\Models\UserSubscription::where('is_active', 0)->count() }}</h2>
                                            <p class="card-text">@lang('subscription_requests')</p>
                                        </div>
                                    </a>
                                </div>
                            </div>
                            <div class="col-xl-2 col-md-4 col-sm-6 flex-fill">
                                <div class="card text-center">
                                    <a href="{{ route('dashboard.authenticationRequests.index') }}">
                                        <div class="card-body">
                                            <div class="avatar bg-light-info p-50 mb-1">
                                                <div class="avatar-content">
                                                    <i data-feather="zap" class="font-medium-5"></i>
                                                </div>
                                            </div>
                                            <h2 class="font-weight-bolder">
                                                {{ \App\Models\User::where('pending_authentication', 1)->count() }}</h2>
                                            <p class="card-text">@lang('authentication_requests')</p>
                                        </div>
                                </div>
                                </a>
                            </div>

                            <div class="col-xl-2 col-md-4 col-sm-6 flex-fill">
                                <div class="card text-center">
                                    <a href="{{ route('dashboard.estateTypes.index') }}">
                                        <div class="card-body">
                                            <div class="avatar bg-light-info p-50 mb-1">
                                                <div class="avatar-content">
                                                    <i data-feather="zap" class="font-medium-5"></i>
                                                </div>
                                            </div>
                                            <h2 class="font-weight-bolder">{{ \App\Models\EstateType::count() }}</h2>
                                            <p class="card-text">@lang('estate_types')</p>
                                        </div>
                                    </a>
                                </div>
                            </div>
                            <div class="col-xl-2 col-md-4 col-sm-6 flex-fill">
                                <div class="card text-center">
                                    <a href="{{ route('dashboard.usageTypes.index') }}">
                                        <div class="card-body">
                                            <div class="avatar bg-light-info p-50 mb-1">
                                                <div class="avatar-content">
                                                    <i data-feather="zap" class="font-medium-5"></i>
                                                </div>
                                            </div>
                                            <h2 class="font-weight-bolder">{{ \App\Models\UsageType::count() }}</h2>
                                            <p class="card-text">@lang('usage_types')</p>
                                        </div>
                                    </a>
                                </div>
                            </div>
                            <div class="col-xl-2 col-md-4 col-sm-6 flex-fill">
                                <div class="card text-center">
                                    <a href="{{ route('dashboard.bankAccounts.index') }}">
                                        <div class="card-body">
                                            <div class="avatar bg-light-info p-50 mb-1">
                                                <div class="avatar-content">
                                                    <i data-feather="zap" class="font-medium-5"></i>
                                                </div>
                                            </div>
                                            <h2 class="font-weight-bolder">{{ \App\Models\BankAccount::count() }}</h2>
                                            <p class="card-text">@lang('bank_accounts')</p>
                                        </div>
                                    </a>
                                </div>
                            </div>
                            <div class="col-xl-2 col-md-4 col-sm-6 flex-fill">
                                <div class="card text-center">
                                    <a href="{{ route('dashboard.marketers.index') }}">
                                        <div class="card-body">
                                            <div class="avatar bg-light-info p-50 mb-1">
                                                <div class="avatar-content">
                                                    <i data-feather="zap" class="font-medium-5"></i>
                                                </div>
                                            </div>
                                            <h2 class="font-weight-bolder">{{ \App\Models\Marketer::count() }}</h2>
                                            <p class="card-text">@lang('marketers')</p>
                                        </div>
                                    </a>
                                </div>
                            </div>
                            <div class="col-xl-2 col-md-4 col-sm-6 flex-fill">
                                <div class="card text-center">
                                    <a href="{{ route('dashboard.todaySubscriptions',['expiringSoon' => 15]) }}">
                                        <div class="card-body">
                                            <div class="avatar bg-light-info p-50 mb-1">
                                                <div class="avatar-content">
                                                    <i data-feather="zap" class="font-medium-5"></i>
                                                </div>
                                            </div>
                                            <h2 class="font-weight-bolder">
                                                {{ \App\Models\UserSubscription::where('end_date', '<=', now()->addDays(15))->where('end_date', '>=', now())->count() }}
                                            </h2>
                                            <p class="card-text">@lang('expire_soon_subscribers')</p>
                                        </div>
                                    </a>
                                </div>
                            </div>
                            <div class="col-xl-2 col-md-4 col-sm-6 flex-fill">
                                <div class="card text-center">
                                    <a href="{{ route('dashboard.todaySubscriptions',['premium' => 1]) }}">
                                        <div class="card-body">
                                            <div class="avatar bg-light-info p-50 mb-1">
                                                <div class="avatar-content">
                                                    <i data-feather="zap" class="font-medium-5"></i>
                                                </div>
                                            </div>
                                            <h2 class="font-weight-bolder">
                                                {{ \App\Models\UserSubscription::where('is_active', 1)->whereRelation('subscription', 'premium', 1)->count() }}
                                            </h2>
                                            <p class="card-text">@lang('premium_subscription')</p>
                                        </div>
                                    </a>
                                </div>
                            </div>
                            <div class="col-xl-2 col-md-4 col-sm-6 flex-fill">
                                <div class="card text-center">
                                    <a href="{{ route('dashboard.todaySubscriptions',['premium' => 0]) }}">
                                        <div class="card-body">
                                            <div class="avatar bg-light-info p-50 mb-1">
                                                <div class="avatar-content">
                                                    <i data-feather="zap" class="font-medium-5"></i>
                                                </div>
                                            </div>
                                            <h2 class="font-weight-bolder">
                                                {{ \App\Models\UserSubscription::where('is_active', 1)->whereRelation('subscription', 'premium', 0)->count() }}
                                            </h2>
                                            <p class="card-text">@lang('individual_subscription')</p>
                                        </div>
                                    </a>
                                </div>
                            </div>

                        </div>

                    </div>

                </section>
                <!-- dashboard_files Ecommerce ends -->

            </div>
        </div>
    </div>


    @endcan
    <!-- END: Content-->


@endsection
