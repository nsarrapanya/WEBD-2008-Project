<?php
    session_start();
    require('connect.php');

    $query = 'SELECT * FROM users';

    $statement = $db->prepare($query);
    $statement->execute();
?>

<!DOCTYPE html>
<html lang="en" dir="ltr">
 <head>
   <meta charset="utf-8">
   <title>Dee's Nuts</title>
   <!-- Bootstrap -->
   <link rel="stylesheet" href="css/bootstrap.css">
   <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.7.0/font/bootstrap-icons.css">
 </head>
 <body>
   <!-- Navbar -->
   <?php
       if(!isset($_SESSION['user_id']) || !isset($_SESSION['logged_in']))
       {
         include('nav.php');
       }
       else if($_SESSION['user_id'] == 1)
       {
         include('admin_nav.php');
       }
       else
       {
         include('user_nav.php');
       }
   ?>

   <!-- Container -->
   <div class="container">
     <div class="row g-3">

       <div class="col offset-md-10 g-3">
         <br>
         <a href="register.php" class="link-decoration-none">Add new user</a>
       </div>
     </div>

     <div class="row g-3">
       <table class="table table-hover table-borderless">
         <thead>
           <tr>
             <th>User ID</th>
             <th>Username</th>
             <th>Fullname</th>
             <th>Phone number</th>
             <th>Location</th>
             <th>Postal code</th>
             <th>Email address</th>
             <th>Action</th>
           </tr>
         </thead>
       <?php if($statement->rowCount() >=1):?>
         <?php while($row=$statement->fetch(PDO::FETCH_ASSOC)):?>
         <tbody>
           <tr>
             <td><?= $row['id']?></td>
             <td><?= $row['username']?></td>
             <td><?= $row['first_name']?> <?= $row['last_name']?></td>
             <td><?= $row['phone_number']?></td>
             <td><?= $row['city']?>, <?= $row['province']?></td>
             <td><?= $row['postal_code']?></td>
             <td><?= $row['email_address']?></td>
             <td>
               <form method="post">
                 <button type="submit" name="btnEdit" class="btn btn-warning btn-sm" formaction="user_edit.php?id=<?= $row['id']?>">Edit</button>
                 <button type="submit" name="btnDelete" class="btn btn-danger btn-sm" formaction="user_delete.php?id=<?= $row['id']?>">Delete</button>
               </form>
             </td>
           </tr>
         </tbody>
         <?php endwhile?>
       <?php else:?>

         <tbody>
           <tr>
             <td>There are no users registered on the website.</td>
           </tr>
         </tbody>

       <?php endif?>

       </table>
     </div>
   </div>

   <!-- Delete Modal -->
   <div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
     <div class="modal-dialog modal-dialog-centered">
       <div class="modal-content">
         <div class="modal-header">
           <h5 class="modal-title" id="cancelModal">Wanring!</h5>
           <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
         </div>
         <div class="modal-body">
           Are you sure you want to delete user, <?= $row['username']?>?
         </div>
         <!-- Buttons -->
         <div class="modal-footer">
           <button type="button" class="btn btn-primary" onclick="window.location.href='index.php'">Yes</button>
           <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
         </div>
       </div>
     </div>
   </div>

   <!-- Bootstrap scripts -->
   <script src="js/bootstrap.bundle.js"></script>
   <!-- Custom scripts -->
   <!-- <script src="js/scripts.js"></script> -->
 </body>
</html>
