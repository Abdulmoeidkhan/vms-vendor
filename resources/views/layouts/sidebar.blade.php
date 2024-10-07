@auth
<!-- Sidebar Start -->
<aside class="left-sidebar">
    <!-- Sidebar scroll-->
    <div>
        <div class="brand-logo d-flex align-items-center justify-content-between">
            <a href="{{route('pages.dashboard')}}" class="text-nowrap logo-img">
                <!-- <img src="{{asset('assets/images/logos/dark-logo.svg')}}" width="180" alt="" /> -->
                <img src="{{asset('assets/images/icons/Badar-Depo.png')}}" width="180" alt="">
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
                @if(session()->get('user')->roles[0]->name =="admin" )
                <li class="sidebar-item">
                    <a class="sidebar-link" href="{{route('pages.userPanel')}}" aria-expanded="false">
                        <span>
                            <i class="ti ti-users"></i>
                        </span>
                        <span class="hide-menu">User Panel</span>
                    </a>
                </li>
                <li class="sidebar-item">
                    <a href="{{route('pages.summaryPanel')}}" class="sidebar-link">
                        <div class="round-16 d-flex align-items-center justify-content-center">
                            <i class="ti ti-chart-bar"></i>
                        </div>
                        <span class="hide-menu">Summary</span>
                    </a>
                </li>
                @endif
                @if(session()->get('user')->roles[0]->name == 'bxssUser' || session()->get('user')->roles[0]->name
                =="admin" )
                <li class="sidebar-item">
                    <a href="{{route('pages.organizations')}}" class="sidebar-link">
                        <div class="round-16 d-flex align-items-center justify-content-center">
                            <i class="ti ti-building"></i>
                        </div>
                        <span class="hide-menu">Vendor & Staff</span>
                    </a>
                </li>
                <li class="sidebar-item">
                    <a href="{{route('pages.hrGroups')}}" class="sidebar-link">
                        <div class="round-16 d-flex align-items-center justify-content-center">
                            <i class="ti ti-user-circle"></i>
                        </div>
                        <span class="hide-menu">BXSS & Staff</span>
                    </a>
                </li>
                @endif
                @if(session()->get('user')->roles[0]->name =="admin" || session()->get('user')->roles[0]->name
                =="media" || session()->get('user')->roles[0]->name == 'bxssUser')
                <li class="sidebar-item">
                    <a href="{{route('pages.mediaGroups')}}" class="sidebar-link">
                        <div class="round-16 d-flex align-items-center justify-content-center">
                            <i class="ti ti-video"></i>
                        </div>
                        <span class="hide-menu">Media & Staff</span>
                    </a>
                </li>
                @endif
                @if(session()->get('user')->roles[0]->name =="admin" || session()->get('user')->roles[0]->name =="depo")
                <li class="sidebar-item">
                    <a href="{{route('pages.depoGroups')}}" class="sidebar-link">
                        <div class="round-16 d-flex align-items-center justify-content-center">
                            <i class="ti ti-shield-checkered"></i>
                        </div>
                        <span class="hide-menu">DEPO & Staff</span>
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
                @if(session()->get('user')->roles[0]->name =="mediaRep" )
                <li class="sidebar-item">
                    <a href="{{route('pages.mediaGroup',session()->get('user')->uid)}}" class="sidebar-link">
                        <div class="round-16 d-flex align-items-center justify-content-center">
                            <i class="ti ti-video"></i>
                        </div>
                        <span class="hide-menu">Media</span>
                    </a>
                </li>
                @endif
                @if(session()->get('user')->roles[0]->name =="depoRep")
                <li class="sidebar-item">
                    <a href="{{route('pages.depoGroup',session()->get('user')->uid)}}" class="sidebar-link">
                        <div class="round-16 d-flex align-items-center justify-content-center">
                            <i class="ti ti-shield-checkered"></i>
                        </div>
                        <span class="hide-menu">Organization</span>
                    </a>
                </li>
                @endif
                @if(session()->get('user')->roles[0]->name =="hrRep" )
                <li class="sidebar-item">
                    <a href="{{route('pages.hrGroup',session()->get('user')->uid)}}" class="sidebar-link">
                        <div class="round-16 d-flex align-items-center justify-content-center">
                            <i class="ti ti-video"></i>
                        </div>
                        <span class="hide-menu">BXSS</span>
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