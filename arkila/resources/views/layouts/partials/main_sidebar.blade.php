<aside class="main-sidebar">
    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">
        <!-- Sidebar user panel -->
        <div class="user-panel">
            <div class="pull-left image">
                <img src="dist/img/user2-160x160.jpg" class="img-circle" alt="User Image">
            </div>
            <div class="pull-left info">
                <p>Admin</p>
                <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
            </div>
        </div>
        <!-- search form -->
        <form action="#" method="get" class="sidebar-form">
            <div class="input-group">
                <input type="text" name="q" class="form-control" placeholder="Search...">
                <span class="input-group-btn">
                  <button type="submit" name="search" id="search-btn" class="btn btn-flat"><i class="fa fa-search"></i>
                  </button>
                </span>
            </div>
        </form>
        <!-- /.search form -->
        <!-- sidebar menu: : style can be found in sidebar.less -->
        <ul class="sidebar-menu" data-widget="tree">
            <li class="header">MAIN NAVIGATION</li>
            <li class="active">
                <a href="/home">
                    <i class="fa fa-dashboard"></i> <span>Dashboard</span>
                </a>
            </li>
            <li>
                <a href="#">
                    <i class="fa fa-ticket"></i>
                    <span>Ticket Management</span>
                </a>
            </li>
            <li class="treeview">
                <a href="#">
                    <i class="fa fa-book"></i>
                    <span>Rental and Resevation</span>
                    <span class="pull-right-container">
                      <i class="fa fa-angle-left pull-right"></i>
                    </span>
                </a>
                <ul class="treeview-menu">
                    <li><a href="{{route('rental.index')}}"><i class="fa fa-circle-o"></i> Rental</a></li>
                    <li><a href="{{route('reservations.index')}}"><i class="fa fa-circle-o"></i> Reservation</a></li>
                </ul>
            </li>
            <li class="treeview">
                <a href="#">
                    <i class="fa fa-users"></i>
                    <span>Personnel</span>
                    <span class="pull-right-container">
                      <i class="fa fa-angle-left pull-right"></i>
                    </span>
                </a>
                <ul class="treeview-menu">
                    <li><a href="{{route('operators.index')}}"><i class="fa fa-circle-o"></i> Operators</a></li>
                    <li><a href="{{route('drivers.index')}}"><i class="fa fa-circle-o"></i>Drivers</a></li>
                    <li><a href="{{route('vans.index')}}"><i class="fa fa-circle-o"></i>Vans</a></li>
                </ul>
            </li>
            <li class="treeview">
                <a href="#">
                    <i class="fa fa-bus"></i>
                    <span>Trips</span>
                    <span class="pull-right-container">
                      <i class="fa fa-angle-left pull-right"></i>
                    </span>
                </a>
                <ul class="treeview-menu">
                    <li><a href="{{route('trips.tripLog')}}"><i class="fa fa-circle-o"></i>Trip Log</a></li>
                    <li><a href="{{route('trips.driverReport')}}"><i class="fa fa-circle-o"></i> Driver Report</a></li>
                </ul>
            </li>
            <li class="treeview">
                <a href="#">
                    <i class="fa fa-calculator"></i>
                    <span>Accounting</span>
                    <span class="pull-right-container">
                      <i class="fa fa-angle-left pull-right"></i>
                    </span>
                </a>
                <ul class="treeview-menu">
                    <li><a href="{{route('ledger.index')}}"><i class="fa fa-circle-o"></i> Daily Ledger</a></li>
                    <li><a href="{{route('ledger.generalLedger')}}"><i class="fa fa-circle-o"></i> General Ledger</a></li>
                </ul>
            </li>
            <li class="header">SETTING</li>
            <li>
                <a href="{{route('settings.index')}}">
                    <i class="fa fa-gear"></i> <span>Settings</span>
                </a>
            </li>
            <li>
                <a href="{{route('usermanagement.dashboard')}}">
                    <i class="fa fa-male"></i> <span>User Management</span>
                </a>
            </li>
            <li>
                <a href="{{route('archive.index')}}">
                    <i class="fa fa-archive"></i> <span>Operator Archive</span>
                </a>
            </li>

            <li>
                <a href="{{route('logout')}}" onclick="event.preventDefault();
                            document.getElementById('logout-form').submit();">
            <i class="fa fa-sign-out"></i>
            <span>Sign Out</span>
          </a>
          <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
            {{csrf_field()}}
          </form>
            </li>
        </ul>
    </section>
    <!-- /.sidebar -->
</aside>