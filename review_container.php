<?php if($statement->rowCount() >=1):?>
  <?php while($row=$statement->fetch(PDO::FETCH_ASSOC)):?>
  <div class="col gx-3 gy-3">
    <img src="images/<?= $row['product_image']?>" class="img-fluid rounded mx-auto d-block vw-100" alt="">
    <h2><?= $row['product_name']?></h2>
    <p><?= $row['product_description']?></p>
    <p>$<?= $row['product_cost']?></p>
    <p>Category:
      <br>
      <a href="<?= $row['category_href']?>.php" class="text-decoration-none"><?= $row['category_name']?></a>
    </p>
  <?php endwhile?>
  <?php else:?>
    <div class="col">
      <h1 class="display-6">There are no product in-stock. Please check back at a later date!</h1>
    </div>
  <?php endif?>
  </div>
