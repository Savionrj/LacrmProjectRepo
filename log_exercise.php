<?php

include_once('include/init.php');
echoHeader('Log');

$exerciseIdPass = $_REQUEST['exerciseIdPass'];
$exerciseData = getSingleExercise($exerciseIdPass);
$user = getUser($_SESSION['userId']);

echo "

<div id='log_exercise_page'>

  <h2 id='add_exercise_header'>".$exerciseData['exerciseName']."</h2>

  <div id='log_exercise_body'>

    <div id='current_attempt'>
    
      <h3 class='log_attempt_header'>Current Attempt</h3>
      <div id='log_exercise_form_layout'>
  
        <form id='log_exercise_form'>
  
        <div class='log_page_formrow'>
          <h3 class='log_exercise_input_labels'>Set:</h3>
          <div class='log_exercise_formbox'>
          </div>
        </div>
  
        <div class='log_page_formrow'>
          <h3 class='log_exercise_input_labels'>Rep(s):</h3>
          <input type='text' name='log_reps_formbox' class='log_exercise_formbox' />
        </div>
  
        <div class='log_page_formrow'>
          <h3 class='log_exercise_input_labels'>Weight:</h3>
          <input type='text' name='log_weight_formbox' class='log_exercise_formbox' />
        </div>
  
        <input type='submit' id='log_exercise_submit' name='log_exercise'/>
  
        </form>
  
        <div id='log_page_buttons'>
  
          <div id='log_exercise_button'>
            <label id='log_exercise_button_label' for='log_exercise_submit' tabindex='0'>Log Set</label>
          </div>

          <a href='' id='next_exercise_button'>
            <h3 id='next_exercise_button_label'>Next Exercise</h3>
          </a>
  
        </div>
      </div>

    </div>

    <div id='previous_attempt'>

      <h3 class='log_attempt_header'>Previous Attempt</h3>
    
      <div>
      
      </div>

    </div>

  </div>

  </div>
";
