<div class="container">
  <!-- <div class="row">
    <div class="col-3">
      <select class="form-select" aria-label="Default select example">
        <option selected>Sort by</option>
        <option value="1"><a >Product name Ascending</a></option>
        <option value="2">Product name Descending</option>
        <option value="3">Prodcut cost Ascending</option>
        <option value="4">Prodcut cost Descending</option>
        <option value="5">Product category Ascending</option>
        <option value="6">Product category Descending</option>
      </select>
    </div>
  </div> -->
  <div class="row row-cols-4 gy-3">
    <?php if($statement->rowCount() >=1):?>
      <?php while($row=$statement->fetch(PDO::FETCH_ASSOC)):?>
      <div class="col">
        <img src="images/<?= $row['product_image']?>" class="img-fluid rounded mx-auto d-block" alt="">
        <h2><?= $row['product_name']?></h2>
        <p><?= $row['product_description']?></p>
        <p>$<?= $row['product_cost']?></p>
        <p>Category:
          <br>
          <a href="<?= $row['category_href']?>.php" class="nav-link"><?= $row['category_name']?></a>
        </p>
        <button class="btn btn-success" type="button" name="btnbuy"><i class="bi bi-cart-fill"></i></button>
      </div>
      <?php endwhile?>
  </div>
</div>
    <?php else:?>
      <div class="row gy-3">
        <div class="col">
          <h1 class="display-6">There are no product in-stock. Please check back at a later date!</h1>
        </div>
      </div>
    <?php endif?>
