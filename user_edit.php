<?php
    session_start();
    require('authenticate.php');
    require('connect.php');

    if(isset($_GET['id']) && !empty($_GET['id'])) {
      $id = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_NUMBER_INT);

      $query = 'SELECT * FROM users WHERE id=:id';
      $statement = $db->prepare($query);

      $statement->bindParam(':id', $id, PDO::PARAM_INT);

      $statement->execute(array(':id'=>$id));

      $row = $statement->fetch(PDO::FETCH_ASSOC);
      extract($row);
    }
    else {
      header('Location: admin_edit_user.php');
    }

    if(isset($_POST['btnRegister'])) {
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
      $confirm_password = filter_input(INPUT_POST, 'confirm_password', FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_HIGH);
      $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);

      if(empty($fname)) {
        $errMSG = "Please enter your first name.";
      }
      else if(empty($lname)) {
        $errMSG = "Please enter your last name.";
      }
      else if(empty($address)) {
        $errMSG = "Please enter your address.";
      }
      else if(empty($postal)) {
        $errMSG = "Please enter your postal code.";
      }
      else if(strlen($phone_number) !== 12 || !preg_match('/^\d{3}(-)?\d{3}(-)?\d{4}$/', $phone_number)) {
        $errMSG = "Your phone number must be exactly 10 digits containing dashes.";
      }
      else if(empty($username)) {
        $errMSG = "Please enter your username";
      }
      else if(empty($password)) {
        $errMSG = "Please enter your password";
      }
      else if($password != $confirm_password) {
        $errMSG = "Your password does not match";
      }
      else if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errMSG = "Please enter a valid email address";
      }

      if(!isset($errMSG)) {
        $query = 'SELECT COUNT(username) AS num FROM users WHERE username=:username';
        $statement = $db->prepare($query);

        $statement->bindValue(':username', $username);

        $statement->execute();

        $row = $statement->fetch(PDO::FETCH_ASSOC);

        if($row['num'] > 0) {
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

        if($statement->execute()) {
          $successMSG = "Thank you for registering with Dee's nuts!";
          header("Location: index.php"); // redirect to main page.
        }
        else {
          $errMSG = "error while inserting....";
          echo $errMSG;
        }
      }
    }
?>

<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>Dee's Nuts - User edit</title>

    <!-- Bootstrap -->
    <link rel="stylesheet" href="css/bootstrap.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.7.0/font/bootstrap-icons.css">
  </head>
  <body>
    <!-- Navbar -->
    <?php
        if(!isset($_SESSION['user_id']) || !isset($_SESSION['logged_in'])) {
          include('nav.php');
        }
        else if($_SESSION['user_id'] == 1) {
          include('admin_nav.php');
        }
        else {
          include('user_nav.php');
        }
    ?>

    <div class="container">
      <h1>Editing <?= $row['username']?></h1>
      <form class="row" method="post">
        <fieldset class="row g-3">
          <legend>Customer information</legend>
          <div class="col-6">
            <label class="form-label">First name</label>
            <input type="text" class="form-control" placeholder="Addie" name="fname" value=<?= $row['first_name']?>>
          </div>
          <div class="col-6">
            <label class="form-label">Last name</label>
            <input type="text" class="form-control" placeholder="Smith" name="lname" value=<?= $row['last_name']?>>
          </div>
          <div class="col-12">
            <label class="form-label">Address</label>
            <input type="text" class="form-control" placeholder="1234 Main St" name="address"
            value=<?= $row['address']?>>
          </div>
          <div class="col-6">
            <label for="inputZip" class="form-label">Postal code</label>
            <input type="text" class="form-control" placeholder="A1B 2C3" name="postal"
            value=<?= $row['postal_code']?>>
          </div>
          <div class="col-4">
            <label class="form-label">City</label>
            <input type="text" class="form-control" name="city" placeholder="Winnipeg" value=<?= $row['city']?>>
          </div>
          <div class="col-2">
            <label class="form-label">Province</label>
            <select class="form-select" name="province">
              <option value=<?= $row['first_name']?> selected><?= $row['first_name']?></option>
              <option value="Alberta">Alberta</option>
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
            <input type="text" class="form-control" placeholder="204-123-4567" name="phone_number" value=<?= $row['phone_number']?>>
          </div>
        </fieldset>
        <fieldset class="row g-3">
          <legend>Login information</legend>
          <div class="col-12">
            <label class="form-label">Username</label>
            <input type="text" class="form-control" name="username" placeholder="asmith" value=<?= $row['username']?>>
          </div>
          <div class="col-6">
            <label class="form-label">Password</label>
            <input type="password" class="form-control" name="password" placeholder="********" value=<?= $row['password']?>>
          </div>
          <div class="col-6">
            <label class="form-label">Re-enter password</label>
            <input type="password" class="form-control" name="confirm_password" placeholder="********" value=<?= $row['password']?>>
          </div>
          <div class="col-12">
            <label class="form-label">Email address</label>
            <input type="text" class="form-control" placeholder="email@domain.com" name="email" value=<?= $row['email_address']?>>
          </div>
        </fieldset>
        <div class="col-2 offset-10 gy-3">
          <button type="submit" class="btn btn-primary" name="btnRegister">Submit</button>
          <button type="button" class="btn btn-warning" name="btnCancel" onclick="window.location.href='admin_edit_user.php'">Cancel</button>
        </div>
      </form>
    </div>

    <!-- Bootstrap scripts -->
    <script src="js/bootstrap.bundle.js"></script>

    <!-- Custom scripts -->
    <!-- <script src="js/scripts.js"></script> -->
  </body>
</html>
