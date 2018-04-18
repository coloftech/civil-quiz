<?php 

if(isset($info) && is_array($info)){
	foreach ($info as $key) {
		# code...
		echo "
			<div class='panel'>
				<div class='panel-heading'><h3>$key->quizes_title</h3></div>
				<div class='panel-body'>
					<p><h4>Exam category</h4>
					";
					if(isset($key->category)){
						echo "<ul>";
						foreach ($key->category as $cat) {
							# code...
							echo "<li>$cat->category_name</li>";

						}

						echo "</ul>";
					}

					echo "
					</p>
				</div>
			</div>
		";

	}
	echo "<a href='' class='btn btn-success btn-sm' data-title='Click to try this exam.' id='btn-try'><i class='fa fa-book'></i> Try this exam</a>";
}

 ?>

 <script type="text/javascript">
 	
 	$('#btn-try').on('mouseover	',function(){
 		$(this).notify($(this).data('title'),{ position:"top left", className:"success" });

 		return false;
 	})
 		$('#btn-try').on('mouseout',function(){

  		$('.notifyjs-wrapper').trigger('notify-hide');

 		return false;
 	})
 		$('#btn-try').on('click',function(){

  			var is_login = false;
  			 <?php if ($this->permission->is_loggedin()): ?>
  			 	is_login = true;
  			 <?php endif ?>
  			 if(is_login == true){
  			 	window.location = '<?php echo site_url("/exam/take_exam/".$info[0]->quizes_id);?>';
  			 }else{

 		$(this).notify('Please login to continue...',{ position:"top left", className:"error" });
  			 }
 		return false;
 	})
 </script>