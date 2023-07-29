<?php
$active_permission    = "";
$active_po            = "";
if (Request::is('user') || Request::is('role') || Request::is('permission')) {
  $active_permission  = "pcoded-trigger";
  $active_po          = "";
} elseif (Request::is('po')) {
  $active_permission  = "";
  $active_po          = "pcoded-trigger";
} else {
  $active_permission  = "";
  $active_po          = "";
}
?>
<nav class="pcoded-navbar">
  <div class="pcoded-inner-navbar main-menu">
    <div class="pcoded-navigatio-lavel">Navigation</div>
    <ul class="pcoded-item pcoded-left-item">
      <li class="{{ Request::is('home') ? 'active' : '' }}" style="@if($user->hasPermission('view_dashboard') == true) {{ 'display:;' }} @else{{ 'display:none;' }}@endif">
        <a href="{{ url('/home') }}">
          <span class="pcoded-micon"><i class="feather icon-home"></i></span>
          <span class="pcoded-mtext">Dashboard</span>
        </a>
      </li>
      <li class="pcoded-hasmenu {{ $active_permission }}">
        <a href="javascript:void(0)">
          <span class="pcoded-micon"><i class="feather icon-sliders"></i></span>
          <span class="pcoded-mtext">Roles & Permissions</span>
        </a>
        <ul class="pcoded-submenu">
          <li class="{{ Request::is('user') ? 'active' : '' }}" style="@if( $user->hasPermission('view_user') == true ) {{ 'display:;' }} @else {{ 'display:none;' }} @endif">
            <a href="{{ url('user') }}">
              <span class="pcoded-mtext">Users {{ Route::is('testing') }}</span>
            </a>
          </li>
          <li class="{{ Request::is('role') ? 'active' : '' }}" style="@if( $user->hasPermission('view_role') == true) {{ 'display:;' }} @else {{ 'display:none;' }} @endif">
            <a href="{{ url('role') }}">
              <span class="pcoded-mtext">Roles</span>
            </a>
          </li>
          <li class="{{ Request::is('permission') ? 'active' : '' }}" style="@if( $user->hasPermission('view_permission') == true) {{ 'display:;' }} @else {{ 'display:none;' }} @endif">
            <a href="{{ url('permission') }}">
              <span class="pcoded-mtext">Permissions</span>
            </a>
          </li>
        </ul>
      </li>
      <li class="pcoded-hasmenu {{ $active_po }}">
        <a href="javascript:void(0)">
          <span class="pcoded-micon"><i class="fa fa-archive"></i></span>
          <span class="pcoded-mtext">Purchase Order</span>
        </a>
        <ul class="pcoded-submenu">
          <li class="{{ Request::is('po') ? 'active' : '' }}">
            <a href="{{ url('po') }}">
              <span class="pcoded-mtext">Daftar PO</span>
            </a>
          </li>
        </ul>
      </li>
      <li class="pcoded-hasmenu">
        <a href="javascript:void(0)">
          <span class="pcoded-micon"><i class="fa fa-truck"></i></span>
          <span class="pcoded-mtext">Delivery</span>
        </a>
        <ul class="pcoded-submenu">
          <li class="#">
            <a href="#">
              <span class="pcoded-mtext">Daftar Delivery</span>
            </a>
          </li>
        </ul>
      </li>
      <li class="pcoded-hasmenu">
        <a href="javascript:void(0)">
          <span class="pcoded-micon"><i class="fa fa-files-o"></i></span>
          <span class="pcoded-mtext">Invoice</span>
        </a>
        <ul class="pcoded-submenu">
          <li class="">
            <a href="#">
              <span class="pcoded-mtext">Daftar Invoice</span>
            </a>
          </li>
        </ul>
      </li>
    </ul>
  </div>
</nav>