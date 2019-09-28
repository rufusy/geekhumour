<?php
    ini_set("display_errors", "1");
    error_reporting(E_ALL);

    
    /**
     * loadTemplate
     * Makes sure variables existing outside of this scope wouldn't be
     * overwritten
     *
     * @param  mixed $tenplateFileName
     * @param  mixed $variables
     *
     * @return void
     */
    function loadTemplate($tenplateFileName, $variables = [])
    {
        extract ($variables);

        ob_start();

        include __DIR__ . '/../templates/'.$tenplateFileName;

        return ob_get_clean();
    }


    try
    {
        include_once __DIR__ . '/../includes/DatabaseConnection.php';
        include __DIR__ . '/../classes/DatabaseTable.php';
        include __DIR__ . '/../controllers/JokeController.php';

        $jokesTable = new DatabaseTable($pdo, $dbName, 'joke', 'id');
        $authorsTable = new DatabaseTable($pdo, $dbName, 'author', 'id');

        $jokeController = new JokeController($jokesTable, $authorsTable);

        $action = $_GET['action'] ?? 'home';

        $page = $jokeController->$action();
 
        $title = $page['title'];

        if(isset($page['variables']))
        {
            $output = loadTemplate($page['template'], $page['variables']);
        }
        else
        {
            $output = loadTemplate($page['template']);
        }
    }


    catch(PDOException $e)
    {
        $title = 'An error occured';
        
        $output = 'Unable to connect to the database server '.
        $e->getMessage() . ' in '.
        $e->getFile() . ' on line :' .$e->getLine();
    }

    include __DIR__ . '/../templates/layout.html.php';
