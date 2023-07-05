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

            <a href='index.php'>
              <div id='add_exercise_go_home_button'>
                <h3 id='home_link'>
                <svg width='24' height='24' fill='none' viewBox='0 0 24 24'>
                  <path stroke='currentColor' stroke-linecap='round' stroke-linejoin='round' stroke-width='1.5' d='M6.75024 19.2502H17.2502C18.3548 19.2502 19.2502 18.3548 19.2502 17.2502V9.75025L12.0002 4.75024L4.75024 9.75025V17.2502C4.75024 18.3548 5.64568 19.2502 6.75024 19.2502Z'/>
                  <path stroke='currentColor' stroke-linecap='round' stroke-linejoin='round' stroke-width='1.5' d='M9.74963 15.7493C9.74963 14.6447 10.6451 13.7493 11.7496 13.7493H12.2496C13.3542 13.7493 14.2496 14.6447 14.2496 15.7493V19.2493H9.74963V15.7493Z'/>
                </svg>
                </svg>
                </h3>
              </div>
            </a>

          </form>
      

    </div>

  </div>

";
