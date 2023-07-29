<nav class="pcoded-navbar">
  <div class="pcoded-inner-navbar main-menu">
    <div class="pcoded-navigatio-lavel">Navigation</div>
    <ul class="pcoded-item pcoded-left-item">
      <li class="" style="@if($user->hasPermission('view_dashboard') == true) {{ 'display:;' }} @else{{ 'display:none;' }}@endif">
        <a href="{{ url('/home') }}">
          <span class="pcoded-micon"><i class="feather icon-home"></i></span>
          <span class="pcoded-mtext">Dashboard</span>
        </a>
      </li>
      <li class="pcoded-hasmenu">
        <a href="javascript:void(0)">
          <span class="pcoded-micon"><i class="feather icon-sliders"></i></span>
          <span class="pcoded-mtext">Roles & Permissions</span>
        </a>
        <ul class="pcoded-submenu">
          <li class="" style="@if( $user->hasPermission('view_user') == true ) {{ 'display:;' }} @else {{ 'display:none;' }} @endif">
            <a href="{{ url('user') }}">
              <span class="pcoded-mtext">Users</span>
            </a>
          </li>
          <li class="" style="@if( $user->hasPermission('view_role') == true) {{ 'display:;' }} @else {{ 'display:none;' }} @endif">
            <a href="{{ url('role') }}">
              <span class="pcoded-mtext">Roles</span>
            </a>
          </li>
          <li class="" style="@if( $user->hasPermission('view_permission') == true) {{ 'display:;' }} @else {{ 'display:none;' }} @endif">
            <a href="{{ url('permission') }}">
              <span class="pcoded-mtext">Permissions</span>
            </a>
          </li>
        </ul>
      </li>

      <li class="pcoded-hasmenu">
        <a href="javascript:void(0)">
          <span class="pcoded-micon"><i class="feather icon-sliders"></i></span>
          <span class="pcoded-mtext">PO</span>
        </a>
        <ul class="pcoded-submenu">
          <li class="" style="">
            <a href="{{ url('user') }}">
              <span class="pcoded-mtext">Users</span>
            </a>
          </li>
        </ul>
      </li>
    </ul>
  </div>
</nav>