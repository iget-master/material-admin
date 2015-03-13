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
		<a href="#" class="create">{!! trans('materialadmin::admin.create') !!}<i class="md md-add md-lg"></i></a>
		<ul>
		@foreach ($permission_groups as $permission_group)
			<li class="editable" data-id="{!! $permission_group->id !!}" data-edit="{!! route('setting.edit', ['permission_groups', $permission_group->id]) !!}" data-delete="{!! route('setting.delete', ['permission_groups', $permission_group->id]) !!}">
				<span class="name">
					{!! $permission_group->name !!}
				</span>
				<a href="#" class="delete"><i class="md md-delete"></i></a>
				<a href="#" class="edit"><i class="md md-edit"></i></a>
			</li>
		@endforeach
		</ul>
	</div>
</div>
