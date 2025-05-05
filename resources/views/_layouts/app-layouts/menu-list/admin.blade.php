<li data-username="animations" class="nav-item">
    <a href="{{ route('admin.home') }}" class="nav-link">
        <span class="pcoded-micon">
            <i class="feather icon-home"></i>
        </span>
        <span class="pcoded-mtext">Dashboard</span>
    </a>
</li>

@php
    $menu = App\Models\MasterMenu::where(['is_active' => true])->get();
@endphp

@forelse ($menu->sortBy('order') as $item)
    @php
        $filteredChildren = $item->children->filter(function ($child) {
            return auth()->user()->menuAccess->contains(function ($permission) use ($child) {
                return $permission->menu_children_id == $child->id;
            });
        });
    @endphp

    @if ($filteredChildren->isNotEmpty())
    <li class="nav-item pcoded-hasmenu">
        <a href="#" class="nav-link">
            <span class="pcoded-micon">
                <i class="{{ $item->icon }}"></i>
            </span>
            <span class="pcoded-mtext">{{ $item->title }}</span>
        </a>
        <ul class="pcoded-submenu">
            @foreach ($filteredChildren->where('is_active', true)->sortBy('order') as $child)
                <li class=""><a href="{{ url($child->route) }}" class="">{{ $child->title }}</a></li>
            @endforeach
        </ul>
    </li>
    @endif
@empty
    <p class="text-center">No menu available</p>
@endforelse
