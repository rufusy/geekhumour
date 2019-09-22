<?php

    function processDates($fields)
    {   
        foreach($fields as $key => $value)
        {
            if($value instanceof DateTime)
            {
                $fields[$key] = $value->format('Y-m-d');
            }
        }
        return $fields;
    }

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


    function insertJoke($pdo, $fields)
    {
        // $sql = 'INSERT INTO joke (joketext, jokedate, authorid)
        //             VALUES (:joketext, CURDATE(), :authorid)';

        $sql = 'INSERT INTO ijdb.joke (';
        foreach($fields as $key => $value)
        {
            $sql .= $key.',' ;
        }
        $sql = rtrim($sql, ',');
        $sql .= ') VALUES (';
        foreach ($fields as $key => $value)
        {
            $sql .= ':' .$key. ',';
        }
        $sql = rtrim($sql, ',');
        $sql .= ')';

        $fields = processDates($fields);

        query($pdo, $sql, $fields);
    }

    function updateJoke($pdo, $fields)
    {  
        /* Skeleton update query  */
        // $sql = 'UPDATE ijdb.joke SET 
        //         id = :id,
        //         authorid = :authorid,
        //         joketext = :joketext
        //         WHERE 
        //         id = :id';
        /* */
        // $fields = [
        //     'id' => $_POST['jokeid'], 
        //     'joketext' => $_POST['joketext'], 
        //     'authorid' => 1
        // ];

        $sql = 'UPDATE ijdb.joke SET';

        foreach($fields as $key => $value)
        {
            $sql .= ' '.$key.'= :'.$key.',' ;
        }
    
        $sql = rtrim($sql, ',');

        // set the primary key variable
        $fields['primaryKey'] = $fields['id'];

        $sql .= ' WHERE id = :primaryKey';

        $fields = processDates($fields);

        query($pdo, $sql, $fields);
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
                        joke.jokedate,
                        author.email,
                        author.name
                        FROM ijdb.joke 
                        INNER JOIN ijdb.author
                        ON joke.authorid = author.id';
        
        $result = query($pdo, $sql);

        return $result->fetchAll();
    }