<?php

  function echoHeader($pageTitle)
  {
    echo "
      <html>

      <head>
        <title>$pageTitle</title>
        <link rel='stylesheet' href='/include/style/index.css' />
        <link rel='stylesheet' href='/include/style/login.css' />
        <link rel='stylesheet' href='/include/style/register.css' />
        <link rel='stylesheet' href='/include/style/log_exercise.css' />
        <link rel='stylesheet' href='/include/style/add_exercise.css' />
      </head>

      <body>
      <div id='default_page'>
        
      ";
  }
