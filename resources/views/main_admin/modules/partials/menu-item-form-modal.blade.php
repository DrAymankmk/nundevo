@php
	$item = $item ?? null;
	$selectedAppTypes = old('app_types', $item->app_types ?? []);
	if (! is_array($selectedAppTypes)) {
		$selectedAppTypes = [];
	}
@endphp

<div class="modal fade" id="{{ $modalId }}" tabindex="-1">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<form action="{{ $action }}" method="POST">
				@csrf
				@if(($method ?? 'POST') !== 'POST')
					@method($method)
				@endif
				<div class="modal-header">
					<h5 class="modal-title">{{ $title }}</h5>
					<button type="button" class="btn-close" data-bs-dismiss="modal"></button>
				</div>
				<div class="modal-body">
					<div class="row g-3">
						<div class="col-md-6">
							<label class="form-label">@lang('main.clinic_module')</label>
							<select name="module_key" class="form-control" required>
								@foreach($moduleKeys as $key)
								<option value="{{ $key }}"
									{{ old('module_key', $item->module_key ?? $moduleKey) === $key ? 'selected' : '' }}>
									{{ app(\App\Services\ClinicModuleService::class)->moduleLabel($key) }}
									({{ $key }})
								</option>
								@endforeach
							</select>
						</div>
						<div class="col-md-6">
							<label class="form-label">@lang('main.module_item_key')</label>
							<input type="text" name="item_key" class="form-control"
								value="{{ old('item_key', $item->item_key ?? '') }}"
								placeholder="clinic_admin.departments">
							<small class="text-muted">@lang('main.module_item_key_hint')</small>
						</div>
						<div class="col-md-6">
							<label class="form-label">@lang('main.module_route_name')</label>
							<input type="text" name="route_name" class="form-control" required
								value="{{ old('route_name', $item->route_name ?? '') }}"
								placeholder="departments">
						</div>
						<div class="col-md-6">
							<label class="form-label">@lang('main.order')</label>
							<input type="number" name="sort_order" class="form-control" min="0"
								value="{{ old('sort_order', $item->sort_order ?? 0) }}">
						</div>
						<div class="col-md-6">
							<label class="form-label">@lang('main.module_label_en')</label>
							<input type="text" name="label_en" class="form-control" required
								value="{{ old('label_en', $item->label_en ?? '') }}">
						</div>
						<div class="col-md-6">
							<label class="form-label">@lang('main.module_label_ar')</label>
							<input type="text" name="label_ar" class="form-control" required
								value="{{ old('label_ar', $item->label_ar ?? '') }}">
						</div>
						<div class="col-md-6">
							<label class="form-label">@lang('main.module_icon_class')</label>
							<input type="text" name="icon_class" class="form-control"
								value="{{ old('icon_class', $item->icon_class ?? '') }}"
								placeholder="fa-solid fa-layer-group">
						</div>
						<div class="col-md-6">
							<label class="form-label d-block">@lang('admin.status')</label>
							<div class="form-check form-switch mt-2">
								<input type="hidden" name="is_active" value="0">
								<input class="form-check-input" type="checkbox" name="is_active" value="1"
									{{ old('is_active', $item->is_active ?? true) ? 'checked' : '' }}>
								<label class="form-check-label">@lang('main.enabled')</label>
							</div>
						</div>
						<div class="col-12">
							<label class="form-label">@lang('admin.app_type')</label>
							<div class="d-flex flex-wrap gap-3">
								@foreach(($appTypes ?? collect()) as $type)
								<label class="form-check" style="display:flex; gap:15px">
									<input class="form-check-input" type="checkbox" name="app_types[]"
										value="{{ $type->id }}"
										{{ in_array((int) $type->id, array_map('intval', $selectedAppTypes), true) ? 'checked' : '' }}>
									<span class="form-check-label">
										{{ app()->getLocale() === 'ar' ? ($type->name_ar ?: $type->name_en) : ($type->name_en ?: $type->name_ar) }}
										<!-- <small class="text-muted">({{ $type->id }})</small> -->
									</span>
								</label>
								@endforeach
							</div>
							<small class="text-muted">@lang('main.module_app_types_hint')</small>
						</div>
					</div>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">@lang('admin.Close')</button>
					<button type="submit" class="btn btn-primary">@lang('admin.save')</button>
				</div>
			</form>
		</div>
	</div>
</div>
