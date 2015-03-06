<ul id="menu">
    @foreach (Config::get('admin::menu_options') as $label=>$attributes)
		@if (IgetMaster\Admin\Helper::checkRoutePermission($attributes['route']))
			<li><a href="{{ route($attributes['route']); }}"><i class="{{ $attributes['icon'] }}"></i><span>{{ $label }}</span></a></li>
		@endif
	@endforeach
</ul>