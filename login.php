<?php
include_once('include/init.php');
echoHeader('Login');
session_unset();

echo "
<div id='login_page'>
";

$errors = array();

if(isset($_REQUEST['login'])){

  verifyPassword();

}

echo"

    <form action='#' method='post'>
    
      <h3 class='login_page_form_heads'>Username</h3>
          <input type='text' name='username' class='login_page_textbox' required /> <br/> <br/>

          <h3 class='login_page_form_heads'>Password</h3>
          <input type='password' name='password' class='login_page_textbox' required /> <br/> <br/>

          <input type='submit' name='login' value='Login' class='login_button' />

    </form>

    <p class='choose_login'>
      Don't Have an Account?
    </p>
        
    <p class='choose_login'>
      <a href='register.php'>Register Here</a>
    </p>

  </div>
";

