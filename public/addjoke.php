<?php 
    if (isset($_POST['joketext']))
    {
        try 
        {
            include_once __DIR__ . '/../includes/DatabaseConnection.php';
            
            include_once __DIR__ . '/../includes/DatabaseFunctions.php';


            insertJoke($pdo, $_POST['joketext'], 1);

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
    }
    else
    {
        $title = 'Add a new joke';

        ob_start();

        include __DIR__ . '/../templates/addjokes.html.php';

        $output = ob_get_clean();
    }

    include __DIR__ . '/../templates/layout.html.php';