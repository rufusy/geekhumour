<?php
    ini_set("display_errors", "1");
    error_reporting(E_ALL);

    use \Ninja\EntryPoint;
    use \Ninja\Ijdb\IjdbRoutes;

    try
    {
        include __DIR__ . '/../includes/autoload.php';
        include __DIR__ . '/../includes/tools.php';

        $route = ltrim(strtok($_SERVER['REQUEST_URI'], '?'), '/');

        $entryPoint = new EntryPoint($route, $_SERVER['REQUEST_METHOD'], new IjdbRoutes());
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

