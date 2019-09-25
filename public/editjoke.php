<?php
    ini_set("display_errors", "1");
    error_reporting(E_ALL);

    include_once __DIR__ . '/../includes/DatabaseConnection.php';
    include_once  __DIR__ . '/../classes/DatabaseTable.php';

    try
    {
        $jokesTable = new DatabaseTable($pdo, $dbName, 'joke', 'id');

        if(isset($_POST['joke']))
        {
            $joke = $_POST['joke'];
            $joke['authorid'] = 1;
            $joke['jokedate'] = new DateTime();

            $jokesTable->save($joke);

            header('location: jokes.php');
        }
        else
        {
            if(isset($_GET['id']) && !empty($_GET['id']))
            {
                $joke = $jokesTable->findById($_GET['id']);
                $title = 'Edit joke';
            }
            else
                $title = 'Add joke';

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


   