<?php

include_once('include/init.php');
echoHeader('New Routine');

if (isset($_REQUEST['add_routine'])) {
  $routineName = $_REQUEST['routine_name'];
  addRoutine($routineName);
  header('location:manage_routines.php');
}

echo "
</br></br></br></br></br></br></br></br></br></br>
  <form class='centered_form' method='post' style='align-self:center' id='new_routine_form'>
    <h3 class='form_heading'>Routine Name</h3>
    <input type='text' name='routine_name' class='standard_form_box' required /> <br/> <br/>
  </form>

  <div class='bottom_nav'>
    <a href='manage_routines.php' class='side_nav_button'>
      <img src='include/icons/undo.svg' />
    </a>
    <a href='index.php' class='nav_button' >
      <img src='include/icons/home.svg' />
    </a>
    <button type='submit' class='side_nav_button' name='add_routine' form='new_routine_form'>
      <img height='100' width='100' src='include/icons/check.svg' />
    </button>
  </div>
";
