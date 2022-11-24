<nav id="sidebar">
    <div class="sidebar-header">
        <h3><img src="{{ asset('assets/images/02_Logo.png') }}" class="img-fluid" /><span>YOO</span></h3>
    </div>
    <ul id="main-selection" class="main-selection list-unstyled compnents">
        <li @if (Route::current()->getName() == 'operator.index') class="active" @endif>
            <a href="{{ route('operator.index') }}" class="dashboard">
                <i class="main-icon material-icons">home</i>
                <span>Home</span>
            </a>
        </li>
        {{-- users --}}
        <li class="has-sub @if (Route::current()->getName() == 'operator.users.driverList' || Route::current()->getName() == 'operator.driver-info' ) expand @endif">
            <a class="menu-list">
                <div class="d-flex justify-content-between">
                    <div>
                        <i class="sub-icon material-icons">person</i>
                        <span>Users</span>
                    </div>
                    <i class="sub-icon material-icons">arrow_drop_down</i>
                </div>
            </a>
            <ul id="user-submenu" class="submenu collapse @if (Route::current()->getName() == 'operator.users.driverList' || Route::current()->getName() == 'operator.users.subOperatorList' || Route::current()->getName() == 'operator.driver-info') show @endif">
                <li @if (Route::current()->getName() == 'operator.users.driverList' || Route::current()->getName() == 'operator.driver-info') class="active" @endif>
                    <a href="{{ route('operator.users.driverList') }}">
                        <i class="sub-icon material-icons">two_wheeler</i>
                        <span>Drivers</span>
                    </a>
                </li>
                @if ($operator->operator_verification_status_id == 4)
                    @if ($operator->operator_type_id == 1)
                        @if ($operator->operatorSubscription)
                            @if ($operator->operatorSubscription->package->id == 1 || $operator->operatorSubscription->package->id == 2)
                                <li @if (Route::current()->getName() == 'operator.users.subOperatorList') class="active" @endif>
                                    <a href="{{ route('operator.users.subOperatorList') }}">
                                        <i class="sub-icon material-icons">engineering</i>
                                        <span>Sub-operators</span>
                                    </a>
                                </li>
                            @endif
                        @endif
                    @endif
                @endif
            </ul>
        </li>
        {{-- topup --}}
        @if ($operator->operator_verification_status_id == 4)
            <li class="has-sub  @if (Route::current()->getName() == 'operator.topUpAccounts' || Route::current()->getName() == 'operator.topUpRequests' || Route::current()->getName() == 'operator.topUpTransactions') expand @endif">
                <a href="#" class="dashboard menu-list">
                    <div class="d-flex justify-content-between">
                        <div>
                            <i class="material-icons">account_balance_wallet</i>
                            <span>Top Up</span>
                        </div>
                        <i class="material-icons">arrow_drop_down</i>
                    </div>
                </a>
                <ul id="submenu" class="submenu collapse @if (Route::current()->getName() == 'operator.topUpAccounts' || Route::current()->getName() == 'operator.topUpRequests' || Route::current()->getName() == 'operator.topUpTransactions') show @endif">
                    <li @if (Route::current()->getName() == 'operator.topUpAccounts') class="active" @endif>
                        <a href="{{ route('operator.topUpAccounts') }}" class="dashboard">
                            <i class="sub-icon material-icons">assignment_ind</i>
                            <span>Accounts</span>
                        </a>
                    </li>
                    <li @if (Route::current()->getName() == 'operator.topUpRequests') class="active" @endif>
                        <a href="{{ route('operator.topUpRequests') }}" class="dashboard">
                            <i class="sub-icon material-icons">request_quote</i>
                            <span>Requests</span>
                        </a>
                    </li>
                    <li @if (Route::current()->getName() == 'operator.topUpTransactions') class="active" @endif>
                        <a href="{{ route('operator.topUpTransactions') }}" class="dashboard">
                            <i class="sub-icon material-icons">point_of_sale</i>
                            <span>Transaction</span>
                        </a>
                    </li>
                </ul>
            </li>
            {{-- orders --}}
            <li @if (Route::current()->getName() == 'operator.orders') class="active" @endif>
                <a href="{{ route('operator.orders') }}" class="dashboard">
                    <i class="main-icon material-icons">shopping_cart</i>
                    <span>Orders</span>
                </a>
            </li>
            {{-- shops --}}
            <li class="has-sub @if (Route::current()->getName() == 'operator.shop' || Route::current()->getName() == 'operator.shopInfo') expand @endif">
                <a class="menu-list">
                    <div class="d-flex justify-content-between">
                        <div>
                            <i class="sub-icon material-icons">shopping_bag</i>
                            <span>Shops</span>
                        </div>
                        <i class="sub-icon material-icons">arrow_drop_down</i>
                    </div>
                </a>
                <ul id="user-submenu" class="submenu collapse @if (Route::current()->getName() == 'operator.shop' || Route::current()->getName() == 'operator.shopInfo') show @endif">
                    {{-- <li @if (Route::current()->getName() == 'operator.user.customerList') class="active" @endif>
                        <a href="{{ route('operator.shop', ['publish', 'view' => 'grid']) }}">
                            <i class="sub-icon material-icons">shopping_cart</i>
                            <span>Shop Pending</span>
                        </a>
                    </li> --}}
                    <li @if (Route::current()->getName() == 'operator.shop' || Route::current()->getName() == 'operator.shopInfo') class="active" @endif>
                        <a href="{{ route('operator.shop', ['my', 'view' => 'grid']) }}">
                            <i class="sub-icon material-icons">add_shopping_cart</i>
                            <span>My Shop List</span>
                        </a>
                    </li>

                </ul>
            </li>
        @endif

    </ul>
