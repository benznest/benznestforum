
        <!-- Navigation -->
        <nav class="navbar navbar-inverse" role="navigation" style="margin-top:10px;">
            <!-- Brand and toggle get grouped for better mobile display -->
            <!-- Sidebar Menu Items - These collapse to the responsive navigation menu on small screens -->
                <ul class="nav navbar-nav side-nav">
                    <li <?php if($admin_tab=="general"){echo"class='active'";} ?>>
                        <a href="{{url('admin/general')}}"><i class="fa fa-fw fa-dashboard"></i> General</a>
                    </li>
                     <li <?php if($admin_tab=="category"){echo"class='active'";} ?>>
                        <a href="{{url('admin/category')}}"><i class="fa fa-fw fa-table"></i> Category</a>
                    </li>
                    <li <?php if($admin_tab=="tag"){echo"class='active'";} ?>>
                        <a href="{{url('admin/tag')}}"><i class="glyphicon glyphicon-tags"></i> Tag</a>
                    </li>
                    <li <?php if($admin_tab=="topic"){echo"class='active'";} ?>>
                        <a href="{{url('admin/topic')}}"><i class="fa fa-fw fa-edit"></i> Topic</a>
                    </li>
                    <li <?php if($admin_tab=="account"){echo"class='active'";} ?>>
                        <a href="{{url('admin/account')}}"><i class="glyphicon glyphicon-user"></i> Account</a>
                    </li>
                     <li>
                        <a href="{{url('admin/request')}}"><i class="fa fa-fw fa-desktop"></i> Request</a>
                    </li>
                    <li <?php if($admin_tab=="statistics"){echo"class='active'";} ?>>
                        <a href="{{url('admin/statistics')}}"><i class="fa fa-fw fa-bar-chart-o"></i> Statistics</a>
                    </li>
                    <!--
                    <li>
                        <a href="javascript:;" data-toggle="collapse" data-target="#demo"><i class="fa fa-fw fa-arrows-v"></i> Dropdown <i class="fa fa-fw fa-caret-down"></i></a>
                        <ul id="demo" class="collapse">
                            <li>
                                <a href="#">Dropdown Item</a>
                            </li>
                            <li>
                                <a href="#">Dropdown Item</a>
                            </li>
                        </ul>
                    </li>
                    -->
                </ul>
            </div>
            <!-- /.navbar-collapse -->
        </nav>