<?php
    try 
    {  
        include_once __DIR__ . '/../includes/DatabaseConnection.php';

        include_once __DIR__ . '/../includes/DatabaseFunctions.php';

   
        $title = 'Joke list';

        $totalJokes = total($pdo, 'ijdb', 'joke');

        $result = findAll($pdo,'ijdb','joke');

        $jokes = [];

        foreach ($result as $joke)
        {
            $author = findById($pdo, 'ijdb', 'author', 'id', $joke['authorid']);

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
        $output = 'Unable to connect to the database server '.
        $e->getMessage() . ' in '.
        $e->getFile() . ' on line :' .$e->getLine();
    }

    include __DIR__ . '/../templates/layout.html.php';

