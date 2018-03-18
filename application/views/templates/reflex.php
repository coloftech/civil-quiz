<!DOCTYPE html>
<html>
 
    <head>

<meta charset="UTF-8" />
<meta name="viewport" content="width=device-width, minimum-scale=1.0, initial-scale=1.0">

<meta name="propeller" content="6db29e64f9cb4b5e95f5e9b6bd5fd21b" />
<meta http-equiv="refresh" content="108000">
<meta name="description" content="Coloftech State of the Arts & technology">
<meta name="author" content="Harold Rita" />
<meta name="keywords" content="coloftech state of the arts & technology, <?php echo isset($metakey) ? $metakey : ''; ?> " />

        <title><?php echo isset($title) ? 'COLOFTECH | '.$title: 'COLOFTECH'; ?></title>
        <link rel="shortcut icon" href="<?=base_url();?>public/images/logo-only-icon.png"/>
        <link rel="stylesheet" type="text/css" href="<?=base_url();?>public/assets/bootstrap/css/bootstrap.min.css">  
        <link rel="stylesheet" type="text/css" href="<?=base_url();?>public/assets/bootstrap/css/font-awesome.css">        
        <link href="<?=base_url('public/assets/css/animate.css');?>" rel="stylesheet">
            <?php // add css files
        $this->minify->css(array('animate.css','bootstrap-datetimepicker.min.css','col-style-two.css','print.css'));
        echo $this->minify->deploy_css();
        
    ?>

        <!-- CORE PLUGINS -->
        <script src="<?=base_url('public/assets/js/jquery.11.min.js');?>" type="text/javascript"></script>
        <script src="<?=base_url('public/assets/bootstrap/js/bootstrap.min.js');?>" type="text/javascript"></script>
        <script src="<?=base_url('assets/js/notify/dist/notify.js');?>" type="text/javascript"></script>
    </head>
 
    <body class="<?php echo isset($home) ? 'home' : ''; ?>">
    <?php /*
<script type="text/javascript" src="//go.oclasrv.com/apu.php?zoneid=1440862"></script> */ ?>

    <div class="wrapper header <?php echo isset($home) ? 'coloftech-header' : 'coloftech-subheader'; ?>">
        <div class="container ">

        <div class="col-md-12 header-top">

        <div class="col-md-3 left-header"></div>
        <div class="col-md-6 login-header">
        <?php if(!$this->aauth->is_loggedin()){?>
           <?php  require_once VIEWPATH."home/login.php";
             ?>
            <?php } ?>
            </div>
        <div class="col-md-3 pull-right right-header">

            <ul class="top-menu ">
            <li><a href=""><i calss="fa-facebook"></i></a></li>
        <?php if(!$this->aauth->is_loggedin()){?> 
            <li><a href=""><i class="fa fa-plus"></i>&nbsp;Register</a></li>
            <li><a href="javascript:void(0);" onclick="showlogin();"><i class="fa fa-sign-in"></i>&nbsp;Login</a></li>
           
            <?php } ?>

            </ul>
        </div>

        </div>
            
        </div>
        <div class="container">
        <div class="col-md-12">
     <?php require_once 'common/reflex_menu.php'; ?>
        </div>
        </div>
             <div class="container body-blank-space">
             <div class="row">
                 <div class="ads">
                 </div>
             </div>
             <div class="row">

                 <div class="slider-show">
                    <?php
                    if (isset($carousel)) {
                         # code...
                        //echo 'carousel';
                        require_once 'common/carousel.php';
                     } ?>
                 </div>
             </div>
             </div>

</div>
<div class="breaker-full"></div>
        <div class="wrapper body">
                <div class="container">

            <div class="col-md-12 announcements">
            </div>

            <div class="row">
                <div class="col-md-12 content">

                    <?php echo $body; ?>
                </div>
            </div>
             </div>
             <?php $this->pagecounter->run_counter();?>
        </div>
