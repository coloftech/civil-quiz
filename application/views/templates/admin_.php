<!DOCTYPE html>
<html>
<head>
    <title><?=$site_title;?></title>
        <link rel="shortcut icon" href="<?=base_url();?>public/images/logo-only-icon.png"/>
        
        <link rel="stylesheet" type="text/css" href="<?=base_url();?>public/assets/bootstrap/css/bootstrap.min.css">   
        <link rel="stylesheet" type="text/css" href="<?=base_url();?>public/assets/bootstrap/css/font-awesome.css">   
        <link rel="stylesheet" type="text/css"  href="<?=base_url('public/assets/js/dist/summernote.css');?>" rel="stylesheet">    
        <link rel="stylesheet" type="text/css" href="<?=base_url('public/assets/fullcalendar/fullcalendar.min.css');?>">   
        <link href="<?=base_url('public/assets/css/animate.css');?>" rel="stylesheet">
        <link href="<?=base_url('public/assets/plugin/bootstrap-tagsinput/dist/bootstrap-tagsinput.css');?>" rel="stylesheet">


        <?php // add css files
        $this->minify->css(array('animate.css','admin.css','print.css'));
        echo $this->minify->deploy_css(FALSE, 'admin-style.min.css');    ?>
        

        <!-- CORE PLUGINS -->

<!-- CORE PLUGINS -->
        <script src="<?=base_url('public/assets/fullcalendar/lib/moment.min.js');?>" type="text/javascript" ></script>
        <script src="<?=base_url('public/assets/js/jquery-1.11.0.min.js');?>" type="text/javascript"></script>
        <script src="<?=base_url('public/assets/fullcalendar/fullcalendar.min.js')?>" type="text/javascript" ></script>
        <script src="<?=base_url('public/assets/bootstrap/js/bootstrap.min.js');?>" type="text/javascript"></script>
        <script src="<?=base_url('public/assets/js/notify/dist/notify.js');?>" type="text/javascript"></script>
        <script src="<?=base_url('public/assets/bootstrap/dt/js/bootstrap-datetimepicker.min.js');?>" type="text/javascript"></script>
        
        <script type="text/javascript" src="<?=base_url('public/assets/js/dist/summernote.js');?>"></script>
        <script type="text/javascript" src="<?=base_url('public/assets/js/summernote-cleaner.js');?>"></script>
        <script src="<?=base_url('public/assets/plugin/bootstrap-tagsinput/dist/bootstrap-tagsinput.js');?>" type="text/javascript"></script>


        
        <?php if (isset($isadmindashboard)): ?>
        <script src="<?=base_url('public/assets/js/highcharts.js');?>"></script>
        <script src="<?=base_url('public/assets/js/exporting.js');?>"></script>
            
        <?php endif ?>
</head>
<header>
    <div class="wrapper">
     <?php require_once 'common/menu_admin.php'; ?>
     </div>
</header>
    <div id="page-wrapper">
        <div class="container-fluid">
            <!-- Page Heading -->
            <div class="row  main">
             
            <?php echo $body; ?>
             

            </div>

        </div>
        </div>

    </div>


  </body>
    
<?php if (isset($editform) == true): ?>
<style>
/*to disable the upload image from computer uncomment this css code.*/
.note-group-select-from-files {
  display: none;
}

</style> 


<script type="text/javascript">
    

