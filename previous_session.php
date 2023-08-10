<?php

include_once('include/init.php');
echoHeader('Previous Session');

$sessionId = $_SESSION['observed_session'];

$exerciseIds = getExerciseIdsFromSesEx($sessionId);

foreach($exerciseIds as $individualExerciseId){
  $exerciseId = $individualExerciseId['exerciseId'];
  $exerciseName = getExerciseNameById($exerciseId);
  $sessionEx = getSessionExercise($sessionId, $exerciseId);
  $sessionExId = $sessionEx['sessionExerciseId'];
  $allSets = getSet($sessionExId);
  $count=0;
  echo "
    <div class='logged_exercise'>
      <h3 class='header_text'>".$exerciseName. "</h3>
        <div style='margin:5%; border:3px solid #A3F8AB; border-radius:50px;'>";
          foreach($allSets as $singleSet){
            $count++;
            echo "
              <div class='set_row'>
                <div class='set_row_box'>".$count. "</div>";
                  if($singleSet['steps'] !== 0){
                    echo "
                      <div class='set_row_box'>Steps: ".$singleSet['steps']."</div>
                    ";
                  }
                  else{
                    ;
                  }
                  if ($singleSet['reps'] !== 0) {
                    echo "
                      <div class='set_row_box'>Reps: " . $singleSet['reps'] . "</div>
                      ";
                  } 
                  else {;
                  }
                  if ($singleSet['weight'] !== 0) {
                    echo "
                      <div class='set_row_box'>Weight: " . $singleSet['weight'] . "</div>
                      ";
                  } 
                  else {;
                  }
                  if ($singleSet['minutes'] !== 0) {
                    echo "
                        <div class='set_row_box'>Minutes: " . $singleSet['minutes'] . "</div>
                      ";
                  } 
                  else {;
                  }
                echo"
              </div>
            ";
          }
        echo"
          </div>
        </div>
      ";
}

echo "

  <div class='bottom_nav'>
  <a href='all_sessions.php' class='side_nav_button'>
    <img src='include/icons/undo.svg' />
  </a>
    <a href='index.php' class='nav_button' >
      <img src='include/icons/home.svg' />
    </a>
    <div href='all_sessions.php' class='hidden_nav_button'>
    </div>
  </div>

";
