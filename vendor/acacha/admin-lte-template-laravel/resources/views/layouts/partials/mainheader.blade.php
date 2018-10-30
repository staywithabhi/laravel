<!-- Main Header -->
<header class="main-header">

    <!-- Logo -->
    <a href="{{ url('/home') }}" class="logo">
        <!-- mini logo for sidebar mini 50x50 pixels -->
        <span class="logo-mini">
        <img src="{{ asset('/img/logo_small.png') }}">
        </span>
        <!-- logo for regular state and mobile devices -->
        <span class="logo-lg"><img src="{{ asset('/img/logo_admin.png') }}"></span>
    </a>

    <!-- Header Navbar -->
    <nav class="navbar navbar-static-top" role="navigation">
        <!-- Sidebar toggle button-->
        <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
            <span class="sr-only">{{ trans('adminlte_lang::message.togglenav') }}</span>
        </a>
        @if($user->hasRole('admin') || $user->hasRole('client-readwrite') || $user->hasRole('client-readonly')|| $user->hasRole('staff-readwrite')|| $user->hasRole('staff-readonly'))
        <div class="col-xs-3 col-xs-offset-3 client-list-header form-group required has-feedback">
            <select id="clientlist" name ="clientlist" class="form-control form-control-lg" required>
            <option value=''>Client List</option>
            @foreach(\App\Clients::get() as $client)
                <option
                <?php if(Session::get("clientSet")==$client->id){?> selected='selected' <?php }?> value='{{$client->id}}'>{{$client->title}}</option>
            @endforeach    
            </select>       
            <span class="glyphicon glyphicon-compressed form-control-feedback"></span>
        </div>
        @endif
        <!-- Navbar Right Menu -->
        <div class="navbar-custom-menu">
            <ul class="nav navbar-nav">

                @if (Auth::guest())
                    <!-- <li><a href="{{ url('/register') }}">{{ trans('adminlte_lang::message.register') }}</a></li> -->
                    <li><a href="{{ url('/login') }}">{{ trans('adminlte_lang::message.login') }}</a></li>
                @else
                    <!-- User Account Menu -->
                    <li class="dropdown user user-menu" id="user_menu">
                        <!-- Menu Toggle Button -->
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                            <!-- The user image in the navbar-->
                            <img src="/uploads/avatars/{{ $user->avatar }}" class="user-image" alt="User Image"/>
                            <!-- hidden-xs hides the username on small devices so only the image appears. -->
                            <span class="hidden-xs">{{ Auth::user()->name }}</span>
                        </a>
                        <ul class="dropdown-menu">
                            <!-- The user image in the menu -->
                            <li class="user-header">
                                <img src="/uploads/avatars/{{ $user->avatar }}" class="img-circle" alt="User Image" />
                                <p>
                                    {{ Auth::user()->name }}
                                    <br>
                                    <!-- Company " {{-- \App\Clients::where('id',Auth::user()->client_id)->first()->title --}} " -->
                                      {{ Auth::user()->email }}
  
                                    <small>{{ trans('adminlte_lang::message.lastlogin') }} 
                                    @if(Session::has('lastLogin'))
                                        {{ Session::get('lastLogin') }}
                                      @endif
                                    </small>
                                </p>
                            </li>
                            <li class="user-footer">
                                <div class="pull-left">
                                    <a href="{{ url('/profile') }}" class="btn btn-default btn-flat">{{ trans('adminlte_lang::message.profile') }}</a>
                                </div>
                                <div class="pull-right">
                                    <a href="{{ url('/logout') }}" class="btn btn-default btn-flat" id="logout"
                                       onclick="event.preventDefault();
                                                 document.getElementById('logout-form').submit();">
                                        {{ trans('adminlte_lang::message.signout') }}
                                    </a>

                                    <form id="logout-form" action="{{ url('/logout') }}" method="POST" style="display: none;">
                                        {{ csrf_field() }}
                                        <input type="submit" value="logout" style="display: none;">
                                    </form>

                                </div>
                            </li>
                        </ul>
                    </li>
                @endif


            </ul>
        </div>
    </nav>
</header>
