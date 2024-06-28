@if(Auth()->user())
<style type="text/css">
    .dawn-angle {
    font-size: 16px;
    margin-left: 15px;
}
a.nav-link.active.collapsed .dawn-angle {
    transform: rotate(270deg);
}
ul.nav.sub-menu.sidebar-submenu {
    padding: 0px;
}
li.submenu-inn::before {
    display: none;
}
li.nav-item.active {
    background: #32388E;
    position: relative;
}
.submenu-inn a.nav-link i {
    margin-right: 1.25rem;
    width: 16px;
    line-height: 1;
    font-size: 18px;
    color: #33398c !important;
}
</style>
<nav class="sidebar sidebar-offcanvas" id="sidebar">
    <ul class="nav">
        <li class="nav-item nav-profile">
            <div class="text-center navbar-brand-wrapper d-flex align-items-top justify-content-center" style="height:100%"> 
                <a class="navbar-brand brand-logo d-flex align-items-center" href="{{ route('dashboard') }}" style="gap:10px">
                     <img src="{{ asset('images/newlogo.gif') }}" alt="homepage" class="dark-logo" style="width: 100px;">
                </a>
                <a class="navbar-brand brand-logo-mini" href="{{ route('dashboard') }}">
                   <b><img src="{{ asset('images/newlogo.gif') }}" alt="homepage" class="dark-logo" style="width: 60%;"></b>
                </a>
            </div>
            <div class="nav-link d-flex d-lg-none">
                <div class="user-wrapper">
                    <div class="text-wrapper">
                        <p class="profile-name">{{ config('app.name', 'Laravel') }}</p>
                        <div>
                            <small class="designation text-muted">{{ Auth::user()->name }}</small>
                            <span class="status-indicator online"></span>
                        </div>
                    </div>
                </div>
            </div>
        </li>
    </ul>
    <ul class="nav sidebarLinks">
        <li class="nav-item {{ request()->is('admin') ? 'active' : '' }}">
            <a class="nav-link first-link" href="{{route('dashboard')}}"><i class="menu-icon mdi mdi-gauge"></i><span class="menu-title">Dashboard</a>
        </li>
    </ul>
</nav>
@endif