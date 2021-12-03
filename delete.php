<?php
    require('connect.php');

    if(isset($_GET['product_id']))
    {
      // select image from db to delete
      $query = 'SELECT product_image FROM products WHERE product_id=:product_id';

      $statement = $db->prepare($query);
      $statement->execute(array(':product_id'=>$id));
      $row=$statement->fetch(PDO::FETCH_ASSOC);
      unlink("images/".$row['product_image']);

      // it will delete an actual record from db
      $query = 'DELETE FROM products WHERE product_id=:product_id';

      $statement = $db->prepare($query);
      $statement->bindParam(':product_id',$_GET['product_id']);

      if($statement->execute())
      {

      header("Location: index.php");
      exit();
      }
    }
?>
