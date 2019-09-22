<?php

    function query($pdo, $sql, $params = [])
    {
        $query = $pdo->prepare($sql);
        $query->execute($params);
        return $query;
    }


    function totalJokes($pdo)
    {
        $sql = $sql = 'SELECT COUNT(*) FROM ijdb.joke';
        $query = query($pdo, $sql);
        $row = $query->fetch();
        return $row[0];
    }

    
    function getJoke($pdo, $id)
    {
        $params = [':id' => $id];

        $sql = 'SELECT * FROM ijdb.joke 
                WHERE id = :id';

        $query = query($pdo, $sql, $params);
        return $query->fetch();
             
    }


    function insertJoke($pdo, $joketext, $authorid)
    {
        $sql = 'INSERT INTO ijdb.joke SET
                joketext = :joketext,
                jokedate = CURDATE(),
                authorid = :authorid';
        
        $params = [
            ':joketext' => $joketext,
            ':authorid' => $authorid
        ];

        query($pdo, $sql, $params);
    }

    function updateJoke($pdo, $jokeid, $joketext, $authorid)
    {
        $sql = 'UPDATE ijdb.joke SET 
                authorid = :authorid,
                joketext = :joketext
                WHERE 
                id = :id';

        $params = [
            ':joketext' => $joketext,
            ':authorid' => $authorid,
            ':id' => $jokeid
        ];

        query($pdo, $sql, $params);
    }

    function deleteJoke($pdo, $id)
    {
        $sql = 'DELETE FROM ijdb.joke 
                WHERE
                id = :id';
        
        $params = [
            ':id' => $id
        ];

        query($pdo, $sql, $params);
    }

    function allJokes($pdo)
    {
        $sql = 'SELECT joke.id, 
                        joke.joketext,
                        author.email,
                        author.name
                        FROM ijdb.joke 
                        INNER JOIN ijdb.author
                        ON joke.authorid = author.id';
        
        $result = query($pdo, $sql);

        return $result->fetchAll();
    }