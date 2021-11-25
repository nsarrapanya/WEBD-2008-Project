<?php
    require('connect.php');

    if(isset($_POST['btnRegister']))
    {
      // customer information fieldset
      $fname = filter_input(INPUT_POST, 'fname', FILTER_SANITIZE_STRING);
      $lname = filter_input(INPUT_POST, 'lname', FILTER_SANITIZE_STRING);
      $address = filter_input(INPUT_POST, 'address', FILTER_SANITIZE_STRING);
      $postal = filter_input(INPUT_POST, 'postal', FILTER_VALIDATE_REGEXP, array(
          "options" => array(
            "regexp" => '/^[ABCEGHJKLMNPRSTVXY]\d[ABCEGHJKLMNPRSTVWXYZ]( )?\d[ABCEGHJKLMNPRSTVWXYZ]\d$/i')
          ));
      // $province = filter_input(INPUT_POST, 'province', FILTER_SANITIZE_STRING);
      $phone_number = filter_input(INPUT_POST, 'phone_number', FILTER_SANITIZE_NUMBER_INT);
      $city = filter_input(INPUT_POST, 'city', FILTER_SANITIZE_STRING);
      // login information fieldset
      $username = filter_input(INPUT_POST, 'username', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
      $password = filter_input(INPUT_POST, 'password', FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_HIGH);
      // $retype_password = filter_input(INPUT_POST, 'retype_password', FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_HIGH);
      $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);

      // $arr = [$fname, $lname, $address, $postal, $phone_number, $username, $password, $email];

      // for($i=0; $i<count($arr[$i]); $i++)
      // {
      //   if(empty($arr[$i])) {
      //     $errMSG = "Field(s) cannot be empty";
      //     console.log();
      //   }
      // }

      if(empty($fname))
      {
        $errMSG = "Please enter your first name.";
      }
      else if(empty($lname))
      {
        $errMSG = "Please enter your last name.";
      }
      else if(empty($address))
      {
        $errMSG = "Please enter your address.";
      }
      else if(empty($postal))
      {
        $errMSG = "Please enter your postal code.";
      }
      else if(strlen($phone_number) !== 12 || !preg_match('/^\d{3}(-)?\d{3}(-)?\d{4}$/', $phone_number))
      {
        $errMSG = "Your phone number must be exactly 10 digits containing dashes.";
      }
      else if(empty($username))
      {
        $errMSG = "Please enter your username";
      }
      else if(empty($password))
      {
        $errMSG = "Please enter your password";
      }
      else if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errMSG = "Please enter a valid email address";
      }

      if(!isset($errMSG))
      {
        $query = 'SELECT COUNT(username) AS num FROM users WHERE username=:username';
        $statement = $db->prepare($query);

        $statement->bindValue(':username', $username);

        $statement->execute();

        $row = $statement->fetch(PDO::FETCH_ASSOC);

        //If the provided username already exists - display error.
        //TO ADD - Your own method of handling this error. For example purposes,
        //I'm just going to kill the script completely, as error handling is outside
        //the scope of this tutorial.
        if($row['num'] > 0)
        {
          die('That username already exists!');
        }

        //Hash the password as we do NOT want to store our passwords in plain text.
        $passwordHash = password_hash($password, PASSWORD_BCRYPT, array("cost" => 12));

        $query = 'INSERT INTO users (username, password, first_name, last_name, address, phone_number, city, province, postal_code, email_address)
                  VALUES (:username, :password, :first_name, :last_name, :address, :phone_number, :city, :province, :postal_code, :email_address)';
        $statement = $db->prepare($query);

        $statement->bindValue(':username', $username);
        $statement->bindValue(':password', $passwordHash);
        $statement->bindValue(':first_name', $fname);
        $statement->bindValue(':last_name', $lname);
        $statement->bindValue(':address', $address);
        $statement->bindValue(':phone_number', $phone_number);
        $statement->bindValue(':city', $city);
        $statement->bindValue(':province', $_POST['province']);
        $statement->bindValue(':postal_code', $postal);
        $statement->bindValue(':email_address', $email);

        if($statement->execute())
        {
          $successMSG = "Thank you for registering with Dee's nuts!";
          echo "<script type='text/javascript'>alert('$successMSG')</script>";
          header("Location: index.php"); // redirect to main page.
        }
        else
        {
          $errMSG = "error while inserting....";
        }
      }
    }
?>
<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>Register</title>
    <!-- Bootstrap -->
    <link rel="stylesheet" href="css/bootstrap.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.7.0/font/bootstrap-icons.css">
  </head>
  <body>
    <?php require('header.php')?>

    <div class="container">
      <h1 class="display-6">New Customer</h1>
      <form class="row" method="post">
        <fieldset class="row g-3">
          <legend>Customer information</legend>
          <div class="col-6">
            <label class="form-label">First name</label>
            <input type="text" class="form-control" placeholder="Addie" name="fname">
          </div>
          <div class="col-6">
            <label class="form-label">Last name</label>
            <input type="text" class="form-control" placeholder="Smith" name="lname">
          </div>
          <div class="col-12">
            <label class="form-label">Address</label>
            <input type="text" class="form-control" placeholder="1234 Main St" name="address">
          </div>
          <div class="col-6">
            <label for="inputZip" class="form-label">Postal code</label>
            <input type="text" class="form-control" placeholder="A1B 2C3" name="postal">
          </div>
          <div class="col-4">
            <label class="form-label">City</label>
            <input type="text" class="form-control" name="city">
          </div>
          <div class="col-2">
            <label class="form-label">Province</label>
            <select class="form-select" name="province">
              <option selected value="Alberta">Alberta</option>
              <option value="British Columbia">British Columbia</option>
              <option value="Manitoba">Manitoba</option>
              <option value="New Brunswick">New Brunswick</option>
              <option value="Newfoundland and Labrador">Newfoundland and Labrador</option>
              <option value="Nova Scotia">Nova Scotia</option>
              <option value="Ontario">Ontario</option>
              <option value="Prince Edward Island">Prince Edward Island</option>
              <option value="Quebec">Quebec</option>
              <option value="Saskatchewan">Saskatchewan</option>
              <option value="Northwest Territories">Northwest Territories</option>
              <option value="Nunavut">Nunavut</option>
              <option value="Yukon">Yukon</option>
            </select>
          </div>
          <div class="col-12">
            <labe class="form-label">Phone number</label>
            <input type="text" class="form-control" placeholder="204-123-4567" name="phone_number">
          </div>
        </fieldset>
        <fieldset class="row g-3">
          <legend>Login information</legend>
          <div class="col-6">
            <label class="form-label">Username</label>
            <input type="text" class="form-control" name="username">
          </div>
          <div class="col-6">
            <label class="form-label">Password</label>
            <input type="password" class="form-control" name="password">
          </div>
          <!-- <div class="col-6">
            <label class="form-label">Re-enter password</label>
            <input type="password" class="form-control" name="retype_password">
          </div> -->
          <div class="col-12">
            <label class="form-label">Email address</label>
            <input type="text" class="form-control" placeholder="email@domain.com" name="email">
          </div>
        </fieldset>
        <div class="col-1 offset-11 gy-3">
          <button type="submit" class="btn btn-primary" name="btnRegister">Submit</button>
        </div>
      </form>
    </div>

    <!-- Bootstrap scripts -->
    <script src="js/bootstrap.bundle.js"></script>
    <!-- Custom scripts -->
    <!-- <script src="js/scripts.js"></script> -->
  </body>
</html>
