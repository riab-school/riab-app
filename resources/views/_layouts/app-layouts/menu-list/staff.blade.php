<li class="nav-item pcoded-menu-caption px-3 mb-2">
    <label>Pilih Tahun Ajaran</label>
    <div>
        <select class="form-control-sm w-100" id="tahun_ajaran">
            @foreach (App\Models\MasterTahunAjaran::get()->sortBy('tahun_ajaran') as $item)
            <option value="{{ $item->id }}" @if(session()->get('tahun_ajaran_aktif_id') == $item->id) selected disabled @endif>{{ $item->tahun_ajaran . "/" . $item->tahun_ajaran + 1 }}</option>    
            @endforeach
        </select>
    </div>
</li>
    
<li data-username="animations" class="nav-item">
    <a href="{{ route('staff.home') }}" class="nav-link">
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

@push('scripts')
    <script>
        // Change Tahun Ajaran
        $('#tahun_ajaran').change(function() {
            $.ajax({
                url: "{{ route('staff.home') }}",
                method: "GET", // First change type to method here    
                data: {
                    tahun_ajaran_new: this.value,
                },
                success: function(response) {
                    showSwal('success', 'Berhasil Mengganti Tahun Ajaran', true);

                },
                error: function(xhr, status, error) {
                    showSwal('error', 'Gagal Mengganti Tahun Ajaran')
                }
            });    
        });
    </script>
@endpush