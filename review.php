<?php
    if(isset($_GET['product_id']) && !empty($_GET['product_id']))
    {
      // $id = $_GET['product_id'];
      $product_id = filter_input(INPUT_GET, 'product_id', FILTER_SANITIZE_NUMBER_INT);

      $query = 'SELECT * FROM reviews WHERE product_id=:product_id ORDER BY review_date DESC';
      $statement = $db->prepare($query);

      $statement->bindParam(':product_id', $product_id, PDO::PARAM_INT);

      $statement->execute(array(':product_id'=>$product_id));

      // $reviews_row = $statement->fetch(PDO::FETCH_ASSOC);
      // extract($reviews_row);
    }

    if(isset($_POST['btnsubmit']))
    {
      $review_fname = filter_input(INPUT_POST, 'review_fname', FILTER_SANITIZE_STRING);
      $review_lname = filter_input(INPUT_POST, 'review_lname', FILTER_SANITIZE_STRING);
      $review_comment = filter_input(INPUT_POST, 'review_comment', FILTER_SANITIZE_STRING);
      $product_id = filter_input(INPUT_GET, 'product_id', FILTER_SANITIZE_NUMBER_INT);

      if(empty($review_fname))
      {
        $errMSG = "You must provide your first name";
      }
      else if(empty($review_lname))
      {
        $errMSG = "You must provide your last name";
      }
      else if(empty($review_comment))
      {
        $errMSG = "You must enter a comment";
      }

      if(!isset($errMSG))
      {
        $query = 'INSERT INTO reviews (review_fname, review_lname, review_comment, product_id) VALUES (:review_fname, :review_lname, :review_comment, :product_id)';

        $statement = $db->prepare($query);
        $statement->bindParam(':review_fname', $review_fname);
        $statement->bindParam(':review_lname', $review_lname);
        $statement->bindParam(':review_comment', $review_comment);
        $statement->bindParam(':product_id', $_GET['product_id']);

        if($statement->execute())
        {
          header("Location: index.php");
        }
      }
    }
?>
<div class="row">
  <?php if($statement->rowCount() >=1):?>
  <?php while($reviews_row = $statement->fetch(PDO::FETCH_ASSOC)):?>
  <div class="col gx-3 gy-3">
    <h1 class="h5"><?= $reviews_row['review_lname'] . ", " . $reviews_row['review_fname']?></h3>
    <h2 class="h6"><?= date("F d, Y, g:i a", strtotime($reviews_row['review_date']))?></h3>
    <p><?= $reviews_row['review_comment']?></p>
  <?php endwhile?>
  <?php else:?>
  <div class="col gx-3 gy-3">
    <h3>There are currently no reviews for this product.</h3>
  <?php endif?>
    <form class="form-horizontal" method="post">
      <div class="row gy-3">
        <div class="col">
          <label for="">First name</label>
          <input type="text" class="form-control" name="review_fname">
        </div>
        <div class="col">
          <label for="">Last Name</label>
          <input type="text" class="form-control" name="review_lname">
        </div>
      </div>
      <div class="row">
        <div class="col">
          <label for="" class="form-label">Comment</label>
          <textarea class="form-control" rows="3" name="review_comment"></textarea>
        </div>
      </div>
      <div class="row">
        <div class="col gy-3">
          <button type="submit" class="btn btn-primary" name="btnsubmit">Submit</button>
        </div>
      </div>
    </form>
  </div>
</div>
<!-- <div class="row">
  <div class="col gx-3 gy-3">

  </div>
</div> -->
