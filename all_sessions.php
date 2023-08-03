<?php

include_once('include/init.php');
echoHeader('All Sessions');

$userId = $_SESSION['userId'];

echo "
    <h3 class='header_text'>Most Recent Session</h3>
    <div class='select_card'>
      <p class='small_text'>7/12/23 - 7 Exercises - Chest</p>
    </div>
    <h3 class='header_text'>All Sessions</h3>";
displayAllSessions($userId);