</nav>

{{-- <div class="d-flex flex-column align-items-center align-items-sm-start px-3 pt-2 text-white min-vh-100">
    <a href="/" class="d-flex align-items-center pb-3 mb-md-0 me-md-auto text-white text-decoration-none">
        <span class="fs-5 d-none d-sm-inline">Menu</span>
    </a>
    <ul class="nav nav-pills flex-column mb-sm-auto mb-0 align-items-center align-items-sm-start" id="menu">
        <li class="nav-item">
            <a href="#" class="nav-link align-middle px-0">
                <i class="fs-4 bi-house"></i> <span class="ms-1 d-none d-sm-inline">Home</span>
            </a>
        </li>
        <li>
            <a href="#submenu1" data-bs-toggle="collapse" class="nav-link px-0 align-middle">
                <i class="fs-4 bi-speedometer2"></i> <span class="ms-1 d-none d-sm-inline">Dashboard</span> </a>
            <ul class="collapse show nav flex-column ms-1" id="submenu1" data-bs-parent="#menu">
                <li class="w-100">
                    <a href="#" class="nav-link px-0"> <span class="d-none d-sm-inline">Item</span> 1 </a>
                </li>
                <li>
                    <a href="#" class="nav-link px-0"> <span class="d-none d-sm-inline">Item</span> 2 </a>
                </li>
            </ul>
        </li>
        <li>
            <a href="#" class="nav-link px-0 align-middle">
                <i class="fs-4 bi-table"></i> <span class="ms-1 d-none d-sm-inline">Orders</span></a>
        </li>
        <li>
            <a href="#submenu2" data-bs-toggle="collapse" class="nav-link px-0 align-middle ">
                <i class="fs-4 bi-bootstrap"></i> <span class="ms-1 d-none d-sm-inline">Bootstrap</span></a>
            <ul class="collapse nav flex-column ms-1" id="submenu2" data-bs-parent="#menu">
                <li class="w-100">
                    <a href="#" class="nav-link px-0"> <span class="d-none d-sm-inline">Item</span> 1</a>
                </li>
                <li>
                    <a href="#" class="nav-link px-0"> <span class="d-none d-sm-inline">Item</span> 2</a>
                </li>
            </ul>
        </li>
        <li>
            <a href="#submenu3" data-bs-toggle="collapse" class="nav-link px-0 align-middle">
                <i class="fs-4 bi-grid"></i> <span class="ms-1 d-none d-sm-inline">Products</span> </a>
                <ul class="collapse nav flex-column ms-1" id="submenu3" data-bs-parent="#menu">
                <li class="w-100">
                    <a href="#" class="nav-link px-0"> <span class="d-none d-sm-inline">Product</span> 1</a>
                </li>
                <li>
                    <a href="#" class="nav-link px-0"> <span class="d-none d-sm-inline">Product</span> 2</a>
                </li>
                <li>
                    <a href="#" class="nav-link px-0"> <span class="d-none d-sm-inline">Product</span> 3</a>
                </li>
                <li>
                    <a href="#" class="nav-link px-0"> <span class="d-none d-sm-inline">Product</span> 4</a>
                </li>
            </ul>
        </li>
        <li>
            <a href="#" class="nav-link px-0 align-middle">
                <i class="fs-4 bi-people"></i> <span class="ms-1 d-none d-sm-inline">Customers</span> </a>
        </li>
    </ul>
    <hr>
    <div class="dropdown pb-4">
        <a href="#" class="d-flex align-items-center text-white text-decoration-none dropdown-toggle" id="dropdownUser1" data-bs-toggle="dropdown" aria-expanded="false">
            <img src="https://github.com/mdo.png" alt="hugenerd" width="30" height="30" class="rounded-circle">
            <span class="d-none d-sm-inline mx-1">loser</span>
        </a>
        <ul class="dropdown-menu dropdown-menu-dark text-small shadow" aria-labelledby="dropdownUser1">
            <li><a class="dropdown-item" href="#">New project...</a></li>
            <li><a class="dropdown-item" href="#">Settings</a></li>
            <li><a class="dropdown-item" href="#">Profile</a></li>
            <li>
                <hr class="dropdown-divider">
            </li>
            <li><a class="dropdown-item" href="#">Sign out</a></li>
        </ul>
    </div>
</div> --}}
