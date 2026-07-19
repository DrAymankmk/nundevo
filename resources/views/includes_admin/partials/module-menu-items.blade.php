@foreach($items as $menuItem)
<li>
	<a href="{{ $menuItem->href() }}"
		class="{{ request()->routeIs($menuItem->route_name) ? 'active' : '' }}">
		<span class="menu-side clinic-admin-menu-icon">
			@if($menuItem->icon_class)
			<i class="{{ $menuItem->icon_class }}"></i>
			@else
			<i class="fa-solid fa-circle"></i>
			@endif
		</span>
		<span>{{ $menuItem->label() }}</span>
	</a>
</li>
@endforeach
