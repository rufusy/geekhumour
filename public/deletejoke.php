<?php 
    try 
    {
        include_once  __DIR__ . '/../includes/DatabaseConnection.php';
        include_once  __DIR__ . '/../includes/DatabaseFunctions.php';

        //deleteJoke($pdo, $_POST['id']);
        delete($pdo, 'ijdb', 'joke', 'id', $_POST['id']);

        header('location:jokes.php');
    }
    catch (PDOException $e)
    {
        $title = 'An error occurred!';
        $output = 'Unable to connect to the database server '.
        $e->getMessage() . ' in '.
        $e->getFile() . ' on line :'.
        $e->getLine();
    }
    
    include __DIR__ . '/../templates/layout.html.php';