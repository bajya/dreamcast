@if(Auth()->user())
<style type="text/css">
    a.nottify-btn {
    width: 100%;
    display: flex;
    justify-content: center;
    align-items: center;
    background-color: #6c8bc0;
    color: #fff;
    padding: 10px;
    border-radius: 999px;
    max-width: 200px;
    margin: 0 auto 10px;
}
#notificationList {
    max-height: 300px !important;
    overflow-y: auto;
}
</style>
<input type="hidden" name="auth_user_id" id="auth_user_id" value="{{ Auth()->user()->id }}">
<input type="hidden" name="auth_user_token" id="auth_user_token" value="{{ auth()->user()->createToken('Token')->accessToken }}">
<nav class="navbar default-layout col-lg-12 col-12 p-0 fixed-top d-flex flex-row" id="topbar">
    <div class="navbar-menu-wrapper d-flex align-items-center ml-auto ml-lg-0">
        <ul class="navbar-nav navbar-nav-right">
            <li class="nav-item dropdown d-none d-lg-inline-block">
                <a class="nav-link dropdown-toggle" id="UserDropdown" href="#" data-toggle="dropdown" aria-expanded="false">
                    <span class="profile-text" style="font-weight: 600; font-size: 14px;">{{ ucfirst(Auth::user()->name) }}</span>
                    <img class="img-xs rounded-circle" src="{{ Auth::user()->avatar }}" alt="Profile image">
                </a>
                <div class="dropdown-menu dropdown-menu-right navbar-dropdown" aria-labelledby="UserDropdown">
                    <ul class="dropdown-user">
                        <li>
                            <div class="dw-user-box">
                                <div class="u-img"><img src="{{ Auth::user()->avatar }}" alt="user" class="profile-pic" style="height: 60px; width: 70px;" /></div>
                                <div class="u-text">
                                    <h4>{{ config('app.name', 'Laravel') }}</h4>
                                    <p class="">{{ ucfirst(Auth::user()->name) }}</p>
                                    <p class="">{{ Auth::user()->email }}</p>
                                </div>
                            </div>  
                        </li>
                        <!-- <li role="separator" class="divider"></li> -->
                        <li><a href="{{route('changepassword')}}" style="padding: 4px 10px;"><i class="fa fa-key"></i> Change Password</a></li>
                        <li><a href="#" class="logoutAdmin" type="header" style="padding: 4px 10px;"><i class="fa fa-power-off"></i>
                            {{ __('Logout') }}
                        </a></li>
                        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                            @csrf
                        </form>
                    </ul>
                </div>
            </li>
        </ul>
        <button class="navbar-toggler navbar-toggler-right d-lg-none align-self-center" type="button" data-toggle="offcanvas">
            <span class="mdi mdi-menu"></span>
        </button>
    </div>
</nav>

@endif
