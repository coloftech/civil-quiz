    <div class="row">

      <div class="col-md-12" id="search-top-menu">
        <div class="bisu-logo">
          <nav class="navbar navbar-inverse">
                  <!-- Brand and toggle get grouped for better mobile display -->
                  <div class="navbar-header">
                      <button type="button" data-target="#navbarCollapse" data-toggle="collapse" class="navbar-toggle">
                          <span class="sr-only">Toggle navigation</span>
                          <span class="icon-bar"></span>
                          <span class="icon-bar"></span>
                          <span class="icon-bar"></span>
                      </button>
                      <a class="navbar-brand" href="<?=site_url();?>"><img src="<?=base_url('public/images/gg-logo-5.png')?>"></a>
                  </div>

                  <!-- Collection of nav links, forms, and other content for toggling -->
                  <div id="navbarCollapse" class="collapse navbar-collapse">
                      
                      <ul class="nav navbar-nav navbar-right">

                          <li class="<?php  ?>"><a href="<?php echo site_url(); ?>"><i class="fa fa-home"></i> Home</a></li>
                          <?php
                          if ($this->aauth->is_loggedin()) {
                          	# code...
                          	?>
                          <li class="<?php ?>"><a href="<?=site_url('ref=user&com=timeline&user='.$this->session->userdata('username'));?>"><i class="fa fa-user"></i> Profile</a></li>
                          <li class="dropdown <?php  ?>">
                              <a data-toggle="dropdown" class="dropdown-toggle" href="#"><i class="fa fa-envelope"></i> Messages <b class="caret"></b></a>
                              <ul class="dropdown-menu">
                                  <li><a href="<?php echo site_url(); ?>?ref=message&com=compose">Compose</a></li>
                                  <li><a href="<?php echo site_url(); ?>?ref=message&com=inbox">Inbox</a></li>
                                  <li><a href="<?php echo site_url(); ?>?ref=message&com=sents">Sent Items</a></li>
                                  <li class="divider"></li>
                                  <li><a href="<?php echo site_url(); ?>?ref=user&com=trash">Trash</a></li>
                              </ul>
                          </li>
                          <?php if ($this->aauth->is_admin()) {
                            # code...
                            ?> 
                          <li><a href="<?=site_url('ref=administration&com=dashboard');?>"><i class="fa fa-gears"></i> <span>Panel</span></a></li>
                     
                            <?php
                          } ?>
                     
                          <li><a href="<?=site_url('ref=home&com=logout');?>"><i class="fa fa-power-off"></i> <span>Logout</span></a></li>

                          <?php } ?>

                          <?php 
                          if (!$this->aauth->is_loggedin()) {
                          	# code...
                          	echo "
                          	<li><a href='".site_url('ref=home&com=about')."'><i class=\"fa fa-question\"></i> <span>About</span></a></li>
                            <li><a href='".site_url('ref=home&com=contact')."'><i class=\"fa fa-envelope\"></i> <span>Contact</span></a></li>
                          	
                          	";
                          }

                          ?>
                      </ul>
                      <ul class="nav navbar-nav navbar-right <?php if (!isset($submenu)): ?>
                        hidden
                      <?php endif ?>">
                      <?php if (isset($submenu)): ?>
                        <?php foreach ($submenu as $key): ?>
                          <li><a href="<?php echo site_url($key->link);?> "><?php echo $key->title; ?></a></li>
                        <?php endforeach ?>
                      <?php endif ?>
                      </ul>
                  </div>
              </nav>

        </div>              
      </div>
      <div class="row">
          
      </div>
    </div> <!-- div row -->