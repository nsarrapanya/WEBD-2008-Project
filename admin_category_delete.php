<?php
    require('connect.php');

    if(isset($_GET['category_id'])) {
      $query = 'DELETE FROM categories WHERE category_id=:category_id';

      $statement = $db->prepare($query);
      $statement->bindParam(':category_id',$_GET['category_id']);

      if($statement->execute()) {

      header("Location: admin_categories.php");
      exit();
      }
    }
?>
