@extends((Request::ajax())?"materialadmin::layout.ajax":"materialadmin::layout.panel")

@section('title')
	@lang('materialadmin::user.title')
@stop

@section('actions')
	<button id="filter-toogler" class="btn btn-flat">
        <i class="md md-filter-list"></i>
    </button>
	<div class="dropdown">
		<button class="btn btn-flat dropdown-toggle" data-toggle="dropdown">
			<i class="md md-more-vert"></i>
		</button>
		<ul class="dropdown-menu dropdown-menu-right" role="menu" aria-labelledby="dropdownMenu1">
			<li>
				<a href="#" role="menuitem">@lang('materialadmin::user.destroy_title')</a>
			</li>
		</ul>
	</div>

@stop

@section('content')
	<div id="collection-wrapper" class="container-fluid">
		<div class="row">
			<div class="col-md-2 filters open">
			<h3 class="title">
				@lang('materialadmin::filter.filter_by')
			</h3>
				@include('materialadmin::user.filters')
			</div>
			<div class="col-md-10 items">
				@include('materialadmin::panel.alerts')
				<table id="users_table" class="index-table table table-condensed" >
					<thead>
						<th><input type="checkbox"></th>
						<th>ID</th>
						<th>@lang('materialadmin::user.name')</th>
						<th>@lang('materialadmin::user.dob')</th>
						<th>@lang('materialadmin::user.permission_group')</th>
						<th>@lang('materialadmin::user.default_language')</th>
						<th>@lang('materialadmin::user.email')</th>
						<th></th>
					</thead>
					<tbody>
					@foreach ($users as $user)
						<tr data-id="{!! $user->id !!}" data-delete-url="{!! route('user.destroy', [$user->id], false) !!}">
							<td class="row-check">
								<input type="checkbox">
								{!! link_to_route('user.edit', '', [$user->id], ['role'=>'edit']) !!}
							</td>
							<td>{!! $user->id !!}</td>
							<td>{!! $user->name !!} {!! $user->surname !!}</td>
							<td>{!! getFormatedDate($user->dob) !!}</td>
							<td>{!! $user->permission_group->name !!}</td>
							<td>//Esperando função ser criada//</td>
							<td>{!! $user->email !!}</td>
							<td class="actions">
								<div class="dropdown">
									<a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="md md-more-vert"></i></a>
									<ul class="dropdown-menu dropdown-menu-right" role="menu" aria-labelledby="dropdownMenu1">
										<li>
											{!! Form::open(array('method'=>'DELETE', 'route' => array('user.destroy', $user->id))) !!}
												<button type="submit" class="btn btn-dropdown-item">@lang('materialadmin::user.destroy_title')</button>
											{!! Form::close() !!}
										</li>
									</ul>
								</div>
							</td>
						</tr>
					@endforeach
					</tbody>
				</table>
			</div>	
		</div>
	</div>
@stop

@section('floating')
   <ul class="btn-action-group">
<!--         <li>
            <span class="label">Convidar Usuários</span>
            <button class="btn btn-floating secondary"><i class="md md-email"></i></button>
        </li>
        <li>
            <span class="label">Adicionar Múltiplos Usuários</span>
            <button class="btn btn-floating secondary"><i class="md md-group-add"></i></button>
        </li> -->
        <li class="primary">
            <span class="label">@lang('materialadmin::user.tooltip_create')</span>
            <a class="btn btn-floating" href="/user/create"><i class="md md-add default"></i><i class="md md-person-add hover"></i></a>
        </li>
    </ul>
@stop

@section('script')
	{!! HTML::script('iget-master/material-admin/js/app/users.js') !!}
@stop