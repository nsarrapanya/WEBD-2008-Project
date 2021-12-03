<?php
    session_start();
    require('connect.php');

    if(isset($_POST['btnLogin'])) {
      $username = filter_input(INPUT_POST, 'username', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
      $password = filter_input(INPUT_POST, 'password', FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_HIGH);

      if(empty(trim($username))) {
        $errMSG = "Please enter you username!";
        echo $errMSG;
      }
      else if (empty(trim($password))) {
        $errMSG = "Please enter your password!";
        echo $errMSG;
      }
      else if (empty(trim($username)) && empty(trim($password))) {
        $errMSG = "Please enter your username and password!";
        echo $errMSG;
      }

      if(!isset($errMSG)) {
        $query = 'SELECT * FROM users WHERE username=:username';
        $statement = $db->prepare($query);

        $statement->bindParam(':username', $username);

        $statement->execute();

        $user = $statement->fetch(PDO::FETCH_ASSOC);

        if($user === false) {
          die('Incorrect username or password!');
        }
        else {
          $validPassword = password_verify($password, $user['password']);

          if($validPassword) {
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['logged_in'] = time();

            if($_SESSION['user_id'] == 1 || $_SESSION['user_id'] == 5) {
              $_SESSION['user_id'] = $user['id'];
              $_SESSION['logged_in'] = time();

              header("Location: index.php");
              exit();
            }
            else {
              $_SESSION['user_id'] = $user['id'];
              $_SESSION['logged_in'] = time();

              header("Location: index.php");
              exit();
            }
          }
          else {
            die('Incorrect username or password!');
          }
        }
      }
    }
?>
<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <title>Sign in</title>

    <!-- Bootstrap core CSS -->
    <link href="css/bootstrap.css" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="css/signin.css" rel="stylesheet">
  </head>
  <body class="text-center">
    
  <main class="form-signin">
    <form method="post">
      <!-- <img class="mb-4" src="../assets/brand/bootstrap-logo.svg" alt="" width="72" height="57"> -->
      <h1 class="h3 mb-3 fw-normal">Please sign in</h1>

      <div class="form-floating">
        <input type="text" class="form-control" name="username">
        <label for="floatingInput">Username</label>
      </div>
      <div class="form-floating">
        <input type="password" class="form-control" name="password">
        <label for="floatingPassword">Password</label>
      </div>

      <!-- <div class="checkbox mb-3">
        <label>
          <input type="checkbox" value="remember-me"> Remember me
        </label>
      </div> -->

      <p>Don't have an account? <a href="register.php">Register</a></p>

      <button class="w-100 btn btn-lg btn-primary" type="submit" name="btnLogin">Sign in</button>
      <!-- <p class="mt-5 mb-3 text-muted">&copy; 2017–2021</p> -->
    </form>
  </main>
  </body>
</html>
