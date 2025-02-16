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
                                    <h4 class="card-title"> @lang('general_data')</h4>
                                </div>
                                <div class="card-body">
                                    <form class="form form-horizontal" action="{{route('dashboard.settings.update')}}" method="POST" enctype="multipart/form-data">
                                        @csrf
                                        @method('put')
                                        <div class="row">
                                            <div class="col-12">
                                                <div class="form-group row">
                                                    <div class="col-sm-3 col-form-label">
                                                        <label>@lang('email')</label>
                                                    </div>
                                                    <div class="col-sm-9">
                                                        <input type="text" class="form-control" name="email" value="{{old('email' ,$settings?->email)}}"  />
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-12">
                                                <div class="form-group row">
                                                    <div class="col-sm-3 col-form-label">
                                                        <label >@lang('phone')</label>
                                                    </div>
                                                    <div class="col-sm-9">
                                                        <input type="text" class="form-control" name="phone" value="{{old('phone' , $settings?->phone)}}"  />
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-12">
                                                <div class="form-group row">
                                                    <div class="col-sm-3 col-form-label">
                                                        <label >@lang('whatsapp')</label>
                                                    </div>
                                                    <div class="col-sm-9">
                                                        <input type="text" class="form-control" name="whatsapp" value="{{ old('whatsapp' , $settings?->whatsapp )}}"  />
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-12">
                                                <div class="form-group row">
                                                    <div class="col-sm-3 col-form-label">
                                                        <label >@lang('address')</label>
                                                    </div>
                                                    <div class="col-sm-9">
                                                        <input type="text" class="form-control" name="address" value="{{ old('address' , $settings?->address )}}"  />
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-12">
                                                <div class="form-group row">
                                                    <div class="col-sm-3 col-form-label">
                                                        <label >@lang('facebook')</label>
                                                    </div>
                                                    <div class="col-sm-9">
                                                        <input type="text" class="form-control" name="facebook" value="{{ old('facebook' , $settings?->facebook )}}"  />
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-12">
                                                <div class="form-group row">
                                                    <div class="col-sm-3 col-form-label">
                                                        <label >@lang('linkedin')</label>
                                                    </div>
                                                    <div class="col-sm-9">
                                                        <input type="text" class="form-control" name="linkedin" value="{{ old('linkedin' , $settings?->linkedin )}}"  />
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-12">
                                                <div class="form-group row">
                                                    <div class="col-sm-3 col-form-label">
                                                        <label >@lang('twitter')</label>
                                                    </div>
                                                    <div class="col-sm-9">
                                                        <input type="text" class="form-control" name="twitter" value="{{ old('twitter' , $settings?->twitter )}}"  />
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-12">
                                                <div class="form-group row">
                                                    <div class="col-sm-3 col-form-label">
                                                        <label >@lang('snapchat')</label>
                                                    </div>
                                                    <div class="col-sm-9">
                                                        <input type="text"  class="form-control" name="snapchat" value="{{ old('snapchat' , $settings?->snapchat)}}"  />
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-12">
                                                <div class="form-group row">
                                                    <div class="col-sm-3 col-form-label">
                                                        <label >@lang('instagram')</label>
                                                    </div>
                                                    <div class="col-sm-9">
                                                        <input type="text" class="form-control" name="instagram" value="{{ old('instagram' , $settings?->instagram)}}"  />
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-12">
                                                <div class="form-group row">
                                                    <div class="col-sm-3 col-form-label">
                                                        <label >@lang('google_play')</label>
                                                    </div>
                                                    <div class="col-sm-9">
                                                        <input type="text" class="form-control" name="google_play" value="{{ old('google_play' , $settings?->google_play)}}"  />
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-12">
                                                <div class="form-group row">
                                                    <div class="col-sm-3 col-form-label">
                                                        <label >@lang('app_store')</label>
                                                    </div>
                                                    <div class="col-sm-9">
                                                        <input type="text" class="form-control" name="app_store" value="{{ old('app_store' , $settings?->app_store)}}"  />
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-12">
                                                <div class="form-group row">
                                                    <div class="col-sm-3 col-form-label">
                                                        <label >@lang('huawei_store')</label>
                                                    </div>
                                                    <div class="col-sm-9">
                                                        <input type="text" class="form-control" name="huawei_store" value="{{ old('huawei_store' , $settings?->huawei_store)}}"  />
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-12">
                                                <div class="form-group row ">
                                                    <div class="col-sm-3 col-form-label">
                                                        <label >@lang('status_support_services')</label>
                                                    </div>
                                                    <div class="col-sm-9 form-check">
                                                        <div class="row mx-4">
                                                            <div class="col-3">
                                                                <input type="radio" id="status_support_services_true" class="form-check-input" name="status_support_services" @checked($settings->status_support_services) value="1" />
                                                                <label class="form-check-label" for="status_support_services_true">
                                                                    مفعل
                                                                </label>
                                                            </div>
                                                            <div class="col-3">
                                                                <input type="radio" id="status_support_services_false" class="form-check-input" name="status_support_services" @checked(!$settings->status_support_services) value="0" />
                                                                <label class="form-check-label" for="status_support_services_false">
                                                                    غير مفعل
                                                                </label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-12">
                                                <div class="form-group row ">
                                                    <div class="col-sm-3 col-form-label">
                                                        <label >@lang('commission_status')</label>
                                                    </div>
                                                    <div class="col-sm-9 form-check">
                                                        <div class="row mx-4">
                                                            <div class="col-3">
                                                                <input type="radio" id="commission_status_true" class="form-check-input" name="commission_status" @checked($settings->commission_status) value="1" />
                                                                <label class="form-check-label" for="commission_status_true">
                                                                    مفعل
                                                                </label>
                                                            </div>
                                                            <div class="col-3">
                                                                <input type="radio" id="commission_status_false" class="form-check-input" name="commission_status" @checked(!$settings->commission_status) value="0" />
                                                                <label class="form-check-label" for="commission_status_false">
                                                                    غير مفعل
                                                                </label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-12">
                                                <div class="form-group row ">
                                                    <div class="col-sm-3 col-form-label">
                                                        <label >@lang('Nafath')</label>
                                                    </div>
                                                    <div class="col-sm-9 form-check">
                                                        <div class="row mx-4">
                                                            <div class="col-3">
                                                                <input type="radio" id="nafath_true" class="form-check-input" name="nafath_status" @checked($settings->nafath_status) value="1" />
                                                                <label class="form-check-label" for="nafath_true">
                                                                    مفعل
                                                                </label>
                                                            </div>
                                                            <div class="col-3">
                                                                <input type="radio" id="nafath_false" class="form-check-input" name="nafath_status" @checked(!$settings->nafath_status) value="0" />
                                                                <label class="form-check-label" for="nafath_false">
                                                                    غير مفعل
                                                                </label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-12">
                                                <div class="form-group row ">
                                                    <div class="col-sm-3 col-form-label">
                                                        <label >@lang('force_update')</label>
                                                    </div>
                                                    <div class="col-sm-9 form-check">
                                                        <div class="row mx-4">
                                                            <div class="col-3">
                                                                <input type="radio" id="force_update_true" class="form-check-input" name="force_update" @checked($settings->force_update) value="1" />
                                                                <label class="form-check-label" for="force_update_true">
                                                                    مفعل
                                                                </label>
                                                            </div>
                                                            <div class="col-3">
                                                                <input type="radio" id="force_update_false" class="form-check-input" name="force_update" @checked(!$settings->force_update) value="0" />
                                                                <label class="form-check-label" for="force_update_false">
                                                                    غير مفعل
                                                                </label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-12">
                                                <div class="form-group row">
                                                    <div class="col-sm-3 col-form-label">
                                                        <label >@lang('android_version')</label>
                                                    </div>
                                                    <div class="col-sm-9">
                                                        <input type="text"  title="Please enter version in format x.x.x"

                                                               class="form-control" name="android_version" value="{{ old('android_version' , $settings?->android_version)}}"  />
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-12">
                                                <div class="form-group row">
                                                    <div class="col-sm-3 col-form-label">
                                                        <label >@lang('ios_version')</label>
                                                    </div>
                                                    <div class="col-sm-9">
                                                        <input type="text"  class="form-control" name="ios_version" value="{{ old('ios_version' , $settings?->ios_version)}}"  />
                                                    </div>
                                                </div>
                                            </div>


                                            <div class="col-12">
                                                <div class="form-group row">
                                                    <div class="col-sm-3 col-form-label">
                                                        <label >@lang('refresh_ad_limit')</label>
                                                    </div>
                                                    <div class="col-sm-9">
                                                        <input type="text" class="form-control" name="refresh_ad_limit" value="{{ old('refresh_ad_limit' , $settings?->refresh_ad_limit)}}"  />
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-12">
                                                <div class="form-group row">
                                                    <div class="col-sm-3 col-form-label">
                                                        <label >@lang('default_free_ads')</label>
                                                    </div>
                                                    <div class="col-sm-9">
                                                        <input type="text" class="form-control" name="default_free_ads" value="{{ old('default_free_ads' , $settings?->default_free_ads)}}"  />
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-12">
                                                <div class="form-group row">
                                                    <div class="col-sm-3 col-form-label">
                                                        <label>@lang('logo')</label>
                                                    </div>
                                                    <div class="col-sm-9">
                                                        <input type="file" class="form-control" name="logo" />
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-12">
                                                <div class="form-group row">
                                                    <div class="col-sm-3 col-form-label">
                                                        <label>@lang('default_image')</label>
                                                    </div>
                                                    <div class="col-sm-9">
                                                        <input type="file" class="form-control" name="default_image" />
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-12">
                                                <div class="form-group row">
                                                    <div class="col-sm-3 col-form-label">
                                                        <label>@lang('val_image')</label>
                                                    </div>
                                                    <div class="col-sm-9">
                                                        <input type="file" class="form-control" name="val_image" />
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-12">
                                                <div class="form-group row">
                                                    <div class="col-sm-3 col-form-label">
                                                        <label >@lang('val_url')</label>
                                                    </div>
                                                    <div class="col-sm-9">
                                                        <input type="text" class="form-control" name="val_url" value="{{ old('val_url' , $settings?->val_url)}}"  />
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-sm-9 offset-sm-3">
                                                <button type="submit" class="btn btn-primary mr-1">@lang('edit')</button>
                                                <button type="reset" class="btn btn-outline-secondary">@lang('reset')</button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12 col-12">
                            <div class="card">
                                <div class="card-header">
                                    <h4 class="card-title"> @lang('metadata')</h4>
                                </div>
                                <div class="card-body">
                                    <form class="form form-horizontal" action="{{route('dashboard.settings.update')}}" method="POST" enctype="multipart/form-data">
                                        @csrf
                                        @method('put')
                                        <div class="row">
                                            <div class="col-12">
                                                <div class="form-group row">
                                                    <div class="col-sm-3 col-form-label">
                                                        <label >@lang('about_us_ar')</label>
                                                    </div>
                                                    <div class="col-sm-9">
                                                        <textarea type="text" class="form-control ckeditor" name="ar[about_us]"  >{{old('ar.about_us'  ,$settings?->translate('ar')?->about_us)}}</textarea>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-12">
                                                <div class="form-group row">
                                                    <div class="col-sm-3 col-form-label">
                                                        <label >@lang('about_us_en')</label>
                                                    </div>
                                                    <div class="col-sm-9">
                                                        <textarea type="text" class="form-control ckeditor" name="en[about_us]"  >{{old('en.about_us'  ,$settings?->translate('en')?->about_us)}}</textarea>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-12">
                                                <div class="form-group row">
                                                    <div class="col-sm-3 col-form-label">
                                                        <label >@lang('our_message_ar')</label>
                                                    </div>
                                                    <div class="col-sm-9">
                                                        <textarea type="text" class="form-control" name="ar[our_message]"  >{{old('ar.our_message'  ,$settings?->translate('ar')?->our_message)}}</textarea>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-12">
                                                <div class="form-group row">
                                                    <div class="col-sm-3 col-form-label">
                                                        <label >@lang('our_message_en')</label>
                                                    </div>
                                                    <div class="col-sm-9">
                                                        <textarea type="text" class="form-control" name="en[our_message]"  >{{old('en.our_message'  ,$settings?->translate('en')?->our_message)}}</textarea>
                                                    </div>
                                                </div>
                                            </div>


                                            <div class="col-12">
                                                <div class="form-group row">
                                                    <div class="col-sm-3 col-form-label">
                                                        <label >@lang('our_vision_ar')</label>
                                                    </div>
                                                    <div class="col-sm-9">
                                                        <textarea type="text" class="form-control" name="ar[our_vision]"  >{{old('ar.our_vision'  ,$settings?->translate('ar')?->our_vision)}}</textarea>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-12">
                                                <div class="form-group row">
                                                    <div class="col-sm-3 col-form-label">
                                                        <label >@lang('our_vision_en')</label>
                                                    </div>
                                                    <div class="col-sm-9">
                                                        <textarea type="text" class="form-control" name="en[our_vision]"  >{{old('en.our_vision'  ,$settings?->translate('en')?->our_vision)}}</textarea>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-12">
                                                <div class="form-group row">
                                                    <div class="col-sm-3 col-form-label">
                                                        <label >@lang('terms_ar')</label>
                                                    </div>
                                                    <div class="col-sm-9">
                                                        <textarea type="text"  class="form-control" name="ar[terms]" >{{old('ar.terms'  ,$settings?->translate('ar')?->terms)}}</textarea>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-12">
                                                <div class="form-group row">
                                                    <div class="col-sm-3 col-form-label">
                                                        <label >@lang('terms_en')</label>
                                                    </div>
                                                    <div class="col-sm-9">
                                                        <textarea type="text"  class="form-control" name="en[terms]"  >{{old('en.terms'  ,$settings?->translate('en')?->terms)}}</textarea>
                                                    </div>
                                                </div>
                                            </div>



                                            <div class="col-12">
                                                <div class="form-group row">
                                                    <div class="col-sm-3 col-form-label">
                                                        <label >@lang('privacy_ar')</label>
                                                    </div>
                                                    <div class="col-sm-9">
                                                        <textarea type="text"  class="form-control ckeditor" name="ar[privacy]" >{{old('ar.privacy'  ,$settings?->translate('ar')?->privacy)}}</textarea>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-12">
                                                <div class="form-group row">
                                                    <div class="col-sm-3 col-form-label">
                                                        <label >@lang('privacy_en')</label>
                                                    </div>
                                                    <div class="col-sm-9">
                                                        <textarea type="text" class="form-control ckeditor" name="en[privacy]" >{{old('en.privacy'  ,$settings?->translate('en')?->privacy)}}</textarea>
                                                    </div>
                                                </div>
                                            </div>


                                            <div class="col-12">
                                                <div class="form-group row">
                                                    <div class="col-sm-3 col-form-label">
                                                        <label >@lang('agreement_ar')</label>
                                                    </div>
                                                    <div class="col-sm-9">
                                                        <textarea type="text"  class="form-control" name="ar[agreement]" >{{old('ar.agreement'  ,$settings?->translate('ar')?->agreement)}}</textarea>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-12">
                                                <div class="form-group row">
                                                    <div class="col-sm-3 col-form-label">
                                                        <label >@lang('agreement_en')</label>
                                                    </div>
                                                    <div class="col-sm-9">
                                                        <textarea type="text" class="form-control" name="en[agreement]" >{{old('en.agreement'  ,$settings?->translate('en')?->agreement)}}</textarea>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-12">
                                                <div class="form-group row">
                                                    <div class="col-sm-3 col-form-label">
                                                        <label >@lang('ad_conditions_ar')</label>
                                                    </div>
                                                    <div class="col-sm-9">
                                                        <textarea type="text"  class="form-control" name="ar[ad_conditions]" >{{old('ar.ad_conditions'  ,$settings?->translate('ar')?->ad_conditions)}}</textarea>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-12">
                                                <div class="form-group row">
                                                    <div class="col-sm-3 col-form-label">
                                                        <label >@lang('ad_conditions_en')</label>
                                                    </div>
                                                    <div class="col-sm-9">
                                                        <textarea type="text" class="form-control" name="en[ad_conditions]" >{{old('en.ad_conditions'  ,$settings?->translate('en')?->ad_conditions)}}</textarea>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-12">
                                                <div class="form-group row">
                                                    <div class="col-sm-3 col-form-label">
                                                        <label >@lang('app_commission_ar')</label>
                                                    </div>
                                                    <div class="col-sm-9">
                                                        <textarea type="text"  class="form-control" name="ar[app_commission]" >{{old('ar.app_commission'  ,$settings?->translate('ar')?->app_commission)}}</textarea>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-12">
                                                <div class="form-group row">
                                                    <div class="col-sm-3 col-form-label">
                                                        <label >@lang('app_commission_en')</label>
                                                    </div>
                                                    <div class="col-sm-9">
                                                        <textarea type="text" class="form-control" name="en[app_commission]" >{{old('en.app_commission'  ,$settings?->translate('en')?->app_commission)}}</textarea>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-12">
                                                <div class="form-group row">
                                                    <div class="col-sm-3 col-form-label">
                                                        <label >@lang('idea_policy_ar')</label>
                                                    </div>
                                                    <div class="col-sm-9">
                                                        <textarea type="text"  class="form-control" name="ar[idea_policy]" >{{old('ar.idea_policy'  ,$settings?->translate('ar')?->idea_policy)}}</textarea>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-12">
                                                <div class="form-group row">
                                                    <div class="col-sm-3 col-form-label">
                                                        <label >@lang('idea_policy_en')</label>
                                                    </div>
                                                    <div class="col-sm-9">
                                                        <textarea type="text" class="form-control" name="en[idea_policy]" >{{old('en.idea_policy'  ,$settings?->translate('en')?->idea_policy)}}</textarea>
                                                    </div>
                                                </div>
                                            </div>


                                            <div class="col-12">
                                                <div class="form-group row">
                                                    <div class="col-sm-3 col-form-label">
                                                        <label >@lang('website_description_ar')</label>
                                                    </div>
                                                    <div class="col-sm-9">
                                                        <textarea class="form-control" name="ar[description]" rows="3">{{old('ar.description'  ,$settings?->translate('ar')?->description)}}</textarea>
                                                    </div>
                                                </div>
                                            </div>


                                            <div class="col-12">
                                                <div class="form-group row">
                                                    <div class="col-sm-3 col-form-label">
                                                        <label >@lang('website_description_en')</label>
                                                    </div>
                                                    <div class="col-sm-9">
                                                        <textarea class="form-control" name="en[description]" rows="3">{{old('en.description'  ,$settings?->translate('en')?->description)}}</textarea>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-sm-9 offset-sm-3">
                                                <button type="submit" class="btn btn-primary mr-1">@lang('edit')</button>
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
@push('scripts')
    {{--<script>
            ClassicEditor.create( document.querySelector( '#editor' ))
            .then( editor => {
                    console.log( editor );
            } )
            .catch( error => {
                    console.error( error );
            });
    </script>--}}
@endpush
@endsection
