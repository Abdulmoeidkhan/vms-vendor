@auth
<!-- Sidebar Start -->
<aside class="left-sidebar">
    <!-- Sidebar scroll-->
    <div>
        <div class="brand-logo d-flex align-items-center justify-content-between">
            <a href="{{route('pages.dashboard')}}" class="text-nowrap logo-img">
                <!-- <img src="{{asset('assets/images/logos/dark-logo.svg')}}" width="180" alt="" /> -->
                <img src="{{asset('images/icons/Badar-Depo.png')}}" width="180" alt="">
            </a>
            <div class="close-btn d-xl-none d-block sidebartoggler cursor-pointer" id="sidebarCollapse">
                <i class="ti ti-x fs-8"></i>
            </div>
        </div>
        <!-- Sidebar navigation-->
        <nav class="sidebar-nav scroll-sidebar" data-simplebar="">
            <ul id="sidebarnav">
                <li class="nav-small-cap">
                    <i class="ti ti-dots nav-small-cap-icon fs-4"></i>
                    <span class="hide-menu">Home</span>
                </li>
                <li class="sidebar-item">
                    <a class="sidebar-link" href="{{route('pages.dashboard')}}" aria-expanded="false">
                        <span>
                            <i class="ti ti-layout-dashboard"></i>
                        </span>
                        <span class="hide-menu">Dashboard</span>
                    </a>
                </li>
                @if(session()->get('user')->roles[0]->name =="admin")
                <li class="sidebar-item">
                    <a class="sidebar-link" href="{{route('pages.userPanel')}}" aria-expanded="false">
                        <span>
                            <i class="ti ti-users"></i>
                        </span>
                        <span class="hide-menu">User Panel</span>
                    </a>
                </li>
                <li class="sidebar-item">
                    <a href="{{route('pages.organizations')}}" class="sidebar-link">
                        <div class="round-16 d-flex align-items-center justify-content-center">
                            <i class="ti ti-building"></i>
                        </div>
                        <span class="hide-menu">Vendor & Staff</span>
                    </a>
                </li>
                @endif
                @if(session()->get('user')->roles[0]->name =="orgRep")
                <li class="sidebar-item">
                    <a href="{{route('pages.organization',session()->get('user')->uid)}}" class="sidebar-link">
                        <div class="round-16 d-flex align-items-center justify-content-center">
                            <i class="ti ti-building"></i>
                        </div>
                        <span class="hide-menu">Organization</span>
                    </a>
                </li>
                @endif
            </ul>
            <br />
            <br />
            <br />
            <br />
            <br />
            <br />
        </nav>

        <!-- End Sidebar navigation -->

    </div>
    <!-- End Sidebar scroll-->
</aside>
<!--  Sidebar End -->
@endauth