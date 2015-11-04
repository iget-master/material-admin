<?php
    $operators = [
        '=' => trans('materialadmin::filter.equals'),
        '!=' => trans('materialadmin::filter.not_equal'),
        '>' => trans('materialadmin::filter.greater'),
        '>=' => trans('materialadmin::filter.greater_than'),
        '<' => trans('materialadmin::filter.less'),
        '<=' => trans('materialadmin::filter.less_than'),
    ];
?>
<div class="form-group col-sm-6">
	<label class="control-label">@lang('materialadmin::filter.condition')</label>
    {!! Form::select($filter . '_operator', $operators, \Request::get($filter . "_operator"), array('class' => 'form-control')) !!}
</div>
<div class="form-group col-sm-6">
	<label class="control-label">@lang('materialadmin::filter.value')</label>
    {!! Form::input('number', $filter, \Request::get($filter), array('class' => 'form-control')) !!}
</div>