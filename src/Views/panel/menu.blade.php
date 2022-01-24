<div class="drawer">
	<div class="header">
		<div class="user-info">
            <img class="img-circle" src="https://placehold.it/60x60" alt="{!! Auth::user()->name !!}">
        </div>
        <div class="user-info details">
			<span class="name">{!! Auth::user()->name !!}</span>
			<span class="email">{!! Auth::user()->email !!}</span>
		</div>
	</div>
	<div class="menu">
        @foreach (Config::get('admin.menu') as $group_label=>$items)
            <h4>
                @lang('materialadmin::menu.' . $group_label)
            </h4>
            <ul>
            @foreach ($items as $label=>$attributes)
                @if ((!array_key_exists('route', $attributes)) || IgetMaster\MaterialAdmin\Helper::checkRoutePermission($attributes['route']))
                    <li>
                        <?php
                            if (array_key_exists('route', $attributes)) {
                                $url = route($attributes['route'], array_key_exists('parameters', $attributes) ? $attributes['parameters'] : null);
                            } else if (array_key_exists('url', $attributes)) {
                                $url = $attributes['url'];
                            } else {
                                $url = "#";
                            }
                        ?>
                        <a href="{!! $url !!}" target="{{ $attributes['target'] ?? '_self'}}">
                            <i class="{!! $attributes['icon'] !!}"></i>
                            <span>
                                @lang('materialadmin::menu.' . $label)
                            </span>
                        </a>
                    </li>
                @endif
            @endforeach
            </ul>
        @endforeach
	</div>
</div>