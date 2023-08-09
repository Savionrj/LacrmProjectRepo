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

  <div id='all_sessions_page' style='display:none'>
    <h3 class='header_text'>Most Recent Session</h3>
    <div class='select_card'>
      <p class='small_text'>7/12/23 - 7 Exercises - Chest</p>
    </div>
    <h3 class='header_text'>All Sessions</h3>";
    displayAllSessions($userId);
echo "
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
