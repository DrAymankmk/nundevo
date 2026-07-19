<?php $page = 'modules-management'; ?>

@extends('layout_new.mainlayout')

@section('content')
<div class="page-wrapper">
	<div class="content">
		<div
			class="d-flex align-items-sm-center flex-sm-row flex-column gap-2 pb-3 mb-3 border-1 border-bottom">
			<div class="flex-grow-1">
				<h4 class="fw-bold mb-0">@lang('main.modules_management')</h4>
				<p class="text-muted mb-0 mt-1">@lang('main.modules_management_hint')</p>
			</div>
		</div>

		@if(session('success'))
		<div class="alert alert-success">{{ session('success') }}</div>
		@endif

		<div class="row">
			@forelse($modules as $module)
			<div class="col-md-6 col-xl-4 mb-3">
				<div class="card h-100">
					<div class="card-body">
						<h5 class="card-title mb-1">{{ $module['label'] }}</h5>
						<p class="text-muted small mb-2">
							<code>{{ $module['key'] }}</code>
						</p>
						<p class="mb-2">
							<span class="badge bg-soft-primary text-primary">
								{{ $module['active_links'] }} / {{ $module['total_links'] }}
								@lang('main.module_menu_links')
							</span>
						</p>
						@if(!empty($module['app_types']))
						<p class="small text-muted mb-3">
							@lang('admin.app_type'):
							{{ implode(', ', $module['app_types']) }}
						</p>
						@endif
						<a href="{{ route('modules-management.show', $module['key']) }}"
							class="btn btn-primary btn-sm">
							@lang('main.manage_module_links')
						</a>
					</div>
				</div>
			</div>
			@empty
			<div class="col-12">
				<div class="alert alert-warning mb-0">@lang('main.no_data')</div>
			</div>
			@endforelse
		</div>
	</div>
</div>
@endsection
