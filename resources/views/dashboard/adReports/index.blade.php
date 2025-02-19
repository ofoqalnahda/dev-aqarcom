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
                <section id="dashboard_files-ecommerce">
                    <div class="row match-height">
                        <!-- Company Table Card -->
                        <div class="col-lg-12 col-12">
                            <div class="card card-company-table">
                                <div class="card-body p-0">
                                    <div class="table-responsive">
                                        <table id="datatable-table"  class="table">
                                            <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>@lang('ad_id')</th>
                                                <th>@lang('reporter_name')</th>
                                                <th>@lang('reason')</th>
                                                <th>@lang('date')</th>
                                                <th>@lang('control')</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                                @foreach($adReports as $adReport)
                                                    <tr>
                                                        <td>
                                                            {{$loop->iteration}}
                                                        </td>
                                                        <td>
                                                            <div class="d-flex align-items-center">
                                                                <span>{{$adReport->ad_id}}</span>
                                                            </div>
                                                        </td>
                                                        <td>
                                                            <div class="d-flex align-items-center">
                                                                <a href="{{route('dashboard.users.show' , $adReport->user_id)}}"><span>{{$adReport->user?->name}}</span></a>
                                                            </div>
                                                        </td>
                                                        <td >
                                                            <div class="d-flex flex-column">
                                                                <span class="font-weight-bolder mb-25">{{$adReport->reportReason->reason}}</span>
                                                            </div>
                                                        </td>
                                                        <td >
                                                            <div class="d-flex flex-column">
                                                                <span class="font-weight-bolder mb-25">{{ $adReport->created_at ? $adReport->created_at->format('Y-m-d h:i A'):'' }}</span>
                                                            </div>
                                                        </td>
                                                        <td>
                                                            <div class="d-flex align-items-center">
                                                                @can('ads-show')
                                                                <a href="{{route('dashboard.ads.show' , $adReport->ad->id)}}" class="btn-sm btn-info">@lang('show_ad')</a>
                                                                @endcan
                                                                @can('adReports-destroy')
                                                                <form action="{{route('dashboard.adReports.destroy' , $adReport->id)}}" method="post">
                                                                    @csrf
                                                                    @method('delete')
                                                                    <button type="submit" class="btn btn-sm btn-danger m-1">@lang('delete')</button>
                                                                </form>
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
