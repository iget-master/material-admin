<div class="filter-group">
	<legend>ID</legend>
	@include('materialadmin::filter.logical')
</div>
<div class="filter-group">
	<legend>@lang('materialadmin::user.name')</legend>
	@include('materialadmin::filter.text')
</div>
<div class="filter-group">
	<legend>@lang('materialadmin::user.email')</legend>
	@include('materialadmin::filter.text')
</div>
<div class="filter-group">
	<legend>@lang('materialadmin::user.dob')</legend>
	@include('materialadmin::filter.date')
</div>