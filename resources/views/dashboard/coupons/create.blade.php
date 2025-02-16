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
                                    <h4 class="card-title">@lang('add')</h4>
                                </div>
                                <div class="card-body">
                                    <form class="form form-horizontal" action="{{route('dashboard.coupons.store')}}" method="POST" >
                                        @csrf
                                        <div class="row">
                                            <div class="col-12">
                                                <div class="form-group row">
                                                    <div class="col-sm-3 col-form-label">
                                                        <label for="code">@lang('code')<font color="red">*</font></label>
                                                    </div>
                                                    <div class="col-sm-6">
                                                        <input required type="text" id="code" class="form-control" name="code" value="{{old('code')}}" />
                                                    </div>

                                                    <div class="col-sm-3">
                                                        <button type="button" id="code_gen" class="btn btn-primary w-100">@lang('generate_code')</button>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-12">
                                                <div class="form-group row">
                                                    <div class="col-sm-3 col-form-label">
                                                        <label for="discount_type">@lang('discount_type')<font color="red">*</font></label>
                                                    </div>
                                                    <div class="col-sm-9">
                                                        <select required name="type" id="discount_type" class="form-control">
                                                            <option @selected(old("type")=="fixed") value="fixed">@lang('discount_fixed')</option>
                                                            <option @selected(old("type")=="percent") value="percent">@lang('discount_percent')</option>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>


                                            <div class="col-12">
                                                <div class="form-group row">
                                                    <div class="col-sm-3 col-form-label">
                                                        <label for="value">@lang('value')<font color="red">*</font></label>
                                                    </div>
                                                    <div class="col-sm-9">
                                                        <input required type="number" min="1" id="value" class="form-control" name="value" value="{{old('value')}}" />
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-12">
                                                <div class="form-group row">
                                                    <div class="col-sm-3 col-form-label">
                                                        <label for="max_usage">@lang('max_usage')</label>
                                                    </div>
                                                    <div class="col-sm-9">
                                                        <input  type="number" min="1" id="max_usage" class="form-control" name="max_usage" value="{{old('max_usage')}}" />
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-12">
                                                <div class="form-group row">
                                                    <div class="col-sm-3 col-form-label">
                                                        <label for="max_usage_per_user">@lang('max_usage_per_user') </label>
                                                    </div>
                                                    <div class="col-sm-9">
                                                        <input  type="number" min="1" id="max_usage_per_user" class="form-control" name="max_usage_per_user" value="{{old('max_usage_per_user')}}" />
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-12" >
                                                <div class="form-group row">
                                                    <div class="col-sm-3 col-form-label">
                                                        <label for="date">@lang('expires')</label>
                                                    </div>
                                                    <div class="col-sm-9">
                                                        <input type="checkbox" @checked(old("expires")) id="expires_box" class="form-control" name="expires" />
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-12 d-none" id="expires">
                                                <div class="form-group row">
                                                    <div class="col-sm-3 col-form-label">
                                                        <label for="date">@lang('date')</label>
                                                    </div>
                                                    <div class="col-sm-9">
                                                        <input required type="date"  id="date" class="form-control" name="expire_date" value="{{old('expire_date')}}" />
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-12">
                                                <div class="form-group row">
                                                    <div class="col-sm-3 col-form-label">
                                                        <label for="subscriptions">{{__("available_subscription_packages")}} <font color="red">*</font></label>
                                                    </div>
                                                    <div class="col-sm-9">
                                                        <select id="page-select" name="subscription_ids[]" id="subscriptions" class="form-control" multiple required>
                                                            <option value="" disabled >@lang('select_value')</option>
                                                            @foreach($subscriptions as $subscription)
                                                                <option value="{{$subscription->id}}" >{{$subscription->name}}</option>
                                                            @endforeach

                                                        </select>
                                                    </div>
                                                </div>
                                            </div>


                                            <div class="col-sm-9 offset-sm-3">
                                                <button type="submit" class="btn btn-primary mr-1">@lang('add')</button>
                                                <button type="reset" class="btn btn-outline-secondary">@lang('reset')</button>
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
            function change_max() {
                if ($('#discount_type').val() == 'percent') {
                    $('#value').attr('max', 100);
                    if ($('#value').val() > 100) $('#value').val('');
                } else {
                    $('#value').removeAttr('max');
                }
            }
            change_max();
            $('#discount_type').change(change_max);

            function change_expires() {
                if ($('#expires_box').is(':checked')) {
                    $('#expires').removeClass('d-none');
                    $('#date').attr('required', true);
                } else {
                    $('#expires').addClass('d-none');
                    $('#date').attr('required', false);
                }
            }
            change_expires();
            $('#expires_box').change(change_expires);

            function auto_generate_code() {
                let code = Math.random().toString(36).substring(2, 10);
                $('#code').val(code);
            }

            $('#code_gen').click(auto_generate_code);

        });
    </script>
@endpush


