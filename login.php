<?php
    session_start();

    if(isset($_POST['btnLogin']))
    {
      $username = filter_input(INPUT_POST, 'username', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
      $password = filter_input(INPUT_POST, 'password', FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_HIGH);

      if(empty($username))
      {
        $errMSG = "Username cannot be empty.";
      }
      else if (empty($password))
      {
        $errMSG = "Password cannot be empty.";
      }
      else if (empty($username) && empty($password))
      {
        $errMSG = "Please enter your username and password!";
      }
      else
      {
        header("Location: index.php");
      }

      if(!isset($errMSG))
      {
        $query = 'SELECT * FROM users WHERE username=:username';
        $statement = $db->prepare($query);

        $statement->bindParam(':username', $username);

        $statement->execute();

        $user = $statement->fetch(PDO::FETCH_ASSOC);

        if($user === false)
        {
          die('Incorrect username or password!');
        }
        else
        {
          $validPassword = password_verify($passwordAttempt, $user['password']);

          if($validPassword)
          {
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['logged_in'] = time();

            header('Location: index.php');
            exit;
          }
          else
          {
            die('Incorrect username or password!');
          }
        }
      }
    }
?>
