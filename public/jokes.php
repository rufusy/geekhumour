<?php
    ini_set("display_errors", "1");
    error_reporting(E_ALL);

    try 
    {  
        include_once __DIR__ . '/../includes/DatabaseConnection.php';

        include_once __DIR__ . '/../classes/DatabaseTable.php';

   
        $jokesTable = new DatabaseTable($pdo, $dbName, 'joke', 'id');
    
        $authorTable = new DatabaseTable($pdo, $dbName, 'author', 'id');

        $title = 'Joke list';

        $totalJokes = $jokesTable->total();

        $result = $jokesTable->findAll();

        $jokes = [];

        foreach ($result as $joke)
        {
            $author = $authorTable->findById($joke['authorid']);

            $jokes[] = [
                'id' => $joke['id'],
                'joketext' => $joke['joketext'],
                'jokedate' => $joke['jokedate'],
                'name' => $author['name'],
                'email' => $author['email']
            ];
        }

        ob_start();

        include __DIR__ . '/../templates/jokes.html.php';

        $output = ob_get_clean();

    }
    catch(PDOException $e)
    {
        $title = 'An error occured';
        
        $output = 'Unable to connect to the database server '.
        $e->getMessage() . ' in '.
        $e->getFile() . ' on line :' .$e->getLine();
    }

    include __DIR__ . '/../templates/layout.html.php';

