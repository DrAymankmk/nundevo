<?php $page = 'modules-management'; ?>

@extends('layout_new.mainlayout')

@section('content')
<div class="page-wrapper">
	<div class="content">
		<div
			class="d-flex align-items-sm-center flex-sm-row flex-column gap-2 pb-3 mb-3 border-1 border-bottom">
			<div class="flex-grow-1">
				<a href="{{ route('modules-management.index') }}"
					class="text-muted small d-inline-block mb-1">
					← @lang('main.modules_management')
				</a>
				<h4 class="fw-bold mb-0">{{ $moduleLabel }}</h4>
				<p class="text-muted mb-0 mt-1">
					@lang('main.manage_module_links_hint')
					(<code>{{ $moduleKey }}</code>)
				</p>
			</div>
			<div>
				<button type="button" class="btn btn-primary" data-bs-toggle="modal"
					data-bs-target="#addMenuItemModal">
					@lang('main.module_add_menu_item')
				</button>
			</div>
		</div>

		@if(session('success'))
		<div class="alert alert-success">{{ session('success') }}</div>
		@endif

		@if($errors->any())
		<div class="alert alert-danger">
			<ul class="mb-0">
				@foreach($errors->all() as $error)
				<li>{{ $error }}</li>
				@endforeach
			</ul>
		</div>
		@endif

		<!-- <div class="card mb-3">
			<div class="card-body">
				<h6 class="mb-2">@lang('main.module_route_patterns')</h6>
				<p class="small text-muted mb-2">@lang('main.module_route_patterns_hint')</p>
				<div class="d-flex flex-wrap gap-1">
					@forelse($definition['route_patterns'] ?? [] as $pattern)
					<span class="badge bg-light text-dark border">{{ $pattern }}</span>
					@empty
					<span class="text-muted">—</span>
					@endforelse
				</div>
			</div>
		</div> -->

		<div class="card">
			<div class="card-body">
				<div class="table-responsive">
					<table class="table table-hover align-middle">
						<thead>
							<tr>
								<th>#</th>
								<th>@lang('main.module_menu_label')</th>
								<th>@lang('main.module_route_name')</th>
								<th>@lang('admin.app_type')</th>
								<th>@lang('main.order')</th>
								<th>@lang('admin.status')</th>
								<th>@lang('admin.Actions')</th>
							</tr>
						</thead>
						<tbody>
							@forelse($items as $item)
							<tr>
								<td>{{ $item->id }}</td>
								<td>
									@if($item->icon_class)
									<i
										class="{{ $item->icon_class }} me-1"></i>
									@endif
									{{ $item->label() }}
									<div class="small text-muted">
										{{ $item->item_key }}
									</div>
								</td>
								<td><code>{{ $item->route_name }}</code>
								</td>
								<td>
									@if($item->app_types)
									@php
									$labels =
									collect($item->app_types)->map(function
									($id) use ($appTypes) {
									$type =
									$appTypes->firstWhere('id',
									(int) $id);
									if (! $type) {
									return (string) $id;
									}

									return app()->getLocale() ===
									'ar'
									? ($type->name_ar ?:
									$type->name_en)
									: ($type->name_en ?:
									$type->name_ar);
									});
									@endphp
									{{ $labels->implode(', ') }}
									@else
									@lang('main.all')
									@endif
								</td>
								<td>{{ $item->sort_order }}</td>
								<td>
									<span
										class="badge {{ $item->is_active ? 'bg-success' : 'bg-secondary' }}">
										{{ $item->is_active ? __('main.enabled') : __('main.disabled') }}
									</span>
								</td>
								<td class="text-nowrap">
									<button type="button"
										class="btn btn-sm btn-info"
										data-bs-toggle="modal"
										data-bs-target="#editMenuItem{{ $item->id }}">
										@lang('admin.edit')
									</button>
									<a href="{{ route('modules-management.toggle', [$moduleKey, $item->id]) }}"
										class="btn btn-sm btn-secondary">
										@lang('admin.status')
									</a>
									<form action="{{ route('modules-management.destroy', [$moduleKey, $item->id]) }}"
										method="POST"
										class="d-inline"
										onsubmit="return confirm(@json(__('admin.confirm_delete')))">
										@csrf
										@method('DELETE')
										<button
											class="btn btn-sm btn-danger">@lang('admin.delete')</button>
									</form>
								</td>
							</tr>
							@empty
							<tr>
								<td colspan="7"
									class="text-center text-muted">
									@lang('main.no_data')</td>
							</tr>
							@endforelse
						</tbody>
					</table>
				</div>
			</div>
		</div>
	</div>
</div>

@include('main_admin.modules.partials.menu-item-form-modal', [
'modalId' => 'addMenuItemModal',
'title' => __('main.module_add_menu_item'),
'action' => route('modules-management.store', $moduleKey),
'method' => 'POST',
'item' => null,
'moduleKey' => $moduleKey,
'moduleKeys' => $moduleKeys,
'appTypes' => $appTypes,
])

@foreach($items as $item)
@include('main_admin.modules.partials.menu-item-form-modal', [
'modalId' => 'editMenuItem'.$item->id,
'title' => __('admin.edit'),
'action' => route('modules-management.update', [$moduleKey, $item->id]),
'method' => 'PUT',
'item' => $item,
'moduleKey' => $moduleKey,
'moduleKeys' => $moduleKeys,
'appTypes' => $appTypes,
])
@endforeach
@endsection