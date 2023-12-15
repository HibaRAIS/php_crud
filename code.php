<?php
session_start();
include("dbcon.php");
if(isset($_SESSION['id'])) {
    $id = $_SESSION['id'];

    if(isset($_POST['Ajouter'])){

        $task_description=$_POST['task_description'];
       
        
        
        $query = "INSERT INTO tasks (user_id, task_description) VALUES (:user_id, :task_description)";
        $query_run = $conn->prepare($query);
        
       
        $query_run->execute(['user_id' => $id, 'task_description' => $task_description]);
        
        
        
        
            
        
        
            if($query_run)
            {
                $_SESSION['message'] = "Informations Insérées";
                header('Location: index.php');
                exit(0);
            }
            else
            {
                $_SESSION['message'] = "Informations Non Insérées";
                header('Location: index.php');
                exit(0);
            }
    
        }


        
         

}






?>