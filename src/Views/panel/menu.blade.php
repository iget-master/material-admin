<ul id="menu">
	@foreach (Config::get('admin.menu.options') as $label=>$attributes)
		@if (IgetMaster\MaterialAdmin\Helper::checkRoutePermission($attributes['route']))
			<li><a href="{!! route($attributes['route']); !!}"><i class="{!! $attributes['icon'] !!}"></i><span>{!! trans('materialadmin::menu.' . $label) !!}</span></a></li>
		@endif
	@endforeach
</ul>