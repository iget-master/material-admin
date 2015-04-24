{!! Form::open(array('method'=>'get', 'route' => array('user.index'))) !!}
<div class="filter-group">
    <legend>ID</legend>
    @include('materialadmin::filter.logical', ['filter'=>'id'])
</div>
<div class="filter-group">
    <legend>@lang('materialadmin::user.permission_group')</legend>
    @include('materialadmin::filter.foreign', ['filter'=>'permission_group_id', 'options'=>IgetMaster\MaterialAdmin\Models\PermissionGroup::getSelectOptions()])
</div>
<div class="filter-group">
    <legend>@lang('materialadmin::user.name')</legend>
    @include('materialadmin::filter.text', ['filter'=>'name'])
</div>
<div class="filter-group">
    <legend>@lang('materialadmin::user.email')</legend>
    @include('materialadmin::filter.text', ['filter'=>'email'])
</div>
<div class="filter-group">
    <legend>@lang('materialadmin::user.dob')</legend>
    @include('materialadmin::filter.date', ['filter'=>'dob'])
</div>

<div class="filter-group text-center">
    <button class="btn btn-raised ">@lang('materialadmin::filter.filter')</button>
</div>

{!! Form::close() !!}