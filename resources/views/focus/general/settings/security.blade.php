@extends ('core.layouts.app')
@section ('title', trans('en.security'))
@section('content')
    <div class="">
        <div class="content-wrapper">

            <div class="content-body "> {{ Form::open(['route' => 'biller.settings.security_settings_post', 'class' => 'form-horizontal', 'role' => 'form', 'method' => 'post','files' => true, 'id' => 'create-hrm']) }}

                <div class="row match-height">
                    <div class="col-xl-12 col-lg-12">
                        <div class="card">
                            <div class="card-header border-bottom-blue-grey">
                                <h4 class="card-title">{{trans('en.security')}}</h4>
                            </div>
                            <div class="card-content">
                                <div class="card-body">
                                    <div class='row mb-1'>
                                        {{ Form::label( 'enable', trans('en.enable_recaptcha').' V-2 ',['class' => 'col-12 control-label']) }}
                                        <div class='col-6'>
                                            <select class="form-control round" name="enable">
                                                  @if(config('master.captcha')))<option value="1" selected>--{{trans('general.yes')}}--</option>@endif
                                                      <option value="" >{{trans('general.no')}}</option>
                                                <option value="Yes">{{trans('general.yes')}}</option>

                                            </select>
                                        </div>
                                    </div>

                                     <div class="row form-group">
                                                {{ Form::label('recaptcha_site', trans('en.recaptcha_site'), ['class' => 'col-lg-12 control-label required']) }}

                                                <div class="col-lg-10">
                                                    {{ Form::text('recaptcha_site', config('no-captcha.sitekey'), ['class' => 'form-control box-size', 'placeholder' =>'V2 Key Only', 'required' => 'required']) }}
                                                </div><!--col-lg-10-->
                                            </div><!--form control-->                                     <div class="row form-group">
                                        {{ Form::label('recaptcha_secret', trans('en.recaptcha_secret'), ['class' => 'col-lg-12 control-label required']) }}

                                        <div class="col-lg-10">
                                            {{ Form::text('recaptcha_secret', config('no-captcha.secret'), ['class' => 'form-control box-size', 'placeholder' =>'V2 Key Only', 'required' => 'required']) }}
                                        </div><!--col-lg-10-->
                                    </div><!--form control-->
<hr>
                                    <div class="card-header border-bottom-blue-grey">
                                        <h4 class="card-title">{{trans('en.app_settings')}}</h4>
                                    </div>
                                    <div class='row mb-1'>
                                        {{ Form::label( 'fixed_url', trans('en.fixed_url'),['class' => 'col-12 control-label mt-2']) }}
                                        <div class='col-6'>
                                            <select class="form-control round" name="fixed_url">
                                                @if(config('master.fixed_url')))<option value="Yes" selected>--{{trans('general.yes')}}--</option>@endif
                                                <option value="">{{trans('general.no')}}</option>
                                                <option value="Yes">{{trans('general.yes')}}</option>

                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class=''>
                                {{ Form::submit(trans('buttons.general.crud.update'), ['class' => 'm-1 btn btn-info btn-md']) }}
                            </div>
                        </div>


                        <!--edit-form-btn-->

                    </div>
                </div>
                {{ Form::close() }}
            </div>
        </div>
    </div>
@endsection
