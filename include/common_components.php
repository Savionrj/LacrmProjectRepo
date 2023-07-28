<?php

  function echoHeader($pageTitle)
  {
    echo "
      <html>

      <head>
        <title>$pageTitle</title>
        <link rel='stylesheet' href='/include/style/style.css' />
      </head>

      <body>
      <div id='default_page'>
        
      ";
  }
