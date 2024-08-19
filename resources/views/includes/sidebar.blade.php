<!-- Sidebar -->
<ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">
    <a class="sidebar-brand d-flex align-items-center justify-content-center" href="/home">
        <div class="sidebar-brand-icon rotate-n-15">
        </div>
        <div class="sidebar-brand-text mx-3"><img class="logo" src="{{ asset('images/BClean-logo-nbg.png') }}" /></div>
    </a>
    @php
    $user = auth()->user();
    $currentUrl = Request::url();
    @endphp
    <li class="nav-item active">
        <a class="nav-link" href="/home">
            <span>Welcome {{ $user->name}} </span></a>
        </li> 
        <li class="nav-item">
            <a class="nav-link collapsed {{ $currentUrl === url('/home') ? 'active' : '' }}" href="/home" data-toggle="" data-target=""
            aria-expanded="true" aria-controls="collapsePages">
            <i class="fa fa-home" aria-hidden="true"></i>
            <span>Dashboard</span>
        </a>        
    </li> 
    
    @if ($user && $user->role === 'admin')    
     <li class="nav-item">
            <a class="nav-link collapsed {{ $currentUrl === route('services.services_calendar') ? 'active' : '' }}" href="{{ route('services.services_calendar') }}" data-toggle="" data-target=""
            aria-expanded="true" aria-controls="collapsePages">
            <i class="fa fa-calendar" aria-hidden="true"></i>
            <span>Rental Calendar</span>
        </a>        
    </li>  
   {{--  <li class="nav-item">
        <a class="nav-link collapsed manage-link" href="{{route('home.manage')}}" data-toggle="collapse" data-target="#collapseservicesr"
        aria-expanded="true" aria-controls="collapsePages">
        <i class="fa fa-calendar" aria-hidden="true"></i>
        <span>Rental Info</span>
    </a>
    <div id="collapseservicesr" class="collapse" aria-labelledby="headingPages" data-parent="#accordionSidebar">
        <div class="bg-white py-2 collapse-inner rounded">
           <a class="collapse-item {{ $currentUrl === route('home.manage') ? 'active' : '' }}" href="{{route('home.manage')}}">Manage</a>

           <a class="collapse-item {{ $currentUrl === route('services.index') ? 'active' : '' }} {{ Str::contains(url()->current(), ['/unit', '/edit', 'services/create']) ? 'active' : '' }}" href="{{route('services.index')}}">Rental Dates</a>

           <a class="collapse-item {{ Str::contains(url()->current(), '/owner') ? 'active' : '' }}" href="{{route('user.userowner')}}">Owners</a>
           <a class="collapse-item {{ Str::contains(url()->current(), ['/cleaner']) ? 'active' : '' }}" href="{{route('user.usercleaner')}}">Cleaners</a>            
           
        </div>
    </div>
</li> --}}


  <li class="nav-item">
        <a class="nav-link collapsed manage-link" href="{{route('home.manage')}}" data-toggle="collapse" data-target="#collapseservicesr"
        aria-expanded="true" aria-controls="collapsePages">
        <i class="fa fa-calendar" aria-hidden="true"></i>
        <span>Rental Info</span>
    </a>
    <div id="collapseservicesr" class="collapse" aria-labelledby="headingPages" data-parent="#accordionSidebar">
        <div class="bg-white py-2 collapse-inner rounded">
            <ul>
            <li class="nav-item">
                <a class="nav-link collapsed" href="{{route('home.manage')}}" data-toggle="collapse" data-target="#collapseservices_inner" aria-expanded="true" aria-controls="collapsePages">
                    <span>Rental Dates</span>
                </a>
                <div id="collapseservices_inner" class="collapse">
                    <div class="bg-white py-2 collapse-inner rounded">
                            <a class="collapse-item {{ $currentUrl === route('services.index') ? 'active' : '' }} {{ Str::contains(url()->current(), ['/services/unit/']) ? 'active' : '' }}" href="{{ route('services.index') }}">View Dates</a>
                            <a class="collapse-item {{ Str::contains(url()->current(), ['/oldservices']) ? 'active' : '' }}" href="{{ route('admin.get_old_services') }}">View Old Dates</a>
                            <a class="collapse-item {{ $currentUrl === route('services.create') ? 'active' : '' }}" href="{{ route('services.create') }}">Insert Dates</a>
                            <a class="collapse-item {{ $currentUrl === route('services.services_calendar') ? 'active' : '' }}" href="{{route('services.services_calendar')}}">Calendar</a>
                    </div>
                </div>
            </li>           
            <li class="nav-item">
                <a class="nav-link collapsed" href="{{route('home.manage')}}" data-toggle="collapse" data-target="#collapseservices_Owners" aria-expanded="true" aria-controls="collapsePages">
                    <span>Owners</span>
                </a>
                <div id="collapseservices_Owners" class="collapse">
                    <div class="bg-white py-2 collapse-inner rounded">
                        <a class="collapse-item {{ $currentUrl === route('user.userowner') ? 'active' : '' }} {{ Str::contains(url()->current(), ['/user/owner/show']) ? 'active' : '' }}" href="{{ route('user.userowner') }}">View Owners</a>
                        <a class="collapse-item {{ $currentUrl === route('user.ownercreate') ? 'active' : '' }}" href="{{ route('user.ownercreate') }}">Insert Owners</a>
                        <a class="collapse-item {{ $currentUrl === route('user.userowner') ? 'active' : '' }}" href="{{ route('user.userowner') }}">Manage Units</a>          
                    </div>
                </div>
           </li>

            <li class="nav-item">
                <a class="nav-link collapsed" href="{{route('user.usercleaner')}}" data-toggle="collapse" data-target="#collapseservices_cleaners" aria-expanded="true" aria-controls="collapsePages">
                    <span>Cleaners</span>
                </a>
                <div id="collapseservices_cleaners" class="collapse">
                    <div class="bg-white py-2 collapse-inner rounded">
                       <a class="collapse-item {{ $currentUrl === route('user.usercleaner') ? 'active' : '' }}" href="{{ route('user.usercleaner') }}">View Cleaners</a>
                       <a class="collapse-item {{ $currentUrl === route('user.cleanercreate') ? 'active' : '' }}" href="{{ route('user.cleanercreate') }}">Insert Cleaner</a>
                       <a class="collapse-item {{ $currentUrl === route('assigncleaner.index') ? 'active' : '' }}" href="{{ route('assigncleaner.index') }}">Assign Cleaner</a>                  
                    </div>
                </div>
           </li>                
           
       </ul>
        </div>
    </div>
