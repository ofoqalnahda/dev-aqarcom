<!-- BEGIN: Header-->
<nav class="header-navbar navbar navbar-expand-lg align-items-center floating-nav navbar-light navbar-shadow container-xxl">
    <div class="navbar-container d-flex content">
        <div class="lang-cont">
            @if(app()->getLocale()=='en')
                <a class="nav-link" href="{{route('changeLocale' , config('app.app_locales')[app()->getLocale()] )}}">
                    <img style="width: 25px;height: 16px" src="{{asset('website')}}/images/ar.png"></a>
            @else
                <a class="nav-link" href="{{route('changeLocale' , config('app.app_locales')[app()->getLocale()] )}}">
                    <img style="width: 25px;height: 16px" src="{{asset('website')}}/images/en.jpg"></a>
            @endif
        </div>

        <ul class="nav navbar-nav align-items-center ml-auto">
            <li class="nav-item dropdown dropdown-user"><a class="nav-link dropdown-toggle dropdown-user-link" id="dropdown-user" href="javascript:void(0);" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <div class="user-nav d-sm-flex d-none">
                        <span class="user-name font-weight-bolder">{{auth('admin')->user()->name}}</span><span class="user-status">مشرف</span>
                        </div><span class="avatar"><img class="round" src="{{auth('admin')->user()->image != null ? get_file(auth('admin')->user()->image) : asset('dashboard_files/').'/app-assets/images/portrait/small/avatar-s-11.jpg'}}" 
                        alt="avatar" height="40" width="40"><span class="avatar-status-online"></span></span>
                </a>
                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdown-user">
                    <a class="dropdown-item" href="{{route('dashboard.logout')}}"><i class="mr-50" data-feather="power"></i> تسجيل خروج </a>
                </div>
            </li>
        </ul>
        @can('notifications-index')
        <div style="display: flex;justify-content: center;align-items: center;margin-right:10px">
            <span style="position: relative;
                        font-weight: bold;
                        top: -8px;
                        /*left: 26px;*/
                        color: white;
                        background-color: #7367F0 !important;
                        border-radius: 10px;">{{\App\Models\Notification::where('is_read' , 0)->count()}}</span>
            <a href="{{route('dashboard.notifications.index')}}">
                <i style="font-size:20px;font-weight:bold" class="fa-regular fa-bell"></i>
            </a>
        </div>
        @endcan
    </div>
</nav>
<!-- END: Header-->
