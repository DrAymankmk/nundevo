@foreach($items as $menuItem)
<li class="{{ request()->routeIs($menuItem->route_name) ? 'active' : '' }}">
	<a href="{{ $menuItem->href() }}">
		@if($menuItem->icon_class)
		<i class="{{ $menuItem->icon_class }}"></i>
		@else
		<i class="ti ti-point"></i>
		@endif
		<span>{{ $menuItem->label() }}</span>
	</a>
</li>
@endforeach
