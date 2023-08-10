<?php

include_once('include/init.php');
echoHeader('All Sessions');

$userId = $_SESSION['userId'];

$recentSession = getMostRecentSession($userId);

if(!empty($recentSession)){
$sessionId = $recentSession['sessionId'];
$exercisesInSession = getExercisesInSession($sessionId);
$exerciseCountInSession = count($exercisesInSession);
$routineId = $recentSession['routineId'];
$routine = getSingleRoutine($userId, $routineId);

echo "
    <h3 class='header_text'>All Sessions</h3>";
displayAllSessions($userId);
echo "
  </div>
";
}
else{
  echo "
    <div class='full_page_text'>
      <h3 class='direction_text'>Your Sessions</br>Will Appear Here</h3>
      <a href='select_routine.php'>
        <h3 class='head_text'>Start One Now</h3>
      </a>
    </div>
  ";
}

echo "
  <div class='bottom_nav'>
    <a href='index.php' class='nav_button' >
      <img src='include/icons/home.svg' />
    </a>
  </div>
";
