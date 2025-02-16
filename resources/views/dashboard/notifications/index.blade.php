@extends('dashboard.layouts.app')

@section('content')
<style>
    td.is_read_0 {
    background-color: #0000001f;
}
</style>
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
                        <div class="col-lg-8 col-12">
                            <div class="card card-company-table">
                                <div class="card-body p-0">
                                    <div class="table-responsive">
                                        <table  class="table">
                                            <thead>
                                            <tr>
                                                <th style="text-align:center">@lang('notifications')</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                                @foreach($notifications as $notification)
                                                    <tr>
                                                        <td class="is_read_{{$notification->is_read}}">
                                                            <a href="{{route('dashboard.notifications.show',$notification->id)}}">{{$notification->message}}</a>
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
