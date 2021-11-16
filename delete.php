<?php
    require('connect.php');

    // Sanitized
    $id = filter_input(INPUT_POST, 'id', FILTER_SANITIZE_NUMBER_INT);

    // Paramerized SQL query
    $query = "DELETE FROM blogs WHERE id=:id LIMIT 1";
    $statement = $db->prepare($query);

    // bind
    $statement->bindValue(':id', $id, PDO::PARAM_INT);
    $statement->execute();

    header("Location: index.php");
    exit();
?>
