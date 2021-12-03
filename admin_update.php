<?php
    session_start();
    require('authenticate.php');
    require('connect.php');

    if(isset($_GET['product_id']) && !empty($_GET['product_id'])) {
      $product_id = filter_input(INPUT_GET, 'product_id', FILTER_SANITIZE_NUMBER_INT);

      $query = 'SELECT * FROM products WHERE product_id=:product_id';
      $statement = $db->prepare($query);

      $statement->bindParam(':product_id', $product_id, PDO::PARAM_INT);

      $statement->execute(array(':product_id'=>$product_id));

      $row = $statement->fetch(PDO::FETCH_ASSOC);
      extract($row);
    }
    else {
      header("Location: index.php");
    }

    if (isset($_POST['btnSubmit'])) {

      $product_name = filter_input(INPUT_POST, 'product_name', FILTER_SANITIZE_STRING);
      $product_description = filter_input(INPUT_POST, 'product_description', FILTER_SANITIZE_STRING);
      $category_id = filter_input(INPUT_POST, 'category_id', FILTER_SANITIZE_NUMBER_INT);
      $product_cost = filter_input(INPUT_POST, 'product_cost', FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);

      $imgFile = $_FILES['product_image']['name'];
      $tmp_dir = $_FILES['product_image']['tmp_name'];
      $imgSize = $_FILES['product_image']['size'];

      if($imgFile) {
        $upload_dir = 'images/'; // upload directory

        $imgExt = strtolower(pathinfo($imgFile,PATHINFO_EXTENSION)); // get image extension

        $valid_extensions = array('jpeg', 'jpg', 'png'); // valid extensions

        $product_image = rand(1000,1000000).".".$imgExt;
        if(in_array($imgExt, $valid_extensions)) {
          if($imgSize < 5000000) {
            unlink($upload_dir.$row['product_image']);
            move_uploaded_file($tmp_dir,$upload_dir.$product_image);
          }
          else {
            $errMSG = "Sorry, your file is too large it should be less then 5MB";
          }
        }
        else {
          $errMSG = "Sorry, only JPG, JPEG & PNG files are allowed.";
        }
      }
      else if(isset($_POST['chkDel'])) {
        $product_image = NULL;
        unlink("images/".$row['product_image']);
      }
      else {
        // if no image selected the old image remain as it is.
        $product_image = $row['product_image']; // old image from database
      }

      // if no error occured, continue ....
      if(!isset($errMSG)) {
        $query = 'UPDATE products SET product_name=:product_name, product_description=:product_description, product_cost=:product_cost, product_image=:product_image, category_id=:category_id WHERE product_id=:product_id';

        $statement = $db->prepare($query);
        $statement->bindParam(':product_name', $product_name);
        $statement->bindParam(':product_description', $product_description);
        $statement->bindParam(':product_cost', $product_cost);
        $statement->bindParam(':product_image', $product_image);
        $statement->bindParam(':category_id', $category_id);
        $statement->bindParam(':product_id', $product_id, PDO::PARAM_INT);

        if($statement->execute()) {
          header("Location: admin_edit.php");
        }
        else {
          $errMSG = "Error while updating...";
          echo $errMSG;
        }
      }
    }
?>
<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>Dee's Nuts - Admin update</title>

    <!-- Bootstrap -->
    <link rel="stylesheet" href="css/bootstrap.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.7.0/font/bootstrap-icons.css">
  </head>
  <body>

    <!-- Navbar -->
    <?php include('admin_nav.php')?>

    <!-- Form -->
    <div class="container">
      <form method="post" enctype="multipart/form-data" class="form-horizontal">
        <!-- <input type="hidden" name="product_id" value="<?= $row['product_id']?>"> -->
        <h1 class="display-6">Edit <?= $row['product_name']?></h1>

        <!-- Product name -->
        <div class="mb-3">
          <label class="form-label">Product name</label>
          <input type="text" class="form-control" name="product_name" value="<?= $row['product_name']?>">
          <div id="productNameValidation" class="invalid-feedback">
            Please enter a product name.
          </div>
        </div>

        <!-- Product description -->
        <div class="mb-3">
          <label class="form-label">Product description</label>
          <textarea class="form-control" name="product_description" rows="3"><?= $row['product_description']?></textarea>
          <div id="productDescValidation" class="invalid-feedback">
            Please enter a product description.
          </div>
        </div>

        <!-- Category id -->
        <div class="input-group mb-3">
          <label class="input-group-text">Category</label>
          <select class="form-select" name="category_id">

            <?php
                $navbar = 'SELECT * FROM categories';

                $navbar_statement = $db->prepare($navbar);
                $navbar_statement->execute();
            ?>

            <?php while($nav_row=$navbar_statement->fetch(PDO::FETCH_ASSOC)):?>

              <option value="<?= $nav_row['category_id']?>"><?= $nav_row['category_name']?></option>

            <?php endwhile?>

          </select>
        </div>
        <!-- Product cost -->
        <div class="input-group mb-3">
          <span class="input-group-text">$</span>
          <input type="text" class="form-control" name="product_cost" value="<?= $row['product_cost']?>">
          <div id="productCostValidation" class="invalid-feedback">
            Please enter a product cost.
          </div>
        </div>
        <!-- Product image -->
        <div class="input-group mb-3">
          <input type="file" class="form-control" aria-describedby="inputGroupFileAddon04" aria-label="Upload" name="product_image" accept="image/*">
          <div id="productImageValidation" class="invalid-feedback">
            Please provide a product image.
          </div>
        </div>

        <?php if(is_null($row['product_image']) && empty($row['product_image'])): ?>

        <?php else:?>
        <!-- Delete image checkbox -->
        <div class="form-check mb-3">
          <input class="form-check-input" type="checkbox" name="chkDel">
          <label class="form-check-label">Remove image</label>
        </div>
        <?php endif?>

        <button type="submit" class="btn btn-success" name="btnSubmit">Submit</button>
        <button type="submit" class="btn btn-danger" name="btnDelete" formaction="delete.php?product_id=<?= $row['product_id']?>">Delete</button>
        <a class="btn btn-warning" href="admin_edit.php">Cancel</a>
      </form>
    </div>

    <!-- Bootstrap scripts -->
    <script src="js/bootstrap.bundle.js"></script>

    <!-- Custom scripts -->
    <!-- <script src="js/scripts.js"></script> -->
  </body>
</html>
