<?php
	use IgetMaster\MaterialAdmin\Models\PermissionGroup;
?>

<div class="row">
	<div class="col-md-3">
		{!! trans('materialadmin::admin.permission_groups') !!}
	</div>
	<div class="col-md-9">
		{!! trans_choice('materialadmin::admin.permission_groups_count', PermissionGroup::count()) !!}
	</div>
</div>
