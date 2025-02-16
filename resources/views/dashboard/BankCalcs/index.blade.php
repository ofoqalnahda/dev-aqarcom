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


                        <!-- Company Table Card -->
                        <div class="col-lg-12 col-12">
                            <div class="card card-company-table">
                                <div class="card-body p-0">
                                    <div class="table-responsive">
                                        <table id="datatable-table" class="table">
                                            <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>الاسم</th>
                                                <th>تاريخ الميﻻد</th>
                                                <th>الراتب</th>
                                                <th>اللتزامات المالية</th>
                                                <th>جهة العمل</th>
                                                <th>البنك</th>
                                                <th>النتيجه</th>
                                                <th>وصول البريد</th>
                                                <th>التحكم</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                                @foreach($calcs as $calc)
{{--                                                    @dd($calc)--}}
                                                    <tr>
                                                        <td>
                                                            {{$loop->iteration}}
                                                        </td>
                                                        <td>
                                                            <div class="d-flex align-items-center">
                                                                <span>{{$calc->name}}</span>
                                                            </div>
                                                        </td>
                                                        <td>
                                                            <div class="d-flex align-items-center">
                                                                <span>{{$calc->birth_date}}</span>
                                                            </div>
                                                        </td>
                                                        <td class="text-nowrap">
                                                            <div class="d-flex align-items-center">
                                                                <span>{{$calc->salary}}</span>
                                                            </div>
                                                        </td>
                                                        <td class="text-nowrap">
                                                            <div class="d-flex align-items-center">
                                                                <span>{{$calc->financial_obligations}}</span>
                                                            </div>
                                                        </td>
                                                        <td class="text-nowrap">
                                                            <div class="d-flex align-items-center">
                                                                <span>{{$calc->job_name}}</span>
                                                            </div>
                                                        </td>
                                                        <td class="text-nowrap">
                                                            <div class="d-flex align-items-center">
                                                                <span>{{$calc->bank_name}}</span>
                                                            </div>
                                                        </td>
                                                        <td class="text-nowrap">
                                                            <div class="d-flex align-items-center">
{{--                                                                <span>{{$calc->result}}</span>--}}
                                                                <span>{{Str::limit($calc->result,40)}}</span>
                                                            </div>
                                                        </td>
                                                        <td class="text-nowrap">
                                                            <div class="d-flex align-items-center">
{{--                                                                <span>{{$calc->result}}</span>--}}
                                                                @if($calc->email_sent)
                                                                    <span class="badge badge-success">تم الإرسال</span>
                                                                @endif
                                                            </div>
                                                        </td>

                                                        <td>
                                                            <div class="d-flex align-items-center">
{{--                                                                <a style="margin-left: 10px" href="{{route('dashboard.bankCalcs.show' , $calc->id)}}" class="btn-sm btn-primary"><i data-feather="eye"></i> @lang("show")</a>--}}
                                                                    @can('bankCalcs-edit')
                                                                <a style="margin-left: 10px" href="{{route('dashboard.bankCalcs.edit' , $calc->id)}}" class="btn-sm btn-primary"><i data-feather="file-minus"></i> @lang('reply')</a>
                                                                @endcan
                                                                @can('bankCalcs-resend')
                                                                @if($calc->result )

                                                                    <form action="{{route('dashboard.bankCalcs.resend' , $calc->id)}}" method="post">
                                                                        @csrf
                                                                        <button type="submit" class="btn-sm btn-success"><i data-feather="send"></i> إعادة ارسال</button>
                                                                    </form>
                                                                @endif
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
