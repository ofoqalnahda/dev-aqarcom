@extends('dashboard.layouts.app')

@section('content')
    <!-- BEGIN: Content-->
    <div class="app-content content ">
        <div class="content-overlay"></div>
        <div class="header-navbar-shadow"></div>
        <div class="content-wrapper container-xxl p-0">
            <div class="content-header row">
                 @can('ads-changeStatus')
                    <div class="col-lg-3 col-6">
                        <div class="card card-company-table">
                            <div class="card-body p-1 search-bar">
                                <a href="{{route('dashboard.ads.changeStatusExpiry')}}" class="btn-sm btn-outline-danger">@lang('changeStatus expiry') ({{$expiry_count}})</a>
                            </div>
                        </div>
                    </div>
                @endcan
                @can('ads-changeStatus')
                    <div class="col-lg-3 col-6">
                        <div class="card card-company-table">
                            <div class="card-body p-1 search-bar">
                                <a href="{{route('dashboard.ads.Expiry',['type'=>'sell'])}}" class="btn-sm btn-outline-secondary">@lang('Ads expiry')</a>
                            </div>
                        </div>
                    </div>
                @endcan
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
                                        <table class="table">
                                            <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>@lang('image')</th>
                                                <th>@lang('user_name')</th>
                                                <th>@lang('main_type')</th>
                                                @can('ads-changeStatus')
                                                <th>@lang('status')</th>
                                                @endcan
                                                <th>@lang('changeStatus_date_expiry')</th>
                                                <th>@lang('date')</th>
                                                <th>@lang('control')</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            @foreach($ads as $ad)
                                                <tr>
                                                    <td>
                                                        <div class="d-flex align-items-center">
                                                            <span>{{$ad->id}}</span>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="d-flex align-items-center">
                                                            <img style="width:50px; height:50px;" class="img-rounded" src="{{get_file($ad->attachments->first()?->link)}}" alt="admin-image" />
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="d-flex align-items-center">
                                                            <a href="{{route('dashboard.users.show' , $ad->user_id)}}"><span>{{$ad->user->name}}</span></a>
                                                        </div>
                                                    </td>

                                                    <td>
                                                        <div class="d-flex align-items-center">
                                                            <span>{{__($ad->main_type)}}</span>
                                                        </div>
                                                    </td>

                                                    @can('ads-changeStatus')
                                                    <td class="text-nowrap">
                                                        <div class="d-flex custom-control custom-control-primary custom-switch">
                                                            <input type="checkbox" class="custom-control-input" id="customSwitch{{$ad->id}}" {{$ad->active? 'checked' : ''}} />
                                                            <label class="custom-control-label changeStatus" for="customSwitch{{$ad->id}}" data-id="{{$ad->id}}"></label>
                                                        </div>
                                                    </td>
                                                    @endcan
                                                    @php
                                                        $platform_data=null;
                                                        $platform= $ad->platform()->first();
                                                        if($platform){
                                                          $platform_data = json_decode($platform->data, true);

                                                        }
                                                    
                                                    
                                                    @endphp
                                                    <td>
                                                        <div class="d-flex flex-column">
                                                            <span class="font-weight-bolder mb-25">{{$platform_data?$platform_data['endDate']:''}}</span>
                                                        </div>
                                                    </td>
                                                    <td >
                                                        <div class="d-flex flex-column">
                                                            <span class="font-weight-bolder mb-25">{{$ad->created_at->diffForHumans()}}</span>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="d-flex align-items-center">
                                                            @can('ads-show')
                                                            <a href="{{route('dashboard.ads.show' , $ad->id)}}" class="btn-sm btn-primary"><i data-feather="eye"></i></a>
                                                        @endcan
                                                            @can('ads-destroy')
                                                            <form action="{{route('dashboard.ads.destroy' , $ad->id)}}" method="post">
                                                                @csrf
                                                                @method('delete')
                                                                <button type="submit" class="btn btn-sm btn-danger m-1"><i data-feather="trash"></i></button>
                                                            </form>
                                                            @endcan
                                                        </div>
                                                    </td>
                                                </tr>
                                            @endforeach
                                            </tbody>
                                        </table>
                                    {{ $ads->appends(request()->query())->links() }}
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
                var url = '{{route("dashboard.ads.changeStatus" , ":id")}}';
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
