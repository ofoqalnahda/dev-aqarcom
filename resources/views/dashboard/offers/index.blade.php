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
                        <div class="col-lg-12 col-12">
                            <div class="card card-company-table">
                                <div class="card-body p-0">
                                    <div class="table-responsive">
                                        <table  class="table">
                                            <thead>
                                            <tr>
                                                <th style="text-align:center">@lang('offers')</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                                @foreach($chats as $chat)
                                                    <tr>
                                                        <td>
                                                            @can('offers-create')
                                                            <a href="{{route("dashboard.offers.show",$chat->id)}}">{{$chat->receiver->name}} - {{$chat->title}}</a>
                                                            @endcan
                                                            <span class="text-muted d-block">{{$chat->lastMessage?->sender->name}} : {{$chat->lastMessage?->message}}</span>
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
