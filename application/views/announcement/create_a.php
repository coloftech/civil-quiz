<div class="col-sm-12 col-md-12 col-lg-12 create">
<div class="col-md-9">
	<div class="panel">
	<div class="heading"><h3><?php echo $title; ?></h3></div>
	<div class="body">
		<form class="form" id="frmcreate" name="frmcreate" method="post" action="">
			<div class="form-group">
				<p class="btn hidden " id="warning_msg"></p>
			</div>
			<div class="form-group">
				<label for="title">Title</label><input type="text" class="form-control" name="title"  id="title" placeholder="Enter title here" required/>
				<p class="btn alert-danger hidden" id="intitle"></p>
			</div>	
			<div class="form-group">
				<label for="title">Description</label><textarea class="form-control" name="desc" id="desc" rows="7"></textarea>
			</div>	
			<div class="form-group">
				<label for="title">Keyword</label><input type="text" class="form-control" name="keyword"  id="keyword" placeholder="Enter keyword here" />
			</div>

			<div class="form-group">
				<label for="title"></label><button class="btn btn-info">Submit</button>
			</div>		
		</form>
	</div>
</div>
</div>
<div class="col-md-3">
<div class="row">
	<div class="panel">
		<div class="panel-heading">&nbsp;</div>
		<div class="panel-body">
			<h4>Featured image</h4>
			<div class="featured">
				
			<div class="featuredImg" id="featuredImg">No images</div>
			<input type="hidden" id="featuredimg_url" name="featuredimg_url" />
			<a class="btn btn-info" data-toggle="modal"  data-target="#uploadModal" href="#" style="width:100px;">Upload</a>
			</div>

			<br />
			<h4>Date Start</h4>
			<div class="category">
			
			<input size="16" type="text" class="form-control" id="start_datetime">
			
			</div>
			<br />
			<h4>Date End</h4>
			<div class="category">

			<input size="16" type="text" class="form-control" id="end_datetime">
			</div>
			<br />
			<h4>Category</h4>
			<div class="category">
				<select class="form-control" style="width:100%;" id="category" name="category">
				<?php
					foreach ($category as $key) {
						# code...
						echo "<option value='$key->id'>$key->name</option>";
					}
				?>
				</select>
			</div>

			<br />
			<h4>Privacy</h4>
			<div class="category">
				<select class="form-control" style="width:100%;" id="privacy" name="privacy">
					<option value="2">Public</option>
					<option value="1">Private</option>
				</select>
			</div>



		</div>
	</div>
</div>

<div class="row">
	<!-- Modal -->
<div id="uploadModal" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Upload Featured Image</h4>
      </div>
      <div class="modal-body">
        <p><div class="err_msg hidden"></div>			
        	<form class="form for-responsive" method="post" action="<?=site_url('files/upload');?>" id="frmupload" name="frmupload">
        		<div class="form-group">
        			<label>Select photo</label><input type="file" name="uploadfile" id="uploadfile" class="btn alert-info"  accept="image/gif, image/jpeg, image/png"  onChange="readURL(this);" style="width:100%;" />
        		</div>
        		<div class="form-group">
        			<label>Preview</label><br><img src="" id="previewImg" class="hidden" >
        			<input type="hidden" name="filehide" id="filehide" value="<?php echo rand(10,100);?>">
        		</div>

        		<div class="form-group">
        			<label></label><button  type="submit" class="btn btn-info" id="btnUpload" name="btnupload">Upload</button>
        		</div>
        		

        	</form>
        </p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal" onClick="clearform('frmupload');">Close</button>
      </div>
    </div>

  </div>
</div>
</div>
</div>

        <script type="text/javascript" src="<?=base_url('assets/js/nicEdit.js');?>"></script>
        <script type="text/javascript" src="<?=base_url('assets/js/dist/summernote.min.js');?>"></script>
<script type="text/javascript">
var isallowed = false;
	function clearform (frm) {
		// body...
		document.getElementById(frm).reset();
		$('#previewImg').addClass('hidden');
            $('#btnupload').addClass('hidden');

		return;
	}
	function readURL(input) {

		 if (!window.FileReader) {
        alert("Oops! This browser isn't supported yet. Please use higher browser to continue.");
        return false;
    	}
        if (input.files && input.files[0]) {
            var reader = new FileReader();

            reader.onload = function (e) {
                $('#previewImg')
                	.removeClass('hidden')
                    .attr('src', e.target.result)
                    .width('70%')
                    .height('70%');
            };

            reader.readAsDataURL(input.files[0]);
        }
    }

