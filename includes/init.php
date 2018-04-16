<?php
// An array to deliver messages to the user.
$messages = array();

// Record a message to display to the user.
function record_message($message) {
  global $messages;
  array_push($messages, $message);
};

// Print messages to user.
function print_messages() {
  global $messages;
  foreach ($messages as $message) {
    echo htmlspecialchars($message);
  }
};


function exec_sql_query($db, $sql, $params = array()) {
  try {
    $query = $db->prepare($sql);
    if ($query and $query->execute($params)) {
      return $query;
    }
  } catch (PDOException $exception) {
    handle_db_error($exception);
  }
  return NULL;
};
// connection string for heroku
$connection_string= "dbname=d9bvjse2g8ba1h host=ec2-54-243-210-70.compute-1.amazonaws.com port=5432 user=dxwirrhzaydomo password=62adc98f8f11caa8d9a71c385d70edb1483dbb761458189b20f5ba9f6ddfae6e sslmode=require";

// PDO connection using heroku string
$conn = new PDO ("pgsql:".$connection_string);

function check_login() {
  global $conn;

  if (isset($_COOKIE["session"])) {
    $session = $_COOKIE["session"];

    $sql = "SELECT * FROM accounts WHERE session = :session;";
    $params = array (
      ':session' => $session
    );
    $records = exec_sql_query($conn, $sql, $params)->fetchAll();
    if ($records) {
      // Username is UNIQUE, so there should only be 1 record.
      $account = $records[0];
      return $account;
    }
  }
  return NULL;
}

function log_in($username, $password) {
  global $conn;
  //echo $username;
  //echo $password;
  if ($username && $password) {
    $sql = "SELECT * FROM accounts WHERE username = :username;";
    $params = array(
      ':username' => $username
    );
    $records = exec_sql_query($conn, $sql, $params)->fetchAll();
    //var_dump($records);
    if ($records) {
      // Username is UNIQUE, so there should only be 1 record.
      $account = $records[0];
      //echo "i made it in records ";
      // Check password against hash in DB
      if (password_verify($password, $account['password'])) {

        // Generate session
        $session = session_create_id();
        $sql = "UPDATE accounts SET session = :session WHERE id = :user_id;";
        $params = array (
          ':user_id' => $account['id'],
          ':session' => $session
        );
        $result = exec_sql_query($conn, $sql, $params);
        if ($result) {
          // Success, session stored in DB
        //  echo "yo i updated session ";
          // Send this back to the user.
          setcookie("session", $session, time()+3600);  /* expire in 1 hour */

          record_message("Logged in as $username.");
          return $account;
        } else {
          record_message("Log in failed.");
        }
      } else {
        record_message("Invalid username or password.");
      }
    } else {
      record_message("Invalid username or password.");
    }
  } else {
    record_message("No username or password given.");
  }
  return NULL;
}
function log_out() {
  global $current_user;
  global $conn;

  if ($current_user) {
    $sql = "UPDATE accounts SET session = :session WHERE username = :username;";
    $params = array(
      ':username' => $current_user,
      ':session' => NULL
    );
    if (!exec_sql_query($conn, $sql, $params)) {
      record_message("Log out failed.");
    }
  }

  // Remove the session from the cookie and force it to expire.
  setcookie("session", "", time()-3600);
  $current_user = NULL;
}

// Check if we should login the user
if (isset($_POST['login'])) {
  //echo "you logged in";
  $username = filter_input(INPUT_POST, 'username', FILTER_SANITIZE_STRING);
  $username = trim($username);
  $password = filter_input(INPUT_POST, 'password', FILTER_SANITIZE_STRING);

  $current_user = log_in($username, $password);

} else {
  // check if logged in
  $current_user = check_login();
}

?>
