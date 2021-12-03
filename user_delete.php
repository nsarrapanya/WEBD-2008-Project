<?php
    require('connect.php');

    if(isset($_GET['id'])) {
      $query = 'DELETE FROM users WHERE id=:id';

      $statement = $db->prepare($query);
      $statement->bindParam(':id',$_GET['id']);

      if($statement->execute()) {

      header("Location: admin_edit_user.php");
      exit();
      }
    }
?>