</li>


<li class="nav-item">
    <a class="nav-link collapsed {{ Str::contains(url()->current(), ['/user/admin','user/create','/edit']) ? 'active' : '' }}" href="{{ route('user.useradmin') }}">
        <i class="fa fa-user" aria-hidden="true"></i>
        <span>Manage Admins</span>
    </a>
</li>


<li class="nav-item">
    <a class="nav-link collapsed {{ $currentUrl === route('assigncleaner.index') ? 'active' : '' }}" href="{{ route('assigncleaner.index') }}">
        <i class="fa fa-envelope" aria-hidden="true"></i>
        <span>Assign Cleaners</span>
    </a>
</li>
<li class="nav-item">
    <a class="nav-link collapsed {{ $currentUrl === route('contactowner.create') ? 'active' : '' }}" href="{{ route('contactowner.create') }}">
        <i class="fa fa-envelope" aria-hidden="true"></i>
        <span>Contact Owner</span>
    </a>
</li>

@elseif ($user && $user->role === 'owner')
<li class="nav-item">
    <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseservicesr"
    aria-expanded="true" aria-controls="collapsePages">
    <i class="fa fa-calendar" aria-hidden="true"></i>
    <span>Rental Info</span>
</a>
<div id="collapseservicesr" class="collapse" aria-labelledby="headingPages" data-parent="#accordionSidebar">
    <div class="bg-white py-2 collapse-inner rounded"> 
           
        <a class="collapse-item {{ Str::contains(url()->current(), '/create') ? 'active' : '' }}" href="{{route('owner-services.create')}}">Insert Dates</a>
        <a class="collapse-item {{ Str::contains(url()->current(), '/service') ? 'active' : '' }}" href="{{route('owner.owner_get_date')}}">View Dates</a>
        <a class="collapse-item {{ Str::contains(url()->current(), '/edit') ? 'active' : '' }}" href="{{route('owner.owner_edit_date')}}">Edit Dates</a>
    </div>
</div>
</li>
<li class="nav-item">
    <a class="nav-link" href="{{ route('owner.owner_account_info') }}" >
    <i class="fas fa-fw fa-address-book"></i>
    <span>Account Info</span>
</a>
</li>
<li class="nav-item">
    <a class="nav-link collapsed" href="{{ route('owner.owner_contact_bclean') }}">
        <i class="fa fa-envelope" aria-hidden="true"></i>
        <span>Contact BClean</span>
    </a>
</li>
@endif

<li class="nav-item mobile-nav-item">
    @guest
        @if (Route::has('login'))
            <a class="nav-link collapsed" href="{{ route('login') }}">
                <i class="fas fa-sign-in-alt fa-sm fa-fw mr-2 text-gray-400"></i>
                {{ __('Login') }}</a>
        @endif
        @if (Route::has('register'))
            <a class="nav-link collapsed" href="{{ route('register') }}">
                <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
                {{ __('Register') }}</a>
        @endif
    @else        
        <a class="nav-link collapsed" href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
            <i class="fas fa-fw fa-lock"></i>
            {{ __('Logout') }}
        </a>
        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
            @csrf
        </form>
    @endguest
</li>



<div class="text-center d-none d-md-inline">
    <button class="rounded-circle border-0" id="sidebarToggle"></button>
</div>
</ul>