$('#desc').summernote({
 
 /*   callbacks: {
        onPaste: function (e) {
            var bufferText = ((e.originalEvent || e).clipboardData || window.clipboardData).getData('Text');
            e.preventDefault();
            document.execCommand('insertText', false, bufferText);
        }
    },
*/

  toolbar: [
    // [groupName, [list of button]]
    ['style', ['bold', 'italic', 'underline', 'clear']],
    ['font', ['strikethrough', 'superscript', 'subscript']],
    ['fontsize', ['fontsize']],
    ['color', ['color']],
    ['para', ['ul', 'ol', 'paragraph']],
    ['height', ['height']],
    ['table', ['table']],
    ['insert', ['picture','link']],
    ['view',['codeview']]
  ],
  height: 250,
    cleaner:{
          action: 'button', // both|button|paste 'button' only cleans via toolbar button, 'paste' only clean when pasting content, both does both options.
          newline: '<br>', // Summernote's default is to use '<p><br></p>'
          notStyle: 'position:absolute;top:0;left:0;right:0', // Position of Notification
          icon: '<i class="note-icon">[Your Button]</i>',
          keepHtml: false, // Remove all Html formats
          keepOnlyTags: ['<p>', '<br>', '<ul>', '<li>', '<b>', '<strong>','<i>', '<a>'], // If keepHtml is true, remove all tags except these
          keepClasses: false, // Remove Classes
          badTags: ['style', 'script', 'applet', 'embed', 'noframes', 'noscript', 'html'], // Remove full tags with contents
          badAttributes: ['style', 'start'], // Remove attributes from remaining tags
          limitChars: false, // 0/false|# 0/false disables option
          limitDisplay: 'both', // text|html|both
          limitStop: false // true/false
    }
});
document.getElementsByClassName('note-group-image-url')[0].insertAdjacentHTML('afterend','<p class="sober"><input   type="file" name="note_upload" id="note_upload" class="form-control " accept="image/x-png,image/gif,image/jpeg" /><button type="button" id="btn-summernote" class="btn btn-default">Upload</button><div class="upload_img btn"></div> </p>');


$('#btn-summernote').on('click',function(){

    var data = new FormData();
    data.append('note_upload', $('#note_upload')[0].files[0]);

     var size  =  $('#note_upload')[0].files[0].size;

    // console.log(size);
     if(size <= 1000000){

        //alert('File is ready to upload');
        i_upload(data);

     }else{
        $('#note_upload').notify('File is to big', { position:"bottom right", className:"error" });
     }

});

            var i = 0;
            var percentComplete;
            var xhr;
        function i_upload(data) {

            $.ajax({


               xhr: function() {
                    

                        xhr = new window.XMLHttpRequest();

                        xhr.upload.addEventListener("progress", function(evt) {
                          if (evt.lengthComputable) {
                            percentComplete = evt.loaded / evt.total;
                            percentComplete = parseInt(percentComplete * 100);
                            $('.upload_img').html('Upload on progress with '+percentComplete+' % to complete.');
                            //console.log(percentComplete);
                           
                            
                            if (percentComplete < 10) {
                              $('.upload_img').addClass('alert-danger');
                            }
                            if (percentComplete >=10 && percentComplete < 25) {
                              $('.upload_img').removeClass('alert-danger');
                            }
                            if (percentComplete >= 25 && percentComplete < 50) {
                              $('.upload_img').removeClass('alert-danger');
                              $('.upload_img').addClass('alert-warning');
                            }
                            if (percentComplete >= 50 && percentComplete < 75) {
                              $('.upload_img').removeClass('alert-warning');
                              $('.upload_img').addClass('alert-info');
                            }
                            if (percentComplete === 100) {
                              $('.upload_img').removeClass('alert-info');
                              $('.upload_img').addClass('alert-success');
                              $('.upload_img').html('proccessing...');

                            }

                          }
                        }, false);

                        return xhr;
               },

              type: 'post',
              url: '<?=site_url('c=summernote&f=insert_image');?>',
              data: data,
              processData: false,
              contentType: false,
              dataType:'json',
              success: function (resp) {
                    console.clear();
                    console.log(resp);
                    if(resp.stats == true){
                       $('.note-image-url').val(resp.link);

                    $('.note-image-btn').removeAttr("disabled").removeClass("disabled");

                        setTimeout(function () {
                            $('.note-image-btn').click();
                        },1000);

                    }else{
                      $('#note_upload').notify(resp.msg, { position:"bottom right", className:"error" });
                    }
              },
                 complete: function() {
                  // setting a timeouti--;
                      if (i <= 0) {
                              $('.upload_img').removeClass('alert-success');
                              $('.upload_img').removeClass('btn');
                                $('.upload_img').html('');                          

                      }
                  }
            });


            return false;
        }
</script>

    
<?php endif ?>
</html>