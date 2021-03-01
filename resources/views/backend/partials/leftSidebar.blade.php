<!-- Left side column. contains the logo and sidebar -->
<aside class="main-sidebar">

    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">

        <!-- Sidebar user panel -->
        <div class="user-panel">
            <div class="pull-left image">
                <a href="{{ route('profile.show', Auth::user()->id ) }}"><img alt="User Image" class="img-circle"
                                                                              src="{{ asset('themes/admin/dist/img/user2-160x160.jpg') }}"></a>
            </div>
            <div class="pull-left info">
                <p><a href="{{ route('profile.show', Auth::user()->id ) }}">{{ Auth::user()->firstname }}</a></p>
                <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
            </div>
        </div>

        <!-- search form -->
        <form action="#" class="sidebar-form" method="get">
            <div class="input-group">
                <input class="form-control" name="q" placeholder="Search..." type="text">
                <span class="input-group-btn">
          <button class="btn btn-flat" id="search-btn" name="search" type="submit"><i class="fa fa-search"></i></button>
        </span>
            </div>
        </form>
        <!-- /.search form -->

        <!-- sidebar menu: : style can be found in sidebar.less -->
        <ul class="sidebar-menu" data-widget="tree">
            <li class="header">MAIN NAVIGATION</li>
            <li><a href="{{ url('home') }}"><i class="fa fa-home"></i>Dashboard</a></li>

            <li class="treeview">
                <a href="#">
                    <i class="fa fa-life-ring"></i>
                    <span>Buoys</span>
                    <span class="pull-right-container"><i class="fa fa-angle-left pull-right"></i></span>
                </a>
                <ul class="treeview-menu">
                    <li><a href="/buoys/create"><i class="fa fa-circle-o"></i>Create Buoy</a></li>
                    <li><a href="/buoys"><i class="fa fa-circle-o"></i>View Buoys</a></li>
                </ul>
            </li>

            <li class="treeview">
                <a href="#">
                    <i class="fa fa-life-ring"></i>
                    <span>Qumatiks</span>
                    <span class="pull-right-container"><i class="fa fa-angle-left pull-right"></i></span>
                </a>
                <ul class="treeview-menu">
                    <li><a href="/qumatiks/create"><i class="fa fa-circle-o"></i>Create Qumatik</a></li>
                    <li><a href="/qumatiks"><i class="fa fa-circle-o"></i>View Qumatiks</a></li>
                </ul>
            </li>


            <li class="treeview">
                <a href="#">
                    <i class="fa fa-users"></i>
                    <span>Communities</span>
                    <span class="pull-right-container"><i class="fa fa-angle-left pull-right"></i></span>
                </a>
                <ul class="treeview-menu">
                    <li><a href="{{ route('communities.create') }}"><i class="fa fa-circle-o"></i>Create Community</a></li>
                    <li><a href="{{ route('communities.index') }}"><i class="fa fa-circle-o"></i>View Communities</a></li>
                </ul>
            </li>


            <li><a href="{{ route('report.index') }}"><i class="fa fa-file"></i>Generate Report</a></li>


            <li class="treeview">
                <a href="#">
                    <i class="fa fa-user"></i>
                    <span>User</span>
                    <span class="pull-right-container"><i class="fa fa-angle-left pull-right"></i></span>
                </a>
                <ul class="treeview-menu">
                    <li><a href="{{ url('users/all/') }}"><i class="fa fa-circle-o"></i><span>All Users</span></a></li>
                    <li><a href="{{ url('registeruser') }}"><i class="fa fa-circle-o"></i><span>Register User</span></a>
                    </li>
                </ul>
            </li>

            <li class="header">Other Options</li>

            <li><a href="#" class="btn btn-success btn-xs custom-btn"><i
                        class="fa fa-download"></i><span>Pull Data</span></a></li>
        </ul>
    </section>
    <!-- /.sidebar -->
</aside>


