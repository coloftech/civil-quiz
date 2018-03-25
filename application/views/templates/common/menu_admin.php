<nav class="navbar navbar-default-primary navbar-fixed-top" role="navigation">
        <!-- Brand and toggle get grouped for better mobile display -->
        <div class="navbar-header">
            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-ex1-collapse">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="<?=site_url('admin');?>">
                <img src="<?=base_url('public/images/logo-only.png');?>">
                <label class="big">COLOFTECH</label>
                <label class="small">State of the Arts &amp; Technology</label>
            </a>
        </div>
        <!-- Top Menu Items -->
        <ul class="nav navbar-right top-nav">
            <li><a href="<?=site_url();?>" data-placement="bottom" data-toggle="tooltip" href="#" data-original-title="Stats">Visit site
                </a>
            </li>            
            <li><a href="#" data-placement="bottom" data-toggle="tooltip" href="#" data-original-title="Stats"><i class="fa fa-bar-chart-o"></i>
                </a>
            </li>            
            <li class="dropdown user-profile" >
                <a href="#" class="dropdown-toggle" data-toggle="dropdown"><?=$this->session->userdata['username'];?></a>
                <ul class="dropdown-menu">
                    <li><a href="<?=site_url('user/profile');?>"><i class="fa fa-fw fa-user"></i> Edit Profile</a></li>
                    <li><a href="<?=site_url('user/change_pass');?>"><i class="fa fa-fw fa-cog"></i> Change Password</a></li>
                    <li class="divider"></li>
                    <li><a href="<?=site_url("logout");?>"><i class="fa fa-fw fa-power-off"></i> Logout</a></li>
                </ul>
            </li>
        </ul>
        <!-- Sidebar Menu Items - These collapse to the responsive navigation menu on small screens -->
        <div class="collapse navbar-collapse navbar-ex1-collapse">
            <ul class="nav navbar-nav side-nav">
                <li><a href="<?=site_url('admin');?>"><i class="fa fa-fw fa-home"></i>Dashboard</a></li>
                

                <li>
                    <a href="#" data-toggle="collapse" data-target="#submenu-2"><i class="fa fa-fw fa-book"></i>  Quiz Setting<i class="fa fa-fw fa-angle-down pull-right"></i></a>
                    <ul id="submenu-2" class="collapse">

                        <li><a href="<?=site_url('quiz/create');?>"><i class="fa fa-angle-double-right"></i> Create a quiz</a></li>
                        <li><a href="<?=site_url('quiz/list_exam');?>"><i class="fa fa-angle-double-right"></i> List all exam</a></li>
                        <li><a href="<?=site_url('quiz/list_questions');?>"><i class="fa fa-angle-double-right"></i> List all question</a></li>
                        <li><a href="<?=site_url('quiz/takeaquiz');?>"><i class="fa fa-angle-double-right"></i> Take a quiz</a></li>

                    </ul>
                </li>

                <li>
                    <a href="#" data-toggle="collapse" data-target="#subject"><i class="fa fa-fw fa-book"></i>  Category Setting<i class="fa fa-fw fa-angle-down pull-right"></i></a>
                    <ul id="subject" class="collapse">

                        <li><a href="<?=site_url('subject');?>"><i class="fa fa-angle-double-right"></i> View all</a></li>
                        <li><a href="<?=site_url('subject/create');?>"><i class="fa fa-angle-double-right"></i> New</a></li>

                    </ul>
                </li>

                <li>
                    <a href="#" data-toggle="collapse" data-target="#site_setting"><i class="fa fa-fw fa-globe"></i>  Site setting <i class="fa fa-fw fa-angle-down pull-right"></i></a>

                    <ul id="site_setting"  class="collapse">
                        <li><a href="<?=site_url('admin/sites/new')?>">New site</a></li>
                        <li><a href="<?=site_url('admin/sites');?>">List sites</a></li>

                    </ul>
                </li>
                <li>
                    <a href="#" data-toggle="collapse" data-target="#page"><i class="fa fa-fw fa-file-powerpoint-o"></i> Page setting <i class="fa fa-fw fa-angle-down pull-right"></i></a>

                    <ul id="page"  class="collapse">
                        <li><a href="<?=site_url('pages/add_page')?>">New page</a></li>
                        <li><a href="<?=site_url('pages')?>">List pages</a></li>

                    </ul>
                </li>
                        <?php if ($this->permission->is_admin  ()): ?>
                            
                 <li>
                    <a href="#" data-toggle="collapse" data-target="#user"><i class="fa fa-fw fa-users"></i> User setting<i class="fa fa-fw fa-angle-down pull-right"></i></a>
                    <ul id="user" class="collapse">
                        <li><a href="<?=site_url('user/create');?>"><i class="fa fa-angle-double-right"></i> New user</a></li>
                        <li><a href="<?=site_url('user');?>"><i class="fa fa-angle-double-right"></i> List users</a></li>                        
                        <li><a href="<?=site_url('user/permission');?>"><i class="fa fa-angle-double-right"></i> Permission</a></li>

                    </ul>
                </li>
                        <?php endif ?>


                <li><a href="<?=site_url('admin/create_zip');?>"><i class="fa fa-fw fa-home"></i>Backup</a></li>
            </ul>
        </div>
        <!-- /.navbar-collapse -->
    </nav>