<?php
    error_reporting( ~E_NOTICE ); // avoid notice

    require('authenticate.php');
    require('connect.php');

    if(isset($_GET['product_id']) && !empty($_GET['product_id']))
    {
      $id = $_GET['product_id'];

      $query = 'SELECT * FROM products WHERE product_id = :product_id';

      $statement = $db->prepare($query);
      $statement->execute(array(':product_id'=>$id));
      $row = $statement->fetch(PDO::FETCH_ASSOC);
      extract($row);
    }
    else
    {
      header("Location: index.php");
    }

    if(isset($_POST['btnsubmit']))
    {
      $product_name = $_POST['product_name'];  // Product name
      $product_description = $_POST['product_description'];  // Product description
      $category_id = $_POST['category_id'];  // Category id
      $product_cost = $_POST['product_cost'];  // Product cost
      // $product_image = $_POST['product_image'];  // Product image

      // $product_name = filter_input(INPUT_POST, 'product_name', FILTER_SANITIZE_STRING);
      // $product_description = filter_input(INPUT_POST, 'product_description', FILTER_SANITIZE_STRING);
      // $category_id = filter_input(INPUT_POST, 'category_id', FILTER_SANITIZE_NUMBER_INT);
      // $product_cost = filter_input(INPUT_POST, 'product_name', FILTER_SANITIZE_NUMBER_FLOAT);

      $imgFile = $_FILES['product_image']['name'];
      $tmp_dir = $_FILES['product_image']['tmp_name'];
      $imgSize = $_FILES['product_image']['size'];

      if($imgFile)
      {
        $upload_dir = 'images/'; // upload directory

        $imgExt = strtolower(pathinfo($imgFile,PATHINFO_EXTENSION)); // get image extension

        $valid_extensions = array('jpeg', 'jpg', 'png', 'gif'); // valid extensions

        $product_image = rand(1000,1000000).".".$imgExt;
        if(in_array($imgExt, $valid_extensions))
        {
          if($imgSize < 5000000)
          {
            unlink($upload_dir.$row['product_image']);
            move_uploaded_file($tmp_dir,$upload_dir.$product_image);
          }
          else
          {
            $errMSG = "Sorry, your file is too large it should be less then 5MB";
          }
       }
       else
       {
         $errMSG = "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
       }
      }
      else
      {
        // if no image selected the old image remain as it is.
        $product_image = $row['product_image']; // old image from database
      }

      // if no error occured, continue ....
      if(!isset($errMSG))
      {
        $query = 'UPDATE products SET product_name:=product_name, product_description:=product_description, product_cost:=product_cost, product_image:=product_image, category_id:=category_id WHERE product_id:=product_id';

        $statement = $db->prepare($query);
        $statement->bindParam(':product_name', $product_name);
        $statement->bindParam(':product_description', $product_description);
        $statement->bindParam(':product_cost', $product_cost);
        $statement->bindParam(':product_image', $product_image);
        $statement->bindParam(':category_id', $category_id);
        $statement->bindParam(':product_id',$id);

        if($statement->execute())
        {
        ?>
                    <script>
        alert('Successfully Updated ...');
        window.location.href='index.php';
        </script>
                    <?php
        }
        else
        {
          $errMSG = "Sorry Data Could Not Updated !";
        }
      }
    }
?>
<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>Dee's Nuts - Admin insert</title>
    <!-- Bootstrap -->
    <link rel="stylesheet" href="css/bootstrap.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.7.0/font/bootstrap-icons.css">
    <script src="js/bootstrap.bundle.js"></script>
  </head>
  <body>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
      <div class="container-fluid">
        <a class="navbar-brand" href="index.php">Dee's Nuts</a>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
          <ul class="navbar-nav me-auto mb-2 mb-lg-0">
            <li class="nav-item">
              <a class="nav-link active" aria-current="page" href="index.php">Home</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="#">Botanical Nuts</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="#">Drupes</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="#">Gymnosperm</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="#">Angiosperm</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="#" data-bs-toggle="modal" data-bs-target="#adminModal">Admin</a>
            </li>
          </ul>
          <form class="d-flex">
            <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search">
            <button class="btn btn-outline-light" type="submit">Search</button>
          </form>
        </div>
      </div>
    </nav>
    <!-- Modal -->
    <div class="modal fade" id="adminModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Administrator</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body">
            What would you like to do? You will be asked for a username and password to make any changes.
          </div>
          <!-- Buttons -->
          <div class="modal-footer">
            <button type="button" class="btn btn-primary" onclick="window.location.href='admin_edit.php'">Edit product</button>
            <button type="button" class="btn btn-primary" onclick="window.location.href='admin_insert.php'">Add products</button>
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
          </div>
        </div>
      </div>
    </div>
    <!-- Form -->
    <div class="container">
      <form method="post" enctype="multipart/form-data" class="form-horizontal">
        <h1 class="display-6">Edit <?= $row['product_name']?></h1>
        <!-- Product name -->
        <div class="mb-3">
          <label class="form-label">Product name</label>
          <input type="text" class="form-control" name="product_name" value="<?= $row['product_name']?>">
        </div>
        <!-- Product description -->
        <div class="mb-3">
          <label class="form-label">Product description</label>
          <textarea class="form-control" name="product_description" rows="3"><?= $row['product_description']?></textarea>
        </div>
        <!-- Category id -->
        <div class="input-group mb-3">
          <label class="input-group-text">Category</label>
          <select class="form-select" name="category_id">
            <option value="1">Botanical nuts</option>
            <option value="2">Drupes</option>
            <option value="3">Gymnosperm seeds</option>
            <option value="4">Angiosperm seeds</option>
          </select>
        </div>
        <!-- Product cost -->
        <!-- <label class="form-label">Product cost</label> -->
        <div class="input-group mb-3">
          <span class="input-group-text">$</span>
          <input type="text" class="form-control" name="product_cost" accept="image/*" value="<?= $row['product_cost']?>">
        </div>
        <!-- Product image -->
        <div class="input-group mb-3">
          <input type="file" class="form-control" aria-describedby="inputGroupFileAddon04" aria-label="Upload" name="product_image">
        </div>
        <button type="submit" class="btn btn-success" name="btnsubmit">Submit</button>
        <button type="submit" class="btn btn-danger" name="btndelete" formaction="delete.php">Delete</button>
      </form>
    </div>
  </body>
</html>
