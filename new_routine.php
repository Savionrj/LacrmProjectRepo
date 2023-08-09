<?php

include_once('include/init.php');
echoHeader('New Routine');

if (isset($_REQUEST['add_routine'])) {
  $routineName = $_REQUEST['routine_name'];
  addRoutine($routineName);
  header('location:manage_routines.php');
}

echo "
  <form method='post' style='align-self:center'>
    <h3 class='form_heading'>Routine Name</h3>
    <input type='text' name='routine_name' class='standard_form_box' required /> <br/> <br/>
    <button type='submit' class='create_new_button' name='add_routine'>
      <h3 class='header_text'>Done</h3>
    </button>
  </form>
  <a href='manage_routines.php' class='small_button'>
    <p class='small_text'>Cancel</p>
  </a>
";
