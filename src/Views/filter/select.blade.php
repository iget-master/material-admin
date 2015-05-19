<div class="form-group col-sm-12">
    <label class="control-label">@lang('materialadmin::filter.equals')</label>
    {!! Form::select($filter, $options, \Request::get($filter), array('class' => 'form-control')) !!}
</div>