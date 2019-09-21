<?php 
   
    try 
    {
        include_once  __DIR__ . '/../includes/DatabaseConnection.php';

        $sql = 'DELETE FROM ijdb.joke WHERE id = :id';
        $stmt = $pdo->prepare($sql);
        $stmt->bindvalue(':id', $_POST['id']);
        $stmt->execute(); 

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