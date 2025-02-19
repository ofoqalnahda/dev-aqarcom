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
                                <div class="card-body p-1 search-bar">
                                        <form class="search-form" action="{{route('dashboard.users.index')}}">
                                            <input type="text" name="search" value="{{request()->search}}" class="form-control-sm" />
                                            <button class="btn btn-sm btn-primary m-1">@lang('search')</button>
                                        </form>

                                </div>

                            </div>
                        </div>

                        <!-- Company Table Card -->
                        <div class="col-lg-12 col-12">
                            <div class="card card-company-table">
                                <div class="card-body p-0">
                                    <div class="table-responsive">
                                        <table class="table">
                                            <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>@lang('image')</th>
                                                <th>@lang('name')</th>
                                                <th>@lang('email')</th>
                                                <th>@lang('phone')</th>
                                                <th>@lang('code')</th>
                                                <th>@lang('city')</th>
                                                <th>@lang('ads_count')</th>
                                                <th> @lang('val_license_photo')</th>
                                                <th>@lang('join at')</th>
                                                @can('users-changeStatus')

                                                <th>@lang('status')</th>
                                                @endcan
                                                <th>@lang('control')</th>
                                                
                                            </tr>
                                            </thead>
                                            <tbody>
                                                @foreach($users as $user)
                                                <?php
                                               // dd($user);
                                                ?>
                                                    <tr>
                                                        <td>
                                                            {{$loop->iteration}}
                                                        </td>

                                                        <td>
                                                            <a  href="{{route('dashboard.users.show' , $user->id)}}" >
                                                            <div class="d-flex align-items-center">
                                                                <img style="width:50px; height:50px;" class="img-rounded" src="{{get_file($user->image)}}" alt="user-image" />
                                                                </a>
                                                            </div>
                                                        </td>
                                                        <td>
                                                               <a  href="{{route('dashboard.users.show' , $user->id)}}" >
                                                            <div class="d-flex">
                                                                <span>{{$user->name}}</span>
                                                            </div>
                                                            </a>
                                                        </td>
                                                        <td>
                                                            <div class="d-flex">
                                                                <span>{{$user->email}}</span>
                                                            </div>
                                                        </td>
                                                        <td class="text-nowrap">
                                                            <div class="d-flex">
                                                                <span><a href="tel:{{$user->phone}}">{{$user->phone}}</a></span>
                                                            </div>
                                                        </td>
                                                        
                                                        <td class="text-nowrap">
                                                            <div class="d-flex">
                                                                <span>{{$user->code}}</span>
                                                            </div>
                                                        </td>
                                                        <td class="text-nowrap">
                                                            <div class="d-flex">
                                                                <span>{{$user->city?->name}}</span>
                                                            </div>
                                                        </td>

                                                        <td class="text-nowrap">
                                                            <div class="d-flex">
                                                                <span>{{$user->ads_count}}</span>
                                                            </div>
                                                        </td>
                                                        
                                                        <td>
                                                            @if($user->val_license)
                                                            <div class="d-flex align-items-center">
                                                                <img style="width:50px; height:50px;" class="img-rounded" src="{{get_file($user->val_license)}}" alt="admin-image" />
                                                            </div>
                                                            @else
                                                            لا يوجد
                                                            @endif
                                                        </td>
                                                        <td class="text-nowrap">
                                                            <div class="d-flex">
                                                                <span>{{ $user->created_at ? $user->created_at->format('Y-m-d h:i A'):'' }}</span>
                                                            </div>
                                                        </td>
                                                        @can('users-changeStatus')
                                                        <td class="text-nowrap">
                                                            <div class="d-flex custom-control custom-control-primary custom-switch">
                                                                <input type="checkbox" class="custom-control-input" id="customSwitch{{$user->id}}" {{$user->is_active? 'checked' : ''}} />
                                                                <label class="custom-control-label changeStatus" for="customSwitch{{$user->id}}" data-id="{{$user->id}}"></label>
                                                            </div>
                                                        </td>
                                                        @endcan

                                                        <td>
                                                            <div class="d-flex align-items-center justify-content-around">
                                                                @can('users-show')
                                                                <a style="margin-left: 10px" href="{{route('dashboard.users.show' , $user->id)}}" class="btn-sm btn-primary"><i data-feather="eye"></i></a>
                                                                @endcan
                                                                @can('ads-index')
                                                                <a style="margin-left: 10px" href="{{route('dashboard.ads.index' , ['user_id'=>$user->id])}}" class="btn-sm btn-info"><i data-feather="file-minus"></i></a>
                                                                @endcan
                                                                @can('users-destroy')
                                                                <form action="{{route('dashboard.users.destroy' , $user->id)}}" method="post">
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
                                    {{ $users->appends(request()->query())->links() }}
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

@push('scripts')
    <script>
        $('.changeStatus').on('click' , function (){
            var id = $(this).data('id');
            var url = '{{route("dashboard.users.changeStatus" , ":id")}}';
            url = url.replace(':id' , id);

            $.ajax({
                url: url,
                method: "get",
                dataType: 'json',
                cache: false,
                contentType: false,
                processData: false,
                success: function (response) {
                    new Noty({
                        type: 'success',
                        layout: 'topRight',
                        text: response.success,
                        timeout: 2000,
                        killer: true
                    }).show();
                },
                error: function (response) {
                    console.log(response.responseJSON);
                    new Noty({
                        type: 'error',
                        layout: 'topRight',
                        text: response.responseJSON.error,
                        timeout: 2000,
                        killer: true
                    }).show();
                }
            });
        });
    </script>
@endpush
@endsection
