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
                        @can('features-create')
                        <div class="col-lg-12 col-12">
                            <div class="card card-company-table">
                                <div class="card-body p-1 search-bar">
                                    <a href="{{route('dashboard.features.create')}}" class="btn-sm btn-primary">@lang('add')</a>
                                </div>
                            </div>
                        </div>
                        @endcan

                        <!-- Company Table Card -->
                        <div class="col-lg-12 col-12">
                            <div class="card card-company-table">
                                <div class="card-body p-0">
                                    <div class="table-responsive">
                                        <table id="datatable-table"  class="table">
                                            <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>@lang('title_ar')</th>
                                                <th>@lang('title_en')</th>
                                                <th>@lang('control')</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                                @foreach($features as $feature)
                                                    <tr>
                                                        <td>
                                                            {{$loop->iteration}}
                                                        </td>
                                                        <td>
                                                            <div class="d-flex align-items-center">
                                                                <span>{{$feature->translate('ar')->title}}</span>
                                                            </div>
                                                        </td>

                                                        <td>
                                                            <div class="d-flex align-items-center">
                                                                <span>{{$feature->translate('en')->title}}</span>
                                                            </div>
                                                        </td>

                                                        <td>
                                                            <div class="d-flex align-items-center">
                                                                @can('features-edit')
                                                                    <a href="{{route('dashboard.features.edit' , $feature->id)}}" class="btn-sm btn-info">@lang('edit')</a>

                                                                    @endcan
                                                                    @can('features-destroy')
                                                                    <form action="{{route('dashboard.features.destroy' , $feature->id)}}" method="post">
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
