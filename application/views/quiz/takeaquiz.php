
<?php if (isset($lists) && is_array($lists)): ?>

	<?php $i=1; foreach ($lists as $key ): ?>
	<div class="panel panel-info">
		<div class="panel-heading"><?=$key->post_question ?></div>
		<div class="pane-body">
			<?php 
			$choices = array($key->post_answer,$key->post_choice1, $key->post_choice2, $key->post_choice3, $key->post_choice4, $key->post_choice4);
			shuffle($choices);
			?>

			<label for="question_<?=$i ?>_A">A) </label></label><input type="radio" name="question_<?=$i ?>_A" class="radio"><?=$choices[0] ?> <br />
			<label for="question_<?=$i ?>_B">B) </label><input type="radio" name="question_<?=$i ?>_B" class="radio"><?=$choices[1] ?></label> <br />
			<label for="question_<?=$i ?>_C">C) </label><input type="radio" name="question_<?=$i ?>_C" class="radio"><?=$choices[2] ?></label> <br />
			<label for="question_<?=$i ?>_D">D) </label><input type="radio" name="question_<?=$i ?>_D" class="radio"><?=$choices[3] ?></label> <br />
			<label for="question_<?=$i ?>_E">E) </label><input type="radio" name="question_<?=$i ?>_E" class="radio"><?=$choices[4] ?></label> <br />
				
			

				
			</div>
	</div>
	<?php $i++; endforeach ?>

<?php endif ?>