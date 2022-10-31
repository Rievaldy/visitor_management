<aside class="main-sidebar">
    <!-- sidebar-->
    <section class="sidebar" id='dash'>
        <!-- sidebar menu-->
        <ul class="sidebar-menu" data-widget="tree">
            @if (Auth::user()->user_type == 99)
                <li class="header nav-small-cap text-uppercase">HOME</li>
                <li class="pt-3 {{ Request::segment(1) === 'dashboard' ? 'active' : '' }}">
                    <a href="{{ url('dashboard') }}">
                        <i class="ti-dashboard"></i>
                        <span>Dashboard</span>
                    </a>
                </li>
            @endif
            @if (Auth::user()->user_type == 99 || Auth::user()->user_type == 3 || Auth::user()->user_type == 4)
                <li class="header nav-small-cap text-uppercase">ACTIVITY</li>
                @if (Auth::user()->user_type == 99 || Auth::user()->user_type == 4)
                    <li class="{{ Request::segment(1) === 'visitor' ? 'active' : '' }}">
                        <a href="{{ url('visitor') }}">
                            <i class="ti-comments-smiley"></i>
                            <span>Visitor Management</span>
                        </a>
                    </li>
                @endif
                @if (Auth::user()->user_type == 99)
                    <li class="treeview {{ Request::segment(1) === 'purchasing' || Request::segment(1) === 'hse'|| Request::segment(1) === 'nda' || Request::segment(1) === 'factory-director'|| Request::segment(1) === 'ga-security' ? 'active' : '' }}">
                        <a href="#">
                            <i class="ti-check-box"></i>
                            <span>Authorized Person</span>
                            <span class="pull-right-container">
                                <i class="fa fa-angle-right pull-right"></i>
                            </span>
                        </a>
                        <ul class="treeview-menu">
                            <li class="{{ Request::segment(1) === 'purchasing' ? 'active' : '' }}">
                                <a href="{{ route('purchasing') }}">
                                    <i class="ti-more"></i>
                                    <span>PIC Project/Purchasing</span>
                                </a>
                            </li>
                            <li class="{{ Request::segment(1) === 'hse' ? 'active' : '' }}">
                                <a href="{{ url('hse') }}">
                                    <i class="ti-more"></i>
                                    <span>HSE Management</span>
                                </a>
                            </li>
                            <li class="{{ Request::segment(1) === 'nda' ? 'active' : '' }}">
                                <a href="{{ url('nda') }}">
                                    <i class="ti-more"></i>
                                    <span>Confidential Management</span>
                                </a>
                            </li>
                            <li class="{{ Request::segment(1) === 'factory-director' ? 'active' : '' }}">
                                <a href="{{ url('factory-director') }}">
                                    <i class="ti-more"></i>
                                    <span>HSE Factory Director</span>
                                </a>
                            </li>
                            <li class="{{ Request::segment(1) === 'ga-security' ? 'active' : '' }}">
                                <a href="{{ url('ga-security') }}">
                                    <i class="ti-more"></i>
                                    <span>GA/Security</span>
                                </a>
                            </li>
                        </ul>
                    </li>
                @endif
                <li class="treeview {{ Request::segment(1) === 'booking-list' || Request::segment(1) === 'book-now' || Request::segment(1) === 'my-booking' ? 'active' : '' }}">
                    <a href="#">
                        <i class="ti-notepad"></i>
                        <span>Visitor</span>
                        <span class="pull-right-container">
                            <i class="fa fa-angle-right pull-right"></i>
                        </span>
                    </a>
                    <ul class="treeview-menu">
                        {{-- @if (Auth::user()->user_type == 99)
                            <li class="{{ Request::segment(1) === 'booking-list' ? 'active' : '' }}">
                                <a href="{{ url('booking-list') }}">
                                    <i class="ti-clipboard"></i>
                                    <span>Booking List</span>
                                </a>
                            </li>
                        @endif --}}
                        <li class="{{ Request::segment(1) === 'book-now' ? 'active' : '' }}">
                            <a href="{{ url('book-now') }}">
                                <i class="ti-pencil-alt"></i>
                                <span>Visitor Normal</span>
                            </a>
                        </li>
                        <li class="{{ Request::segment(1) === 'my-booking' ? 'active' : '' }}">
                            <a href="{{ url('my-booking') }}">
                                <i class="ti-calendar"></i>
                                <span>Vendor/Contractor</span>
                            </a>
                        </li>
                        <li class="{{ Request::segment(1) === 'my-booking' ? 'active' : '' }}">
                            <a href="{{ url('my-booking') }}">
                                <i class="ti-calendar"></i>
                                <span>Visitor Special</span>
                            </a>
                        </li>
                        <li class="{{ Request::segment(1) === 'my-booking' ? 'active' : '' }}">
                            <a href="{{ url('my-booking') }}">
                                <i class="ti-calendar"></i>
                                <span>Visitor Renewal</span>
                            </a>
                        </li>
                    </ul>
                </li>

            @endif
            @if (Auth::user()->user_type == 6)
                <li class="header nav-small-cap text-uppercase">ACTIVITY</li>

                <li class="treeview {{ Request::segment(1) === 'booking-list' || Request::segment(1) === 'book-now' || Request::segment(1) === 'my-booking' ? 'active' : '' }}">
                    <a href="#">
                        <i class="ti-notepad"></i>
                        <span>Booking Room</span>
                        <span class="pull-right-container">
                            <i class="fa fa-angle-right pull-right"></i>
                        </span>
                    </a>
                    <ul class="treeview-menu">
                        @if (Auth::user()->user_type == 99)
                            <li class="{{ Request::segment(1) === 'booking-list' ? 'active' : '' }}">
                                <a href="{{ url('booking-list') }}">
                                    <i class="ti-clipboard"></i>
                                    <span>Booking List</span>
                                </a>
                            </li>
                        @endif
                            <li class="{{ Request::segment(1) === 'book-now' ? 'active' : '' }}">
                                <a href="{{ url('book-now') }}">
                                    <i class="ti-pencil-alt"></i>
                                    <span>Book Now</span>
                                </a>
                            </li>
                            <li class="{{ Request::segment(1) === 'my-booking' ? 'active' : '' }}">
                                <a href="{{ url('my-booking') }}">
                                    <i class="ti-calendar"></i>
                                    <span>My Booking</span>
                                </a>
                            </li>
                    </ul>
                </li>
                <li class="header nav-small-cap text-uppercase">REPORT</li>
                <li class="{{ Request::segment(1) === 'book-now' ? 'active' : '' }}">
                    <a href="{{ route('reportAttendance') }}">
                        <i class="ti-briefcase"></i>
                        <span>Attendance</span>
                    </a>
                </li>
            @endif
            @if (Auth::user()->user_type == 1)
                <li class="header nav-small-cap text-uppercase">ACTIVITY</li>
                <li class="treeview {{ Request::segment(1) === 'booking-list' || Request::segment(1) === 'book-now' || Request::segment(1) === 'my-booking' ? 'active' : '' }}">
                    <a href="#">
                        <i class="ti-notepad"></i>
                        <span>Booking Room</span>
                        <span class="pull-right-container">
                            <i class="fa fa-angle-right pull-right"></i>
                        </span>
                    </a>
                    <ul class="treeview-menu">
                        <li class="{{ Request::segment(1) === 'book-now' ? 'active' : '' }}">
                            <a href="{{ url('book-now') }}">
                                <i class="ti-pencil-alt"></i>
                                <span>Book Now</span>
                            </a>
                        </li>
                        <li class="{{ Request::segment(1) === 'my-booking' ? 'active' : '' }}">
                            <a href="{{ url('my-booking') }}">
                                <i class="ti-calendar"></i>
                                <span>My Booking</span>
                            </a>
                        </li>
                    </ul>
                </li>
                <li class="treeview {{ Request::segment(1) === 'frontdesk' || Request::segment(1) === 'secretary' ? 'active' : '' }}">
                    <a href="#">
                        <i class="ti-more"></i>
                        <span>Task</span>
                        <span class="pull-right-container">
                            <i class="fa fa-angle-right pull-right"></i>
                        </span>
                    </a>
                    <ul class="treeview-menu">
                        <li class="{{ Request::segment(1) === 'frontdesk' && Request::segment(2) === null ? 'active' : '' }}">
                            <a href="{{ url('frontdesk') }}">
                                <i class="ti-headphone"></i>
                                <span>Frontdesk</span>
                            </a>
                        </li>
                    </ul>
                </li>
                <li class="{{ Request::segment(1) === 'visitor' && Request::segment(2) === null ? 'active' : '' }}">
                    <a href="{{ url('visitor') }}">
                        <i class="ti-face-smile"></i>
                        <span>Visitor Management </span>
                    </a>
                </li>
            @endif
            {{-- ini --}}
            @if (Auth::user()->user_type == 5)
                <li class="header nav-small-cap text-uppercase">ACTIVITY</li>

                <li class="treeview {{ Request::segment(1) === 'booking-list' || Request::segment(1) === 'book-now' || Request::segment(1) === 'my-booking' ? 'active' : '' }}">
                    <a href="#">
                        <i class="ti-notepad"></i>
                        <span>Booking Room</span>
                        <span class="pull-right-container">
                            <i class="fa fa-angle-right pull-right"></i>
                        </span>
                    </a>
                    <ul class="treeview-menu">
                        <li class="{{ Request::segment(1) === 'book-now' ? 'active' : '' }}">
                            <a href="{{ url('book-now') }}">
                                <i class="ti-pencil-alt"></i>
                                <span>Book Now</span>
                            </a>
                        </li>
                        <li class="{{ Request::segment(1) === 'my-booking' ? 'active' : '' }}">
                            <a href="{{ url('my-booking') }}">
                                <i class="ti-calendar"></i>
                                <span>My Booking</span>
                            </a>
                        </li>
                    </ul>
                </li>

                <li class="treeview {{ Request::segment(1) === 'frontdesk' || Request::segment(1) === 'secretary' ? 'active' : '' }}">
                    <a href="#">
                        <i class="ti-more"></i>
                        <span>Task</span>
                        <span class="pull-right-container">
                            <i class="fa fa-angle-right pull-right"></i>
                        </span>
                    </a>
                    <ul class="treeview-menu">
                        <li class="{{ Request::segment(1) === 'secretary' ? 'active' : '' }}">
                            <a href="{{ url('secretary') }}">
                                <i class="ti-light-bulb"></i>
                                <span>Secretary</span>
                            </a>
                        </li>
                    </ul>
                </li>
                <li class="{{ Request::segment(1) === 'visitor' && Request::segment(2) === null ? 'active' : '' }}">
                    <a href="{{ url('visitor') }}">
                        <i class="ti-comments-smiley"></i>
                        <span>Visitor Management</span>
                    </a>
                </li>
                <li class="{{ Request::segment(1) === 'attendance-online' ? 'active' : '' }}">
                    <a href="{{ url('attendance-online') }}">
                        <i class="ti-check-box"></i>
                        <span>My Attendance</span>
                    </a>
                </li>
            @endif
            @if (Auth::user()->user_type == 99)
                <li class="pt-3 {{ Request::segment(1) === 'dashboard' ? 'active' : '' }}">
                    <a href="{{ url('dashboard') }}">
                        <i class="ti-dashboard"></i>
                        <span>Findings</span>
                    </a>
                </li>
            @endif
            @if (Auth::user()->user_type == 2)
                <li class="header nav-small-cap text-uppercase">CONFIGURATION </li>
                <li class="treeview {{ Request::segment(1) === 'foodandbaverages' ? 'active' : ''}}">
                    <a href="#">
                        <i class="ti-settings"></i>
                        <span>Settings</span>
                        <span class="pull-right-container">
                            <i class="fa fa-angle-right pull-right"></i>
                        </span>
                    </a>
                    <ul class="treeview-menu">
                        <li class="treeview {{ Request::segment(1) === 'foodandbaverages' && Request::segment(2) === 'menu' || Request::segment(1) === 'foodandbaverages' && Request::segment(2) === 'categories' ? 'active' : '' }}">
                            <a href="#">
                                <i class="ti-menu-alt"></i>
                                <span>Menu</span>
                                <span class="pull-right-container">
                                    <i class="fa fa-angle-right pull-right"></i>
                                </span>
                            </a>
                            <ul class="treeview-menu">
                                <li class="{{ Request::segment(1) === 'foodandbaverages' && Request::segment(2) === 'menu' ? 'active' : '' }}">
                                    <a href="{{ url('foodandbaverages/menu') }}">
                                        <i class="ti-more"></i>List Menu
                                    </a>
                                </li>
                                <li class="{{ Request::segment(1) === 'foodandbaverages' && Request::segment(2) === 'categories' ? 'active' : '' }}">
                                    <a href="{{ url('foodandbaverages/categories') }}">
                                        <i class="ti-more"></i>Categories
                                    </a>
                                </li>
                            </ul>
                        </li>
                    </ul>
                </li>
            @endif
            @if (Auth::user()->user_type == 99)
                <li class="header nav-small-cap text-uppercase">REPORT</li>
                <li class="treeview {{ Request::segment(1) === 'report' ? 'active' : '' }}">
                    <a href="#">
                        <i class="ti-briefcase"></i>
                        <span>Report</span>
                        <span class="pull-right-container">
                            <i class="fa fa-angle-right pull-right"></i>
                        </span>
                    </a>
                    <ul class="treeview-menu">
                        <li class="{{ Request::segment(1) === 'report' && Request::segment(2) === 'attendance' ? 'active' : '' }}">
                            <a href="{{route('reportAttendance')}}">
                                <i class="ti-files"></i>
                                <span>Registered Visit</span>
                            </a>
                        </li>
                        <li class="{{ Request::segment(1) === 'report' && Request::segment(2) === 'fnb' ? 'active' : '' }}">
                            <a href="{{route('reportFnB')}}">
                                <i class="ti-files"></i>
                                <span>On Progress Visit</span>
                            </a>
                        </li>
                        <li class="{{ Request::segment(1) === 'report' && Request::segment(2) === 'frontdesk' ? 'active' : '' }}">
                            <a href="{{route('reportFrontdesk')}}">
                                <i class="ti-files"></i>
                                <span>Visit Complete History</span>
                            </a>
                        </li>
                    </ul>
                </li>
                <li class="header nav-small-cap text-uppercase">CONFIGURATION </li>
                <li class="treeview {{ Request::segment(1) === 'areas' || Request::segment(1) === 'locations' || Request::segment(1) === 'sites' || Request::segment(1) === 'suppliers' || Request::segment(1) === 'device'|| Request::segment(1) === 'purpose-device'|| Request::segment(1) === 'supplier' || Request::segment(1) === 'purpose' || Request::segment(1) === 'tools' || Request::segment(1) === 'locations' ? 'active' : '' }}">
                    <a href="#">
                        <i class="ti-settings"></i>
                        <span>General Settings</span>
                        <span class="pull-right-container">
                            <i class="fa fa-angle-right pull-right"></i>
                        </span>
                    </a>
                    <ul class="treeview-menu">
                        <li class="pt-3 {{ Request::segment(1) === 'areas' ? 'active' : '' }}">
                            <a href="{{ url('areas') }}">
                                <i class="ti-location-pin"></i>
                                <span>Area</span>
                            </a>
                        </li>
                        <li class="pt-3 {{ Request::segment(1) === 'locations' ? 'active' : '' }}">
                            <a href="{{ url('locations') }}">
                                <i class="ti-location-pin"></i>
                                <span>Location</span>
                            </a>
                        </li>
                        <li class="pt-3 {{ Request::segment(1) === 'sites' ? 'active' : '' }}">
                            <a href="{{ url('sites') }}">
                                <i class="ti-location-pin"></i>
                                <span>Site</span>
                            </a>
                        </li>
                        <li class="pt-3 {{ Request::segment(1) === 'purpose' ? 'active' : '' }}">
                            <a href="{{ url('purpose') }}">
                                <i class="ti-pencil-alt2"></i>
                                <span>Purpose</span>
                            </a>
                        </li>
                        <li class="pt-3 {{ Request::segment(1) === 'suppliers' ? 'active' : '' }}">
                            <a href="{{ url('suppliers') }}">
                                <i class="ti-package"></i>
                                <span>Supplier</span>
                            </a>
                        </li>
                        <li class="pt-3 {{ Request::segment(1) === 'device' ? 'active' : '' }}">
                            <a href="{{ url('device') }}">
                                <i class="ti-mobile"></i>
                                <span>Device</span>
                            </a>
                        </li>
                        <li class="pt-3 {{ Request::segment(1) === 'purpose-device' ? 'active' : '' }}">
                            <a href="{{ url('purpose-device') }}">
                                <i class="ti-tablet"></i>
                                <span>Purpose Device</span>
                            </a>
                        </li>
                        <li class="pt-3 {{ Request::segment(1) === 'tools' ? 'active' : '' }}">
                            <a href="{{ url('tools') }}">
                                <i class="ti-hummer"></i>
                                <span>Tools</span>
                            </a>
                        </li>
                        <li class="pt-3 {{ Request::segment(1) === 'high-risk' ? 'active' : '' }}">
                            <a href="{{ url('high-risk') }}">
                                <i class="ti-hummer"></i>
                                <span>High Risk Tools</span>
                            </a>
                        </li>
                    </ul>
                </li>
                <li class="treeview {{ Request::segment(1) === 'vms-parameter' ? 'active' : '' }}">
                    <a href="#">
                        <i class="ti-settings"></i>
                        <span>Frontdesk</span>
                        <span class="pull-right-container">
                            <i class="fa fa-angle-right pull-right"></i>
                        </span>
                    </a>
                    <ul class="treeview-menu">
                        <li class="pt-3 {{ Request::segment(1) === 'vms-parameter' ? 'active' : '' }}">
                            <a href="{{ url('vms-parameter')}}">
                                <i class="ti-blackboard"></i>
                                <span>VMS</span>
                            </a>
                        </li>
                    </ul>
                </li>

            @endif
            @if (Auth::user()->user_type != 20 && Auth::user()->user_type != 30)
                <li class="header nav-small-cap text-uppercase">UTILITIES</li>
                <li class="{{ Request::segment(1) === 'my-profile' ? 'active' : '' }}">
                    <a href="{{ url('my-profile') }}">
                        <i class="ti-user"></i>
                        <span>My Profile</span>
                    </a>
                </li>
            @endif
            @if (Auth::user()->user_type == 99)
                <li class="{{ Request::segment(1) === 'user' || Request::segment(1) === 'userAdd' || Request::segment(1) === 'userEdit' ? 'active' : '' }}">
                    <a href="{{ url('user') }}">
                        <i class="ti-user"></i>
                        <span>User</span>
                    </a>
                </li>
            @endif
            <li>
                <a href="{{ route('logout') }}">
                    <i class="ti-power-off"></i>
                    <span>Help</span>
                </a>
            </li>
            <li>
                <a href="{{ route('logout') }}">
                    <i class="ti-power-off"></i>
                    <span>Log Out</span>
                </a>
            </li>
        </ul>
    </section>
</aside>
