<!-- Left Sidebar -->
<aside id="leftsidebar" class="sidebar">
    <!-- User Info -->

    <div class="user-info" style="background: url({{ asset('/bg/sidebar/blue.png') }}) no-repeat no-repeat; background-size: cover;">
        <div class="image">
            <img src="data:image/png;base64,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" width="50" heigh="50" />
        </div>
        <div class="info-container">
            <div class="name" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                {{ Auth::user()->name }}
            </div>
            <div class="email">
                {{ Auth::user()->email }}
            </div>
            <div class="btn-group user-helper-dropdown">
                <i class="material-icons" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">keyboard_arrow_down</i>
                <ul class="dropdown-menu pull-right">
                    <li><a href=""><i class="material-icons">person</i>Account</a></li>
                    <li role="seperator" class="divider"></li>
                    <li><a href="{{ route('logout') }}" onclick="event.preventDefault();document.getElementById('logout-form').submit();"><i class="material-icons">input</i>Sign Out</a></li>
                </ul>

                <form id="logout-form" action="{{ route('logout') }}" method="post" style="display: none">
                    {{ csrf_field() }}
                </form>
            </div>
        </div>
    </div>
    <!-- #User Info -->
    <!-- Menu -->
    <div class="menu">

        <a href="javascript:void(0);" class="bars"></a>

    <ul class="list">

    <li class="header">MAIN NAVIGATION</li>

    <li><a href="{{ route('home') }}" title="Home" class="">
            <i class="material-icons">apps</i>
            <span>Home</span>
        </a>
    </li>
@role('Super Admin')
    <li><a href="{{ route('index') }}" title="Signups" class="">
            <i class="material-icons">apps</i>
            <span>Signups</span>
        </a>
    </li>
@endrole
    <li><a href="{{ route('users..index') }}" title="Users" class="">
            <i class="material-icons">apps</i>
            <span>Users</span>
        </a>
    </li>
    <li><a href="{{ route('clients.index') }}" title="Clients" class="">
            <i class="material-icons">apps</i>
            <span>Clients</span>
        </a>
    </li>
    <li><a href="{{ route('contractorsignup.index') }}" title="Contractor Signups" class="">
            <i class="material-icons">apps</i>
            <span>Contractor Signups</span>
        </a>
    </li>
    <li><a href="{{ route('contractors.index') }}" title="Contractors" class="">
            <i class="material-icons">apps</i>
            <span>Contractors</span>
        </a>
    </li>
    <li><a href="{{ route('jobs.index') }}" title="Jobs" class="">
            <i class="material-icons">apps</i>
            <span>Jobs</span>
        </a>
    </li>
    <li><a href="{{ route('jobs.calendar') }}" title="Jobs" class="">
            <i class="material-icons">apps</i>
            <span>Calendar</span>
        </a>
    </li>

    </ul>
        

    </div>
    <!-- #Menu -->
    <!-- Footer -->
    <div class="legal">
        <i title="@lang('core::core.minify_sidebar')" id="minify-sidebar" class="material-icons">keyboard_arrow_left</i>
        <div class="version">
            <b>@lang('bap.version'): {{ config('bap.version') }}</b>
        </div>
    </div>
    <!-- #Footer -->
</aside>
<!-- #END# Left Sidebar -->