<?php
    ini_set("display_errors", "1");
    error_reporting(E_ALL);

    try
    {
        include __DIR__ . '/../includes/autoload.php';


        $route = ltrim(strtok($_SERVER['REQUEST_URI'], '?'), '/');

        $entryPoint = new EntryPoint($route, new IjdbRoutes());
        $entryPoint->run();
    }

    catch(PDOException $e)
    {
        $title = 'An error occured';
        
        $output = 'Unable to connect to the database server '.
        $e->getMessage() . ' in '.
        $e->getFile() . ' on line :' .$e->getLine();

        include __DIR__ . '/../templates/layout.html.php';
    }