$(function () {
    var today = new Date();
    var date = today.getFullYear()+'-'+(today.getMonth()+1)+'-'+today.getDate();
    var time = today.getHours() + ":" + today.getMinutes();
    var dateTime = date+' '+time;
    $("#start_datetime").datetimepicker({
        format: 'yyyy-mm-dd hh:ii P',
        showMeridian: true,
        autoclose: true,
        todayBtn: true,
        startDate: dateTime
    });
    $("#end_datetime").datetimepicker({
        format: 'yyyy-mm-dd hh:ii P',
        showMeridian: true,
        autoclose: true,
        todayBtn: true,
        startDate: dateTime
    });
});



    $(function(){
		/*$("#datetime").datetimepicker({
		    format: 'yyyy-mm-dd hh:ii',
		    autoclose: true,
		    todayBtn: true
		});*/

//$("#datetime").datetimepicker();


    	$('#title').on('keyup',function(){
    		var title = $('#title');
    		var intitle = $('#intitle');
    		
    		$.ajax({
    			type: 'post',
    			data: 'title='+title.val(),
    			url: '<?=site_url("announcement/iftitle");?>',
    			dataType: 'json',
    			success: function(resp2){
    				console.clear();
    				console.log(resp2)
    				if (resp2.stat) {

								if($(intitle).hasClass('alert-danger')){
								intitle.removeClass('alert-danger');									
								}

    					intitle.removeClass('hidden');
    					intitle.addClass('alert-success');
    					intitle.html(resp2.msg);
    					setTimeout(function(){
    						intitle.addClass('hidden');
    						intitle.removeClass('alert-success');
    					},10000);
    					isallowed = true;

    				}else{

								if($(intitle).hasClass('alert-success')){
								intitle.removeClass('alert-success');									
								}

    					intitle.removeClass('hidden');
    					intitle.addClass('alert-danger');
    					intitle.html(resp2.msg);
    					isallowed = false;
    				}
    				
    			}
    		});
    		return false;
    	});

    	$('#frmcreate').on('submit',function(){
    		var warning = $('#warning_msg');

    		//return false;
    		if(isallowed == false){
    			warning.removeClass('hidden');
    			warning.removeClass('alert-success');
    			warning.addClass('alert-danger');
    			warning.html('Warning: Please check or input required information!');
    			return false;
    		}

  		var content = $('#desc').summernote('code');
    	var start_datetime = $('#start_datetime').val();
    	var end_datetime = $('#start_datetime').val();

  		var createformdata  = 'content='+content+'&title='+$('#title').val()+'&keyword='+$('#keyword').val()+'&featuredImg='+$('#featuredimg_url').val()+'&category='+$('#category').val()+'&start_datetime='+$('#start_datetime').val()+'&end_datetime='+$('#end_datetime').val();
  		

							//console.log(createformdata);return false;
					$.ajax({
						type: 'post',
						dataType: 'json',
						url: '<?=site_url("announcement/save_a");?>',
						data: createformdata,
						success: function(response){
							//console.clear();
							console.log(response);

							if (response.stat == true) {
								alert(response.msg);
								$('#warning_msg').removeClass('hidden');

								if($('#warning_msg').hasClass('alert-danger')){
								$('#warning_msg').removeClass('alert-danger');									
								}
								$('#warning_msg').addClass('alert-success');
								$('#warning_msg').html('response.msg');
								//window.location.reload();
								return false;
							}else{
								$('#warning_msg').removeClass('hidden');
								if($('#warning_msg').hasClass('alert-success')){
								$('#warning_msg').removeClass('alert-success');									
								}
								$('#warning_msg').addClass('alert-danger');
								$('#warning_msg').html('response.msg');
								return false;

							}
							//alert(response.msg);
								//return false;



						}
					});


  		return false;
    	});

		$("#frmupload").on('submit', function(){

			var formData = new FormData();
		    var fileh = $("#filehide");
		    var file = $("#uploadfile")[0].files[0];

		    formData.append("fileh", fileh);
		    formData.append("file", file);

		    var url ="../files/upload";
			    if (window.XMLHttpRequest){
			        xmlhttp=new XMLHttpRequest();
			    }else{
			        xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
			    }

			    var http = new XMLHttpRequest();
			    http.open("POST", url, true);        
			    http.send(formData);

			    http.onreadystatechange = function() {
			        if(http.readyState == 4 && http.status == 200) {

			        	var data = JSON.parse(http.responseText);
			        	console.clear();
			        	console.log(data.stat);
			        	if (data.stat == true) {

			        		alert(data.msg);
			        		if ($('.err_msg').hasClass('hidden')) {
			        		}else{
			        			$('.err_msg').addClass('hidden');
			        		}


								var elem = document.createElement("img");
								elem.setAttribute("src", '<?=base_url();?>'+data.getlink);
								elem.setAttribute("height", "100%");
								elem.setAttribute("width", "100%");
								$('#featuredImg').html(elem);
								$('#featuredimg_url').val('<?=base_url();?>'+data.getlink);

								clearform('frmupload');
			        			$('#uploadModal').modal('hide');


			        	}else{

			        			$('.err_msg').removeClass('hidden');
			        			$('.err_msg').html('<p class="alert alert-warning">'+data.msg+'</p>');

			        			setTimeout(function(){
			        			$('.err_msg').addClass('hidden');

			        			},3000);

			        	}

			        	return false;
			        	
			        	};
			        }
		    	

	    return false;
		});


});
/*
  $(function () {
  editor =  new nicEditor({fullPanel : true}).panelInstance('desc');
  })

  $(window).resize(function() {
     editor.removeInstance('desc'); 
  		editor =  new nicEditor({buttonList : ['fontSize','bold','italic','underline','strikeThrough','subscript','superscript','html']}).panelInstance('desc');

  	});

  */

  $('#desc').summernote({
  toolbar: [
    // [groupName, [list of button]]
    ['style', ['bold', 'italic', 'underline', 'clear']],
    ['font', ['strikethrough', 'superscript', 'subscript']],
    ['fontsize', ['fontsize']],
    ['color', ['color']],
    ['para', ['ul', 'ol', 'paragraph']],
    ['height', ['height']],
    ['table', ['table']]
  ],
  height: 150
});

  /*
  var edit = function() {
  $('.click2edit').summernote({focus: true});
};

var save = function() {
  var markup = $('.click2edit').summernote('code');
  $('.click2edit').summernote('destroy');
};

*/


</script>