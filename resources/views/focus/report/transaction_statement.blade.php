{{ Form::open(['route' => array('biller.reports.generate_statement','transaction'), 'class' => 'form-horizontal', 'role' => 'form', 'method' => 'post','files' => false, 'id' => 'statement']) }}
<div class="form-group row">
    <label class="col-sm-3 col-form-label"
           for="pay_cat">{{trans('transactioncategories.transactioncategories')}}</label>
    <div class="col-sm-4">
        <select name="categories" class="form-control">
            echo "<option value='0'>{{trans('general.all')}}</option>";
            <?php
            foreach ($categories as $row) {
                $cid = $row['id'];
                $holder = $row['name'];
                echo "<option value='$cid'>$holder</option>";
            }
            ?>
        </select>


    </div>
</div>
<div class="form-group row">
    <label class="col-sm-3 col-form-label"
           for="pay_cat">{{trans('accounts.account')}}</label>
    <div class="col-sm-4">
        <select name="account" class="form-control">
            echo "<option value='0'>{{trans('general.all')}}</option>";
            <?php
            foreach ($accounts as $row) {
                $cid = $row['id'];
                $acn = $row['number'];
                $holder = $row['holder'];
                echo "<option value='$cid'>$acn - $holder</option>";
            }
            ?>
        </select>


    </div>
</div>

<div class="form-group row">

    <label class="col-sm-3 control-label"
           for="sdate">{{trans('meta.from_date')}}</label>

    <div class="col-sm-4">
        <input type="text" class="form-control from_date required"
               placeholder="Start Date" name="from_date"
               autocomplete="false" data-toggle="datepicker">
    </div>
</div>
<div class="form-group row">

    <label class="col-sm-3 control-label"
           for="edate">{{trans('meta.to_date')}}</label>

    <div class="col-sm-4">
        <input type="text" class="form-control required to_date"
               placeholder="End Date" name="to_date"
               data-toggle="datepicker" autocomplete="false">
    </div>
</div>
<div class="form-group row">
    <label class="col-sm-3 col-form-label"
           for="pay_cat">{{trans('meta.report_output_format')}}</label>

    <div class="col-sm-4">
        <select name="output_format" class="form-control">
            <option value='pdf_print'>{{trans('general.pdf_print')}}</option>
            <option value='pdf'>{{trans('general.pdf')}}</option>
            <option value='csv'>CSV</option>
        </select>


    </div>
</div>
<div class="form-group row">
    <label class="col-sm-3 col-form-label" for="pay_cat"></label>

    <div class="col-sm-4">
        <input type="submit" class="btn btn-primary btn-md" value="View">


    </div>
</div>

{{ Form::close() }}
