<div class="top-navbar">
    <nav class="navbar navbar-expand-lg">
        <div class="container-fluid">
            <button type="button" id="sidebarCollapse" class="d-xl-block d-lg-block d-md-mone d-none">
                <span class="material-icons">
                    menu
                </span>
            </button>
            <span class="navbar-brand"><i class="fa fa-home" aria-hidden="true"></i></span>

            <button class="d-inline-block d-lg-none ml-auto more-button" type="button" data-toggle="collapse"
                data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false"
                aria-label="Toggle navigation">
                <span class="material-icons">more_vert</span>
            </button>
            <div class="collapse navbar-collapse d-lg-block d-xl-block d-sm-none d-md-none d-none"
                id="navbarSupportedContent">
                <ul class="nav navbar-nav ml-auto">
                    <li class="nav-item dropdown d-flex justify-content-center align-content-center">
                        @if (auth()->user()->userInfo->profile_picture != null)
                            <div class="d-flex justify-content-center align-content-center dropdown-toggle"
                                id="navbarDarkDropdownMenuLink" role="button" data-bs-toggle="dropdown"
                                aria-expanded="false">
                                <p class="mt-2 text-lowercase">
                                    @if (auth()->user()->email != null)
                                        {{ auth()->user()->email }}
                                    @else
                                        {{ auth()->user()->mobile_number }}
                                    @endif
                                </p>
                                <img id="nav-profile-picture-img" class="nav-profile-avatar nav-link"
                                    src="{{ asset('storage/profile_picture/' . auth()->user()->userInfo->profile_picture) }}">
                            </div>
                        @else
                            <div class="d-flex justify-content-center align-content-center dropdown-toggle"
                                id="navbarDarkDropdownMenuLink" role="button" data-bs-toggle="dropdown"
                                aria-expanded="false">
                                <p class="mt-2 text-lowercase">
                                    @if (auth()->user()->email != null)
                                        {{ auth()->user()->email }}
                                    @else
                                        {{ auth()->user()->mobile_number }}
                                    @endif
                                </p>
                                <img id="nav-profile-picture-img" class="nav-profile-avatar nav-link"
                                    src="
                                    {{ asset('assets/images/Profile_Placeholder.png') }}" alt="">
                            </div>
                        @endif
                        <ul class="dropdown-menu dropdown-menu" aria-labelledby="navbarDarkDropdownMenuLink">
                            {{-- profile route here --}}
                            @if (auth()->user()->management->management_role_id == 1)
                                <li>
                                    <a class="dropdown-item" href="{{ route('management.profile') }}">
                                        Profile
                                    </a>
                                </li>
                                <li>
                                    <a class="dropdown-item" href="{{ route('management.settings') }}">
                                        Settings
                                    </a>
                                </li>
                            @else
                                <li>
                                    <a class="dropdown-item" href="{{ route('shopadmin.profile') }}">
                                        Profile
                                    </a>
                                </li>
                                <li>
                                    <a class="dropdown-item" href="{{ route('shopadmin.settings') }}">
                                        Settings
                                    </a>
                                </li>
                            @endif


                            <div class="border"></div>
                            <li>
                                <a class="dropdown-item" href="" data-bs-toggle="modal"
                                    data-bs-target="#logout">
                                    Logout
                                </a>
                            </li>
                        </ul>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
</div>
