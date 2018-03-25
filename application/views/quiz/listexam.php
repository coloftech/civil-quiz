
<table class="table table-bordered">
	<thead>
		
	<tr>
		<th>#</th>
		<th>Exam title</th>
		<th>Question</th>
		<th>Category</th>
		<th>Status</th>
		<th></th>
	</tr>
	</thead>	<tbody>
<?php if (isset($lists) && is_array($lists)): ?>
	<?php $i=0; foreach ($lists as $key ): ?>
		<?php 
		$i++;
		$added_q = 0;
		if($total = $this->quiz_m->countExamById($key->quizes_id)){

			$added_q = $total;
		}

		 	$choices = 'No';
		if ($key->shuffle_choices == 1) {
		 	$choices = 'Yes';
		 }

		 	$questions = 'No';
		if ($key->suffle_questions == 1) {
		 	$questions = 'Yes';
		 }
		 $Status = 'Draft';
		if ($key->status == 1) {
		 	$Status = 'Publish';
		 }

		  ?>
	<tr id="tr_<?=$key->quizes_id ?>">
		<td><?=$key->quizes_id ?></td>
		<td><?=$key->quizes_title ?></td>
		<td><?php echo "$added_q/$key->total"; ?></td>
		<td><?=$key->cat_name ?></td>
		<td><?=$Status ?></td>
		<td width="80px"><i class="fa fa-edit btn"></i> <i class="fa fa-remove btn" onclick="removeExam(<?=$key->quizes_id ?>);"></i></td>
	</tr>
	<?php endforeach ?>
<?php endif ?>

	</tbody>
</table>


<script type="text/javascript">
	
	function removeExam(examid){
		//alert(examid);
		var data = 'quizes_id='+examid;
		 $.ajax({

      type: 'post',
      data: data,
      url: '<?=site_url("quiz/removeExam"); ?>',
      dataType: 'json',

      success: function(resp){
         console.log(resp);
         if (resp.stats ==  true) {

          $('.user-profile').notify(resp.msg, { position:"bottom right", className:"success" }); 

          $('#tr_'+examid).remove();

         }else{

                  $('.user-profile').notify('Error! '+resp.msg, { position:"bottom right", className:"error" }); 
              }
      }

    });
	}
</script>