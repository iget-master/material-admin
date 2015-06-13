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
            <div class="col-md-12">
                <legend>
                    {!! Form::label('name', trans('materialadmin::admin.permission_group_roles')) !!}
                </legend>
            </div>
            <?php
                $currentRoleTitle = "";
                $count = 0;
            ?>
            @foreach($roles as $title)
                <?php
                    if($count == 0){
                        echo "<div class='col-md-12'>";
                    }
                    $roleTitle = explode(".", $title->name);
                    if($roleTitle[0] != $currentRoleTitle){
                        $currentRoleTitle = $roleTitle[0];
                        echo "<div class='col-md-4'>
                        <label>".trans('materialadmin::roles.permission_group_'.$currentRoleTitle.'_title')."</label>";
                        $pass = true;
                        $count++;
                    } else{
                        $pass = false;
                    }
                ?>
                @if($pass)
                    @foreach($roles as $role)
                        <?php
                            $currentRole = explode(".",$role->name);
                        ?>
                        @if($currentRole[0] == $currentRoleTitle)
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
                        @endif
                    @endforeach
                    </div>
                @endif

                    @if(($count%3 == 0) && ($pass == true))
                        </div>
                        <div class='col-md-12'>
                    @endif
            @endforeach
        </div>
	{!! Form::close() !!}
@stop

