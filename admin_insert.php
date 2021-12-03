<?php
    require('authenticate.php');
    require('connect.php');

    if(isset($_POST['btnSubmit']))
    {
      $product_name = filter_input(INPUT_POST, 'product_name', FILTER_SANITIZE_STRING);
      $product_description = filter_input(INPUT_POST, 'product_description', FILTER_SANITIZE_STRING);
      $category_id = filter_input(INPUT_POST, 'category_id', FILTER_SANITIZE_NUMBER_INT);
      $product_cost = filter_input(INPUT_POST, 'product_cost', FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);

      $imgFile = $_FILES['product_image']['name'];
      $tmp_dir = $_FILES['product_image']['tmp_name'];
      $imgSize = $_FILES['product_image']['size'];

      if(empty($product_name))
      {
        $errMSG = "Please enter the product name.";
      }
      else if(empty($product_description))
      {
        $errMSG = "Please enter the product description.";
      }
      else if(empty($product_cost))
      {
        $errMSG = "Please enter the product cost.";
      }
      else
      {
        if(!empty($imgFile))
        {
          $upload_dir = 'images/'; // upload directory

          $imgExt = strtolower(pathinfo($imgFile,PATHINFO_EXTENSION)); // get image extension

          // valid image extensions
          $valid_extensions = array('jpeg', 'jpg', 'png'); // valid extensions

          // rename uploading image
          $product_image = rand(1000,1000000).".".$imgExt;

          // allow valid image file formats
          if(in_array($imgExt, $valid_extensions))
          {
            // Check file size '5MB'
            if($imgSize < 5000000)
            {
              move_uploaded_file($tmp_dir,$upload_dir.$product_image);
            }
            else
            {
              $errMSG = "Sorry, your file is too large.";
            }
          }
          else
          {
            $errMSG = "Sorry, only JPG, JPEG & PNG files are allowed.";
          }
        }
      }


      // if no error occured, continue ....
      if(!isset($errMSG))
      {
        $query = 'INSERT INTO products (product_name, product_description, product_cost, product_image, category_id) VALUES (:product_name, :product_description, :product_cost, :product_image, :category_id)';

        $statement = $db->prepare($query);
        $statement->bindParam(':product_name', $product_name);
        $statement->bindParam(':product_description', $product_description);
        $statement->bindParam(':product_cost', $product_cost);
        $statement->bindParam(':product_image', $product_image);
        $statement->bindParam(':category_id', $category_id);

        if($statement->execute())
        {
          $successMSG = "new record succesfully inserted ...";
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
    <title>Dee's Nuts - Admin insert</title>
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
        <h1 class="display-6">Add a new product</h1>
        <!-- Product name -->
        <div class="mb-3">
          <label class="form-label">Product name</label>
          <input type="text" class="form-control" name="product_name" placeholder="Almonds">
          <div id="productNameValidation" class="invalid-feedback">
            Please enter a product name.
          </div>
        </div>
        <!-- Product description -->
        <div class="mb-3">
          <label class="form-label">Product description</label>
          <textarea class="form-control" name="product_description" rows="3" placeholder="The almond is the edible kernel of the fruit of the sweet almond tree. It is a bright white fruit wrapped in a reddish brown cover."></textarea>
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
        <!-- <label class="form-label">Product cost</label> -->
        <div class="input-group mb-3">
          <span class="input-group-text">$</span>
          <input type="text" class="form-control" name="product_cost" placeholder="9.99">
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
        <button type="submit" class="btn btn-success" name="btnSubmit">Submit</button>
        <button type="button" class="btn btn-warning" name="btnCancel" data-bs-toggle="modal" data-bs-target="#cancelModal">Cancel</button>
      </form>
    </div>
    <!-- Cancel Modal -->
    <div class="modal fade" id="cancelModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="cancelModal">Warning!</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body">
            Are you sure you want to cancel?
          </div>
          <!-- Buttons -->
          <div class="modal-footer">
            <button type="button" class="btn btn-primary" onclick="window.location.href='index.php'">Yes</button>
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
          </div>
        </div>
      </div>
    </div>

    <!-- Bootstrap scripts -->
    <script src="js/bootstrap.bundle.js"></script>
    
    <!-- Custom scripts -->
    <!-- <script src="js/scripts.js"></script> -->
  </body>
</html>
