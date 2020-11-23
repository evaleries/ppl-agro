@php
$dashboardRoute = auth()->user()->hasRole('admin') ? 'admin.dashboard' : 'seller.dashboard';
@endphp
<aside id="sidebar-wrapper">
    <div class="sidebar-brand my-3">
        <img src="{{ asset('images/J-Coffee.png') }}" class="rounded-circle" style="height: 80px;" alt="{{ config('app.name') }}">
        <br>
        <a href="{{ route($dashboardRoute) }}" class="mb-2">{{ config('app.name') }}</a>
    </div>
    <div class="sidebar-brand sidebar-brand-sm">
        <a href="{{ route($dashboardRoute) }}">JC</a>
    </div>
    <ul class="sidebar-menu">
        <li class="menu-header">Dashboard</li>
        <li class="{{ request()->routeIs($dashboardRoute) ? 'active' : '' }}">
            <a class="nav-link" href="{{ route($dashboardRoute) }}">
                <i class="fas fa-columns"></i> <span>Dashboard</span>
            </a>
        </li>

        @can('manage all users')
        <li class="menu-header">Users</li>
        <li class="{{ request()->routeIs('admin.users.index') ? 'active' : '' }}">
            <a class="nav-link" href="{{ route('admin.users.index') }}"><i class="fas fa-users"></i> <span>Users</span></a>
        </li>
        @endcan

        @can('manage all stores')
{{--            <li class="menu-header">Users</li>--}}
{{--            <li class="{{ request()->routeIs('admin.users.index') ? 'active' : '' }}">--}}
{{--                <a class="nav-link" href="{{ route('admin.users.index') }}"><i class="fas fa-users"></i> <span>Users</span></a>--}}
{{--            </li>--}}
        @endcan
    </ul>
    <div class="mt-4 mb-4 p-3 hide-sidebar-mini">
        <a href="{{ url('/') }}" class="btn btn-primary btn-lg btn-block btn-icon-split">
            <i class="fas fa-rocket"></i> Home
        </a>
    </div>
</aside>
