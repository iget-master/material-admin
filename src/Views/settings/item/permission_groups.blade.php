<?php
	use IgetMaster\MaterialAdmin\Models\PermissionGroup;
	$permission_groups = PermissionGroup::all();
?>

<div class="row">
	<div class="col-md-3 title">
		{!! trans('materialadmin::admin.permission_groups') !!}
	</div>
	<div class="col-md-9 content">
		{!! trans_choice('materialadmin::admin.permission_groups_count', $permission_groups->count()) !!}
		<ul>
		@foreach ($permission_groups as $permission_group)
			<li data-id="{!! $permission_group->id !!}">
				<span class="name">
					{!! $permission_group->name !!}
				</span>
				<a class="remove"><i class="md md-delete"></i></a>
				<a class="modify"><i class="md md-edit"></i></a>
			</li>
		@endforeach
		</ul>
	</div>
</div>
