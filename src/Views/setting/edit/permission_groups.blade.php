@extends('materialadmin::setting.edit')

<?php
	$roles = IgetMaster\MaterialAdmin\Models\Role::all();
?>

@section('form')
	@if (isset($model))
	{!! Form::model($model, ['method'=>'PATCH', 'route'=>['setting.update', 'permission_groups', $model->id], 'id'=>'model']) !!}
	@else
	{!! Form::open(array('route' => ['setting.store', 'permission_groups'], 'id' => 'model')) !!}
	@endif
		<div class="container">
			<div class="row">
				<div class="col-md-4">
					<div class="form-group">
						{!! Form::label('name', trans('materialadmin::admin.permission_group_name')) !!}
						{!! Form::text('name', null, array('class' => 'form-control')) !!}
						@if ($errors->has('name'))
							{!! $errors->first('name') !!}	
						@endif
					</div>
				</div>
			</div>
			<div class="row">
				<div class="col-md-8">
					{!! Form::label('name', trans('materialadmin::admin.permission_group_roles')) !!}
					@foreach($roles as $role)
						<div class="checkbox">
						    <label>
						    	<?php 
						    		$checked = false;
						    		if (isset($model)) {
						    			$checked = $model->roles->contains('id', $role->id)?'checked':null;
						    		}
						    	?>
								<input type="checkbox" name="roles[]" value="{!! $role->id !!}" {!! $checked !!} >
								{!! trans('materialadmin::roles.' . $role->name) !!}
						    </label>
						</div>
					@endforeach
				</div>
			</div>
		</div>
	{!! Form::close() !!}
@stop

