<?php

include_once('include/init.php');
echoHeader('All Exercises');

if(isset($_REQUEST['addExercise'])){
  addExercise ($_REQUEST['exerciseName'], $_REQUEST["exerciseType"], $_REQUEST['session'], $_REQUEST['target'] );
  header('location:?');
  exit;
}

echo "
  <div id='all_exercises_page'>
";

echo "

    <div id='exercises_list'>";
    
      displayAllExercises();

  echo "
    </div>

  </div>
";
