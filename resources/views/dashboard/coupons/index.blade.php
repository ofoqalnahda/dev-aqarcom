@extends('dashboard.layouts.app')
@php($subs = \App\Models\Subscription::all())
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
                        @can('coupons-create')
                        <div class="col-lg-12 col-12">
                            <div class="card card-company-table">
                                <div class="card-body p-1 search-bar">
                                    <a href="{{route('dashboard.coupons.create')}}" class="btn-sm btn-primary">@lang('add')</a>
                                </div>
                            </div>
                        </div>
                        @endcan

                        <!-- Company Table Card -->
                        <div class="col-lg-12 col-12">
                            <div class="card card-company-table">
                                <div class="card-body p-0">
                                    <div class="table-responsive">
                                        <table id="datatable-table" class="table">
                                            <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>الكود</th>
                                                <th>النوع</th>
                                                <th>القيمه</th>
                                                <th>{{__('max_usage')}}</th>
                                                <th>{{__('max_usage_per_user')}}</th>
                                                <th>الباقات المتاحه للخصم </th>
                                                <th>تاريخ الانتهاء</th>
{{--                                                <th>استخدم بواسطة</th>--}}
                                                <th>التحكم</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                                @foreach($coupons as $coupon)
                                                    <tr>
                                                        <td>
                                                            {{$loop->iteration}}
                                                        </td>
                                                        <td>
                                                            <div class="d-flex align-items-center">
                                                                <span>{{$coupon->code}}</span>
                                                            </div>
                                                        </td>
                                                        <td>
                                                            <div class="d-flex align-items-center">
                                                                <span>{{$coupon->type}}</span>
                                                            </div>
                                                        </td>
                                                        <td class="text-nowrap">
                                                            <div class="d-flex align-items-center">
                                                                <span>{{$coupon->value}} @if($coupon->type=="percent")%@endif</span>
                                                            </div>
                                                        </td>
                                                        <td class="text-nowrap">
                                                            <div class="d-flex align-items-center">
                                                                <span>{{$coupon->max_usage}} </span>
                                                            </div>
                                                        </td>
                                                        <td class="text-nowrap">
                                                            <div class="d-flex align-items-center">
                                                                <span>{{$coupon->max_usage_per_user}}</span>
                                                            </div>
                                                        </td>

                                                        <td class="text-nowrap">
                                                            <div class="d-flex align-items-center">
                                                                <span>{{$coupon->subscriptionsName()}}</span>
                                                            </div>
                                                        </td>
                                                        <td class="text-nowrap">
                                                            <div class="d-flex align-items-center">
                                                                <span>{{$coupon->expire_date_for_human}}</span>
                                                            </div>
                                                        </td>
{{--                                                        <td class="text-nowrap">
                                                            <div class="d-flex align-items-center">
                                                                <span>{{$coupon->user_used?->name}}</span>
                                                            </div>
                                                        </td>--}}
                                                        <td>
                                                            <div class="d-flex align-items-center">
                                                                <a class="btn-sm btn-primary m-1" data-toggle="modal"
                                                                   data-target="#coupon{{ $coupon->id }}">@lang('users')</a>
                                                                @can('coupons-edit')
                                                                    <a href="{{route('dashboard.coupons.edit' , $coupon->id)}}" class="btn-sm btn-info">@lang('edit')</a>
                                                                    @endcan
                                                                    @can('coupons-destroy')
                                                                    <form action="{{route('dashboard.coupons.destroy' , $coupon->id)}}" method="post">
                                                                        @csrf
                                                                        @method('delete')
                                                                        <button type="submit" class="btn btn-sm btn-danger m-1">@lang('delete')</button>
                                                                    </form>
                                                                    @endcan
                                                                    @can('coupons-toggle')
                                                                @if(!$coupon->user_used && (!$coupon->expire_date || ($coupon->expire_date && $coupon->expire_date >= today())))
                                                                    <form action="{{route('dashboard.coupons.toggle' , $coupon->id)}}" method="post">
                                                                        @csrf
                                                                        <button type="submit"  @class([
                                                                                                'btn btn-sm m-1'=>true,
                                                                                                'btn-danger' => !$coupon->is_active,
                                                                                                'btn-success' => $coupon->is_active
                                                                                        ])>
                                                                            @if(!$coupon->is_active) @lang('not_active')
                                                                            @elseif($coupon->is_active) @lang('active')@endif
                                                                        </button>
                                                                    </form>
                                                                @endif
                                                                @endcan
                                                            </div>
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>

                                        @foreach ($coupons as $coupon)
                                            <div class="modal fade" id="coupon{{ $coupon->id }}" tabindex="-1"
                                                 role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
                                                <div class="modal-dialog" role="document">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title" id="exampleModalLongTitle">
                                                                @lang('users')</h5>
                                                            <button type="button" class="close" data-dismiss="modal"
                                                                    aria-label="Close">
                                                                <span aria-hidden="true">&times;</span>
                                                            </button>
                                                        </div>
                                                        <div class="modal-body">
                                                            @foreach ($coupon->users as $user)
                                                                <a
                                                                    href="{{ route('dashboard.users.show', $user->id) }}">{{ $user->name }} - {{$subs->where("id",$user?->pivot?->subscription_id)?->first()?->name}}  - {{(new \Carbon\Carbon($user?->pivot?->created_at))->format('Y-m-d')}}</a>
                                                                <hr>
                                                            @endforeach
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach

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
