<?php
    ini_set("display_errors", "1");
    error_reporting(E_ALL);

    include_once __DIR__ . '/../includes/DatabaseConnection.php';

    include_once __DIR__ . '/../includes/DatabaseFunctions.php'; 

    try
    {
        if(isset($_POST['joketext']))
        {
            updateJoke($pdo, $_POST['jokeid'], $_POST['joketext'], 1);

            header('location: jokes.php');

        }
        else
        {
            $joke = getJoke($pdo, $_GET['id']);

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


   