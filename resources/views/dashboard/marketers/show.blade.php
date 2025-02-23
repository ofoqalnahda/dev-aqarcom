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
                                        <div class="col-xl-6 col-lg-12 d-flex flex-column justify-content-between border-container-lg">
                                            <div class="user-avatar-section">
                                                <div class="d-flex justify-content-start">
                                                    <img class="img-fluid rounded" src="{{get_file($marketer->image)}}" height="104" width="104" alt="User avatar" />
                                                    <div class="d-flex flex-column ml-1 justify-content-center">
                                                        <div class="user-info mb-1">
                                                            <h4 class="mb-0">{{$marketer->name}}</h4>
                                                        </div>
                                                        <div class="d-flex flex-wrap">
                                                            @can('marketers-edit')
                                                            <a class="btn btn-outline btn-primary m-1" href="{{route('dashboard.marketers.draws' , $marketer->id)}}" >@lang('actions')</a>
                                                            @endcan
                                                            @can('marketers-destroy')
                                                            <form action="{{route('dashboard.marketers.destroy' , $marketer->id)}}" method="post">
                                                                @csrf
                                                                @method('delete')
                                                                <button type="submit" class="btn btn-outline btn-danger m-1">@lang('delete')</button>
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
                                                        <span class="card-text user-info-title font-weight-bold mb-0">{{$marketer->name}}</span>
                                                    </div>
                                                </div>
                                                <div class="d-flex flex-wrap">
                                                    <div class="user-info-title">
                                                        <i class="fa-regular fa-envelope mr-1"></i>
                                                        <span class="card-text user-info-title font-weight-bold mb-0">{{$marketer->email}}</span>
                                                    </div>
                                                </div>
                                                <div class="d-flex flex-wrap">
                                                    <div class="user-info-title">
                                                        <i data-feather="phone" class="mr-1"></i>
                                                        <span class="card-text user-info-title font-weight-bold mb-0">{{$marketer->phone}}</span>
                                                    </div>
                                                </div>

                                                <div class="d-flex flex-wrap">
                                                    <div class="user-info-title">
                                                        <span class="card-text user-info-title font-weight-bold mb-0">@lang('identity_number') : </span>
                                                        <span class="card-text user-info-title font-weight-bold mb-0">{{$marketer->identity_number}}</span>
                                                    </div>
                                                </div>

                                                <div class="d-flex flex-wrap">
                                                    <div class="user-info-title">
                                                        <span class="card-text user-info-title font-weight-bold mb-0">@lang('balance') : </span>
                                                        <span class="card-text user-info-title font-weight-bold mb-0">{{$marketer->balance}}</span>
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
                </section>

            </div>
        </div>
    </div>

@endsection
