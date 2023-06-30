<?php

include_once('include/init.php');
echoHeader('Home');


$user = getUser($_SESSION['userId']);

echo "
  <div id='home_page'>
";

echo "

  <div id='home_header'>
    
    <div id='profile_button'>
    </div>

    <div id='home_greeting'>
      <p>Hi ".$user['firstName']."!</p>
    </div>

  </div>

  <div id='session_display'>";
    // listSessions();
  echo "</div>

  <div id='home_menu'>
    <div>
      
    </div>

    <div id='new_exercise'>

    </div>

    <div>
    </div>

  </div>

  </div>

";
