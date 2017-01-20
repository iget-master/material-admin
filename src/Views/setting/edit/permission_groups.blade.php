@extends('materialadmin::setting.edit', ['size'=>'lg'])

<?php
    use IgetMaster\MaterialAdmin\Models\Role;

    $routeGroups = [];

    foreach (Role::get() as $route)
    {
        $routeName = $route->name;
        $group = explode('.', $routeName)[0];

        $routeGroups[$group][] = $route;
    }

    uasort($routeGroups, function($a, $b) {
        $countA = count($a);
        $countB = count($b);

        return $countB - $countA;
    })
?>

@section('form')
	@if (isset($model))
	{!! Form::model($model, ['method'=>'PATCH', 'route'=>['setting.update', 'permission_groups', $model->id], 'id'=>'model']) !!}
	@else
	{!! Form::open(['route' => ['setting.store', 'permission_groups'], 'id' => 'model']) !!}
	@endif
        <div class="row">
            <div class="col-md-4">
                <div class="form-group">
                    {!! Form::label('name', trans('materialadmin::admin.permission_group_name'), ['class' => 'required']) !!}
                    {!! Form::text('name', null, ['class' => 'form-control']) !!}
                    @if ($errors->has('name'))
                        {!! $errors->first('name') !!}
                    @endif
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <legend>{!! Form::label('name', trans('materialadmin::admin.permission_group_roles')) !!}</legend>
                <div class="row">
                    <?php
                    $count = 0;
                    $colSize = 2;
                    ?>
                    @foreach($routeGroups as $group => $routes)
                        <div class="col-md-{!! $colSize !!} roles-list">
                            <h3>@lang("materialadmin::roles.role_group_${group}_title")</h3>
                            @foreach($routes as $route)
                                <div class="checkbox">
                                    <label for="">
                                        {!! \Form::checkbox('roles[]', $route->id, $checked = isset($model) && $model->roles->contains('name', $route->name)) !!}
                                        {!! trans('materialadmin::roles.' . $route->name) !!}
                                    </label>
                                </div>
                            @endforeach
                        </div>
                        @if (++$count % (12 / $colSize) == 0)
                            </div>
                            <div class="row">
                        @endif
                    @endforeach
                </div>
            </div>
        </div>
	{!! Form::close() !!}
@stop

