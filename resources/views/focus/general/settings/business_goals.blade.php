@extends ('core.layouts.app')
@section ('title', trans('business.billing_settings_preference'))
@section('content')

    <div class="content-wrapper">

        <div class="content-body "> {{ Form::open(['route' => 'biller.settings.business_goals_post', 'class' => 'form-horizontal', 'role' => 'form', 'method' => 'post','files' => true, 'id' => 'create-hrm']) }}

            <div class="row match-height">
                <div class="col-xl-12 col-lg-12">
                    <div class="card">
                        <div class="card-header border-bottom-blue-grey">
                            <h4 class="card-title">{{ trans('business.billing_settings_preference') }}</h4>
                        </div>
                        <div class="card-content">
                            <div class="card-body">
                               @foreach($goals as $goal)

@php
    $dateObj   = DateTime::createFromFormat('!m', $goal['month']);
    $monthName = $dateObj->format('F'); // March
@endphp
                                <div class='row mb-2'>
                                    {{ Form::label( 'auto_debit_transaction',$monthName,['class' => 'col-12 control-label font-weight-bold primary']) }}
                                    <div class='col-2 '>
                                        <small>Sales</small>
                                        <input class="form-control round " name="sales[{{$goal['month']}}]" type="number"
                                               value="{{$goal['sales']}}">
                                    </div> <div class='col-2'>
                                        <small>Products</small>
                                        <input class="form-control round" name="stock[{{$goal['month']}}]" type="number"
                                               value="{{$goal['stock']}}">
                                    </div> <div class='col-2'>
                                        <small>Customers</small>
                                        <input class="form-control round" name="customers[{{$goal['month']}}]" type="number"
                                               value="{{$goal['customers']}}">
                                    </div>
                                    <div class='col-2'>
                                        <small>Income</small>
                                        <input class="form-control round" name="income[{{$goal['month']}}]" type="number"
                                               value="{{$goal['income']}}">
                                    </div>
                                    <div class='col-2'>
                                        <small>Expense</small>
                                        <input class="form-control round" name="expense[{{$goal['month']}}]" type="number"
                                               value="{{$goal['income']}}">
                                    </div>

                                </div>
                                   <hr>

                                @endforeach

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

@endsection
