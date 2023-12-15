<?php
session_start();
include('dbcon.php');

    

    // if ($_SERVER["REQUEST_METHOD"] == "POST") {

        if(isset($_POST['Enregistrer'])){
        // Récupérer les valeurs du formulaire
        $username = $_POST['username'];
        $password = $_POST['password'];
        $email = $_POST['email'];
        // Vous pouvez ajouter d'autres champs ici en fonction de votre structure de données
        
        // Requête pour insérer les données dans la base de données
        $query = "INSERT INTO users (username, password,email) VALUES (:username, :password,:email)";
            $query_run = $conn->prepare($query);
            
            $query_run->execute(['username' => $username, 'password' => $password,'email'=> $email]);
        
            if($query_run)
            {
                $_SESSION['message'] = "Informations Insérées";
                header('Location: register.php');
                exit(0);
            }
            else
            {
                $_SESSION['messagee'] = "Informations Non Insérées";
                header('Location: register.php');
                exit(0);
            }
        }   




?>
<!DOCTYPE html>
<html>
<head>
<link rel="stylesheet" href="style.css">
    <title>Formulaire d'enregistrement</title>
</head>
<body>
<div class="row">
            <div class="col-md-8 mt-4">

                <?php if(isset($_SESSION['message'])) : ?>
                    <h5 class="alert" style="color:green;font-size:20px;font-family: 'Montserrat', sans-serif;"  ><?= $_SESSION['message']; ?></h5>
                <?php 
                    unset($_SESSION['message']);
                    endif; 
                ?>

                <?php if(isset($_SESSION['messagee'])) : ?>
                    <h5 class="alert" style="color:red;font-size:15px;font-family: 'Montserrat', sans-serif;"  ><?= $_SESSION['messagee']; ?></h5>
                <?php 
                    unset($_SESSION['messagee']);
                    endif; 
                ?>
   </div>
    <h1>Enregistrement</h1>
    <form action="register.php" method="POST">
        <label>Nom d'utilisateur:</label>
        <input type="text" name="username" required/><br><br>
        <label>Mot de passe:</label>
        <input type="password" name="password" required/><br><br>
        <label>Email:</label>
        <input type="text" name="email" ><br><br>
        <button type="submit" name="Enregistrer">Enregistrer</button>
        <a href="login.php">Page login</a>
    </form>
</body>
</html>
