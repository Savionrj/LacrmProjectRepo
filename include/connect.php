<?php
// For Local
    DEFINE('DB_HOSTNAME', 'localhost');
    DEFINE('DB_DATABASE', 'summer_main');
    DEFINE('DB_USERNAME', 'root');
    DEFINE('DB_PASSWORD', 'root');

if(GETENV("MOVEMINDER_IS_HEROKU")){
  error_log('Heroku Connected');
  $DbUrl = parse_url(getenv("CLEARDB_DATABASE_URL"));
  $DbServer = $DbUrl["host"];
  $DbUser = $DbUrl["user"];
  $DbPassword = $DbUrl["pass"];
  $DbName = substr($DbUrl["path"], 1);
  $dsn = "mysql:host=$DbServer;dbname=$DbName;charset=utf8";
  $opt = array(
    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::ATTR_EMULATE_PREPARES   => false,
  );
  $pdo = new PDO($dsn, $DbUser, $DbPassword, $opt);   //here is where php is connectng to the DB

// You'll want to leave the rest of the file the same below here.

}
else{
  error_log('Local Connected');
  $dsn = "mysql:host=" . DB_HOSTNAME . ";dbname=" . DB_DATABASE . ";charset=utf8";
  $opt = array(
    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::ATTR_EMULATE_PREPARES   => false,
  );
  $pdo = new PDO($dsn, DB_USERNAME, DB_PASSWORD, $opt);

}

function db_Query($query, $values = array())
{
  global $pdo;

  $stmt = $pdo->prepare($query);
  $stmt->execute($values);
  return $stmt;
}

