<nav id="sidebar">
    <div class="sidebar-header">
        <h3><img src="{{ asset('assets/images/02_Logo.png') }}" class="img-fluid" /><span>YOO</span></h3>
    </div>
    <ul class="list-unstyled compnents">
        @if (auth()->user()->management->management_role_id == 1)
            <li @if (Route::current()->getName() == 'management.index') class="active" @endif>
                <a href="{{ route('management.index') }}" class="dashboard">
                    <i class="main-icon material-icons">home</i>
                    <span>Home</span>
                </a>
            </li>
            {{-- users --}}
            <li class="has-sub @if (Route::current()->getName() == 'management.userDrivers' || Route::current()->getName() == 'management.userCustomers' || Route::current()->getName() == 'management.userOperators' || Route::current()->getName() == 'management.userManagement' || Route::current()->getName() == 'management.userOperatorInfo' || Route::current()->getName() == 'management.userDrivers' || Route::current()->getName() == 'management.userDriverInfo') expand @endif">
                <a class="menu-list">
                    <div class="d-flex justify-content-between">
                        <div>
                            <i class="sub-icon material-icons">person</i>
                            <span>Users</span>
                        </div>
                        <i class="sub-icon material-icons">arrow_drop_down</i>
                    </div>
                </a>
                <ul id="user-submenu" class="submenu collapse @if (Route::current()->getName() == 'management.userDrivers' || Route::current()->getName() == 'management.userCustomers' || Route::current()->getName() == 'management.userOperators' || Route::current()->getName() == 'management.userManagement' || Route::current()->getName() == 'management.userOperatorInfo' || Route::current()->getName() == 'management.userDriverInfo') show @endif">
                    <li @if (Route::current()->getName() == 'management.userDrivers' || Route::current()->getName() == 'management.userDriverInfo') class="active" @endif>
                        <a href="{{ route('management.userDrivers') }}">
                            <i class="sub-icon material-icons">two_wheeler</i>
                            <span>Drivers</span>
                        </a>
                    </li>
                    <li @if (Route::current()->getName() == 'management.userCustomers') class="active" @endif>
                        <a href="{{ route('management.userCustomers') }}">
                            <i class="sub-icon material-icons">sentiment_satisfied_alt</i>
                            <span>Customers</span>
                        </a>
                    </li>
                    <li @if (Route::current()->getName() == 'management.userOperators' || Route::current()->getName() == 'management.userOperatorInfo') class="active" @endif>
                        <a href="{{ route('management.userOperators') }}">
                            <i class="sub-icon material-icons">engineering</i>
                            <span>Operators</span>
                        </a>
                    </li>
                    <li @if (Route::current()->getName() == 'management.userManagement') class="active" @endif>
                        <a href="{{ route('management.userManagement') }}">
                            <i class="sub-icon material-icons">support_agent</i>
                            <span>Management</span>
                        </a>
                    </li>
                </ul>
            </li>
            {{-- topup --}}
            <li class="has-sub @if (Route::current()->getName() == 'management.topUpAccounts' || Route::current()->getName() == 'management.topUpRequests') expand @endif">
                <a class="menu-list">
                    <div class="d-flex justify-content-between">
                        <div>
                            <i class="material-icons">account_balance_wallet</i>
                            <span>Top Up</span>
                        </div>
                        <i class="material-icons">arrow_drop_down</i>
                    </div>
                </a>
                <ul id="user-submenu" class="submenu collapse   @if (Route::current()->getName() == 'management.topUpAccounts' || Route::current()->getName() == 'management.topUpRequests') show @endif">
                    <li @if (Route::current()->getName() == 'management.topUpAccounts') class="active" @endif>
                        <a href="{{ route('management.topUpAccounts') }}">
                            <i class="sub-icon material-icons">assignment_ind</i>
                            <span>Accounts</span>
                        </a>
                    </li>
                    <li @if (Route::current()->getName() == 'management.topUpRequests') class="active" @endif>
                        <a href="{{ route('management.topUpRequests') }}">
                            <i class="sub-icon material-icons">request_quote</i>
                            <span>Requests</span>
                        </a>
                    </li>
                </ul>
            </li>
            {{-- orders --}}
            <li @if (Route::current()->getName() == 'management.orders') class="active" @endif>
                <a href="{{ route('management.orders') }}" class="dashboard">
                    <i class="main-icon material-icons">shopping_cart</i>
                    <span>Orders</span>
                </a>
            </li>
            {{-- shop --}}
            <li class="has-sub @if (Route::current()->getName() == 'management.shop' || Route::current()->getName() == 'management.shopInfo') expand @endif">
                <a class="menu-list">
                    <div class="d-flex justify-content-between">
                        <div>
                            <i class="sub-icon material-icons">shopping_bag</i>
                            <span>Shops</span>
                        </div>
                        <i class="sub-icon material-icons">arrow_drop_down</i>
                    </div>
                </a>
                <ul id="user-submenu" class="submenu collapse @if (Route::currentRouteName() == 'management.shop' || Route::current()->getName() == 'management.shopInfo') show @endif">
                    <li @if (Route::current()->type == 'publish') class="active" @endif>
                        <a href="{{ route('management.shop', ['type' => 'publish', 'view' => 'grid']) }}">
                            <i class="sub-icon material-icons">shopping_cart</i>
                            <span>Shop</span>
                        </a>
                    </li>
                    <li @if (Route::current()->type == 'pending') class="active" @endif>
                        <a href="{{ route('management.shop', ['type' => 'pending', 'view' => 'grid']) }}">
                            <i class="sub-icon material-icons">remove_shopping_cart</i>
                            <span>Pending Shops</span>
                        </a>
                    </li>
                    <li @if (Route::current()->type == 'my') class="active" @endif>
                        <a href="{{ route('management.shop', ['type' => 'my', 'view' => 'grid']) }}">
                            <i class="sub-icon material-icons">add_shopping_cart</i>
                            <span>My Shops</span>
                        </a>
                    </li>
                </ul>
            </li>
        @else
            <li @if (Route::current()->type == 'publish') class="active" @endif>
                <a href="{{ route('shopadmin.shop', ['type' => 'publish', 'view' => 'grid']) }}">
                    <i class="sub-icon material-icons">shopping_cart</i>
                    <span>Shop</span>
                </a>
            </li>
            <li @if (Route::current()->type == 'pending') class="active" @endif>
                <a href="{{ route('shopadmin.shop', ['type' => 'pending', 'view' => 'grid']) }}">
                    <i class="sub-icon material-icons">remove_shopping_cart</i>
                    <span>Pending Shops</span>
                </a>
            </li>
            <li @if (Route::current()->type == 'my') class="active" @endif>
                <a href="{{ route('shopadmin.shop', ['type' => 'my', 'view' => 'grid']) }}">
                    <i class="sub-icon material-icons">add_shopping_cart</i>
                    <span>My Shops</span>
                </a>
            </li>
        @endif
    </ul>
</nav>
