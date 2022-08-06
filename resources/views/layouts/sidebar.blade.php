<div class="main-sidebar sidebar-style-2">
    <aside id="sidebar-wrapper">
        <div class="sidebar-brand">
            <a href="index.html">Stisla</a>
        </div>
        <div class="sidebar-brand sidebar-brand-sm">
            <a href="index.html">St</a>
        </div>
        <ul class="sidebar-menu">
            <li class="menu-header">{{ __('Dashboard') }}</li>

            <li class="{{ request()->routeIs('dashboard') ? 'active' : '' }}">
                <a class="nav-link" href="{{ route('dashboard') }}">
                    <i class="fas fa-tachometer-alt"></i>
                    <span>{{ __('Dashboard') }}</span>
                </a>
            </li>

            <li class="menu-header">{{ __('Master') }}</li>

            <li class="{{ request()->routeIs('departments.*') ? 'active' : '' }}">
                <a class="nav-link" href="{{ route('departments.index') }}">
                    <i class="fas fa-building"></i>
                    <span>{{ __('Departments') }}</span>
                </a>
            </li>

            <li class="{{ request()->routeIs('designations.*') ? 'active' : '' }}">
                <a class="nav-link" href="{{ route('designations.index') }}">
                    <i class="fas fa-user-tie"></i>
                    <span>{{ __('Designations') }}</span>
                </a>
            </li>

            <li class="{{ request()->routeIs('employees.*') ? 'active' : '' }}">
                <a class="nav-link" href="{{ route('employees.index') }}">
                    <i class="fas fa-users"></i>
                    <span>{{ __('Employees') }}</span>
                </a>
            </li>

            <li class="{{ request()->routeIs('holidays.*') ? 'active' : '' }}">
                <a class="nav-link" href="{{ route('holidays.index') }}">
                    <i class="fas fa-calendar"></i>
                    <span>{{ __('Holidays') }}</span>
                </a>
            </li>

            <li class="{{ request()->routeIs('attendances.*') ? 'active' : '' }}">
                <a class="nav-link" href="{{ route('attendances.index') }}">
                    <i class="fas fa-user-clock"></i>
                    <span>{{ __('Atendance') }}</span>
                </a>
            </li>

            <li class="{{ request()->routeIs('leaves.*') ? 'active' : '' }}">
                <a class="nav-link" href="{{ route('leaves.index') }}">
                    <i class="fas fa-running"></i>
                    <span>{{ __('Leave') }}</span>
                </a>
            </li>

            <li class="menu-header">{{ __('Settings') }}</li>

            <li class="{{ request()->routeIs('roles-permissions.*') ? 'active' : '' }}">
                <a class="nav-link" href="{{ route('roles-permissions.index') }}">
                    <i class="fas fa-user-lock"></i>
                    <span>{{ __('Roles & Permissions') }}</span>
                </a>
            </li>
        </ul>
    </aside>
</div>