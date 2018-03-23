<h3 style="padding:0;margin:0;padding-bottom: 20px;">Create quiz question.</h3>

<div class="form-responsive">
	<form class="form form-horizontal" action="<?=site_url('quiz/add');?>" method="post" autocomplete="off" id="frmquestion" name="frmquestion" >
		<div class="col-md-6">
		
		<div class="form-group">
			<label for="question">Question</label>
			<textarea class="form-control" name="question" id="question" class="summernote" required></textarea>
		</div>

		<div class="form-group choices">
			<label for="answer1">Choice 1 <input type="radio" name="answer" id="answer1" value="1" required=""></label>
			<input type="text" name="choice1" id="choice1" class="form-control"  required />
		</div>
		<div class="form-group choices">
			<label for="answer2">Choice 2 <input type="radio" name="answer" id="answer2" value="2"></label>
			<input type="text" name="choice2" id="choice2" class="form-control"  required />
		</div>
		<div class="form-group choices">
			<label for="answer3">Choice 3 <input type="radio" name="answer" id="answer3" value="3"></label>
			<input type="text" name="choice3" id="choice3" class="form-control" required  />
		</div>
		<div class="form-group choices">
			<label for="answer4">Choice 4 <input type="radio" name="answer" id="answer4" value="4"></label>
			<input type="text" name="choice4" id="choice4" class="form-control" required  />
		</div>
		<div class="form-group choices">
			<label for="answer5">Choice 5 <input type="radio" name="answer" id="answer5" value="5"></label>
			<input type="text" name="choice5" id="choice5" class="form-control" required  />
		</div>


		</div>
		<div class="col-md-1"></div>
		<div class="col-md-5">
			<div class="form-group">
			<label for="question">Category <i class="btn fa fa-plus"></i></label>
			<?=$category?>
		</div><div class="form-group">
			<label for="question">Quiz group <i class="btn fa fa-plus"></i></label>
			<?=$category?>
		</div>

		<div class="form-group">
			<label  for="Add"></label>
			<button class="btn btn-info" type="submit" name="btn_add" id="btn_add">Add</button>
		</div>
		</div>
	</form>
</div>

<style type="text/css">
	.choices label{
		cursor: pointer;
	}
	.choices.alert{
		padding: 1px;
	}
</style>

<script type="text/javascript">
	$('input[type="radio"]').on('click change', function(e) {
   // console.log(e.type);

   var	radio = $(this).val();
   var	answer = $('#choice'+radio).val();
   $('input.form-control').css('border','solid #e5e5e5 1px');
   $('#choice'+radio).css('border','solid #7CFC00 1px');
        //$(this).parent().siblings().css("border", "2px solid white");
        $('.choices').removeClass("alert alert-success"); 
        $(this).parent().parent().addClass("alert alert-success"); 
        
   console.log(answer);
	});



	$('#frmquestion').on('submit',function(){
		var data = $(this).serialize();

		$.ajax({

			type: 'post',
			data: data,
			url: '<?=site_url("quiz/add"); ?>',
			dataType: 'json',

			success: function(resp){
				console.log(resp);
			}

		});
		return false;
	});

</script>