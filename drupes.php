<?php
    session_start();
    require('connect.php');

    $query = 'SELECT * FROM products JOIN categories ON products.category_id = categories.category_id WHERE products.category_id = 2';

    $statement = $db->prepare($query);
    $statement->execute();
?>
 <!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>Drupes nuts</title>

    <!-- Bootstrap -->
    <link rel="stylesheet" href="css/bootstrap.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.7.0/font/bootstrap-icons.css">
  </head>
  <body>
    <!-- Navbar -->
    <?php
        if(!isset($_SESSION['user_id']) || !isset($_SESSION['logged_in']))
        {
          include('nav.php');
        }
        else if($_SESSION['user_id'] == 1)
        {
          include('admin_nav.php');
        }
        else
        {
          include('user_nav.php');
        }
    ?>

    <!-- Container -->
    <div class="container">
      <div class="row row-cols-3">
        <?php include('container.php')?>
      </div>
    </div>
    <!-- Bootstrap scripts -->
    <script src="js/bootstrap.bundle.js"></script>
    <!-- Custom scripts -->
    <!-- <script src="js/scripts.js"></script> -->
  </body>
</html>
