<?php

include 'config.php';

if (isset($_POST['submit'])) {

   $name = mysqli_real_escape_string($conn, $_POST['name']);
   $email = mysqli_real_escape_string($conn, $_POST['email']);
   $pass = mysqli_real_escape_string($conn, md5($_POST['password']));
   $cpass = mysqli_real_escape_string($conn, md5($_POST['cpassword']));
   $user_type = $_POST['user_type'];

   $select_users = mysqli_query($conn, "SELECT * FROM `users` WHERE email = '$email' AND password = '$pass'") or die('query failed');

   if (mysqli_num_rows($select_users) > 0) {
      $message[] = 'cet utilisateur existe déjà!';
   } else {
      if ($pass != $cpass) {
         $message[] = 'les mots de passe ne correspondent pas!';
      } else {
         mysqli_query($conn, "INSERT INTO `users`(name, email, password, user_type) VALUES('$name', '$email', '$cpass', '$user_type')") or die('query failed');
         $message[] = 'inscription réussie!';
         header('location:login.php');
      }
   }
}

?>

<!DOCTYPE html>
<html lang="fr">

<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>inscription</title>

   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

   <!-- custom css file link  -->
   <link rel="stylesheet" href="css/style.css">

</head>

<body>



   <?php
   if (isset($message)) {
      foreach ($message as $message) {
         echo '
      <div class="message">
         <span>' . $message . '</span>
         <i class="fas fa-times" onclick="this.parentElement.remove();"></i>
      </div>
      ';
      }
   }
   ?>

   <div class="form-container">
      <form action="" method="post">
         <h3>inscrivez-vous maintenant</h3>
         <input type="text" name="name" placeholder="entrez votre nom" required class="box">
         <input type="email" name="email" placeholder="entrez votre email" required class="box">
         <input type="password" name="password" placeholder="entrez votre mot de passe" required class="box">
         <input type="password" name="cpassword" placeholder="confirmez votre mot de passe" required class="box">
         <select name="user_type" class="box">
            <option value="user">client</option>
            <option value="admin">administrateur</option>
         </select>
         <input type="submit" name="submit" value="s'inscrire" class="btn">
         <p>vous avez déjà un compte? <a href="login.php">connectez-vous</a></p>
      </form>
   </div>

</body>

</html>