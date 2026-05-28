<ul class="menu">
    @foreach (config('admin_sidebar.menu', []) as $item)
        @if (isset($item['section']))
            <li class="sidebar-title">{{ $item['section'] }}</li>
        @elseif (!empty($item['children']))
            <li
                class="sidebar-item has-sub {{ isset($item['active']) && request()->routeIs($item['active']) ? 'active' : '' }}">
                <a href="#" class="sidebar-link">
                    <i class="{{ $item['icon'] ?? 'bi bi-circle' }}"></i>
                    <span>{{ $item['label'] }}</span>
                </a>
                <ul class="submenu">
                    @foreach ($item['children'] as $child)
                        @php
                            $childHref = isset($child['route'])
                                ? route($child['route'])
                                : ($child['url'] ?? '#');
                        @endphp
                        <li class="submenu-item">
                            <a href="{{ $childHref }}" class="submenu-link">{{ $child['label'] }}</a>
                        </li>
                    @endforeach
                </ul>
            </li>
        @else
            @php
                $href =
                    isset($item['route']) ? route($item['route']) : ($item['url'] ?? '#');
                $isActive = isset($item['active'])
                    ? request()->routeIs($item['active'])
                    : (isset($item['route']) && request()->routeIs($item['route']));
            @endphp
            <li class="sidebar-item {{ $isActive ? 'active' : '' }}">
                <a href="{{ $href }}" class="sidebar-link">
                    <i class="{{ $item['icon'] ?? 'bi bi-circle' }}"></i>
                    <span>{{ $item['label'] }}</span>
                </a>
            </li>
        @endif
    @endforeach
</ul>
