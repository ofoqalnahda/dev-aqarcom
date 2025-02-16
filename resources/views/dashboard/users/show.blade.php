@extends('dashboard.layouts.app')

@section('content')
    <div class="app-content content ">
        <div class="content-overlay"></div>
        <div class="header-navbar-shadow"></div>
        <div class="content-wrapper container-xxl p-0">
            <div class="content-header row">
            </div>
            <div class="content-body">
                <section class="app-user-view">
                    <!-- User Card & Plan Starts -->
                    <div class="row">
                        <!-- User Card starts-->
                        <div class="col-xl-12 col-lg-8 col-md-7">
                            <div class="card user-card">
                                <div class="card-body">
                                    <div class="row">
                                        <div
                                            class="col-xl-6 col-lg-12 d-flex flex-column justify-content-between border-container-lg">
                                            <div class="user-avatar-section">
                                                <div class="d-flex justify-content-start">
                                                    <img class="img-fluid rounded" src="{{ get_file($user->image) }}"
                                                        height="104" width="104" alt="User avatar" />
                                                    <div class="d-flex flex-column ml-1 justify-content-center">
                                                        <div class="user-info mb-1">
                                                            <h4 class="mb-0">{{ $user->name }}</h4>
                                                        </div>
                                                        <div class="d-flex flex-wrap">
                                                            @can('ads-index')
                                                                <a class="btn btn-outline btn-primary m-1"
                                                                    href="{{ route('dashboard.ads.index', ['user_id' => $user->id]) }}">@lang('ads')</a>
                                                            @endcan
                                                            @can('users-destroy')
                                                                <form
                                                                    action="{{ route('dashboard.users.destroy', $user->id) }}"
                                                                    method="post">
                                                                    @csrf
                                                                    @method('delete')
                                                                    <button type="submit"
                                                                        class="btn btn-outline btn-danger m-1">@lang('delete')</button>
                                                                </form>
                                                            @endcan
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-xl-6 col-lg-12 mt-2 mt-xl-0">
                                            <div class="user-info-wrapper">
                                                <div class="d-flex flex-wrap">
                                                    <div class="user-info-title">
                                                        <i data-feather="user" class="mr-1"></i>
                                                        <span
                                                            class="card-text user-info-title font-weight-bold mb-0">{{ $user->name }}</span>
                                                    </div>
                                                </div>
                                                <div class="d-flex flex-wrap">
                                                    <div class="user-info-title">
                                                        <i class="fa-regular fa-envelope mr-1"></i>
                                                        <span
                                                            class="card-text user-info-title font-weight-bold mb-0">{{ $user->email }}</span>
                                                    </div>
                                                </div>
                                                <div class="d-flex flex-wrap">
                                                    <div class="user-info-title">
                                                        <i data-feather="phone" class="mr-1"></i>
                                                        <span
                                                            class="card-text user-info-title font-weight-bold mb-0">{{ $user->phone }}</span>
                                                    </div>
                                                </div>

                                                <div class="d-flex flex-wrap">
                                                    <div class="user-info-title">
                                                        <i class="fa-brands fa-whatsapp mr-1"></i>
                                                        <span
                                                            class="card-text user-info-title font-weight-bold mb-0">{{ $user->whatsapp }}</span>
                                                    </div>
                                                </div>

                                                <div class="d-flex flex-wrap">
                                                    <div class="user-info-title">
                                                        @lang('ads_count') :
                                                        <span
                                                            class="card-text user-info-title font-weight-bold mb-0">{{ $user->ads()->count() }}</span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- /User Card Ends-->
                    </div>
                    <!-- User Card & Plan Ends -->

                    <!-- User Timeline & Permissions Starts -->
                    <div class="row">
                        <!-- information starts -->
                        <div class="col-md-4">
                            <div class="card">
                                <div class="card-header">
                                    <h4 class="card-title mb-2">@lang('authentication')</h4>
                                </div>
                                <div class="card-body">
                                    @if ($user->is_nafath_verified)
                                        <div class="d-flex justify-content-between">
                                            <p>@lang('account_type')</p>
                                            <p>{{ __('identity_type'.$user->identity_type) }}</p>
                                        </div>
                                        <div class="d-flex justify-content-between">
                                            <p>@lang('identity_number')</p>
                                            <p>{{ $user->identity_number }}</p>
                                        </div>
                                       {{-- <div class="d-flex justify-content-between">
                                            <p>@lang('commercial_name')</p>
                                            <p>{{ $user->commercial_name }}</p>
                                        </div> --}}
                                        @if($user->identity_type == 2)
                                            <div class="d-flex justify-content-between">
                                                <p>@lang('commercial_number')</p>
                                                <p>{{ $user->unified_number }}</p>
                                            </div> 
                                        @endif
                                        <div class="d-flex justify-content-between">
                                            <p>@lang('commercial_image')</p>
                                            <p><a href="{{ get_file($user->commercial_image) }}">@lang('show')</a></p>
                                        </div>
                                        <div class="d-flex justify-content-between">
                                            <p>@lang('identity_image')</p>
                                            <p><a href="{{ get_file($user->identity_image) }}">@lang('show')</a></p>
                                        </div>
                                    @else
                                        <h2>@lang('not_auth')</h2>
                                    @endif
                                </div>
                            </div>
                        </div>

                        <!-- information Ends -->

                        <!-- User Permissions Starts -->
                        <div class="col-md-4">
                            <!-- User Permissions -->
                            <div class="card">
                                <div class="card-header">
                                    <h4 class="card-title">@lang('subscription')</h4>
                                </div>
                                <div class="card-body">
                                    @if ($subscription)
                                        <div class="d-flex justify-content-between">
                                            <p>@lang('subscription_name')</p>
                                            <p>{{ $subscription->name }}</p>
                                        </div>
                                        <div class="d-flex justify-content-between">
                                            <p>@lang('price')</p>
                                            <p>{{ $subscription->price }}</p>
                                        </div>
                                        <div class="d-flex justify-content-between">
                                            <p>@lang('free_ads')</p>
                                            <p>{{ $user->free_ads }}</p>
                                        </div>
                                        <div class="d-flex justify-content-between">
                                            <p>@lang('regular_ads')</p>
                                            <p>{{ $subscription->pivot->regular_ads }}</p>
                                        </div>
                                        <div class="d-flex justify-content-between">
                                            <p>@lang('special_ads')</p>
                                            <p>{{ $subscription->pivot->special_ads }}</p>
                                        </div>
                                        <div class="d-flex justify-content-between">
                                            <p>@lang('end_date')</p>
                                            <p>{{ $subscription->pivot->end_date }}</p>
                                        </div>
                                        @can('users.deleteSubscription')
                                            @if ($subscription->premium)
                                                <div class="d-flex justify-content-between">
                                                    <a class="btn btn-primary" style="width: 100%"
                                                        href="{{ route('dashboard.users.deleteSubscription', $user->id) }}">@lang('delete_subscription')</a>
                                                </div>
                                            @endif
                                        @endcan
                                    @else
                                        <h2>@lang('no_subscription')</h2>
                                    @endif
                                </div>
                            </div>
                            <!-- /User Permissions -->
                        </div>
                        <!-- User Permissions Ends -->
                        <div class="col-md-4">
                            <div class="card">
                                <div class="card-header">
                                    <h4 class="card-title mb-2">@lang('free_ads')</h4>
                                </div>
                                <div class="card-body">
                                    <form method="post" action="{{ route('dashboard.users.changeBalance', $user->id) }}">
                                        @csrf
                                        <div class="form-group">
                                            <input class="form-control" type="number" name="balance"
                                                value="{{ $user->free_ads }}">
                                        </div>
                                        @can('users.changeBalance')
                                            <input class="btn btn-primary" type="submit" value="@lang('change')">
                                        @endcan
                                    </form>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="card">
                                <div class="card-header">
                                    <h4 class="card-title mb-2">@lang('val_license_photo')</h4>
                                </div>
                                <div class="card-body">
                                    @if ($user->val_license)
                                        <div class="d-flex justify-content-between">
                                             <img style="width:100x; height:100px;"
                                                    src="{{ get_file($user->val_license) }}" alt="admin-image" />

                                        </div>
                                    @else
                                        <h2>لا يوجد</h2>
                                    @endif
                                </div>
                            </div>
                        </div>

                    </div>
                    <!-- User Timeline & Permissions Ends -->
                </section>

            </div>
        </div>
    </div>

@endsection
