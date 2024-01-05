<?php

session_start();
include("dbcon.php"); 

// Récupérer l'ID de l'étudiant connecté depuis la session
if(isset($_SESSION['id'])) {                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                   
    $id = $_SESSION['id'];

    // Requête pour récupérer les informations de l'étudiant depuis la base de données
    $query = "SELECT id, username FROM users WHERE id = :id";
    $stmt = $conn->prepare($query);
    $stmt->bindParam(':id', $id);
    $stmt->execute();

    // Vérifier si la requête a renvoyé un résultat
    if($stmt->rowCount() > 0) {
        $user = $stmt->fetch(PDO::FETCH_ASSOC);}
    
    
// Supposons que $user['id'] contient l'ID de l'utilisateur connecté
$user_id = $user['id'];

// Requête pour récupérer les tâches de l'utilisateur connecté
$query_tasks = "SELECT task_id, task_description,created_at,completion_date FROM tasks WHERE user_id = :user_id";
$stmt_tasks = $conn->prepare($query_tasks);
$stmt_tasks->bindParam(':user_id', $user_id);
$stmt_tasks->execute();
$tasks = $stmt_tasks->fetchAll(PDO::FETCH_ASSOC);
   
    
if(isset($_POST['update'])) {
    $task_id = $_POST['task_id'];
    $new_description = $_POST['new_description'];

    // Mettre à jour la description de la tâche
    $query_update = "UPDATE tasks SET task_description = :new_description WHERE user_id = :user_id AND task_id = :task_id";
    $stmt_update = $conn->prepare($query_update);
    $stmt_update->bindParam(':new_description', $new_description);
    $stmt_update->bindParam(':user_id', $user_id);
    $stmt_update->bindParam(':task_id', $task_id);
    $stmt_update->execute();

    // Redirection après mise à jour
    header('Location: index.php');
    exit;
}
    
    
if(isset($_POST['delete']))
        {
            $task_id = $_POST['task_id'];
        
           
        
                $query = "DELETE FROM tasks WHERE task_id=? LIMIT 1";
                $statement = $conn->prepare($query);
                $statement->bindParam(1, $task_id, PDO::PARAM_INT);
                $query_execute = $statement->execute();
        
                // if($query_execute)
                // {
                //     $_SESSION['messa'] = "Informations Supprimées";
                //     header('Location: index.php');
                //     exit(0);
                // }
                // else
                // {
                //     $_SESSION['messa'] = "Informations Non Supprimées";
                //     header('Location: index.php');
                //     exit(0);
                // }
        
                header('Location: index.php');
                exit;



    }}


    if(isset($_POST['save_completion'])) {
        if(isset($_POST['task_complete'])) {
            $completed_tasks = $_POST['task_complete'];
    
            foreach($completed_tasks as $task_id) {
                $query = "UPDATE tasks SET completion_date = NOW() WHERE task_id = :task_id";
                $stmt = $conn->prepare($query);
                $stmt->bindParam(':task_id', $task_id);
                $stmt->execute();
            }
        }
    }
    

    if (isset($_POST['shared_user_email'])) {
    // Récupérer l'email de l'utilisateur avec qui partager la tâche depuis le formulaire
$shared_user_email = $_POST['shared_user_email'];

// Préparer la requête SQL pour obtenir l'ID de l'utilisateur avec l'email spécifié
$query_get_shared_user_id = "SELECT id FROM users WHERE email = :shared_user_email";
$stmt_get_shared_user_id = $conn->prepare($query_get_shared_user_id);
$stmt_get_shared_user_id->bindParam(':shared_user_email', $shared_user_email);

// Exécuter la requête pour obtenir l'ID de l'utilisateur
$stmt_get_shared_user_id->execute();

// Vérifier si l'utilisateur avec l'email spécifié existe
if ($stmt_get_shared_user_id->rowCount() > 0) {
    // Récupérer l'ID de l'utilisateur
    $shared_user = $stmt_get_shared_user_id->fetch(PDO::FETCH_ASSOC);
    $shared_user_id = $shared_user['id'];

    // Récupérer l'ID de la tâche à partager depuis le formulaire (supposons qu'il s'appelle task_id)
    $task_id = $_POST['task_id']; // Assurez-vous que vous avez récupéré correctement l'ID de la tâche depuis le formulaire

    // Préparer la requête SQL pour insérer une nouvelle entrée dans la table shared_tasks
    $query_share_task = "INSERT INTO shared_tasks (task_id, shared_user_id) VALUES (:task_id, :shared_user_id)";
    $stmt_share_task = $conn->prepare($query_share_task);
    $stmt_share_task->bindParam(':task_id', $task_id);
    $stmt_share_task->bindParam(':shared_user_id', $shared_user_id);

    // Exécuter la requête pour partager la tâche avec l'utilisateur spécifié
    $stmt_share_task->execute();

    // Redirection vers la page index ou une autre page après le partage
    header('Location: index.php');
    exit();
} else {
    // Si l'utilisateur n'est pas trouvé, afficher un message d'erreur
    echo "Utilisateur non trouvé.";
}

}   




