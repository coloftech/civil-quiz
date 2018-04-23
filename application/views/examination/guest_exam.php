<div class="post-index">
	<div class="panel-show-exam">
		
	<a class="btn btn-info btn-sm btn-show-exam" href="javascript:void(0);" data-exam="<?=$exam_id?>">Show exam</a>
	<input type="hidden" name="categories" id="categories" value="<?php echo isset($categories) ? $categories : false; ?>" 	\>

	</div>
	<div class="panel panel-exam-questions">
		<div class="form-group">
			<form class="form form-horizontal" id="frmExam" method="post" action="">
				<div class="questions-id hidden">
					<input type="text" name="questions_id" id="questions_id" value=""/>
				</div>
				<div class="list-questions">
					
				</div>
				<div class="btn-submit">
					<div class="form-group">
						<label>&nbsp;&nbsp;&nbsp;</label><button class="btn btn-info btn-sm" id="btn_submit">Submit</button>
					</div>
				</div>
			</form>
		</div>
	</div>
	<div class="panel panel-show-result">
		<center>
		<div class="loader hidden"></div>
		<div class="result hidden" style="font-size:30px; ">Result</div>
			
		</center>

	</div>


</div>
<style type="text/css">
	.list-questions .panel-question p{
		display: inline;
	}
</style>

<script type="text/javascript">

		var exam_id = 0;
		var category_id = 0;
		var a_category_id = 0;
		var i = 0;
		var i_question = 0;
		var i_answer = 0;
		var my_answer = false;
		var questions_id = false;

	$('.btn-show-exam').on('click',function() {
		// body...
		exam_id = $(this).data('exam');
		var categoy_id = $('#categories').val();
		
		category_id = categoy_id.split(',');
		a_category_id = category_id[i];

		var data = 'exam_id='+exam_id+'&category_id='+category_id[i] ;

		questionaire(data);

	});

	
	$('#frmExam').on('submit',function(){
		var data = $(this).serialize();
		data = data+'&exam_id='+exam_id+"&category_id="+a_category_id+"&questions_id="+JSON.stringify(questions_id);
		//console.log(questions_id);
		if(i_question != 0){

		showRatings(data);
		}else{

			$('.navbar-coloftech').notify('Sorry you can\'t resubmit your answer. Reload the page to restart the exam.', { position:"bottom right", className:"warning" });

		}

		return false;
	});

</script>

<script type="text/javascript">
	
	/* ------------function only---------------- */

	function questionaire(data) {
		// body...

		$.ajax({
			data: data,
			type: 'post',
			url: '../../examination/questions',			
	    	statusCode: {
	        404: function() {
                  $('.navbar-coloftech').notify('Error 404! page not found.', { position:"bottom right", className:"warning" });
	        },
	        505: function() {
                  $('.navbar-coloftech').notify('Error 505! page not found.', { position:"bottom right", className:"warning" });
	        }
   			 },
			dataType: 'json',
			success: function(result) {
				// body...
				// console.log(result);
				if(result.stats == true){
					$('.panel-show-exam').hide('fast');
					var num = 1;
					var list = '';
					 	questions_id = false;
					 	questions_id = [];
						i_question = 0;
						i_answer = 0;
					$.each(result.questions, function(key, exam) {
						list = list+'<div class="panel panel-default"><div class="panel-body panel-question"><i>'+num+')</i>&nbsp;<span>'+exam.question+'</span></div><div class="panel-body panel-choices"><ul class="list"><li class="list_item"> <input type="radio" value="'+exam.choice_1+'" class="radio radio-inline radio-btn" id="choice_1_'+exam.quiz_id+'" name="choice_'+exam.quiz_id+'"/><label for="choice_1_'+exam.quiz_id+'" class="label"> A) '+exam.choice_1+'</label></li><li class="list_item"> <input type="radio" value="'+exam.choice_2+'" class="radio radio-inline radio-btn" id="choice_2_'+exam.quiz_id+'" name="choice_'+exam.quiz_id+'"/><label for="choice_2_'+exam.quiz_id+'" class="label"> B) '+exam.choice_2+'</label></li><li class="list_item"> <input type="radio" value="'+exam.choice_3+'" class="radio radio-inline radio-btn" id="choice_3_'+exam.quiz_id+'" name="choice_'+exam.quiz_id+'"/><label for="choice_3_'+exam.quiz_id+'" class="label"> C) '+exam.choice_3+'</label></li><li class="list_item"> <input type="radio" value="'+exam.choice_4+'" class="radio radio-inline radio-btn" id="choice_4_'+exam.quiz_id+'" name="choice_'+exam.quiz_id+'"/><label for="choice_4_'+exam.quiz_id+'" class="label"> A) '+exam.choice_4+'</label></li><li class="list_item"> <input type="radio" value="'+exam.choice_5+'" class="radio radio-inline radio-btn" id="choice_5_'+exam.quiz_id+'" name="choice_'+exam.quiz_id+'"/><label for="choice_5_'+exam.quiz_id+'" class="label"> E) '+exam.choice_1+'</label></li></ul></div></div>';
					//console.log(exam.question);

						num++;i_question++;
						questions_id.push(exam.quiz_id);
					});


						$('.list-questions').html(list);
						i++;
				}else{
					console.log(result);
					 $('.navbar-coloftech').notify('No question available. Try again later.', { position:"bottom right", className:"warning" });
				}
        	
       	 }

		});

	}

	function showRatings(data) {
		// body...

		$.ajax({
			data: data,
			type: 'post',
			url: '../../examination/results',			
	    	statusCode: {
	        404: function() {
                  $('.navbar-coloftech').notify('Error 404! page not found.', { position:"bottom right", className:"warning" });
	        },
	        505: function() {
                  $('.navbar-coloftech').notify('Error 505! page not found.', { position:"bottom right", className:"warning" });
	        }
   			 },
			dataType: 'json',
			beforeSend: function(){

						$('.list-questions').addClass('hidden');
						$('.loader').removeClass('hidden');

			},
			success: function(result) {
				// body...

				 console.log(result);
				if(result.stats == true){
					$('.panel-exam-questions').hide('fast');
					$('.result').removeClass('hidden').html(result.total_exam+'/'+i_question);
					$('.loader').addClass('hidden');

					$('.list-questions').html('');

					setTimeout(function(){

					$('.result').addClass('hidden');

					},5000)

					 	questions_id = false;
					 	questions_id = [];
						i_question = 0;
						i_answer = 0;

					 $('.navbar-coloftech').notify('Your answer save successfully', { position:"bottom right", className:"success" });

				}else{
					 $('.navbar-coloftech').notify('No question available. Try again later.', { position:"bottom right", className:"warning" });
				}
        	
       	 }

		});

	}
</script>