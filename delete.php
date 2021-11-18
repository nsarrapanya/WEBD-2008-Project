<?php
    require('connect.php');

    if(isset($_GET['product_id']))
    {
      // select image from db to delete
      $query = 'SELECT product_image FROM products WHERE product_id=:product_id';

      $statement = $db->prepare();
      $statement->execute(array(':product_id'=>$_GET['product_id']));
      $row=$statement->fetch(PDO::FETCH_ASSOC);
      unlink("images/".$row['product_image']);

      // it will delete an actual record from db
      $query = 'DELETE FROM products WHERE product_id=:product_id';

      $statement = $db->prepare($query);
      $statement->bindParam(':product_id',$_GET['product_id']);
      $statement->execute();

      header("Location: index.php");
      exit();
    }

    // // Sanitized
    // $id = filter_input(INPUT_POST, 'id', FILTER_SANITIZE_NUMBER_INT);
    //
    // // Paramerized SQL query
    // $query = "DELETE FROM blogs WHERE id=:id LIMIT 1";
    // $statement = $db->prepare($query);
    //
    // // bind
    // $statement->bindValue(':id', $id, PDO::PARAM_INT);
    // $statement->execute();
    //
    // header("Location: index.php");
    // exit();
?>
