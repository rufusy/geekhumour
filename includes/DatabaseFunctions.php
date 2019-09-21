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

        $sql = 'SELECT FROM ijdb.joke WHERE joke.id = :id';
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