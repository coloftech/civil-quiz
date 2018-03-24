
<ul class="nav nav-tabs" id="ul_new">
  <li class="active"><a data-toggle="tab" href="#home" class="home">SETTING</a></li>
  <li><a data-toggle="tab" href="#category" class="category">QUESTIONS</a></li>
</ul>

<div class="tab-content">
  <div id="home" class="tab-pane fade in active">
    <h3>Exam settings</h3>
    <p>
      <div class="col-md-12">
    	<div class="col-md-8">
    		<div class="is_new">
    			<form class="form form-horizontal" id="frmnew" method="post" accept="./addexam">
            <div class="form-group">
              
          <label>Title of the quiz</label>
          <input type="text" name="q_title" id="q_title" class="form-control" />
            </div>
            <div class="form-group">
              
          <label>Total of the quiz</label>
          <input type="number" name="q_total" id="q_total" class="form-control" />
            </div>
             <div class="form-group">
              <label for="s_category">Select subject/category <i class="btn fa fa-plus"></i></label>
              <?php echo $category; ?>
            </div>

            <div class="form-group">
              <label for="question">Select quiz type </label>
              <select class="form-control" id="q_type" name="q_type">
                <option value="1">Multiple choice</option>
              </select>
            </div>

            <div class="form-group">
              
          <label>Allow shuffle</label>
          <br />
          <label for="q_random_choices" style="font-weight: normal;cursor: pointer"><input type="checkbox" name="q_random_choices" id="q_random_choices" class="checkbox-inline" value="1" /> Shuffle choices </label><br />
          <label for="q_random_question" style="font-weight: normal;cursor: pointer"><input type="checkbox" name="q_random_question" id="q_random_question" class="checkbox-inline" value="1" /> Suffle questions</label><br />
            </div>

            <div class="form-group">
              
          <label></label>
          <button class="btn btn-info btn-sm" style="" type="submit" id="btn_set">Set</button>
            </div>

    <div class="form-group append_exam ">
    </div>
    			</form>
        </div>
        </div>
      <div class="col-md-4">
       <p style="font-size: 12px; ">
        <b>Important Note:</b><br>
          <span><b>Title of quiz:</b> </span> This will be the title of the quizzes. <br />
          <span><b>Shuffle choices:</b> </span> If this is checked the choices will shuffle/randomized on a page reload. <br />
          <span><b>Shuffle questions: </b> </span> If this is checked the questions will shuffle/randomized on a page reload. <i>currently not available.</i><br />
        </p> 

        </div>
      </div>
      </p>
  </div>
  <div id="category" class="tab-pane fade">
    <h3>Questions</h3>
    <p>
    <div class="form-responsive">
  <form class="form form-horizontal" action="<?=site_url('quiz/add');?>" method="post" autocomplete="off" id="frmquestion" name="frmquestion" >
    <div class="col-md-8">
      <div class="col-md-12">
        <input type="hidden" name="quizes_id" id="quizes_id" value="0" />
        <input type="hidden" name="quiz_total" id="quiz_total" value="0" />
        <input type="hidden" name="category_id" id="category_id" value="0" />
        <input type="hidden" name="type_id" id="type_id" value="0" />
    <div class="form-group">
      <label for="question">Question textarea</label>
      <textarea class="form-control" name="question" id="question" class="summernote" required></textarea>
    </div>

    <div class="form-group choices">
      <label for="answer1" style="width:100%;display: block;"><input type="radio" name="answer" id="answer1" value="1" required=""> Choice 1 </label>
      <input type="text" name="choice1" id="choice1" class="form-control"  required />
    </div>
    <div class="form-group choices">
      <label for="answer2" style="width:100%;display: block;"><input type="radio" name="answer" id="answer2" value="2"> Choice 2 </label>
      <input type="text" name="choice2" id="choice2" class="form-control"  required />
    </div>
    <div class="form-group choices">
      <label for="answer3" style="width:100%;display: block;"><input type="radio" name="answer" id="answer3" value="3"> Choice 3 </label>
      <input type="text" name="choice3" id="choice3" class="form-control" required  />
    </div>
    <div class="form-group choices">
      <label for="answer4" style="width:100%;display: block;"><input type="radio" name="answer" id="answer4" value="4"> Choice 4 </label>
      <input type="text" name="choice4" id="choice4" class="form-control" required  />
    </div>
    <div class="form-group choices">
      <label for="answer5" style="width:100%;display: block;"><input type="radio" name="answer" id="answer5" value="5"> Choice 5 </label>
      <input type="text" name="choice5" id="choice5" class="form-control" required  />
    </div>

  </div>
  </div>
  <div class="col-md-4">

      <div class="col-md-12">
      <div class="form-group">
        <label>You already have <span id="question_added"  style="color:red;">0</span> of <span id="total_question">0</span> questions</label>
      </div>

    <div class="form-group">
      <label  for="Add"></label>
      <button class="btn btn-info btn-sm" type="submit" name="btn_add" id="btn_add">Add</button>&nbsp;
      <button class="btn btn-default btn-sm" type="submit" name="btn_addlater" id="btn_addlater">Draft</button>
      <button class="btn btn-success btn-sm " type="submit" name="btn_publish" id="btn_publish" disabled='true'>Publish</button>&nbsp;
    </div>

    </div>

      <div class="col-md-12">
          <br />
          <br />
       <p style="font-size: 12px; ">
        <b>Important Note:</b><br>
          <span><b>Question textare:</b> </span> Used this area to input the questions. <br />
          <span><b>Choice (1-5):</b> </span>Use the inputbox to input the choices . <br />
          <span><b>Radio button: </b> </span> Click this button (the small circle) to set the correct answer to the following choices. Make sure that the backgound color of your selected answer willchange to light green.<br />
          <span><b>Add button: </b> </span> Click this button to add the question (it will dislabled after you reach the maximum total questions.<br />
          <span><b>Radio button: </b> </span> Click this button to save in draft the questionfor later update.<br />
          <span><b>Radio button: </b> </span> Click this button to publish and show to the public the examination.<br />
        </p> 

        </div>
    </div>
    </div>
  </form>
</p>
  </div>
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
  
  $(function(){ 
  var total_question = 0;
    $("#question_added").html(total_question);
  });
  $('input[type="radio"]').on('click', function(e) {
   // console.log(e.type);

   var  radio = $(this).val();
   var  answer = $('#choice'+radio).val();
   $('input.form-control').css('border','solid #e5e5e5 1px');
   $('#choice'+radio).css('border','solid #7CFC00 1px');
        //$(this).parent().siblings().css("border", "2px solid white");
        $('.choices').removeClass("alert alert-success"); 
        $(this).parent().parent().addClass("alert alert-success"); 
        
   console.log(answer);
  });



  $('#frmquestion').on('submit',function(){
    var data = $(this).serialize();
    var category_id = $('#s_category').val();
    var type_id = $('#q_type').val();

    data =  data + '&category_id='+category_id+'&type_id='+type_id;

    $.ajax({

      type: 'post',
      data: data,
      url: '<?=site_url("quiz/add"); ?>',
      dataType: 'json',

      success: function(resp){
        console.log(resp);
        if(resp.stats == true){
          total_question++;
        $("#question_added").html(total_question);
        }
      }

    });
    return false;
  });

</script>


<script type="text/javascript">
	$('#frmnew').on('submit',function(){
		var data = $(this).serialize();


         // $('#btn_publish').removeAttr('disabled');
          return false;
    $.ajax({

      type: 'post',
      data: data,
      url: '<?=site_url("quiz/addexam"); ?>',
      dataType: 'json',

      success: function(resp){
         console.log(resp);
         if (resp.stats ==  true) {

          $('.category').click();

          $('.user-profile').notify("Question settings added successfully", { position:"bottom right", className:"success" }); 

          $('#btn_add').attr('disabled');

         }else{

                  $('.user-profile').notify('Error! '+resp.msg, { position:"bottom right", className:"error" }); 
                  if (resp.msg == 'Post failed! The exam title already used.') {
                    $('.append_exam').html('<a href="'+'<?=site_url("quiz/edit/");?>'+resp.quizes_id+'" >Click here to append this exam.</a>')
                  }
              }
      }

    });
		return false;
	});
	

  $('#q_total').on('change',function(){
    var total = $(this).val();
    $('#total_question').html(total);
    $('#total_question').css('color','blue');
  });


</script>

