
<table class="table table-bordered">
	<thead>
		
	<tr>
		<th>Date added</th>
		<th>Exam title</th>
		<th>Category</th>
		<th>Total exam</th>
		<th>Shuffle Choices</th>
		<th>Status</th>
		<th></th>
	</tr>
	</thead>	<tbody>
<?php if (isset($lists) && is_array($lists)): ?>
	<?php $i=0; foreach ($lists as $key ): ?>
		<?php 

		//print_r($lists);exit();
		$i++;
		$added_q = 0;
		

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
		<td width="100px"><?=date('Y-m-d',strtotime($key->date_posted)) ?></td>
		<td><?=$key->quizes_title ?></td>
		<td><?php if(!empty($key->category_names)) echo implode(', ', $key->category_names);?></td>
		<td  width="100px"><?=$key->exam_total?></td>
		<td  width="130px"><?=$choices ?></td>
		<td  width="80px"><?=$Status ?></td>
		<td width="120px"><a href="<?=site_url("quiz/take_exam/$key->quizes_id"); ?>"><i class="fa fa-briefcase btn" style="color:green;" title="Take this exam"></i></a> <a href="<?=site_url("quiz/edit/$key->quizes_id"); ?>"><i class="fa fa-edit btn" title="Edit exam"></i></a> <i class="fa fa-remove btn"  style="color:red;"  onclick="removeExam(<?=$key->quizes_id ?>);" title="Drop this exam"></i></td>
	</tr>
	<?php endforeach ?>
<?php endif ?>

	</tbody>
</table>


<script type="text/javascript">
	
	function editExam(examid){
		window.location = '<?=site_url("quiz/edit/")?>'+examid;
	}
	function testExam(examid){
		window.location = '<?=site_url("quiz/take_exam/")?>'+examid;
	}
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