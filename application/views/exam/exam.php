<style type="text/css">
.panel > .panel-body.panel-choices label{cursor:pointer;font-weight: normal;font-size: 13px;}

* {
  box-sizing: border-box;
  padding: 0;
  margin: 0;
}

.list {
  flex: 0 0 20rem;
  list-style: none;
}

.list__item {
  position: relative;
}
.list__item:hover > .label {
  color: #009688;
}
.list__item:hover > .label::before {
  border: 0.5rem solid #009688;
  margin-right: 2rem;
}

.radio-btn {
  position: absolute;
  opacity: 0;
  visibility: hidden;
}
.radio-btn:checked + .label {
  color: #009688;
}
.radio-btn:checked + .label::before {
  margin-right: 2rem;
  border: 0.5rem solid #009688;
  background: #fff;
}

.label {
  display: flex;
  align-items: center;
  padding: 0.75rem 0;
  color: #fff;
  font-size: 1.25rem;
  text-transform: uppercase;
  cursor: pointer;
  transition: all 0.25s linear;
}

.label::before {
  display: inline-block;
  content: "";
  height: 1.125rem;
  width: 1.125rem;
  margin-right: 0.625rem;
  border: 0.5rem solid #fff;
  border-radius: 50%;
  transition: all 0.25s linear;
}

</style>
<?php
//print_r($list_exam);

if(isset($list_exam) && is_array($list_exam)){
	$i = 1;$j=1;
		$category = 0;
?>
<?php foreach ($list_exam as $key): ?>

	<?php
		
		if ( $category != (int)$key->category_id) {
			$category = $key->category_id;
			?>
			<h3>Test <?php echo $j; ?> - <?php echo $this->quiz_m->getCategoryName($key->category_id); ?></h3>
			<p>Directions: <?=($result = $this->quiz_m->getCategoryDirection($key->category_id,$exam_id)) ? $result : '' ;?></p>
			<?php
			 $j++;
		}
	?>
	
	<div class="panel panel-default">
		<div class="panel-heading panel-question">
			<?php echo "<span style='display: inline-block;font-weight:bold;font-size:15px;'>$i)</span> <span style='display: inline-block;font-weight:bold;font-size:15px;'>$key->question_title </span>"; ?>
				
		</div>
		<div class="panel-body panel-choices">
			<ul class="list">
				<li class="list__item">
					<input type="radio" name="answer_<?=$key->question_id;?>" id="choice_1_<?=$key->question_id;?>" class="radio radio-inline radio-btn"><label for="choice_1_<?=$key->question_id;?>"  class="label"> A. <?=$key->choice_1?></label>
				</li>

				<li class="list__item">
				<input type="radio" name="answer_<?=$key->question_id;?>" id="choice_2_<?=$key->question_id;?>" class="radio radio-inline radio-btn"><label for="choice_2_<?=$key->question_id;?>"  class="label"> B. <?=$key->choice_2?></label>
					
				</li>
				<li class="list__item">
				<input type="radio" name="answer_<?=$key->question_id;?>" id="choice_3_<?=$key->question_id;?>" class="radio radio-inline radio-btn"><label for="choice_3_<?=$key->question_id;?>"  class="label"> C. <?=$key->choice_3?></label>
					
				</li>
				<li class="list__item">
				<input type="radio" name="answer_<?=$key->question_id;?>" id="choice_4_<?=$key->question_id;?>" class="radio radio-inline radio-btn"><label for="choice_4_<?=$key->question_id;?>"  class="label"> D. <?=$key->choice_4?></label>
					
				</li>
				<li class="list__item">
				<input type="radio" name="answer_<?=$key->question_id;?>" id="choice_5_<?=$key->question_id;?>" class="radio radio-inline radio-btn"><label for="choice_5_<?=$key->question_id;?>"  class="label"> E. <?=$key->choice_5?></label>
					
				</li>
			</ul>
			<p>
				
			</p>

			<p>
			</p>

			<p>
			</p>

			<p>
			</p>

			<p>
			</p>
		</div>
	</div>
<?php $i++; endforeach ?>

<?php

}

;?>

<script type="text/javascript">

	/*
window.onbeforeunload = function() {
  return "Data will be lost if you leave the page, are you sure?";
};*/
</script>