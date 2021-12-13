<?php
    session_start();
    require('connect.php');

    if(isset($_POST['bxQuery'])) {
      $bxQuery = filter_input(INPUT_POST, 'bxQuery', FILTER_SANITIZE_STRING);

      if(isset($_POST['drpdwnCategory'])) {
        if($_POST['drpdwnCategory'] == 'Botanical') {
          $query = "SELECT * FROM products JOIN categories ON products.category_id = categories.category_id WHERE categories.category_id = 1 AND (product_name LIKE '%" . $bxQuery . "%')";

          $statement = $db->prepare($query);
          $statement->execute();
        }
        else if($_POST['drpdwnCategory'] == 'Drupes') {
          $query = "SELECT * FROM products JOIN categories ON products.category_id = categories.category_id WHERE categories.category_id = 2 AND (product_name LIKE '%" . $bxQuery . "%')";

          $statement = $db->prepare($query);
          $statement->execute();
        }
        else if($_POST['drpdwnCategory'] == 'Gymnosperm') {
          $query = "SELECT * FROM products JOIN categories ON products.category_id = categories.category_id WHERE categories.category_id = 3 AND (product_name LIKE '%" . $bxQuery . "%')";

          $statement = $db->prepare($query);
          $statement->execute();
        }
        else if($_POST['drpdwnCategory'] == 'Angiosperm') {
          $query = "SELECT * FROM products JOIN categories ON products.category_id = categories.category_id WHERE categories.category_id = 4 AND (product_name LIKE '%" . $bxQuery . "%')";

          $statement = $db->prepare($query);
          $statement->execute();
        }
        else {
          $query = "SELECT * FROM products JOIN categories ON products.category_id = categories.category_id WHERE (product_name LIKE '%" . $bxQuery . "%') OR (category_name LIKE '%" . $bxQuery . "%')";

          $statement = $db->prepare($query);
          $statement->execute();
        }
      }
    }
?>

<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>Dee's Nuts - Search Results</title>

    <!-- Bootstrap -->
    <link rel="stylesheet" href="css/bootstrap.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.7.0/font/bootstrap-icons.css">
    <script src="js/bootstrap.bundle.js"></script>
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
      <div class="row row-cols-3">
        <?php if($statement->rowCount() >=1):?>
        <?php while($row=$statement->fetch(PDO::FETCH_ASSOC)):?>
        <div class="col g-3">

          <?php if(is_null($row['product_image']) && empty($row['product_image'])): ?>

            <h2><?= $row['product_name']?></h2>
            <p><?= $row['product_description']?> <a href="select_where.php?product_id=<?= $row['product_id']?>" class="text-decoration-none"> More... </a></p>
            <p>$<?= $row['product_cost']?></p>
            <p>Category:
              <br>
              <a href="select_where.php?category_id=<?= $row['category_id']?>" class="text-decoration-none"><?= $row['category_name']?></a>
            </p>
            <div class="row">
              <div class="col-3">
                <input type="text" class="form-control vw-25" name="qty<?= $row['product_id']?>" id="qty<?= $row['product_id']?>" value="" placeholder="0">
              </div>
              <div class="col-3 ms-auto">
                <button class="btn btn-success" type="button" name="btnbuy" id="addItem<?= $row['product_id']?>"><i class="bi bi-cart-fill"></i></button>
              </div>
            </div>

          <?php else:?>

            <a href="select_where.php?product_id=<?= $row['product_id']?>">
              <img src="images/<?= $row['product_image']?>" class="img-fluid rounded mx-auto d-block vw-100" alt="">
            </a>
            <h2><?= $row['product_name']?></h2>
            <p><?= $row['product_description']?> <a href="select_where.php?product_id=<?= $row['product_id']?>" class="text-decoration-none"> More... </a></p>
            <p>$<?= $row['product_cost']?></p>
            <p>Category:
              <br>
              <a href="select_where.php?category_id=<?= $row['category_id']?>" class="text-decoration-none"><?= $row['category_name']?></a>
            </p>
            <div class="row">
              <div class="col-3">
                <input type="text" class="form-control vw-25" name="qty<?= $row['product_id']?>" id="qty<?= $row['product_id']?>" value="" placeholder="0">
              </div>
              <div class="col-3 ms-auto">
                <button class="btn btn-success" type="button" name="btnbuy" id="addItem<?= $row['product_id']?>"><i class="bi bi-cart-fill"></i></button>
              </div>
            </div>

          <?php endif?>

          </div>

        <?php endwhile?>

        <?php else:?>

        <div class="col">
          <h1 class="display-6">There are no product '<?php echo $bxQuery; ?>' in-stock under '<?php echo $_POST['drpdwnCategory']?>' category. Please check back at a later date!</h1>
        </div>

        <?php endif?>
      </div>
    </div>
  </body>
  </body>
</html>
