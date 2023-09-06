<?php

include_once('include/init.php');
echoHeader('Add Freestyle');

$userId = $_SESSION['userId'];

$exercises = getExercises($userId);
if(!empty($exercises)){
  displayAllExercisesForFreestyle($userId);
}
else{
  echo "
    <div class='full_page_text'>
      <h3 class='direction_text'>No Exercises</h3>
      <a href='new_exercise.php'>
        <h3 class='direction_text'>Create One Here</h3>
      </a>
    </div>
  ";
}


