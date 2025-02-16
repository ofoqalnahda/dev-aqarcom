@extends('dashboard.layouts.app')
<link href="{{ asset('website/css/chat.css') }}" rel="stylesheet">
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
                            <div class="padding-top-2x mt-2 hidden-lg-up"></div>
                            <div class="table-responsive margin-bottom-2x">
                                <table class="table margin-bottom-none">
                                    <thead>
                                    <tr>
                                        <th class="w-50">{{__("title")}}</th>
                                        <th class="w-25">{{__("date_submitted")}}</th>
                                        <th class="w-25">{{__("last_updated")}}</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <tr>
                                        <td>{{$chat->title}}</td>
                                        <td>{{$chat->date}}</td>
                                        <td>{{$chat->lastMessage->date}}</td>
{{--                                        <td><span class="text-warning">High</span></td>--}}
{{--                                        <td><span class="text-primary">Open</span></td>--}}
                                    </tr>
                                    </tbody>
                                </table>
                            </div>
                            <!-- Messages-->
{{--                            @dd($chat->messages)--}}
                            @foreach($chat->messages->reverse() as $message)
                                <div class="comment">
                                    <div class="comment-author-ava"><img src="{{$message->sender->image??asset("/dashboard_files/app-assets/images/portrait/small/avatar-s-11.jpg")}}" alt="Avatar"></div>
                                    <div
                                         @class([
                        "comment-body"=>true,
                        "customer-comment"=>$message->sender_id != $chat->user_id,
])
{{--                                         style="{{$message->sender_id == $chat->user_id?"background-color:#22b765;":""}}"--}}
                                    >
                                        <p class="comment-text">{{$message->message}}</p>
                                        <div class="comment-footer"><span class="comment-meta">{{$message->sender->name}}</span></div>
                                    </div>
                                </div>
                            @endforeach
                            <!-- Reply Form-->
                            <h5 class="mb-30 padding-top-1x">{{__("reply")}}</h5>
                            <form method="post" action="{{route("dashboard.offers.update",$chat->id)}}">
                                @csrf
                                <div class="form-group">
                                    <textarea name="message" class="form-control form-control-rounded" id="review_text" rows="8" placeholder="Write your message here..." required=""></textarea>
                                </div>
                                <div class="text-right">
                                    <button class="btn btn-outline-primary px-5" type="submit">{{__("send")}}</button>
                                </div>
                            </form>
                        </div>
                    </div>
                    <div class="padding-bottom-2x mb-3 hidden-lg-up"></div>


                </section>
                <!-- Basic Horizontal form layout section end -->

            </div>
        </div>
    </div>
    <!-- END: Content-->
@endsection
