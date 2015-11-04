<div class="form-group col-sm-6">
	<label class="control-label">@lang('materialadmin::filter.from')</label>
    {!! Form::input('date', $filter . "_from", \Request::get($filter . "_from"), array('class' => 'form-control')) !!}
</div>
<div class="form-group col-sm-6">
	<label class="control-label">@lang('materialadmin::filter.up_to')</label>
    {!! Form::input('date', $filter . "_to", \Request::get($filter . "_to"), array('class' => 'form-control')) !!}
</div>