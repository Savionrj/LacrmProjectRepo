<?php

include_once('include/init.php');
echoHeader('Edit Exercise');

$exerciseId = $_SESSION['current_exerciseId'];
$exerciseData = getExerciseById($exerciseId);

$exerciseName = $exerciseData['exerciseName'];

if (isset($_REQUEST['update_exercise'])) {
  $exerciseName = $_REQUEST['exercise_name'];
  $use_reps = $_REQUEST['use_reps'];
  $use_steps = $_REQUEST['use_steps'];
  $use_weight = $_REQUEST['use_weight'];
  $use_minutes = $_REQUEST['use_minutes'];
  updateExercise($exerciseId, $exerciseName, $use_reps, $use_steps, $use_weight, $use_minutes);
  header('location:manage_exercises.php');
} 
elseif (isset($_REQUEST['delete'])) {
  deleteExercise($exerciseId);
  header('location:manage_exercises.php');
}

echo "
  <form method='post'>
    <h3 class='form_heading'>Exercise Name</h3>
    <input type='text' name='exercise_name' class='standard_form_box' value=".$exerciseName. " required /> <br/> <br/>
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
    <button style='border-color:red' class='standard_button' type='submit' value='$exerciseId' name='delete'>
      <img src='include/icons/trash.svg' height='100' width='100' />
    </button>
    <button type='submit' class='create_new_button' name='update_exercise'>
      <h3 class='header_text'>Done</h3>
    </button>
  </form>
  <a href='manage_exercises.php' class='small_button'>
    <p class='small_text'>Cancel</p>
  </a>
";
