<?php
    try 
    {  
        include_once __DIR__ . '/../includes/DatabaseConnection.php';

        include_once __DIR__ . '/../includes/DatabaseFunctions.php';

       
        $sql = 'SELECT joke.id,
                        joke.joketext,
                        author.name,
                        author.email
                        FROM ijdb.joke 
                        INNER JOIN ijdb.author
                        ON joke.authorid = author.id';
        $result = $pdo->query($sql);

        $title = 'Joke list';

        $totalJokes = totalJokes($pdo);

        // start the bufffer
        ob_start();

        // Include the template. The PHP code will be executed, but the resulting HTML will be 
        // put in a buffer then sent to the browser
        include __DIR__ . '/../templates/jokes.html.php';

        // Read the contents of the output buffer and store them in the $output variable for use 
        // in layout.html.php

        $output = ob_get_clean();

    }
    catch(PDOException $e)
    {
        $output = 'Unable to connect to the database server '.
        $e->getMessage() . ' in '.
        $e->getFile() . ' on line :' .$e->getLine();
    }

    include __DIR__ . '/../templates/layout.html.php';

