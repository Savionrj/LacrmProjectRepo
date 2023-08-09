<?php

include_once('include/init.php');
echoHeader('Home');

if(empty($_SESSION)){
  header('location:login.php');
}
else{
  $user = getUser($_SESSION['userId']);
  $userId = $_SESSION['userId'];

echo "
  <div id='home_page'>
    <h1 id='title_text'>MoveMinder</h1>
    <h3 class='app_direction_text'>Welcome Back " . $user['firstName'] . "</h3>
    <div id='index_center_interactivity'>
      <div id='nav_arrows'>
        <button type='button' id='slide_left_modal' onclick='slideLeft()'>
          <img src='include/icons/arrow-left.svg' />
        </button>
        <button type='button' id='slide_left_modal' onclick='slideRight()'>
          <img src='include/icons/arrow-right.svg' />
        </button>
      </div>
      <a href='select_routine.php' id='start_session_link'>
        <div id='start_session_button'></div>
      </a>
    </div>
    <h3 class='header_text'>Start Session</h3>
  </div>

  <div id='all_sessions_page' style='display:none'>";
  $recentSession = getMostRecentSession($userId);
  $sessionId = $recentSession['sessionId'];
  $exercisesInSession = getExercisesInSession($sessionId);
  $exerciseCountInSession = count($exercisesInSession);
  $routineId = $recentSession['routineId'];
  $routine = getSingleRoutine($userId, $routineId);
  echo"
    <h3 class='header_text'>Most Recent Session</h3>
    <form action='previous_session.php' method='post'>
      <input type='hidden' name='sessionIdPass' value=" . $recentSession['sessionId'] . " />
      <button name='session_card_button' type='submit' class='select_card'>
          <p class='small_text'>" . $recentSession['dateLogged'] . " - " . $exerciseCountInSession . " Exercises - " . $routine['routineName'] . "</p>
      </button>
    </form>
    <h3 class='header_text'>All Sessions</h3>";
    displayAllSessions($userId);
echo "
  </div>

  <div id='manage_page' style='display:none'>
    <a href='manage_exercises.php' class='select_card'>
      <h3 class='header_text'>Manage Exercises</h3>
    </a>
    <a href='manage_routines.php' class='select_card'>
      <h3 class='header_text'>Manage Routines</h3>
    </a>
      <a href='login.php' id='sign_out_button' class='select_card'>
      <h3 class='header_text'>Sign Out</h3>
    </a>
  </div>
  

  <script type='text/javascript'>
    function slideLeft(){
      document.getElementById('home_page').style.display = 'none';
      document.getElementById('all_sessions_page').style.display = 'flex';
    }

    function slideRight(){
      document.getElementById('home_page').style.display = 'none';
      document.getElementById('manage_page').style.display = 'flex';
    }
  </script>
";
}
