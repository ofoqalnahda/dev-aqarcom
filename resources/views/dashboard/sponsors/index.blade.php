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
                        @can('sponsors-create')
                        <div class="col-lg-12 col-12">
                            <div class="card card-company-table">
                                <div class="card-body p-1 search-bar">
                                        <form class="search-form " method="post" action="{{route('dashboard.sponsors.store')}}" enctype="multipart/form-data">
                                            @csrf
                                            <input type="file" name="image" class="form-control" />
                                            <button type="submit" style="width: 80px;" class="btn btn-sm btn-primary m-1">@lang('add') </button>
                                        </form>
                                </div>
                            </div>
                        </div>
                        @endcan

                        <!-- Company Table Card -->
                        <div class="col-lg-6 col-6">
                            <div class="card card-company-table">
                                <div class="card-body p-0">
                                    <div class="table-responsive">
                                        <table class="table">
                                            <thead>
                                            <tr>
                                                <th>@lang('image')</th>
                                                <th>@lang('control')</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                                @foreach($sponsors as $sponsor)
                                                    <tr>
                                                        <td>
                                                            <div class="d-flex align-items-center">
                                                                <img style="width:50px; height:50px;" class="img-rounded" src="{{$sponsor->image}}" alt="admin-image" />
                                                            </div>
                                                        </td>
                                                        <td>
                                                            @can('sponsors-destroy')
                                                            <div class="d-flex align-items-center">
                                                                <form action="{{route('dashboard.sponsors.destroy' , $sponsor->id)}}" method="post">
                                                                    @csrf
                                                                    @method('delete')
                                                                    <button type="submit" class="btn btn-sm btn-danger m-1">@lang('delete')</button>
                                                                </form>
                                                            </div>
                                                            @endcan
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
