<?php

include_once('include/init.php');
echoHeader('Manage Exercises');

$userId = $_SESSION['userId'];

echo "
  <div class='search_bar'>
    <img src='include/icons/search.svg' />
  </div>";

  displayAllExercises($userId);

echo "
  <a href='new_exercise.php' class='create_new_button'>
    <h3 class='header_text'>Create New</h3>
  </a>

  <a href='manage.php' class='small_button'>
    <p class='small_text'>Back</p>
  </a>
";
