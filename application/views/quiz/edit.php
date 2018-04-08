<style type="text/css">
  .list-question{
    cursor: pointer;

  }
  .list-question:hover,.list:hover{
    background-color: #FFF8DC;
    color: #008080;
  }
  .list-question .span-hidden{
    display: none;
  }
  .list-question:hover .span-hidden{
    display: inline-block;
    color: #696969;
    font-size: 10px;
    text-align: right;
    float: right;
  }
</style>
<ul class="nav nav-tabs" id="ul_new">
  <li class="li_home active"><a data-toggle="tab" href="#home" class="home">SETTING</a></li>
  <li class="li_category"><a data-toggle="tab" href="#category" class="category">CATEGORY</a></li>
  <li class="li_questions disabled"><a data-toggle="tab" href="#questions" class="questions">QUESTION</a></li>

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
          <input type="text" name="q_title" id="q_title" class="form-control" value="<?=isset($q_title) ? $q_title : '' ; ?>" />
            </div>
            
            <div class="form-group">
              
          <label>Exam description</label>
          <textarea class="form-control" id="e_description" name="e_description" rows="8" required><?=isset($e_description) ? $e_description : '' ; ?></textarea> 
            </div>


            <div class="form-group">
              
          <label>Allow shuffle</label>
          <br />
          <label for="q_random_choices" style="font-weight: normal;cursor: pointer"><input type="checkbox" name="q_random_choices" id="q_random_choices" class="checkbox-inline" value="1"  <?=isset($isChoice) ? $isChoice : '' ; ?> /> Shuffle choices </label><br />
          <label for="q_random_question" style="font-weight: normal;cursor: pointer"><input type="checkbox" name="q_random_question" id="q_random_question" class="checkbox-inline" value="1" <?=isset($isQuestion) ? $isQuestion : '' ; ?> /> Suffle questions</label><br />
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
    <h3>Category</h3>


      <button class="btn btn-default btn-sm" data-toggle="modal"  data-target="#category_modal" type="button" >Exam category <i class="fa fa-plus "></i></button> &nbsp;
      <a class="btn btn-info btn-sm"  href="../quiz/list_exam">Finnish <i class="fa fa-remove "></i></a>
      <p id="listexam">
        <table class="table table-bordered" id="tbl_exams">
          <thead><tr><th>Exam Category</th><th>Type</th><th>Added question</th><th>Max question</th><th></th></tr></thead>
          <tbody>
            <?=isset($tr) ? $tr : '' ; ?>
          </tbody>
        </table>
      </p>
  </div>
  <div id="questions" class="tab-pane fade">

    <div class="create_question">
       <h3>Create Question</h3>
    <p>
    <div class="form-responsive">
  <form class="form form-horizontal" action="<?=site_url('quiz/add');?>" method="post" autocomplete="off" id="frmquestion" name="frmquestion" >
    <div class="col-md-8">
      <div class="col-md-12">
        <input type="hidden" name="quizes_id" id="quizes_id" value="<?=$examId?>" />
        <input type="hidden" name="quiz_total" id="quiz_total" value="0" />
        <input type="hidden" name="category_id" id="category_id" value="0" />
        <input type="hidden" name="type_id" id="type_id" value="0" />
    <div class="form-group">
      <label for="question">Question textarea</label>
      <textarea class="form-control" name="question" id="question" class="summernote"></textarea>
    </div>

    <div class="form-group choices">
      <label for="answer1" style="width:100%;display: block;"><input type="radio" name="answer" id="answer1" value="1" > Choice 1 </label>
      <input type="text" name="choice1" id="choice1" class="form-control txtinput" placeholder="Enter choice here..."  required />
    </div>
    <div class="form-group choices">
      <label for="answer2" style="width:100%;display: block;"><input type="radio" name="answer" id="answer2" value="2"> Choice 2 </label>
      <input type="text" name="choice2" id="choice2" class="form-control txtinput" placeholder="Enter choice here..."  required />
    </div>
    <div class="form-group choices">
      <label for="answer3" style="width:100%;display: block;"><input type="radio" name="answer" id="answer3" value="3"> Choice 3 </label>
      <input type="text" name="choice3" id="choice3" class="form-control txtinput" placeholder="Enter choice here..." required  />
    </div>
    <div class="form-group choices">
      <label for="answer4" style="width:100%;display: block;"><input type="radio" name="answer" id="answer4" value="4"> Choice 4 </label>
      <input type="text" name="choice4" id="choice4" class="form-control txtinput" placeholder="Enter choice here..." required  />
    </div>
    <div class="form-group choices">
      <label for="answer5" style="width:100%;display: block;"><input type="radio" name="answer" id="answer5" value="5"> Choice 5 </label>
      <input type="text" name="choice5" id="choice5" class="form-control txtinput" placeholder="Enter choice here..." required  />
    </div>

  </div>
  </div>
  <div class="col-md-4">

      <div class="col-md-12">
      <div class="form-group">
        <label>You already have <span id="question_added"  style="color:red;">0</span> of <span id="total_question">0</span> questions</label>
      </div>

    <div class="form-group">
      <label for="exam_title">Exam title: </label><span id="exam_title"><?=isset($q_title) ? $q_title : '' ; ?></span><input type="hidden" name="e_title_id" id="etitle_id" value="<?=isset($examId) ? $examId : 0 ; ?>">
    </div>
    <div class="form-group">
      <label for="exam_category">Exam Category: </label><span id="exam_category"></span><input type="hidden" name="ecategory" id="ecategory">
    </div>
    <div class="form-group">
      <label for="exam_type">Exam type: </label><span id="exam_type"></span><input type="hidden" name="etype_id" id="etype_id">
    </div>
    </div>
    <div class="form-group">
      <label  for="Add"></label>
      <button class="btn btn-info btn-sm" type="submit" name="btn_add" id="btn_add">Add</button>&nbsp;
      <button class="btn btn-default btn-sm" type="submit" name="btn_addlater" id="btn_addlater">Draft</button>
      <button class="btn btn-success btn-sm " type="submit" name="btn_publish" id="btn_publish" disabled='true'>Publish</button>&nbsp;
    </div>


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

      <div id="listofquestion" style="display: none;">

        <h4>List of question <div class="pull-right"><i class="btn btn-default btn-close-list fa fa-sign-out"></i></div></h4>
        
        <br/>
        <div class="list_here" style="display: block;"></div>
      </div>
   
  </div>
