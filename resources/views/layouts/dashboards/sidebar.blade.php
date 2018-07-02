@extends("layouts.dashboards.dashboard")
@section("dashboard.sidebar")

<div class="overlay"></div>

<nav class="navbar">
    <div class="container-fluid">
        <div class="navbar-header">
            <a href="javascript:void(0);" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar-collapse" aria-expanded="false"></a>
            <a href="javascript:void(0);" class="bars"></a>
            <a class="navbar-brand" href="index.html">{{ env('APP_NAME') }}</a>
        </div>
    </div>
</nav>
<section>
    <aside id="leftsidebar" class="sidebar">
        <div class="user-info">
            <div class="image">
                <img id="profile_img" src="{{ '' === \Session::get('img')?asset('/assets/images/user.png'):\Session::get('img') }}" width="48" height="48" alt="User" />
            </div>
            <div class="info-container">
                <div id="profile_name" class="name" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">{{ \Session::get('name') }}</div>
                <div id="profile_email" class="email">{{ \Session::get('email') }}</div>
                <div class="btn-group user-helper-dropdown">
                    <i class="material-icons" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">keyboard_arrow_down</i>
                    <ul class="dropdown-menu pull-right">
                        <li><a href="{{ route('profile.index') }}"><i class="material-icons">person</i>Profile</a></li>
                        <li><a data-toggle="modal" data-target="#signout_confirmation_modal"><i class="material-icons">input</i>Sign Out</a></li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="menu">
            <ul class="list">
                <li class="header">{{ trans('string.menu') }}</li>
                @foreach (trans('string.menuItems') as $menu)
                  <li class="{{ starts_with(Route::currentRouteName(), $menu['prefix']) ? 'active':'' }}">
                      <a href="{{ route($menu['url']) }}">
                          <i class="material-icons">{{ $menu['icon'] }}</i>
                          <span>{{ $menu['title'] }}</span>
                      </a>
                  </li>
                @endforeach
            </ul>
        </div>
        <div class="legal">
            <div class="copyright">
                &copy; 2018 <a href="javascript:void(0);">{{ env('APP_NAME') }} - {{ env('APP_COMPANY') }}</a>.
            </div>
            <div class="version">
                <b>Version: </b> {{ env('APP_VERSION') }}
            </div>
        </div>
        <!-- #Footer -->
    </aside>
</section>
@endsection
