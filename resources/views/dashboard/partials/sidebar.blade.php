<!-- BEGIN: Main Menu-->
<div class="main-menu menu-fixed menu-dark menu-accordion menu-shadow" data-scroll-to-active="true">
    <div class="navbar-header">
        <ul class="nav navbar-nav flex-row">
            <li class="nav-item mr-auto"><a class="navbar-brand"
                    href="{{route('dashboard.home')}}">
                    <h2 class="brand-text">@lang('dashboard')</h2>
                </a></li>
            <li class="nav-item nav-toggle"><a class="nav-link modern-nav-toggle pr-0" data-toggle="collapse"><i
                        class="d-block d-xl-none text-primary toggle-icon font-medium-4" data-feather="x"></i><i
                        class="d-none d-xl-block collapse-toggle-icon font-medium-4  text-primary" data-feather="disc"
                        data-ticon="disc"></i></a></li>
        </ul>
    </div>
    <div class="shadow-bottom"></div>
    <div class="main-menu-content">
        <ul class="navigation navigation-main" id="main-menu-navigation" data-menu="menu-navigation">
            @can('home')
                <li class=" nav-item {{ request()->routeIs('dashboard.home') ? 'active' : '' }}">
                    <a class="d-flex align-items-center" href="{{ route('dashboard.home') }}">
                        <i class="fa-solid fa-house"></i><span class="menu-title text-truncate">@lang('home')</span>
                    </a>
                </li>
            @endcan
            @can('notifications-sendForm')
                <li class=" nav-item {{ request()->routeIs('dashboard.notifications.sendForm') ? 'active' : '' }}">
                    <a class="d-flex align-items-center" href="{{ route('dashboard.notifications.sendForm') }}">
                        <i class="fa-solid fa-comment"></i><span class="menu-title text-truncate">@lang('send_notifications')</span>
                    </a>
                </li>
                @endcan
                {{--
                @can('offers-create')
                <li class=" nav-item {{ request()->routeIs('dashboard.offers.create') ? 'active' : '' }}">
                    <a class="d-flex align-items-center" href="{{ route('dashboard.offers.create') }}">
                        <i class="fa-solid fa-comment"></i><span class="menu-title text-truncate">@lang('send_offers')</span>
                    </a>
                </li>
                @endcan
                @can('offers-index')
                <li class=" nav-item {{ request()->routeIs('dashboard.offers.index') ? 'active' : '' }}">
                    <a class="d-flex align-items-center" href="{{ route('dashboard.offers.index') }}">
                        <i class="fa-solid fa-comment"></i><span class="menu-title text-truncate">@lang('offers_messages')</span>
                    </a>
                </li>
                @endcan--}}

                @can('admins-index')
                <li class=" nav-item {{ request()->routeIs('dashboard.admins.*') ? 'active' : '' }}">
                    <a class="d-flex align-items-center" href="{{ route('dashboard.admins.index') }}">
                        <i class="fa-solid fa-users"></i><span class="menu-title text-truncate"
                        data-i18n="Email">@lang('admins')</span>
                    </a>
                </li>
                @endcan
            @can('users-index')
                <li class=" nav-item {{ request()->routeIs('dashboard.users.*') ? 'active' : '' }}"><a
                        class="d-flex align-items-center" href="{{ route('dashboard.users.index') }}">
                        <i class="fa-solid fa-user-group"></i><span class="menu-title text-truncate"
                            data-i18n="Email">@lang('users')</span></a>
                </li>
            @endcan
            @can('todaySubscriptions')
                <li class=" nav-item {{ request()->routeIs('dashboard.todaySubscriptions.*') ? 'active' : '' }}"><a
                        class="d-flex align-items-center" href="{{ route('dashboard.todaySubscriptions') }}">
                        <i class="fa-solid fa-user-group"></i><span class="menu-title text-truncate"
                            data-i18n="Email">@lang('todaySubscriptions')</span></a>
                </li>
            @endcan
            @can('ads-index')
                <li class=" nav-item"><a class="d-flex align-items-center"
                        href="{{ route('dashboard.ads.index', ['type' => 'sell']) }}">
                        <i class="fa-solid fa-file"></i><span class="menu-title text-truncate"
                            data-i18n="Email">@lang('sell_ads')</span></a>
                </li>
                <li class=" nav-item"><a class="d-flex align-items-center"
                        href="{{ route('dashboard.ads.index', ['type' => 'buy']) }}">
                        <i class="fa-solid fa-file"></i><span class="menu-title text-truncate"
                            data-i18n="Email">@lang('buy_ads')</span></a>
                </li>
            @endcan
            @can('supportServiceAds-index')
                <li class=" nav-item"><a class="d-flex align-items-center"
                                         href="{{ route('dashboard.supportServiceAds.index') }}">
                        <i class="fa-solid fa-file"></i><span class="menu-title text-truncate"
                                                              data-i18n="Email">@lang('support_service_ads')</span></a>
                </li>
            @endcan






            @canany(['areas-index', 'states-index', 'cities-index', 'neighborhoods-index'])
                <li class=" nav-item">
                    <a class="d-flex align-items-center" href="#">
                        <i class="fa-solid fa-location-dot"></i><span class="menu-title text-truncate"
                            data-i18n="Invoice">@lang('location_settings')</span></a>
                    <ul class="menu-content">
                        @can('areas-index')
                            <li class=" nav-item {{ request()->routeIs('dashboard.areas.*') ? 'active' : '' }} ">
                                <a class="d-flex align-items-center" href="{{ route('dashboard.areas.index') }}">
                                    <i class="fa-regular fa-circle"></i><span class="menu-title text-truncate"
                                        data-i18n="Email">@lang('areas')</span></a>
                            </li>
                        @endcan
                        @can('states-index')
                            <li class=" nav-item {{ request()->routeIs('dashboard.states.*') ? 'active' : '' }} ">
                                <a class="d-flex align-items-center" href="{{ route('dashboard.states.index') }}"><i
                                        class="fa-regular fa-circle"></i><span class="menu-title text-truncate"
                                        data-i18n="Email">@lang('states')</span></a>
                            </li>
                        @endcan
                        @can('cities-index')
                            <li class=" nav-item {{ request()->routeIs('dashboard.cities.*') ? 'active' : '' }}"><a
                                    class="d-flex align-items-center" href="{{ route('dashboard.cities.index') }}"><i
                                        class="fa-regular fa-circle"></i><span class="menu-title text-truncate"
                                        data-i18n="Email">@lang('cities')</span></a>
                            </li>
                        @endcan
                        @can('neighborhoods-index')
                            <li class="nav-item {{ request()->routeIs('dashboard.neighborhoods.*') ? 'active' : '' }}"><a
                                    class="d-flex align-items-center" href="{{ route('dashboard.neighborhoods.index') }}"><i
                                        class="fa-regular fa-circle"></i><span class="menu-title text-truncate"
                                        data-i18n="Email">@lang('neighborhoods')</span></a>
                            </li>
                        @endcan
                    </ul>
                </li>
            @endcan
            @canany(['adTypes-index', 'estateTypes-index', 'advertiserOrientations-index', 'usageTypes-index',
                'properties-index'])

                <li class=" nav-item"><a class="d-flex align-items-center" href="#"><i
                            class="fa-solid fa-file-medical"></i><span class="menu-title text-truncate"
                            data-i18n="Invoice">@lang('ads_requirements')</span></a>
                    <ul class="menu-content">
                        @can('adTypes-index')
                            <li class="nav-item {{ request()->routeIs('dashboard.adTypes.*') ? 'active' : '' }}"><a
                                    class="d-flex align-items-center" href="{{ route('dashboard.adTypes.index') }}"><i
                                        class="fa-regular fa-circle"></i><span class="menu-title text-truncate"
                                        data-i18n="Email">@lang('ad_types')</span></a>
                            </li>
                        @endcan
                        @can('estateTypes-index')
                            <li class=" nav-item {{ request()->routeIs('dashboard.estateTypes.*') ? 'active' : '' }}"><a
                                    class="d-flex align-items-center" href="{{ route('dashboard.estateTypes.index') }}"><i
                                        class="fa-regular fa-circle"></i><span class="menu-title text-truncate"
                                        data-i18n="Email">@lang('estate_types')</span></a>
                            </li>
                        @endcan
                        @can('advertiserOrientations-index')
                            <li
                                class=" nav-item {{ request()->routeIs('dashboard.advertiserOrientations.*') ? 'active' : '' }}">
                                <a class="d-flex align-items-center"
                                    href="{{ route('dashboard.advertiserOrientations.index') }}"><i
                                        class="fa-regular fa-circle"></i><span class="menu-title text-truncate"
                                        data-i18n="Email">@lang('advertiser_orientations')</span></a>
                            </li>
                        @endcan
                        @can('usageTypes-index')
                            <li class="nav-item {{ request()->routeIs('dashboard.usageTypes.*') ? 'active' : '' }}"><a
                                    class="d-flex align-items-center" href="{{ route('dashboard.usageTypes.index') }}"><i
                                        class="fa-regular fa-circle"></i><span class="menu-title text-truncate"
                                        data-i18n="Email">@lang('usage_types')</span></a>
                            </li>
                        @endcan
                        @can('properties-index')
                            <li class="nav-item {{ request()->routeIs('dashboard.properties.*') ? 'active' : '' }}"><a
                                    class="d-flex align-items-center" href="{{ route('dashboard.properties.index') }}"><i
                                        class="fa-regular fa-circle"></i><span class="menu-title text-truncate"
                                        data-i18n="Email">@lang('properties')</span></a>
                            </li>
                        @endcan
                    </ul>
                </li>
            @endcan
            @can('accountTypes-index')
                <li class=" nav-item {{ request()->routeIs('dashboard.accountTypes.*') ? 'active' : '' }}"><a
                        class="d-flex align-items-center" href="{{ route('dashboard.accountTypes.index') }}"><i
                            class="fa-solid fa-clipboard-check"></i><span class="menu-title text-truncate"
                            data-i18n="Email">@lang('account_types')</span></a>
                </li>
            @endcan
            @can('blogs-index')
                <li class=" nav-item {{ request()->routeIs('dashboard.blogs.*') ? 'active' : '' }}"><a
                        class="d-flex align-items-center" href="{{ route('dashboard.blogs.index') }}">
                        <i class="fa-solid fa-blog"></i><span class="menu-title text-truncate"
                            data-i18n="Email">@lang('blogs')</span></a>
                </li>
            @endcan
            @can('services-index')
                <li
                    class=" nav-item {{ request()->routeIs('dashboard.services.*') && !request()->query('type') ? 'active' : '' }}">
                    <a class="d-flex align-items-center" href="{{ route('dashboard.services.index') }}"><i
                            class="fa-solid fa-server"></i><span class="menu-title text-truncate"
                            data-i18n="Email">@lang('services')</span></a>
                </li>

            @endcan
            @can('coupons-index')
                <li class=" nav-item {{ request()->routeIs('dashboard.coupons.*') ? 'active' : '' }}"><a
                        class="d-flex align-items-center" href="{{ route('dashboard.coupons.index') }}"><i
                            class="fa-solid fa-server"></i><span class="menu-title text-truncate"
                            data-i18n="Email">@lang('coupons')</span></a>
                </li>
            @endcan
            @can('bankCalcs-index')
                <li class=" nav-item {{ request()->routeIs('dashboard.bankCalcs.*') ? 'active' : '' }}"><a
                        class="d-flex align-items-center" href="{{ route('dashboard.bankCalcs.index') }}"><i
                            class="fa-solid fa-server"></i><span class="menu-title text-truncate" data-i18n="Email">حسبة
                            البنك</span></a>
                </li>
            @endcan


            @can('adReports-index')
                <li class=" nav-item {{ request()->routeIs('dashboard.adReports.*') ? 'active' : '' }}"><a
                        class="d-flex align-items-center" href="{{ route('dashboard.adReports.index') }}"><i
                            class="fa-solid fa-flag"></i><span class="menu-title text-truncate"
                            data-i18n="Email">@lang('ad_reports')</span></a>
                </li>
            @endcan
            @can('reportReasons-index')
                <li class=" nav-item {{ request()->routeIs('dashboard.reportReasons.*') ? 'active' : '' }}"><a
                        class="d-flex align-items-center" href="{{ route('dashboard.reportReasons.index') }}"><i
                            class="fa-solid fa-bars"></i><span class="menu-title text-truncate"
                            data-i18n="Email">@lang('report_reasons')</span></a>
                </li>
            @endcan
            @can('bankAccounts-index')
                <li class=" nav-item {{ request()->routeIs('dashboard.bankAccounts.*') ? 'active' : '' }}"><a
                        class="d-flex align-items-center" href="{{ route('dashboard.bankAccounts.index') }}"><i
                            class="fa-solid fa-dollar-sign"></i><span class="menu-title text-truncate"
                            data-i18n="Email">@lang('bank_accounts')</span></a>
                </li>
            @endcan
            @can('subscriptions-index')
                <li class=" nav-item {{ request()->routeIs('dashboard.subscriptions.*') ? 'active' : '' }}"><a
                        class="d-flex align-items-center" href="{{ route('dashboard.subscriptions.index') }}"><i
                            class="fa-solid fa-right-to-bracket"></i><span class="menu-title text-truncate"
                            data-i18n="Email">@lang('subscriptions')</span></a>
                </li>
            @endcan
            @can('subscriptionRequests-index')
                <li class=" nav-item {{ request()->routeIs('dashboard.subscriptionRequests.*') ? 'active' : '' }}"><a
                        class="d-flex align-items-center" href="{{ route('dashboard.subscriptionRequests.index') }}"><i
                            class="fa-solid fa-clipboard-question"></i><span class="menu-title text-truncate"
                            data-i18n="Email">@lang('subscription_requests')</span></a>
                </li>
            @endcan
            @can('authenticationRequests-index')
                <li class=" nav-item {{ request()->routeIs('dashboard.authenticationRequests.*') ? 'active' : '' }}"><a
                        class="d-flex align-items-center" href="{{ route('dashboard.authenticationRequests.index') }}"><i
                            class="fa-solid fa-clipboard-question"></i><span class="menu-title text-truncate"
                            data-i18n="Email">@lang('authentication_requests')</span></a>
                </li>
            @endcan
            @can('marketers-index')
                <li class=" nav-item {{ request()->routeIs('dashboard.marketers.*') ? 'active' : '' }}"><a
                        class="d-flex align-items-center" href="{{ route('dashboard.marketers.index') }}"><i
                            class="fa-solid fa-people-group"></i><span class="menu-title text-truncate"
                            data-i18n="Email">@lang('marketers')</span></a>
                </li>
            @endcan
            @can('contact-index')
                <li><a class="d-flex align-items-center" href="{{ route('dashboard.contact.index') }}"><i
                            class="fa-regular fa-envelope"></i><span class="menu-item text-truncate"
                            data-i18n="List">@lang('contact_us')</span></a>
                </li>
            @endcan
            @canany(['sliders-index', 'roles-index', 'sections-index', 'supportServices-index',
                'prePurchaseServices-index', 'postPurchaseServices-index', 'estateDeveloperServices-index',
                'afterSellServices-index', 'afterSellServices-index', 'sponsors-index', 'features-index', 'settings-edit'])

                <li class=" nav-item"><a class="d-flex align-items-center" href="#"><i
                            class="fa-solid fa-gears"></i><span class="menu-title text-truncate"
                            data-i18n="Invoice">@lang('setting')</span></a>
                    <ul class="menu-content">

                        @can('sliders-index')
                            <li><a class="d-flex align-items-center" href="{{ route('dashboard.sliders.index') }}"><i
                                        class="fa-regular fa-circle"></i><span class="menu-item text-truncate"
                                        data-i18n="List">@lang('slider')</span></a>
                            </li>
                        @endcan
                        @can('roles-index')
                            <li><a class="d-flex align-items-center" href="{{ route('dashboard.roles.index') }}"><i
                                        class="fa-regular fa-circle"></i><span class="menu-item text-truncate"
                                        data-i18n="List">@lang('roles')</span></a>
                            </li>
                        @endcan

                        @can('sections-edit')
                            <li><a class="d-flex align-items-center" href="{{ route('dashboard.sections.edit') }}"><i
                                        class="fa-regular fa-circle"></i><span class="menu-item text-truncate"
                                        data-i18n="List">@lang('sections')</span></a>
                            </li>
                        @endcan
                        @can('supportServices-index')
                            <li><a class="d-flex align-items-center" href="{{ route('dashboard.supportServices.index') }}"><i
                                        class="fa-regular fa-circle"></i><span class="menu-item text-truncate"
                                        data-i18n="List">@lang('support_services')</span></a>
                            </li>
                        @endcan
                        @can('prePurchaseServices-index')
                            <li><a class="d-flex align-items-center"
                                    href="{{ route('dashboard.prePurchaseServices.index') }}"><i
                                        class="fa-regular fa-circle"></i><span class="menu-item text-truncate"
                                        data-i18n="List">@lang('pre_purchase_services')</span></a>
                            </li>
                        @endcan
                        @can('postPurchaseServices-index')
                            <li><a class="d-flex align-items-center"
                                    href="{{ route('dashboard.postPurchaseServices.index') }}"><i
                                        class="fa-regular fa-circle"></i><span class="menu-item text-truncate"
                                        data-i18n="List">@lang('post_purchase_services')</span></a>
                            </li>
                        @endcan
                        @can('estateDeveloperServices-index')
                            <li><a class="d-flex align-items-center"
                                    href="{{ route('dashboard.estateDeveloperServices.index') }}"><i
                                        class="fa-regular fa-circle"></i><span class="menu-item text-truncate"
                                        data-i18n="List">@lang('estate_developer_services')</span></a>
                            </li>
                        @endcan
                        @can('afterSellServices-index')
                            <li><a class="d-flex align-items-center"
                                    href="{{ route('dashboard.afterSellServices.index') }}"><i
                                        class="fa-regular fa-circle"></i><span class="menu-item text-truncate"
                                        data-i18n="List">@lang('after_sell_services')</span></a>
                            </li>
                        @endcan
                        @can('sponsors-index')
                            <li><a class="d-flex align-items-center" href="{{ route('dashboard.sponsors.index') }}"><i
                                        class="fa-regular fa-circle"></i><span class="menu-item text-truncate"
                                        data-i18n="List">@lang('dashboard_sponsors')</span></a>
                            </li>
                        @endcan
                        @can('features-index')
                            <li><a class="d-flex align-items-center" href="{{ route('dashboard.features.index') }}"><i
                                        class="fa-regular fa-circle"></i><span class="menu-item text-truncate"
                                        data-i18n="List">@lang('app_features')</span></a>
                            </li>
                        @endcan
                        @can('settings-edit')
                            <li><a class="d-flex align-items-center" href="{{ route('dashboard.settings.edit') }}"><i
                                        class="fa-regular fa-circle"></i><span class="menu-item text-truncate"
                                        data-i18n="List">@lang('website_data')</span></a>
                            </li>
                        @endcan
                    </ul>
                </li>
            @endcan





        </ul>
    </div>
</div>
<!-- END: Main Menu-->
