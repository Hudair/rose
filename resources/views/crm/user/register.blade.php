@extends('core.layouts.public_app',['page'=>' class="horizontal-layout horizontal-menu 2-columns bg-full-screen-image" data-open="click" data-menu="horizontal-menu" data-col="2-columns"'])

@section ('title', trans('labels.backend.customers.management'))


@section('content')
    <div class="content-wrapper">
        <div class="content-header row">
        </div>
        <div class="content-body">
            <section class="flexbox-container">
                <div class="col-12 d-flex align-items-center justify-content-center">
                    <div class="col-lg-10 col-md-8 col-10 box-shadow-2 p-0">
                        <div class="card border-grey border-lighten-3 m-0">
                            <div class="">
                                <div class="card-title text-center">
                                    <div><img class="avatar-100"
                                                          src="{{ Storage::disk('public')->url('app/public/img/company/' . business()['logo']) }}"
                                                          alt="Logo"></div>
                                </div>
                                <h6 class="card-subtitle line-on-side text-muted text-center font-small-3 pt-2">
                                    <span>{{trans('customers.register')}}</span></h6>
                            </div>
                            <div class="card-content">
                                <div class="card-body">
                                    {{ Form::open(array('url' => route('crm.register'),'method' => 'post','files'=>true)) }}

                                    <div class="row">

                                                <div class='form-group col-md-6'>
                                                    {{ Form::label( 'name', trans('customers.name'),['class' => 'col-12 control-label']) }}
                                                    <div class='col-12'>
                                                        {{ Form::text('name', null, ['class' => 'form-control box-size', 'placeholder' => trans('customers.name').'*','required'=>'required']) }} @if ($errors->has('name')) <div class="display-inline danger">{{ $errors->first('name') }} </div> @endif
                                                    </div>
                                                </div>
                                                <div class='form-group  col-md-6'>
                                                    {{ Form::label( 'phone', trans('customers.phone'),['class' => 'col-12 control-label']) }}
                                                    <div class='col-12'>
                                                        {{ Form::text('phone',null, ['class' => 'form-control box-size', 'placeholder' => trans('customers.phone').'*','required'=>'required']) }} @if ($errors->has('phone')) <div class="display-inline danger">{{ $errors->first('phone') }} </div> @endif
                                                    </div>
                                                </div>
                                    </div> <div class="row">
                                                <div class='form-group col-md-6'>
                                                    {{ Form::label( 'email', trans('customers.email'),['class' => 'col-12 control-label']) }}
                                                    <div class='col-12'>
                                                        {{ Form::email('email', null, ['class' => 'form-control box-size', 'placeholder' => trans('customers.email').'*','required'=>'required']) }} @if ($errors->has('email')) <div class="display-inline danger">{{ $errors->first('email') }} </div> @endif
                                                    </div>
                                                </div>
                                                <div class='form-group col-md-6'>
                                                    {{ Form::label( 'company', trans('customers.company'),['class' => 'col-12 control-label']) }}
                                                    <div class='col-12'>
                                                        {{ Form::text('company', null, ['class' => 'form-control box-size', 'placeholder' => trans('customers.company')]) }} @if ($errors->has('company')) <div class="display-inline danger">{{ $errors->first('company') }} </div> @endif
                                                    </div>
                                                </div>  </div>
                                    <div class="row">
                                                <div class='form-group col-md-6'>
                                                    {{ Form::label( 'address', trans('customers.address'),['class' => 'col-12 control-label']) }}
                                                    <div class='col-12'>
                                                        {{ Form::text('address', null, ['class' => 'form-control box-size', 'placeholder' => trans('customers.address').'*','required'=>'required']) }} @if ($errors->has('address')) <div class="display-inline danger">{{ $errors->first('address') }} </div> @endif
                                                    </div>
                                                </div>

                                                <div class='form-group col-md-3'>
                                                    {{ Form::label( 'city', trans('customers.city'),['class' => 'col-12 control-label']) }}
                                                    <div class='col-lg-12'>
                                                        {{ Form::text('city',null, ['class' => 'form-control box-size', 'placeholder' => trans('customers.city').'*','required'=>'required']) }} @if ($errors->has('city')) <div class="display-inline danger">{{ $errors->first('city') }} </div> @endif
                                                    </div>
                                                </div>
                                                <div class='form-group col-md-3'>
                                                    {{ Form::label( 'region', trans('customers.region'),['class' => 'col-12 control-label']) }}
                                                    <div class='col-12'>
                                                        {{ Form::text('region', null, ['class' => 'form-control box-size', 'placeholder' => trans('customers.region').'*','required'=>'required']) }}@if ($errors->has('region')) <div class="display-inline danger">{{ $errors->first('region') }} </div> @endif
                                                    </div>
                                                </div>
                                    </div> <div class="row">
                                                <div class='form-group col-md-4'>
                                                    {{ Form::label( 'country', trans('customers.country'),['class' => 'col-12 control-label']) }}
                                                    <div class='col-12'>
                                                        {{ Form::text('country',null, ['class' => 'form-control box-size', 'placeholder' => trans('customers.country').'*','required'=>'required']) }}@if ($errors->has('country')) <div class="display-inline danger">{{ $errors->first('country') }} </div> @endif
                                                    </div>
                                                </div>
                                                <div class='form-group col-md-4'>
                                                    {{ Form::label( 'postbox', trans('customers.postbox'),['class' => 'col-12 control-label']) }}
                                                    <div class='col-12'>
                                                        {{ Form::text('postbox', null, ['class' => 'form-control box-size', 'placeholder' => trans('customers.postbox')]) }}
                                                    </div>
                                                </div>


                                                <div class='form-group  col-md-4'>
                                                    {{ Form::label( 'taxid', trans('customers.taxid'),['class' => 'col-12 control-label']) }}
                                                    <div class='col-12'>
                                                        {{ Form::text('taxid', null, ['class' => 'form-control box-size', 'placeholder' => trans('customers.taxid')]) }}
                                                    </div>
                                                </div>

                                    </div>
                                    <hr>
                                    <div class="row">

                                        <div class='form-group col-md-6'>
                                            {{ Form::label( 'password', trans('customers.password'),['class' => 'col-12 control-label']) }}
                                            <div class='col-12'>
                                                {{ Form::password('password', ['class' => 'form-control box-size', 'placeholder' => trans('customers.password'),'required'=>'']) }}@if ($errors->has('password')) <div class="display-inline danger">{{ $errors->first('password') }} </div> @endif
                                            </div>
                                        </div>


                                        <div class='form-group  col-md-6'>
                                            {{ Form::label('password_confirmation', trans('customers.confirm_password'),['class' => 'col-12 control-label']) }}
                                            <div class='col-12'>
                                                {{ Form::password('password_confirmation', ['class' => 'form-control box-size', 'placeholder' => trans('customers.confirm_password'),'required'=>'']) }}
                                            </div>
                                        </div>

                                    </div>
                                    <div class="row">
@if(config('standard.type'))
                                        <div class='form-group col-md-6'>
                                            {{ Form::label( 'reg_id', trans('customers.reg_id'),['class' => 'col-12 control-label']) }}<small class="ml-1">Ask your business provider to get the registration id, it is 10 digit alphanumeric ID starts with CR</small>
                                            <div class='col-12'>
                                                {{ Form::text('reg_id',null, ['class' => 'form-control box-size', 'placeholder' => trans('customers.reg_id').' CR']) }}
                                            </div>
                                        </div>

@endif
                                        <div class='form-group  col-md-6'>
                                            <label for="confirm_passwordd" class="col-12 control-label">&nbsp;</label>
                                            <div class='col-12 mt-1'>
                                                {{ Form::submit(trans('customers.register'), ['class' => 'btn btn-primary btn-md']) }}
                                            </div>
                                        </div>

                                    </div>

                                    <div class="edit-form-btn">

                                            <div class="clearfix"></div>
                                        </div><!--edit-form-btn-->

                                    {{ Form::close() }}
                                </div>


                            </div>
                        </div>
                    </div>
                </div></section></div></div>
@endsection
