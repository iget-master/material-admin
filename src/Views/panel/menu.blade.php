<div class="drawer">
	<div class="header">
		<div class="user-info">
			<img src="http://placehold.it/60x60" alt="{!! Auth::user()->name!!}">
		</div>
		<div class="user-info">
			<span>{!! Auth::user()->name!!}</span>
			<span>{!! Auth::user()->email !!}</span>
		</div>
	</div>
	<div class="menu">
		<ul>
			@foreach (Config::get('admin.menu.options') as $label=>$attributes)
				@if (IgetMaster\MaterialAdmin\Helper::checkRoutePermission($attributes['route']))
					<li><a href="{!! route($attributes['route']); !!}"><i class="{!! $attributes['icon'] !!}"></i><span>{!! trans('materialadmin::menu.' . $label) !!}</span></a></li>
				@endif
			@endforeach
		</ul>			
	</div>
</div>