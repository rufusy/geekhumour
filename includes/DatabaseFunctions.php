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


    function findAll($pdo, $databaseName, $databaseTable)
    {
        $catalogName = $databaseName.'.'.$databaseTable;

        $sql = 'SELECT * FROM '.$catalogName;
        $result = query($pdo, $sql);
        return $result->fetchAll();
    }


    function findById($pdo, $databaseName, $databaseTable, $primaryKey, $id)
    {   
        $catalogName = $databaseName.'.'.$databaseTable;

        $sql = 'SELECT * FROM '.$catalogName.' WHERE '.$primaryKey.' = :id';

        $params = [
            'id' => $id
        ];

        $result = query($pdo, $sql, $params);

        return $result->fetch();
    }


    function insert($pdo, $databaseName, $databaseTable, $fields)
    {
    
        $catalogName = $databaseName.'.'.$databaseTable;

        $sql = 'INSERT INTO '.$catalogName.'(';
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
   

    function update($pdo, $databaseName, $databaseTable, $primaryKey, $fields)
    {  
     
        $catalogName = $databaseName.'.'.$databaseTable;

        $sql = 'UPDATE '.$catalogName.' SET';

        foreach($fields as $key => $value)
        {
            $sql .= ' '.$key.'= :'.$key.',' ;
        }
    
        $sql = rtrim($sql, ',');

        // set the primary key variable
        $fields['primaryKey'] = $fields['id'];

        $sql .= ' WHERE '.$primaryKey.' = :primaryKey';

        $fields = processDates($fields);

        query($pdo, $sql, $fields);
    }


    function delete($pdo, $databaseName, $databaseTable, $primaryKey, $id)
    {
        $catalogName = $databaseName.'.'.$databaseTable;

        $sql = 'DELETE FROM '.$catalogName.' WHERE '.$primaryKey.' = :id';

        $params = [
            ':id' => $id
        ];

        query($pdo, $sql, $params);
    }


    function total($pdo, $databaseName, $databaseTable)
    {
        $catalogName = $databaseName.'.'.$databaseTable;

        $sql = 'SELECT COUNT(*) FROM '.$catalogName;
        $query = query($pdo, $sql);
        $row = $query->fetch();
        return $row[0];
    }


    function save($pdo, $databaseName, $databaseTable, $primaryKey, $record)
    {
        try 
        {
            if ($record[$primaryKey] == '')
            {
                $record[$primaryKey] = null;
            }
            insert($pdo, $databaseName, $databaseTable, $record);
        }
        catch (PDOException $e)
        {
            update($pdo, $databaseName, $databaseTable, $primaryKey, $record);
        }
    }
    