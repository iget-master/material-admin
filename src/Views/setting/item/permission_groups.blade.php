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
		<table>
			<tbody>
				@foreach ($permission_groups as $permission_group)
					<tr class="editable" data-id="{!! $permission_group->id !!}" data-edit="{!! route('setting.edit', ['permission_groups', $permission_group->id]) !!}" data-delete="{!! route('setting.delete', ['permission_groups', $permission_group->id]) !!}">
						<td>{!! $permission_group->name !!}</td>
						<td class="actions">
							<a href="#" class="delete"><i class="md md-delete"></i></a>
							<a href="#" class="edit"><i class="md md-edit"></i></a>
						</td>
					</tr>
				@endforeach
			</tbody>
		</table>
	</div>
</div>
