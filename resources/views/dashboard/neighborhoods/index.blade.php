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
                        @can('neighborhoods-create')
                        <div class="col-lg-12 col-12">
                            <div class="card card-company-table">
                                <div class="card-body p-1 search-bar">
                                    <a href="{{route('dashboard.neighborhoods.create')}}" class="btn-sm btn-primary">@lang('add')</a>
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
                                                <th>@lang('city')</th>
                                                <th>@lang('name_ar')</th>
                                                <th>@lang('name_en')</th>
                                                <th>@lang('control')</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                                @foreach($neighborhoods as $neighborhood)
                                                    <tr>
                                                        <td>
                                                            {{$loop->iteration}}
                                                        </td>
                                                        <td>
                                                            <div class="d-flex align-items-center">
                                                                <span>{{$neighborhood->city?->name}}</span>
                                                            </div>
                                                        </td>
                                                        <td>
                                                            <div class="d-flex align-items-center">
                                                                <span>{{$neighborhood->translate('ar')?->name}}</span>
                                                            </div>
                                                        </td>

                                                        <td>
                                                            <div class="d-flex align-items-center">
                                                                <span>{{$neighborhood->translate('en')?->name}}</span>
                                                            </div>
                                                        </td>

                                                        <td>
                                                            <div class="d-flex align-items-center">
                                                                @can('neighborhoods-edit')
                                                                <a href="{{route('dashboard.neighborhoods.edit' , $neighborhood->id)}}" class="btn-sm btn-info">@lang('edit')</a>
                                                                @endcan
                                                                @can('neighborhoods-destroy')

                                                                <form action="{{route('dashboard.neighborhoods.destroy' , $neighborhood->id)}}" method="post">
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
