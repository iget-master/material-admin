@extends((Request::ajax())?"materialadmin::layout.ajax":"materialadmin::layout.panel")

<?php
	$groups = \Config::get('admin.settings_groups');

	$order = array();
	foreach ($groups as $key => $row)
	{
	    $order[$key] = $row['order'];
	}
	array_multisort($order, SORT_DESC, $groups);

	$items = \Config::get('admin.settings_items');

	$order = array();
	foreach ($items as $key => $row)
	{
	    $order[$key] = $row['order'];
	}
	array_multisort($order, SORT_DESC, $items);
?>

@section('title')
    @lang('materialadmin::settings.model_title')
@stop

@section('content')
    <div id="card-wrapper">
        <div class="container">
            <div class="row">
                <div class="col-md-offset-2 col-md-8 card">
                    <div class="header">
                        <div class="info">
                            <h1>@lang('materialadmin::settings.model_title')</h1>
                        </div>
                        <div class="action">

                        </div>
                    </div>
                    <div role="tabpanel">
                        <!-- Nav tabs -->
                        <ul class="nav nav-tabs header-tab" role="tablist">
                            @foreach($groups as $index=>$group)
                                <li @if($index == 0) class="active" @endif>
                                    <a href="#group-{!! $index !!}" data-toggle="tab">
                                        @lang($group['translation']['name'])
                                    </a>
                                </li>
                            @endforeach
                        </ul>

                        @include('materialadmin::panel.alerts')

                        <div id="settings-groups" class="tab-content">
                            @foreach($groups as $index=>$group)
                                <div class="tab-pane body @if($index == 0) active @endif" id="group-{!! $index !!}">
                                    @foreach($items as $item_name => $item)
                                        @if ($item['group'] == $group['name'])
                                            <div class="settings-item" data-setting-name="{!! $item_name !!}" data-create="{!! route('setting.create', [$item_name]) !!}" data-show="{!! route('setting.show', [$item_name]) !!}">
                                                @include($item['item'])
                                            </div>
                                        @endif
                                    @endforeach
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop

@section('script')
	{!! HTML::script('iget-master/material-admin/js/app/setting.js') !!}
@stop