</div>


<!--- -->

<div class="row">
  <!-- Modal -->
<div id="category_modal" class="modal fade" role="dialog">
<div class="modal-bg hidden">
  <!--span class="loader"></span -->
  <progress id="progressBar" value="0" maximum="100" style="width:300px;"></progress>
  <h3 id="status"></h3>
  <p id="loaded_n_total"></p>
</div>
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" >&times;</button>
        <h4 class="modal-title">Add exam</h4>
      </div>
      <div class="modal-body">
        
        <p>   
    <form action="#" id="frm_exam" name="frm_exam" class="">
           
             <div class="form-group">
              <label for="s_category">Select subject/category <i class="btn fa fa-plus"></i></label>
              <?php echo $category; ?>
            </div>
             <div class="form-group">
              <label for="category_notes">Directions: </label>
              <textarea id="directions" name="directions" class="form-control"  placeholder="(optional)"></textarea>
            </div>

            <div class="form-group">
              <label for="question">Select quiz type </label>
              <select class="form-control" id="q_type" name="q_type">
                <option value="1">Multiple choice</option>
              </select>
            </div>
             <div class="form-group">
              
          <label>Total of the quiz</label>
          <input type="number" name="q_total" id="q_total" class="form-control" required />
            </div>

            <div class="form-group">
        <label style="width:12px;"></label><button class="btn btn-sm btn-info upload" type="submit" id="btn_category">Set</button>
            </div>
            <div class="form-group">
        <label for="error"></label><div id="error"></div>
            </div>
    </form>
        </p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default hidden" data-dismiss="modal" >Close</button>
      </div>
    </div>

  </div>
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
  
  var total_question = 0;
  var max_question = 0;

  var eid = <?=$examId?>;
  var ecategory_id = 0;
  var etotal = 0;
  var etype = 0; 
  var input_questions = 0;


  $('a[data-toggle="tab"]').on('click', function(){
  if ($(this).parent('li').hasClass('disabled')) {
    return false;
  };
});


  $(function(){ 
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
        
  });

  function clearform(){

          $('input.form-control').css('border','solid #e5e5e5 1px');
          $('.choices').removeClass("alert alert-success"); 
          $('input[type="radio"]').parent().parent().removeClass("alert alert-success"); 
          $('#question').summernote('code', '');
  }



  $('#frmquestion').on('submit',function(){

    var data = $(this).serialize();
    var category_id = $('#category_id').val();
    var question = $('#question').val()
    var type_id = $('#type_id').val();
    var choices = $('input[name="answer"]:checked').val();

    var added = $('#input_questions_'+ecategory_id).val();



    if(question == '' || question == '<p></p>' || question == '<p><br></p>'){

      $('.user-profile').notify('Error! Please input a question.', { position:"bottom right", className:"error" }); 
      return false;
    }
     if(choices == '' || choices == undefined){


      $('.user-profile').notify('Error! Please select an answer to this question.', { position:"bottom right", className:"error" }); 
      return false;
    }

          if(parseInt(max_question) == parseInt(added)){
            $('.user-profile').notify('Maximum question already added.', { position:"bottom right", className:"error" }); 
            return false;
          }
   

    $.ajax({

      type: 'post',
      data: data,
      url: '<?=site_url("quiz/add"); ?>',
      dataType: 'json',

      success: function(resp){


        if(resp.stats == true){

        total_question =parseInt(total_question) + 1;

        $("#question_added").html(total_question);

        $("#added_question_"+ecategory_id).html(total_question);
        $('#input_questions_'+ecategory_id).val(total_question);
        
          if(max_question == total_question){
           //$('#btn_add').prop('disabled',true);
            $('#btn_publish').removeAttr('disabled');
          }

          $('.user-profile').notify("Question added successfully", { position:"bottom right", className:"success" }); 

          $('#frmquestion')[0].reset();

          clearform();


        }else{

                  $('.user-profile').notify('Error! '+resp.msg, { position:"bottom right", className:"error" }); 
        }
      }

    });
    return false;
  });


  $('#frm_exam').on('submit',function(){
    var category = $('#s_category').val();
    var t_category = $('#s_category option:selected').text();
    var q_type = $('#q_type').val();
    var t_type = $('#q_type option:selected').text();
    var q_total = $('#q_total').val();
    //eid = $('#quizes_id').val();


    var type = '';
    var data = $(this).serialize();
    if (parseInt(q_type) == 1) {
      type = 'Multiple choice';
    }

    $.ajax({

      type: 'post',
      data: data+'&quizes_id='+eid,
      url: '<?=site_url("quiz/add_exam_setting"); ?>',
      dataType: 'json',
      success: function(resp){

        if(resp.stats == true){

          ecategory_id = category;
          etype = q_type;

      $('#tbl_exams tbody').append('<tr class="list"><td>'+t_category+'</td><td>'+t_type+'</td><td  class="list-question" data-quiz='+eid+' data-category='+ecategory_id+'><span id="added_question_'+category+'" class="red" color="red">0</span><span class="span-hidden">List questions.</span><input type="hidden" id="input_questions_'+category+'" value="0"/></td><td>'+q_total+' <input type="hidden" id="max_'+category+'" value="'+q_total+'" /></td><td><button class="btn btn-sm btn-default" type="button" onclick="add_questions('+quizes_id+','+category+','+q_total+','+q_type+',\''+t_category+'\',\''+t_type+'\')"><i class="fa fa-plus"></i> questions</button></td></tr>');

              $('#category_modal').modal('hide');
               $('.list-question').on('click',function(){
                  var action = $(this);
                  list_question(action);
               });

        }else{

                  $('#s_category').notify('Error! '+resp.msg, { position:"bottom right", className:"error" }); 
        }
      }
    });

    return false;
  });

  $('.list-question').on('click',function(){
    var action = $(this);
    list_question(action);
  });
  function list_question(action){

    var cat = action.data('category');
    var quiz = action.data('quiz');
    var q = $('#added_question_'+cat).text();


    if(parseInt(q) <= 0){

                  $('#added_question_'+cat).notify('No data. ', { position:"bottom right", className:"error" }); 
      return false;
    }
    $('.li_questions').removeClass('disabled');
    $('.questions').click();

            $('.list_here').html('');


    var data = 'exam_id='+quiz+'&category_id='+cat;

    $('#listofquestion').show('slow');
    $('.create_question').hide('fast');

        $.ajax({

      type: 'post',
      data: data,
      url: '<?=site_url("quiz/list_question"); ?>',
      dataType: 'json',

      success: function(resp){

        var n = 1;
         $.each(resp, function(i) {

            var list = '';
            list = '<div class="panel panel-info"><div class="panel-heading"><b style="display:block;width:100%;"><span style="display:inline-block;">'+n+') </span> <span style="display:inline-block;">'+resp[i].post_question+'</span></b></div><div class="panel-body"> <p style="color:green;">Answer: '+resp[i].post_answer+'</p><p>Choice: '+resp[i].post_choice1+'</p><p>Choice: '+resp[i].post_choice2+'</p><p>Choice: '+resp[i].post_choice3+'</p><p>Choice: '+resp[i].post_choice4+'</p></div></div>';
            $('.list_here').append(list);
            n++;
          });
      }

    });
    return false;
  }

  $('.btn-close-list').on('click',function(){

    $('.li_questions').addClass('disabled');
    $('.category').click();
    $('.create_question').show('fast');
    $('.table').show('slow');
    $('#listofquestion').hide('fast');
    

  });
  function addQuestion(exam_id,category_id,a_question,mtotal,eqtype,t_category,t_type){

  //}
  //function add_question(exam_id,category_id,a_question,mtotal,eqtype,t_category,t_type){
    
    eid = exam_id;
    ecategory_id = category_id;
    etotal = mtotal;
    etype = eqtype;
    total_question = a_question;

    max_question = mtotal;



    ad_q = $('#input_questions_'+ecategory_id).val();


    if(parseInt(ad_q) == parseInt(etotal)){
      $('.user-profile').notify('Maximum question already added.', { position:"bottom right", className:"error" }); 
      return false;
    }


    total_question = ad_q ;



    $("#question_added").html(total_question);
    $("#total_question").html(etotal);



      $('#category_id').val(ecategory_id);
      $('#quiz_total').val(etotal);
      $('#type_id').val(etype);

   // $('#exam_title').html();
    $('#exam_category').html(t_category);
    $('#exam_type').html(t_type);

    $('.li_questions').removeClass('disabled');
    $('.questions').click();

    return false;

  }

  $('.category').on('click',function(){
    $('.li_questions').addClass('disabled');
  });
  $('.home').on('click',function(){
    $('.li_questions').addClass('disabled');
  });

	$('#frmnew').on('submit',function(){
    var data = $(this).serialize();
    var data = $(this).serialize();
    max_question = $('#q_total').val();

    $.ajax({

      type: 'post',
      data: data,
      url: '<?=site_url("quiz/addexam"); ?>',
      dataType: 'json',

      success: function(resp){

         if (resp.stats ==  true) {
          $('.li_category').removeClass('disabled');
          $('.category').click();

          $('.user-profile').notify("Question settings added successfully", { position:"bottom right", className:"success" }); 
          
          $("#quizes_id").val(resp.quizes_id);

          $('#exam_title').html($('#q_title').val());

          $('#btn_set').attr('disabled',true);

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
    max_question = total;
  });


  $('.txtinput').on('change',function(){
    var data = $(this).val();
    var i = 0;
    var choice1 = $('#choice1').val();
    var choice2 = $('#choice2').val();
    var choice3 = $('#choice3').val();
    var choice4 = $('#choice4').val();
    var choice5 = $('#choice5').val();
   

    if(data == choice1){
      i++;
    }
    if(data == choice2){
      i++;
    }
    if(data == choice3){
      i++;
    }
    if(data == choice4){
      i++;
    }
    if(data == choice5){
      i++;
    }
    if(i > 1){
      $(this).val('');
      //$(this).focus();
      $(this).attr('placeholder','Warning: This field should be unique.');
    }
    
  });


</script>

