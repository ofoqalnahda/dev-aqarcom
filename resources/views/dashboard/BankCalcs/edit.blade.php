@extends('dashboard.layouts.app')

@section('content')
    <!-- BEGIN: Content-->
    <div class="app-content content ">
        <div class="content-overlay"></div>
        <div class="header-navbar-shadow"></div>
        <div class="content-wrapper container-xxl p-0">
            <div class="content-body">
                <!-- Basic Horizontal form layout section start -->
                <section id="basic-horizontal-layouts">
                    <div class="row">
                        <div class="col-md-12 col-12">
                            <div class="card">
                                <div class="card-header">
                                    <h4 class="card-title">@lang('edit')</h4>
                                </div>
                                <div class="card-body">
                                    <form class="form form-horizontal" action="{{route('dashboard.bankCalcs.update',$bankCalc->id)}}" method="POST" >
                                        @csrf
                                        @method("put")
                                        <div class="row">
                                            <div class="col-12">
                                                <div class="form-group row">
                                                    <div class="col-sm-3 col-form-label">
                                                        <label for="code">@lang('name')</label>
                                                    </div>
                                                    <div class="col-sm-9">
                                                        <p>{{$bankCalc->name}}</p>
                                                    </div>
                                                </div>
                                            </div><div class="col-12">
                                                <div class="form-group row">
                                                    <div class="col-sm-3 col-form-label">
                                                        <label for="code">رقم الهوية</label>
                                                    </div>
                                                    <div class="col-sm-9">
                                                        <p>{{$bankCalc->national_id}}</p>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-12">
                                                <div class="form-group row">
                                                    <div class="col-sm-3 col-form-label">
                                                        <label for="discount_type">تاريخ الميلاد</label>
                                                    </div>
                                                    <div class="col-sm-9">
                                                        <p>{{$bankCalc->birth_date}}</p>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-12">
                                                <div class="form-group row">
                                                    <div class="col-sm-3 col-form-label">
                                                        <label for="value">الراتب</label>
                                                    </div>
                                                    <div class="col-sm-9">
                                                        <p>{{$bankCalc->salary}}</p>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-12">
                                                <div class="form-group row">
                                                    <div class="col-sm-3 col-form-label">
                                                        <label for="value">رقم التواصل</label>
                                                    </div>
                                                    <div class="col-sm-9">
                                                        <p>{{$bankCalc->contact_number}}</p>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-12">
                                                <div class="form-group row">
                                                    <div class="col-sm-3 col-form-label">
                                                        <label for="value">البريد الإلكتروني</label>
                                                    </div>
                                                    <div class="col-sm-9">
                                                        <p>{{$bankCalc->email}}</p>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-12">
                                                <div class="form-group row">
                                                    <div class="col-sm-3 col-form-label">
                                                        <label for="value">المهنة</label>
                                                    </div>
                                                    <div class="col-sm-9">
                                                        <p>{{$bankCalc->job}} - {{$bankCalc->job_name}}</p>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-12">
                                                <div class="form-group row">
                                                    <div class="col-sm-3 col-form-label">
                                                        <label for="value">البنك</label>
                                                    </div>
                                                    <div class="col-sm-9">
                                                        <p>{{$bankCalc->bank_name}}</p>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-12" >
                                                <div class="form-group row">
                                                    <div class="col-sm-3 col-form-label">
                                                        <label for="value">الإلتزامات المالية</label>
                                                    </div>
                                                    <div class="col-sm-9">
                                                        <p>{{$bankCalc->financial_obligations}}</p>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-12" >
                                                <div class="form-group row">
                                                    <div class="col-sm-3 col-form-label">
                                                        <label for="result">الرد</label>
                                                    </div>
                                                    <div class="col-sm-9">
                                                        <textarea name="result" id="result" @readonly($bankCalc->result) id="result" cols="30" rows="10" class="form-control">{{$bankCalc->result}}</textarea>
                                                    </div>
                                                </div>
                                            </div>





                                            <div class="col-sm-9 offset-sm-3">
                                                <button type="submit" id="toggle" class="btn btn-primary mr-1">@lang('reply')</button>

                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
                <!-- Basic Horizontal form layout section end -->

            </div>
        </div>
    </div>
    <!-- END: Content-->
@endsection

@push('scripts')
    <script>
        $(document).ready(function() {
            $("#toggle").on("click", function(e) {
                if($("#result").attr("readonly")) {
                    $("#result").attr("readonly", false);
                    e.preventDefault();
                    $(this).text("حفظ");

                    $(this)[0].classList.toggle("btn-primary");
                    $(this)[0].classList.toggle("btn-success");

                }
            });

        });
    </script>
@endpush


