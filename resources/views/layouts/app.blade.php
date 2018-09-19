@extends('layouts.plane')

@section('body')
    <div class="wrapper">

        <header class="main-header">
            <!-- Logo -->
            <a href="{{url('')}}" class="logo">
                <!-- mini logo for sidebar mini 50x50 pixels -->
                <span class="logo-mini"><b>AD</b></span>
                <!-- logo for regular state and mobile devices -->
                <span class="logo-lg"><b> Airport</b> DB</span>
            </a>

            <!-- Header Navbar: style can be found in header.less -->
            <nav class="navbar navbar-static-top">
                <!-- Sidebar toggle button-->
                <a href="#" class="sidebar-toggle" data-toggle="push-menu" role="button">
                    <span class="sr-only">Toggle navigation</span>
                </a>

                <div class="navbar-custom-menu">
                    <ul class="nav navbar-nav">
                        <!-- User Account: style can be found in dropdown.less -->
                        <li class="dropdown user user-menu">
                            @if(!Auth::guest())
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                                    @if(Auth::user()->profile_picture == null)
                                        <img src="{{asset("images/user.png")}}" class="user-image" alt="User Image">
                                    @else
                                        <img src="{{asset('images/profile/'.Auth::user()->profile_picture)}}" class="user-image" alt="User Image">
                                    @endif

                                    <span class="hidden-xs">{{Auth::user()->name}}</span>
                                </a>
                                <ul class="dropdown-menu">
                                    <!-- User image -->
                                    <li class="user-header">
                                        @if(Auth::user()->profile_picture == null)
                                            <img src="{{asset("images/user.png")}}" class="img-circle" alt="User Image">
                                        @else
                                            <img src="{{asset('images/profile/'.Auth::user()->profile_picture)}}" class="img-circle" alt="User Image">
                                        @endif

                                        <p>
                                            {{Auth::user()->name}}
                                            <?php $since = date('M. Y', strtotime(Auth::user()->created_at))?>
                                            <small>Member since {{$since}}</small>
                                        </p>
                                    </li>
                                    <!-- Menu Footer-->
                                    <li class="user-footer">
                                        <div class="pull-left">
                                            <a href="{{url('user-profile')}}" class="btn btn-default btn-flat">
                                                <i class="fa fa-user"></i> Profile
                                            </a>
                                        </div>
                                        <div class="pull-right">
                                            <a href="{{ route('logout') }}" class="btn btn-default btn-flat"
                                               onclick="event.preventDefault();
                                        document.getElementById('logout-form').submit();">
                                                <i class="fa fa-sign-out fa-fw"></i> Log Out
                                            </a>

                                            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                                @csrf
                                            </form>
                                        </div>
                                    </li>
                                </ul>
                            @endif
                        </li>
                    </ul>
                </div>
            </nav>
        </header>
        <!-- Left side column. contains the logo and sidebar -->
        <aside class="main-sidebar">
            <!-- sidebar: style can be found in sidebar.less -->
            <section class="sidebar">
                <ul class="sidebar-menu" data-widget="tree">
                    <li class="header">MAIN MENU</li>
                    <li class="{{ Request::is('/') || Request::is('home') ? 'active' : '' }}"><a href="{{url('')}}"><i class="fa fa-dashboard"></i> <span>Dashboard</span></a></li>

                    <!-- Airport -->
                    <li class="treeview {{ Request::is('*airport-*') ? 'active' : '' }}">
                        <a href="#">
                            <i class="fa fa-plane"></i>
                            <span>Airport Data</span>
                            <span class="pull-right-container">
                            <i class="fa fa-angle-left pull-right"></i>
                        </span>
                        </a>
                        <ul class="treeview-menu">
                            <li class="{{ Request::is('*airport-dom*') ? 'active' : '' }}"><a href="{{url('airport-dom')}}"><i class="fa fa-circle-o"></i> Domestic</a></li>
                            <li class="{{ Request::is('*airport-int*') ? 'active' : '' }}"><a href="{{url('airport-int')}}"><i class="fa fa-circle-o"></i> International</a></li>
                        </ul>
                    </li>

                    @if(!Auth::guest() && Auth::user()->role_name == 'admin')
                        <li class="header">MANAGEMENT DATA</li>
                        <!-- Database -->
                        <li class="treeview {{ Request::is('*manage-*') ? 'active' : '' }}">
                            <a href="#">
                                <i class="fa fa-database"></i>
                                <span>Manage Database</span>
                                <span class="pull-right-container">
                            <i class="fa fa-angle-left pull-right"></i>
                        </span>
                            </a>
                            <ul class="treeview-menu">
                                <li class="{{ Request::is('manage-users') ? 'active' : '' }}"><a href="{{url('manage-users')}}"><i class="fa fa-circle-o"></i> User</a></li>
                                <li class="{{ Request::is('manage-actypes') ? 'active' : '' }}"><a href="{{url('manage-actypes')}}"><i class="fa fa-circle-o"></i> Aircraft Type</a></li>
                                <li class="{{ Request::is('manage-doc') ? 'active' : '' }}"><a href="{{url('manage-doc')}}"><i class="fa fa-circle-o"></i> Document</a></li>
                                <li class="{{ Request::is('manage-region') ? 'active' : '' }}"><a href="{{url('manage-region')}}"><i class="fa fa-circle-o"></i> Region</a></li>
                            </ul>
                        </li>
                    @endif
                </ul>
            </section>
            <!-- /.sidebar -->
        </aside>

        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">
            <!-- Content Header (Page header) -->
            <section class="content-header">
                <h1>
                    @yield('page_heading')
                </h1>

                @yield('breadcrumb')
            </section>

            <!-- Main content -->
            @yield('section')

        </div>
        <!-- /.content-wrapper -->
        <footer class="main-footer">
            <div class="pull-right hidden-xs">
                <b>Version</b> 1.0.0
            </div>
            <strong>Copyright © 2018 <a href="https://github.com/kirandz/airport-db" target="_blank">Irfan Hafid</a></strong>
        </footer>
    </div>
    <!-- ./wrapper -->
@endsection
