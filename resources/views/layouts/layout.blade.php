<!DOCTYPE html>
<html lang="en">

<head>
    @include("layouts.head")
    @livewireStyles
    <!-- just remove arrow (->) to make it PWA  @->laravelPWA -->
    @laravelPWA
    <title>VMS</title>
</head>

<body>
    <!--  Body Wrapper -->
    @auth
    <div class="page-wrapper" id="main-wrapper" data-layout="vertical" data-navbarbg="skin6" data-sidebartype="full" data-sidebar-position="fixed" data-header-position="fixed">
        @include("layouts.sidebar")
        <!--  Main wrapper -->
        <div class="body-wrapper">
            @include("layouts.header")
            <div class="container-fluid">
                @if(session('flash_message'))
                <div class="alert alert-primary alert-dismissible fade show" role="alert">
                    <div class="d-flex flex-row">
                        <div class="p-2">{{session('flash_message')}}</div>
                        <button id="installButton" class="btn btn-primary p-2" style="display: none;">Install</button>
                    </div>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
                @endif
                @if(session('error'))
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <div>{{session('error')}}</div>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
                @elseif(session('message'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <div>{{session('message')}}</div>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
                @endif
                @yield("content")
            </div>
        </div>
    </div>
    @else
    @yield("content")
    @endauth
    @include("layouts.foot")
    @livewireScripts
</body>

</html>