<?php
	use IgetMaster\MaterialAdmin\Models\PermissionGroup;
	$permission_groups = PermissionGroup::all();
?>

<div class="row setting-group">
	<div class="col-md-3 title">
		{!! trans('materialadmin::admin.permission_groups') !!}
	</div>
	<div class="col-md-9 content">
		<div class="panel panel-default">
			<!-- Default panel contents -->
			<div class="panel-heading">
				{!! trans_choice('materialadmin::admin.permission_groups_count', $permission_groups->count()) !!}
				<a href="#" class="create"><i class="zmdi zmdi-plus-circle-o zmdi-hc-lg"></i></a>
			</div>

			<!-- List group -->
			<ul class="list-group">
				@foreach ($permission_groups as $permission_group)
					<li class="list-group-item editable" data-id="{!! $permission_group->id !!}" data-edit="{!! route('setting.edit', ['permission_groups', $permission_group->id]) !!}" data-delete="{!! route('setting.delete', ['permission_groups', $permission_group->id]) !!}">
						{!! $permission_group->name !!}
						<a href="#" class="delete"><i class="zmdi zmdi-delete zmdi-hc-lg"></i></a>
					</li>
				@endforeach
			</ul>
		</div>
	</div>
</div>