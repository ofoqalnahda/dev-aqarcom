@extends('dashboard.layouts.app')

@section('content')
<style>
   
 .item-action {
    width: 30%;
    margin: auto;
    padding: 10px;
    text-align: center;
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
                <section id="dashboard_files-ecommerce">
                    <div class="row match-height">
                        <!-- Company Table Card -->
                        <div class="col-lg-12 col-12">
                            <div class="card card-company-table">
                                <div class="card-body p-0">
                                    <div class="table-responsive">
                                        <table id="datatable-table" class="table">
                                            <thead>
                                            <tr>
                                                <th>@lang('fname')</th>
                                                <th>@lang('lname')</th>
                                                <th>@lang('email')</th>
                                                <th>@lang('phone')</th>
                                                <th>@lang('subject')</th>
                                                <th>@lang('message')</th>
                                                <th>@lang('date')</th>
                                                <th>@lang('action')</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            @foreach($messages as $message)
                                                @php
                                                    $user = \App\Models\User::where('phone' , $message->phone)->first();
                                                @endphp

                                                <tr>
                                                    <td>
                                                        <div class="d-flex flex-column">
                                                            <span
                                                                class="font-weight-bolder mb-25">{{$user?->name?:$message->fname}}</span>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="d-flex flex-column">
                                                            <span
                                                                class="font-weight-bolder mb-25">{{$message->lname}}</span>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="d-flex flex-column">
                                                            <span
                                                                class="font-weight-bolder mb-25">{{$message->email}}</span>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="d-flex align-items-center">
                                                            @if($user)
                                                                <a href="{{route('dashboard.users.show' ,$user->id )}}"><span>{{$message->phone}}</span></a>
                                                            @else
                                                                <span>{{$message->phone}}</span>
                                                            @endif
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="d-flex flex-column">
                                                            <span
                                                                class="font-weight-bolder mb-25">{{$message->subject}}</span>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="d-flex flex-column">
                                                            <span
                                                                class="font-weight-bolder mb-25">{{$message->message}}</span>
                                                        </div>
                                                    </td>

                                                    <td>
                                                        <div class="d-flex flex-column">
                                                            <span
                                                                class="font-weight-bolder mb-25">{{$message->created_at->diffForHumans()}}</span>
                                                        </div>
                                                    </td>
                                                     <td>
                                                        <div class="row" style=" width: 150px;">
                                                            @if($user)
                                                            <a class="btn btn-outline-primary item-action" href="{{url('/dashboard/notifications/send')}}?user_id={{$user->id}}">
                                                                <i class="fa-solid fa-comment"></i>
                                                            </a>
                                                            @endif
                                                            <a class="btn btn-outline-success item-action" href="https://api.whatsapp.com/send?phone=966{{ ltrim($message->whatsapp, '0')}}">
                                                                <i class="fa-brands fa-whatsapp"></i>
                                                            </a>
                                                            <a class="btn btn-outline-info item-action" href="tel:{{$message->phone}}">
                                                                <i  data-feather="phone"></i>
                                                            </a>
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
