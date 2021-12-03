<?php if($statement->rowCount() >=1):?>
<?php while($row=$statement->fetch(PDO::FETCH_ASSOC)):?>
<div class="col g-3">

  <?php if(is_null($row['product_image']) && empty($row['product_image'])): ?>

    <h2><?= $row['product_name']?></h2>
    <p><?= $row['product_description']?> <a href="select_where.php?product_id=<?= $row['product_id']?>" class="text-decoration-none"> More... </a></p>
    <p>$<?= $row['product_cost']?></p>
    <p>Category:
      <br>
      <a href="<?= $row['category_href']?>.php" class="text-decoration-none"><?= $row['category_name']?></a>
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
      <a href="<?= $row['category_href']?>.php" class="text-decoration-none"><?= $row['category_name']?></a>
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
  <h1 class="display-6">There are no product in-stock. Please check back at a later date!</h1>
</div>

<?php endif?>
