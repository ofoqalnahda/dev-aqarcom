@extends('dashboard.layouts.app')

@section('content')
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
                                    <form class="form form-horizontal" action="{{ route('dashboard.roles.store') }}"
                                        method="POST">
                                        @csrf


                                        <div class="row">
                                            <div class="col-12">
                                                <div class="form-group row">
                                                    <div class="col-sm-3 col-form-label">
                                                        <label for="name">@lang('name')</label>
                                                    </div>
                                                    <div class="col-sm-9">
                                                        <input type="text" id="name" class="form-control"
                                                            name="name" value="{{ old('name') }}" />
                                                    </div>
                                                </div>

                                            </div>
                                            <div class="col-md-12 col-12">
                                                <table class="table table-bordered">
                                                    <thead class="thead-light">
                                                        <th>
                                                            <input type="checkbox" id="check-all">
                                                            <label for="check-all">أختر الكل</label>
                                                        </th>
                                                        @foreach (actions() as $action)
                                                            <th>
                                                                @lang($action)
                                                            </th>
                                                        @endforeach
                                                    </thead>
                                                    <tbody>
                                                        @foreach (categorizePermissions() as $key => $permission)
                                                            <tr>
                                                                <td>
                                                                    <label for="{{ $key }}"><small>@lang($key)</small></label>
                                                                </td>
                                                                @foreach (actions() as $action)
                                                                    @if ($action == 'extra' && isset($permission[$action]))
                                                                        <td>
                                                                            @foreach ($permission[$action] as $extra)
                                                                                <input type="checkbox"  name="permission[]" class="row-checkbox"
                                                                                    id="{{ $extra->id }}" value="{{ $extra->id }}"
                                                                                    @if (in_array($extra->id, old('permission') ?: [])) checked @endif>
                                                                                <label for="{{ $extra->id }}"><small>@lang($extra->name)</small></label>
                                                                                <br>
                                                                            @endforeach
                                                                        </td>
                                                                    @else
                                                                        @if (isset($permission[$action]))
                                                                            <td>
                                                                                <input type="checkbox"  name="permission[]" class="row-checkbox"
                                                                                    id="{{ $permission[$action]->id }}" value="{{ $permission[$action]->id }}"
                                                                                    @if (in_array($permission[$action]->id, old('permission') ?: [])) checked @endif>
                                                                            </td>
                                                                        @else
                                                                            <td>-</td>
                                                                        @endif
                                                                    @endif
                                                                @endforeach
                                                            </tr>
                                                        @endforeach
                                                    </tbody>
                                                </table>







                                            </div>

                                            <div class="col-sm-9 offset-sm-3 mt-3">
                                                <button type="submit"
                                                    class="btn btn-primary mr-1">@lang('add')</button>
                                                <button type="reset"
                                                    class="btn btn-outline-secondary">@lang('reset')</button>
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
@endsection
@push('scripts')
<script>
    $(document).ready(function () {
        // Handle the "Check All" checkbox in the header
        $("#check-all").change(function () {
            $(".row-checkbox").prop('checked', $(this).prop("checked"));
        });


    });
</script>

@endpush
