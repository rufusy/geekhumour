<?php
    ini_set("display_errors", "1");
    error_reporting(E_ALL);

    include_once __DIR__ . '/../includes/DatabaseConnection.php';

    include_once __DIR__ . '/../includes/DatabaseFunctions.php'; 

    try
    {
        if(isset($_POST['joketext']))
        {
            updateJoke($pdo, 'ijdb', 'joke', 'id', [
                'id' => $_POST['jokeid'], 
                'joketext' => $_POST['joketext'], 
                'jokedate' => new DateTime()
            ]);

            header('location: jokes.php');
        }
        else
        {
            $joke = findById($pdo, 'ijdb', 'joke', 'id', $_GET['id']);

            $title = 'Edit joke';

            ob_start();

            include __DIR__ . '/../templates/editjoke.html.php';

            $output = ob_get_clean();
        }
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


   