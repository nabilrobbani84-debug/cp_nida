@php
    $menuItems = collect(config('admin_sidebar.menu', []));

    $canSeeMenuItem = function (array $item): bool {
        if (empty($item['role_ids'])) {
            return true;
        }

        $userRoleId = auth()->user()?->id_role;

        return $userRoleId !== null && in_array((int) $userRoleId, $item['role_ids'], true);
    };

    $isMenuItemVisible = function (array $item) use ($canSeeMenuItem): bool {
        if (isset($item['section'])) {
            return false;
        }

        if (! empty($item['children'])) {
            return collect($item['children'])->contains(
                fn (array $child) => $canSeeMenuItem($child)
            );
        }

        return $canSeeMenuItem($item);
    };

    $isMenuItemActive = function (array $item): bool {
        if (isset($item['active'])) {
            return request()->routeIs($item['active']);
        }

        return isset($item['route']) && request()->routeIs($item['route']);
    };

    $sectionHasVisibleItems = function (int $sectionIndex) use ($menuItems, $isMenuItemVisible): bool {
        for ($i = $sectionIndex + 1; $i < $menuItems->count(); $i++) {
            $next = $menuItems[$i];

            if (isset($next['section'])) {
                break;
            }

            if ($isMenuItemVisible($next)) {
                return true;
            }
        }

        return false;
    };
@endphp

<ul class="menu">
    @foreach ($menuItems as $index => $item)
        @if (isset($item['section']))
            @if (! $sectionHasVisibleItems($index))
                @continue
            @endif
            <li class="sidebar-title">{{ $item['section'] }}</li>
        @elseif (! $isMenuItemVisible($item))
            @continue
        @elseif (! empty($item['children']))
            <li
                class="sidebar-item has-sub {{ $isMenuItemActive($item) ? 'active' : '' }}">
                <a href="#" class="sidebar-link">
                    <i class="{{ $item['icon'] ?? 'bi bi-circle' }}"></i>
                    <span>{{ $item['label'] }}</span>
                </a>
                <ul class="submenu">
                    @foreach ($item['children'] as $child)
                        @if (! $canSeeMenuItem($child))
                            @continue
                        @endif
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
                $isActive = $isMenuItemActive($item);
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
