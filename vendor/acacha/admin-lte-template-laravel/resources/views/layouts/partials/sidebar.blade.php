<!-- Left side column. contains the logo and sidebar -->
<aside class="main-sidebar">

    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">

        <!-- Sidebar user panel (optional) -->
        @if ( Auth::guest())
            <div class="user-panel">
                <div class="pull-left image">
                    <img src="/uploads/avatars/{{ $user->avatar }}" class="img-circle" alt="User Image" />
                </div>
                <div class="pull-left info">
                    <p>{{ Auth::user()->name }}</p>
                    <!-- Status -->
                    <a href="#"><i class="fa fa-circle text-success"></i> {{ trans('adminlte_lang::message.online') }}</a>
                </div>
            </div>
        @endif
       <!-- Sidebar Menu -->
        <ul class="sidebar-menu">
            <!-- <li class="header">{{ trans('adminlte_lang::message.header') }}</li> -->
            <!-- Optionally, you can add icons to the links -->
            <li @yield('home')><a href="{{ url('home') }}"><i class='fa fa-home'></i> <span>{{ trans('adminlte_lang::message.dashboard') }}</span></a></li>
            @if($user->hasRole('admin')|| $user->hasRole('client-readonly') || $user->hasRole('client-readwrite'))
                <li @yield('client')><a href="{{ url('/clients') }}"><i class='fa fa-users'></i> <span>Manage Clients</span></a></li>
            @endif 
            @if($user->hasRole('admin')|| $user->hasRole('staff-readonly') || $user->hasRole('staff-readwrite'))
                <li @yield('staff')><a href="{{ url('/staff') }}"><i class='fa fa-user-md'></i> <span>Manage Staff</span></a></li>
            @endif 
           <!-- <li><a href="{{ url('/company') }}"><i class='fa fa-user-md'></i> <span>Manage Companies</span></a></li> -->
        </ul><!-- /.sidebar-menu -->
    </section>
    <!-- /.sidebar -->
</aside>
