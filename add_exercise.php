<?php

include_once('include/init.php');
echoHeader('Add Exercise');

$_SESSION['userId'] = 1;

if(isset($_REQUEST['addExercise'])){
  addExercise ($_REQUEST['exerciseName'], $_REQUEST["exerciseType"], $_REQUEST['session'], $_REQUEST['target'] );
  header('location:?');
  exit;
}

echo "
  <div id='add_exercise_page'>
";

// debugOutput($_SESSION);

echo "

  <h2 id='add_exercise_header'>Add Exercise</h2>

    <div id='add_exercise_body'>
      
          <form id='add_exercise_form' action='#' method='post'>
      
            <div class='add_exercise_formbox'>
              
              <h3 class='add_exercise_form_head'>Exercise <br> Name</h3>
                <input type='text' name='exerciseName' class='add_exercise_textbox' required='required' />
              
            </div>

            <div class='add_exercise_formbox'>
              
              <h3 class='add_exercise_form_head'>Exercise <br> Type</h3>
              <select name='exerciseType' class='add_exercise_dropdown' required='required'>";
                displayExerciseTypeOptions();
              echo "</select>
  
            </div>

            <div class='add_exercise_formbox'>
  
              <h3 class='add_exercise_form_head'>Select <br> Session</h3>
              <select name='session' class='add_exercise_dropdown'>
                <option value='Full Body'>Full Body</option>
                <option value='Upper Body'>Upper Body</option>
                <option value='Lower Body'>Lower Body</option>
                <option value='Chest'>Chest</option>
                <option value='Back'>Back</option>
                <option value='Legs'>Legs</option>
              </select>
              
            </div>

            <div class='add_exercise_formbox'>
              
              <h3 class='add_exercise_form_head'>Exercise <br> Target</h3>
              <input type='text' name='target' class='add_exercise_textbox' value=''  />
  
            </div>

            <input type='submit' name='addExercise' id='add_exercise' value='Add'/>

          </form>
      

    </div>

  </div>

";
