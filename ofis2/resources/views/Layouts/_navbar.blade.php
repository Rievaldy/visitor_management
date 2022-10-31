<header class="main-header">
    <!-- Logo -->
    <a href="javascript:void(0);" class="logo">
        <!-- mini logo -->
        <!-- logo-->
        <div class="logo-lg">
            <span class="dark-logo"><img src="{{ asset('img/logo.png') }}" style="height: 52px" alt="logo"></span>
            <span class="light-logo"><img src="{{ asset('img/logo.png') }}" style="height: 52px" alt="logo"></span>
        </div>
        <div class="logo-mini">
            <span class="dark-logo"><img src="{{ asset('img/favicon.png') }}" style="height: 52px" alt="logo"></span>
            <span class="light-logo"><img src="{{ asset('img/favicon.png') }}" style="height: 52px" alt="logo"></span>
        </div>
    </a>
    <!-- Header Navbar -->
    <nav class="navbar navbar-static-top">
        <!-- Sidebar toggle button-->
        <div>
            <a href="#" class="sidebar-toggle" data-toggle="push-menu" role="button">
            <i class="ti-align-left"></i>
            </a>
        </div>
        <div class="navbar-custom-menu r-side">
            <ul class="nav navbar-nav">
                <!-- Messages -->
                {{-- <li class="dropdown messages-menu">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                    <i class="mdi mdi-email"></i>
                    </a>
                    <ul class="dropdown-menu animated bounceIn">
                        <li class="header">
                            <div class="p-20 bg-light">
                                <div class="flexbox">
                                    <div>
                                        <h4 class="mb-0 mt-0">Messages</h4>
                                    </div>
                                    <div>
                                        <a href="#" class="text-danger">Clear All</a>
                                    </div>
                                </div>
                            </div>
                        </li>
                        <li>
                            <ul class="menu sm-scrol">
                                <li>
                                    <a href="#">
                                        <div class="pull-left">
                                            <img src="{{ asset('img/avatar/user2-160x160.jpeg') }}" class="rounded-circle" alt="User Image">
                                        </div>
                                        <div class="mail-contnet">
                                            <h4>
                                                Lorem Ipsum
                                                <small><i class="fa fa-clock-o"></i> 15 mins</small>
                                            </h4>
                                            <span>Lorem ipsum dolor sit amet, consectetur adipiscing elit.</span>
                                        </div>
                                    </a>
                                </li>
                                <li>
                                    <a href="#">
                                        <div class="pull-left">
                                            <img src="{{ asset('img/avatar/user3-128x128.jpeg') }}" class="rounded-circle" alt="User Image">
                                        </div>
                                        <div class="mail-contnet">
                                            <h4>
                                                Nullam tempor
                                                <small><i class="fa fa-clock-o"></i> 4 hours</small>
                                            </h4>
                                            <span>Curabitur facilisis erat quis metus congue viverra.</span>
                                        </div>
                                    </a>
                                </li>
                                <li>
                                    <a href="#">
                                        <div class="pull-left">
                                            <img src="{{ asset('img/avatar/user3-128x128.jpeg') }}" class="rounded-circle" alt="User Image">
                                        </div>
                                        <div class="mail-contnet">
                                            <h4>
                                                Proin venenatis
                                                <small><i class="fa fa-clock-o"></i> Today</small>
                                            </h4>
                                            <span>Vestibulum nec ligula nec quam sodales rutrum sed luctus.</span>
                                        </div>
                                    </a>
                                </li>
                                <li>
                                    <a href="#">
                                        <div class="pull-left">
                                            <img src="{{ asset('img/avatar/user3-128x128.jpeg') }}" class="rounded-circle" alt="User Image">
                                        </div>
                                        <div class="mail-contnet">
                                            <h4>
                                                Praesent suscipit
                                                <small><i class="fa fa-clock-o"></i> Yesterday</small>
                                            </h4>
                                            <span>Curabitur quis risus aliquet, luctus arcu nec, venenatis neque.</span>
                                        </div>
                                    </a>
                                </li>
                                <li>
                                    <a href="#">
                                        <div class="pull-left">
                                            <img src="{{ asset('img/avatar/user4-128x128.jpeg') }}" class="rounded-circle" alt="User Image">
                                        </div>
                                        <div class="mail-contnet">
                                            <h4>
                                                Donec tempor
                                                <small><i class="fa fa-clock-o"></i> 2 days</small>
                                            </h4>
                                            <span>Praesent vitae tellus eget nibh lacinia pretium.</span>
                                        </div>
                                    </a>
                                </li>
                            </ul>
                        </li>
                        <li class="footer">
                            <a href="#" class="bg-light">See all Messages</a>
                        </li>
                    </ul>
                </li> --}}
                <!-- Notifications -->
                {{-- <li class="dropdown notifications-menu">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                    <i class="mdi mdi-bell"></i>
                    </a>
                    <ul class="dropdown-menu animated bounceIn">
                        <li class="header">
                            <div class="bg-light p-20">
                                <div class="flexbox">
                                    <div>
                                        <h4 class="mb-0 mt-0">Notifications</h4>
                                    </div>
                                    <div>
                                        <a href="#" class="text-danger">Clear All</a>
                                    </div>
                                </div>
                            </div>
                        </li>
                        <li>
                            <ul class="menu sm-scrol">
                                <li>
                                    <a href="#">
                                    <i class="fa fa-users text-info"></i> Curabitur id eros quis nunc suscipit blandit.
                                    </a>
                                </li>
                                <li>
                                    <a href="#">
                                    <i class="fa fa-warning text-warning"></i> Duis malesuada justo eu sapien elementum, in semper diam posuere.
                                    </a>
                                </li>
                                <li>
                                    <a href="#">
                                    <i class="fa fa-users text-danger"></i> Donec at nisi sit amet tortor commodo porttitor pretium a erat.
                                    </a>
                                </li>
                                <li>
                                    <a href="#">
                                    <i class="fa fa-shopping-cart text-success"></i> In gravida mauris et nisi
                                    </a>
                                </li>
                                <li>
                                    <a href="#">
                                    <i class="fa fa-user text-danger"></i> Praesent eu lacus in libero dictum fermentum.
                                    </a>
                                </li>
                                <li>
                                    <a href="#">
                                    <i class="fa fa-user text-primary"></i> Nunc fringilla lorem
                                    </a>
                                </li>
                                <li>
                                    <a href="#">
                                    <i class="fa fa-user text-success"></i> Nullam euismod dolor ut quam interdum, at scelerisque ipsum imperdiet.
                                    </a>
                                </li>
                            </ul>
                        </li>
                        <li class="footer">
                            <a href="#" class="bg-light">View all</a>
                        </li>
                    </ul>
                </li> --}}
                <!-- Tasks-->
                {{-- <li class="dropdown tasks-menu">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                    <i class="mdi mdi-bulletin-board"></i>
                    </a>
                    <ul class="dropdown-menu animated bounceIn">
                        <li class="header">
                            <div class="p-20 bg-light">
                                <div class="flexbox">
                                    <div>
                                        <h4 class="mb-0 mt-0">Tasks</h4>
                                    </div>
                                    <div>
                                        <a href="#" class="text-danger">Clear All</a>
                                    </div>
                                </div>
                            </div>
                        </li>
                        <li>
                            <ul class="menu sm-scrol">
                                <li>
                                    <a href="#">
                                        <h3>
                                            Lorem ipsum dolor sit amet
                                            <small class="pull-right">30%</small>
                                        </h3>
                                        <div class="progress xs">
                                            <div class="progress-bar progress-bar-danger" style="width: 30%" role="progressbar"
                                                aria-valuenow="20" aria-valuemin="0" aria-valuemax="100">
                                                <span class="sr-only">30% Complete</span>
                                            </div>
                                        </div>
                                    </a>
                                </li>
                                <li>
                                    <a href="#">
                                        <h3>
                                            Vestibulum nec ligula
                                            <small class="pull-right">20%</small>
                                        </h3>
                                        <div class="progress xs">
                                            <div class="progress-bar progress-bar-info" style="width: 20%" role="progressbar"
                                                aria-valuenow="20" aria-valuemin="0" aria-valuemax="100">
                                                <span class="sr-only">20% Complete</span>
                                            </div>
                                        </div>
                                    </a>
                                </li>
                                <li>
                                    <a href="#">
                                        <h3>
                                            Donec id leo ut ipsum
                                            <small class="pull-right">70%</small>
                                        </h3>
                                        <div class="progress xs">
                                            <div class="progress-bar progress-bar-success" style="width: 70%" role="progressbar"
                                                aria-valuenow="20" aria-valuemin="0" aria-valuemax="100">
                                                <span class="sr-only">70% Complete</span>
                                            </div>
                                        </div>
                                    </a>
                                </li>
                                <li>
                                    <a href="#">
                                        <h3>
                                            Praesent vitae tellus
                                            <small class="pull-right">40%</small>
                                        </h3>
                                        <div class="progress xs">
                                            <div class="progress-bar progress-bar-warning" style="width: 40%" role="progressbar"
                                                aria-valuenow="20" aria-valuemin="0" aria-valuemax="100">
                                                <span class="sr-only">40% Complete</span>
                                            </div>
                                        </div>
                                    </a>
                                </li>
                                <li>
                                    <a href="#">
                                        <h3>
                                            Nam varius sapien
                                            <small class="pull-right">80%</small>
                                        </h3>
                                        <div class="progress xs">
                                            <div class="progress-bar progress-bar-primary" style="width: 80%" role="progressbar"
                                                aria-valuenow="20" aria-valuemin="0" aria-valuemax="100">
                                                <span class="sr-only">80% Complete</span>
                                            </div>
                                        </div>
                                    </a>
                                </li>
                                <li>
                                    <a href="#">
                                        <h3>
                                            Nunc fringilla
                                            <small class="pull-right">90%</small>
                                        </h3>
                                        <div class="progress xs">
                                            <div class="progress-bar progress-bar-info" style="width: 90%" role="progressbar"
                                                aria-valuenow="20" aria-valuemin="0" aria-valuemax="100">
                                                <span class="sr-only">90% Complete</span>
                                            </div>
                                        </div>
                                    </a>
                                </li>
                            </ul>
                        </li>
                        <li class="footer">
                            <a href="#" class="bg-light">View all tasks</a>
                        </li>
                    </ul>
                </li> --}}
                <!-- User Account-->
                <li class="dropdown user user-menu">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                        @if( Auth::user()->img != null)
                            <img src="{{ Auth::user()->img }}" class="user-image rounded-circle" alt="User Image">
                        @else
                            <img src="{{ asset('img/avatar/default-avatar.png') }}" class="user-image rounded-circle" alt="User Image">
                        @endif

                    </a>
                    <ul class="dropdown-menu animated flipInX">
                        <!-- User image -->
                        <li class="user-header bg-img" style="background-image: url({{ asset('img/user-info.jpeg') }})" data-overlay="3">
                            <div class="flexbox align-self-center">
                                @if( Auth::user()->img != null)
                                    <img src="{{ Auth::user()->img }}" class="float-left rounded-circle" alt="User Image">
                                @else
                                    <img src="{{ asset('img/avatar/default-avatar.png') }}" class="float-left rounded-circle" alt="User Image">
                                @endif
                                <h4 class="user-name align-self-center">
                                    <span>{{ Auth::user()->name }}</span>
                                    <small>{{ Auth::user()->email }}</small>
                                </h4>
                            </div>
                        </li>
                        <li class="user-body">
                            {{-- <a class="dropdown-item" href="javascript:void(0)"><i class="ion ion-person"></i> My Profile</a> --}}
                            {{-- <a class="dropdown-item" href="javascript:void(0)"><i class="ion ion-bag"></i> My Balance</a> --}}
                            {{-- <a class="dropdown-item" href="javascript:void(0)"><i class="ion ion-email-unread"></i> Inbox</a> --}}
                            {{-- <div class="dropdown-divider"></div> --}}
                            {{-- <a class="dropdown-item" href="javascript:void(0)"><i class="ion ion-settings"></i> Account Setting</a> --}}
                            {{-- <div class="dropdown-divider"></div> --}}
                            <div class="p-10"><a href="{{ url('my-profile') }}" class="btn btn-sm btn-rounded btn-success">View Profile</a></div>
                            <div class="dropdown-divider"></div>
                            <a class="dropdown-item" href="{{ route('logout') }}"><i class="ion-log-out"></i> Logout</a>
                        </li>
                    </ul>
                </li>
            </ul>
        </div>
    </nav>
</header>
