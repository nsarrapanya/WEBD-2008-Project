<?php
    require('connect.php');

    if(isset($_GET['review_id']))
    {
      $query = 'DELETE FROM reviews WHERE review_id=:review_id';

      $statement = $db->prepare($query);
      $statement->bindParam(':review_id',$_GET['review_id']);

      if($statement->execute())
      {

      header("Location: index.php");
      exit();
      }
    }
?>
