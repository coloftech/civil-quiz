<?php 

$page = $this->input->get('p') ? $this->input->get('p') : 'bilar';


 ?>

<!-- Fixed navbar -->
        <nav id="header" class="navbar navbar-fixed-top">
            <div id="header-container" class="container navbar-container">
                <div class="navbar-header">
                    <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
                        <span class="sr-only">Toggle navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>
                    <a id="brand" class="navbar-brand" href="<?=site_url();?>"><div class="logo"><img src="<?=base_url('public/images/bisu-logo.png');?>"></div> </a>
                    
                    <a id="brand" class="navbar-brand" href="<?=site_url();?>"><div class="title"><div class="subtitle">Bohol Island State University</div>Bilar Campus</div> </a>

                </div>
                <div id="navbar" class="collapse navbar-collapse">
                    <div class="nav navbar-nav"></div>
                    <ul class="nav navbar-nav">

                                  
                               <?php if ($this->auto_m->getColleges(2)): ?>
                              
                            <li class="dropdown home">
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><i class="fa fa-home"></i></i> <span class="caret"></span></a>
                                <ul class="dropdown-menu">
                                    <?php echo $this->auto_m->getColleges(2); ?>

                                </ul>
                          </li>
                          
                          <?php endif ?>
                          <?php if ($this->auto_m->getColleges(1)): ?>
                              
                            <li class="dropdown home">
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Colleges <span class="caret"></span></a>
                                <ul class="dropdown-menu">
                                    <?php echo $this->auto_m->getColleges(1); ?>

                                </ul>
                          </li>
                          
                          <?php endif ?>

                         

                          <?php echo $this->auto_m->menu_top(); ?>
                      <?php /*  <li><a href='<?=site_url("c=site&f=view&p=$page&i=about");?>'>About</a></li>
                        <li><a href='<?=site_url("c=site&f=view&p=$page&i=services");?>'>Services</a></li>
                        */ ?>
                        <li class="hidden"><a href="<?=site_url("c=site&f=view&p=$page&i=contact");?>">Contact</a></li>
                        <?php if ($this->permission->is_loggedIn()): ?>

                        <li><a href="<?=site_url("c=administration");?>">Administration</a></li>
                        <li><a href="<?=site_url("c=site&f=logout");?>">Logout</a></li>
                        <?php else: ?>
                        <li><a href="<?=site_url("c=site&f=login");?>">Login</a></li>
                        <?php endif ?>

                    </ul>
                </div><!-- /.nav-collapse -->
            </div><!-- /.container -->
        </nav><!-- /.navbar -->