// Requête pour récupérer les tâches partagées avec l'utilisateur actuel
$query_shared_tasks = "
    SELECT t.task_id, t.task_description, t.created_at, t.completion_date
    FROM tasks t
    INNER JOIN shared_tasks st ON t.task_id = st.task_id
    WHERE st.shared_user_id = :user_id";

$stmt_shared_tasks = $conn->prepare($query_shared_tasks);
$stmt_shared_tasks->bindParam(':user_id', $id);
$stmt_shared_tasks->execute();
$shared_tasks = $stmt_shared_tasks->fetchAll(PDO::FETCH_ASSOC);
?>
    





<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>Document</title>
</head>
<body>
<!-- <div class="row">
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
   </div> -->
<h1>Bienvenue, <?= $user['username']; ?>!</h1>
<form action="code.php" method="POST">
<label>tache</label>
<input type="text" name="task_description" >
<button type="submit" name="Ajouter">Ajouter</button>
</form>
<h1>Liste des tâches</h1>
<?php if(isset($tasks) && !empty($tasks)): ?>
        <table border="1" class="styled-table">
            <tr>
                <th>Description de la tâche</th>
               
                <th>Action</th>
                <th>Date de creation de la tâche</th>
                <th>Action</th>
                <th>Terminée Le</th>
                <th>Partager</th>
            </tr>
            <?php foreach($tasks as $task): ?>
                <tr>
                    <td>
                    <form  action="index.php" method="POST">
                            <input type="hidden" name="task_id" value="<?= $task['task_id']; ?>">
                            <input type="text" name="new_description" value="<?= $task['task_description']; ?>">
                           
                            <button type="submit" name="update">Modifier</button>
                        </form>
                    </td>
                    <td>
                    <form class="form1" action="index.php" method="POST">
                            <input type="hidden" name="task_id" value="<?= $task['task_id']; ?>">
                            <input type="submit" name="delete" value="Supprimer">
                        </form>
                    </td>
                    <td>
                    <input type="text" name="created_at" value="<?= $task['created_at']; ?>">
                    </td>
                    <td>
                    <form class="form1" action="index.php" method="POST">
                    <input type="hidden" name="task_complete[]" value="<?= $task['task_id']; ?>">
                    <input type="submit" name="save_completion" value="Terminer">
                    </form>
                </td>
                <td>
                    <input type="text" name="completion_date" value="<?= $task['completion_date']; ?>">
                </td>
                <td>
                <form action="index.php" method="POST">
                <input type="hidden" name="task_id" value="<?= $task['task_id']; ?>">
                <input type="text" name="shared_user_email" placeholder="Email de l'utilisateur à partager">
                <input type="submit" name="share_task" value="Partager">
            </form>
                </td>
            </form>
                </tr>
            <?php endforeach; ?>
        </table>
    <?php else: ?>
        <p>Aucune tâche trouvée.</p>
    <?php endif; ?>


    <h1>Liste des tâches partagées</h1>
<?php if(isset($shared_tasks) && !empty($shared_tasks)): ?>
    <table border="1" class="styled-table">
        <tr>
            <th>Description de la tâche</th>
            <!-- <th>Action</th> -->
            <th>Date de création de la tâche</th>
            <th>Action</th>
            <th>Terminée Le</th>
            <th>Partager</th>
        </tr>
        <?php foreach($shared_tasks as $shared_task): ?>
            <tr>
                <td>
                    <form  action="index.php" method="POST">
                        <input type="hidden" name="task_id" value="<?= $shared_task['task_id']; ?>">
                        <input type="text" name="new_description" value="<?= $shared_task['task_description']; ?>">
                        <button type="submit" name="update">Modifier</button>
                    </form>
                </td>
                <!-- <td>
                    <form class="form1" action="index.php" method="POST">
                        <input type="hidden" name="task_id" value="<?= $shared_task['task_id']; ?>">
                        <input type="submit" name="delete" value="Supprimer">
                    </form>
                </td> -->
                <td>
                    <input type="text" name="created_at" value="<?= $shared_task['created_at']; ?>">
                </td>
                <td>
                    <form class="form1" action="index.php" method="POST">
                        <input type="hidden" name="task_complete[]" value="<?= $shared_task['task_id']; ?>">
                        <input type="submit" name="save_completion" value="Terminer">
                    </form>
                </td>
                <td>
                    <input type="text" name="completion_date" value="<?= $shared_task['completion_date']; ?>">
                </td>
                <td>
                    <form action="index.php" method="POST">
                        <input type="hidden" name="task_id" value="<?= $shared_task['task_id']; ?>">
                        <input type="text" name="shared_user_email" placeholder="Email de l'utilisateur à partager">
                        <input type="submit" name="share_task" value="Partager">
                    </form>
                </td>
            </tr>
        <?php endforeach; ?>
    </table>
<?php else: ?>
    <p>Aucune tâche partagée trouvée.</p>
<?php endif; ?>





<a href="logout.php">logout</a>
</body>
</html>