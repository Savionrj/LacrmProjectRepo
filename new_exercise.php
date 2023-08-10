<?php

include_once('include/init.php');
echoHeader('New Exercise');

if(isset($_REQUEST['add_exercise'])){
  $exerciseName = $_REQUEST['exercise_name'];
  $use_reps = $_REQUEST['use_reps'];
  $use_steps = $_REQUEST['use_steps'];
  $use_weight = $_REQUEST['use_weight'];
  $use_minutes = $_REQUEST['use_minutes'];
  addExercise($exerciseName, $use_reps, $use_steps, $use_weight, $use_minutes);
  header('location:manage_exercises.php');
}

echo "
</br></br></br></br></br></br></br></br></br></br>
  <form class='centered_form' method='post' id='new_exercise_form'>
    <h3 class='form_heading'>Exercise Name</h3>
    <input type='text' name='exercise_name' class='standard_form_box' required /> <br/> <br/>
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
  </form>

  <div class='bottom_nav'>
    <a href='manage_exercises.php' class='side_nav_button'>
      <img src='include/icons/undo.svg' />
    </a>
    <a href='index.php' class='nav_button' >
      <img src='include/icons/home.svg' />
    </a>
    <button type='submit' class='side_nav_button' name='add_exercise' form='new_exercise_form'>
      <img height='100' width='100' src='include/icons/check.svg' />
    </button>
  </div>
";

// <h3 class='form_heading' style='top-margin:0px'>Routine</h3>
// <select name='routine' class='standard_form_box' >
//   <option value='0' ></option>
//   <option value='2' >Upper Body</option>
//   <option value='3' >Lower Body</option>
// </select>