<?php if (isset($home)) { ?>
<div class="footer footer-recents">
    <div class="wrapper">
        <div class="container">
        <div class="col-md-12">
            <div class="col-md-3" id="about"><h4>About us</h4>
            <div class="col-md-12">
                <p><label>Company</label></p>
            <p><span>Coloftech | State of the Arts &amp; Technology</span></p>
            </div>
            <div class="col-md-12">
                <p><label>Email</label></p>
            <p><span>info@coloftech.com</span></p>
            </div>

            <div class="col-md-12">
                <p><label>Address</label></p>
            <p><span>Quezon City Philippines</span></p>
            </div>
            
            </div>
            <div class="col-md-6 " id="contact">
                <!--

            <form class="form" action="#" method="post" id="frmcontactus" name="frmcontactus"><h4>Contact Us</h4>
                <div class="form-group"><input type="text" name="email" id="name" class="form-control" placeholder="Your name"></div>
                <div class="form-group"><input type="email" name="email" id="email" class="form-control" placeholder="Your email">
                </div>
                <div class="form-group"><input type="text" name="subject" id="subject" class="form-control" placeholder="Your subject">
                </div>
                <div class="form-group"><textarea name="message" id="message" class="form-control" rows="4" placeholder="Your message"></textarea>
                </div>
                <div class="math-captcha form-inline" >
                <div class="math-captcha form-inline" >
                    <canvas id='canvas' class="form-control" style="width:220px;display:inline-block;background:#e5e5e5;height:50px;"></canvas>
                    
                    <input type="number" id="total" name="total" class="form-control" placeholder="Enter total here">
                </div>  
                </div>  
                    <br />
                <div class="form-group">
                    <label></label><button type="button" class="btn btn-info" style="width:100px">Send</button>
                </div>
            </form>
            -->
            </div>
            <div class="col-md-3" id="mostviews"><h4>Most read</h4>
            <ul>

        <?php
        /*if (isset($posts)) {
            # code...
            if(is_array($posts)){

         foreach ($posts as $key2) {

        //echo "<li>(0) | <a href='".site_url('post/read/$key->slug')."' style='font-size:11px;'> $key2->title </a></li>";
            }
            }
        }*/
        ?>


            </ul></div>
        </div>
        </div>
    </div>
</div>
<script type="text/javascript">


function draw() {
  var ctx = document.getElementById('canvas').getContext('2d');
  ctx.font = '78px serif';
  ctx.fillText('<?php echo $h_number1;?> + <?php echo $h_number2;?>' , 20, 100);
}

//draw();

</script>
<?php } ?>
<div class="footer footer-bottom"></div>
                <footer class="footer navbar-fixed-bottom">
                <div class="wrapper">
                    <div class="container">

                    <div class="col-md-6 footer-left"></div>
                    <div class="col-md-6 footer-rigth"></div>
                    <div class="col-md-12 footer-full">
                    <span>Copyright @ <a href="<?=site_url();?> " class="t-link">COLOFTECH | State of the Arts and Technology </a>2016-2017</span>
                    <span style="display:inline-block;"><i class='v-line'></i>Visitors <a href="#" class="t-link"><?=$this->pagecounter->visit_total();?></a></span>
                    </div>
                        
                    </div>
                </div>

                </footer>


        <?php if ($this->aauth->is_loggedin()): ?>
            
        <script src="<?=base_url('public/assets/bootstrap/dt/js/bootstrap-datetimepicker.min.js');?>" type="text/javascript"></script>
        <?php endif ?>
         
        <!-- niceDIT! text area html editor -->
        
        <script type="text/javascript" src="<?=base_url('assets/js/col-script.js');?>"></script>

     <?php if(!$this->aauth->is_loggedin()){?>
        <script type="text/javascript">

        $(function(){
            $('#frmcontactus').on('submit',function(){
                return false;
            })

        });
        </script>
    <?php } ?>
    </body>
     
</html>