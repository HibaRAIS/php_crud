<?php
session_start();
include("dbcon.php");
    if (isset($_POST["login"])) {
        if (empty($_POST["username"]) || empty($_POST["password"])) {
            $message = '<label>Tous les champs sont obligatoires</label>';
        } else {
            $query = "SELECT * FROM users WHERE username = :username AND password = :password";
            $statement = $conn->prepare($query);
            $statement->execute(
                array(
                    'username' => $_POST["username"],
                    'password' => $_POST["password"]
                )
            );
            $count = $statement->rowCount();
            // Après avoir vérifié les identifiants et que l'étudiant est authentifié avec succès
if ($count > 0) {
    // Récupère les données de l'étudiant depuis la requête
    $user = $statement->fetch(PDO::FETCH_ASSOC);
    
    // Affecte l'ID de l'étudiant à la session
    $_SESSION['id'] = $user['id'];
   
    // Redirige vers la page de l'étudiant
    header("Location: index.php");
    exit();
}
else {
                $message = '<label>Données incorrectes</label>';
            }
        }
    }

?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8" />
    <title>LOGIN</title>
    <meta content="width=device-width, initial-scale=1" name="viewport" />
    <link rel="stylesheet" href="style.css">
    <!-- <link rel="stylesheet" href="login.css"> -->
</head>

<body class="body-2">
    <div class="spark-section-5 spark-secondary-background wf-section">
        <div class="spark-container-6 w-container">
            <img srcset="logo.png" alt="" class="spark-centered-logo" />
            <div class="spark-centered-form spark-simple-shadow-small w-form">
                <?php
                if (isset($message)) {
                    echo '<label class="text-danger">' . $message . '</label>';
                }
                ?>
                <h1>Login</h1>
                <form method="POST">
                    <label>Nom d'utilisateur</label>
                    <input type="text" class="spark-input w-input" maxlength="256" name="username" placeholder="Entrez le nom d'utilisateur" required />
                    <label>Mot de passe</label>
                    <input type="password" class="spark-input w-input" maxlength="256" name="password" required />
                    <input type="submit" value="login" name="login" class="spark-button-4 spark-full-width w-button" /><br><br>
                    
                    <a href="register.php">Creer un compte</a>
                </form>
               
            </div>
        </div>
    </div>

</body>

</html>
