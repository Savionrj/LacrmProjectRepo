<?php

include_once('include/init.php');
echoHeader('Edit Exercise');

$exerciseId = $_SESSION['current_exerciseId'];
$exerciseData = getExerciseById($exerciseId);

$exerciseHead = $exerciseData['exerciseName'];

if (isset($_REQUEST['update_exercise'])) {
  $exerciseName = $_REQUEST['exercise_name'];
  $use_reps = $_REQUEST['use_reps'];
  $use_steps = $_REQUEST['use_steps'];
  $use_weight = $_REQUEST['use_weight'];
  $use_minutes = $_REQUEST['use_minutes'];
  debugOutput($_REQUEST);
  updateExercise($exerciseId, $exerciseName, $use_reps, $use_steps, $use_weight, $use_minutes);
  header('location:manage_exercises.php');
} 
elseif (isset($_REQUEST['delete'])) {
  if($_REQUEST['delete'] == $exerciseId){
    deleteExercise($exerciseId);
    header('location:manage_exercises.php');
  }
}

echo "
</br></br></br></br></br></br></br></br></br></br>
  <form class='centered_form' method='post' id='update_exercise'>
    <h3 class='form_heading'>Exercise Name</h3>
    <input type='text' name='exercise_name' class='standard_form_box' value='$exerciseHead' required /> <br/> <br/>
    <div class='checkbox_grid'>
      <div class=checkbox_col>
        <div class='checkbox_single'>
          <h3 class='form_heading'>Reps</h3>
          <input type='hidden' class='checkbox' name='use_reps' value='0' />
          <input type='checkbox' class='checkbox' name='use_reps' value='1' />
        </div>
        <div class='checkbox_single'>
          <h3 class='form_heading'>Steps</h3>
          <input type='hidden' class='checkbox' name='use_steps' value='0' />
          <input type='checkbox' class='checkbox' name='use_steps' value='1' />
        </div>
      </div>
      <div class=checkbox_col>
        <div class='checkbox_single'>
          <h3 class='form_heading'>Weight</h3>
          <input type='hidden' class='checkbox' name='use_weight' value='0' />
          <input type='checkbox' class='checkbox' name='use_weight' value='1' />
        </div>
        <div class='checkbox_single'>
          <h3 class='form_heading'>Minutes</h3>
          <input type='hidden' class='checkbox' name='use_minutes' value='0' />
          <input type='checkbox' class='checkbox' name='use_minutes' value='1' />
        </div>
      </div>
    </div>
    <button class='side_nav_button' type='submit' value='$exerciseId' name='delete' style='border-color:red; width:200px; height:200px;'>
      <img src='include/icons/trash.svg' height='100' width='100' />
    </button>
  </form>

  <div class='bottom_nav'>
    <a href='manage_exercises.php' class='side_nav_button'>
      <img src='include/icons/undo.svg' />
    </a>
    <a href='index.php' class='nav_button' >
      <img src='include/icons/home.svg' />
    </a>
    <button type='submit' class='side_nav_button' name='update_exercise' form='update_exercise'>
      <img height='100' width='100' src='include/icons/check.svg' />
    </button>
  </div>
";
