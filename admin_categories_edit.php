<?php
    session_start();
    require('authenticate.php');
    require('connect.php');

    if(isset($_GET['category_id']) && !empty($_GET['category_id'])) {
      $category_id = filter_input(INPUT_GET, 'category_id', FILTER_SANITIZE_NUMBER_INT);

      $query = 'SELECT * FROM categories WHERE category_id=:category_id';
      $statement = $db->prepare($query);

      $statement->bindParam(':category_id', $category_id, PDO::PARAM_INT);

      $statement->execute(array(':category_id'=>$category_id));

      $row = $statement->fetch(PDO::FETCH_ASSOC);
      extract($row);
    }
    else {
      header('Location: admin_categories.php');
    }

    if(isset($_POST['btnSubmit'])) {
      $category_name = filter_input(INPUT_POST, 'category_name', FILTER_SANITIZE_STRING);
      $category_description = filter_input(INPUT_POST, 'category_description', FILTER_SANITIZE_STRING);
      $category_href = filter_input(INPUT_POST, 'category_href', FILTER_SANITIZE_STRING);

      if(empty(trim($category_name))) {
        $errMSG = "Please enter a category name.";
        echo $errMSG;
      }
      else if(empty(trim($category_description))) {
        $errMSG = "Please enter a category description.";
        echo $errMSG;
      }
      else if(empty(trim($category_href))) {
        $errMSG = "Please enter a category href.";
        echo $errMSG;
      }

      if(!isset($errMSG)) {
        $query = 'INSERT INTO categories (category_name, category_description, category_href) VALUES (:category_name, :category_description, :category_href)';

        $statement = $db->prepare($query);
        $statement->bindParam(':category_name', $category_name);
        $statement->bindParam(':category_description', $category_description);
        $statement->bindParam(':category_href', $category_href);

        if($statement->execute()) {
          header("Location: index.php");
        }
        else {
          $errMSG = "Error while inserting....";
          echo $errMSG;
        }
      }
    }
?>

<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>Dee's Nuts - Admin categories insert</title>

    <!-- Bootstrap -->
    <link rel="stylesheet" href="css/bootstrap.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.7.0/font/bootstrap-icons.css">
    <script src="js/bootstrap.bundle.js"></script>
  </head>
  <body>

    <!-- Navbar -->
    <?php include('admin_nav.php')?>

    <!-- Form -->
    <div class="container">
      <form class="post" method="post">
        <h1 class="display-6">Add a new category</h1>
        <div class="mb-3">
          <label>Category name</label>
          <input type="text" class="form-control" name="category_name" placeholder="Botanical" value="<?= $row['category_name']?>">
        </div>
        <div class="mb-3">
          <label>Category description</label>
          <input type="text" class="form-control" name="category_description" placeholder="Dry, hard-shelled, compartmentalized fruit that do not split on maturity to release seeds." value="<?= $row['category_description']?>">
        </div>
        <button type="submit" class="btn btn-success" name="btnSubmit">Submit</button>
        <a class="btn btn-warning" href="admin_categories.php">Cancel</a>
      </form>
    </div>
  </body>
</html>
