<div class="form-group col-sm-12">
    <label class="control-label">@lang('materialadmin::filter.equals')</label>
    {!! Form::checkbox($filter, 1, \Request::get($filter)) !!}
</div>