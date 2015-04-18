<div class="form-group col-sm-12">
	<label class="control-label">@lang('materialadmin::filter.search_for')</label>
    {!! Form::text($filter, \Request::get($filter), array('class' => 'form-control')) !!}
</div>