<?php
    class DatabaseTable 
    {
        private $catalogName;
        private $pdo;
        private $primaryKey;

        public function __construct(PDO $pdo, string $databaseName, string $tableName, string $primaryKey)
        {
            $this->pdo = $pdo;
            $this->catalogName = $databaseName.'.'.$tableName;
            $this->primaryKey = $primaryKey;
        }

        /**
         * query
         *
         * @param  mixed $sql
         * @param  mixed $params
         *
         * @return void
         */
        private function query($sql, $params = [])
        {
            $query = $this->pdo->prepare($sql);
            $query->execute($params);
            return $query;
        }

      
        /**
         * total
         *
         * @return void
         */
        public function total()
        {
            $sql = 'SELECT COUNT(*) FROM '.$this->catalogName;
            $result = $this->query($sql);
            $row = $result->fetch();
            return $row[0];
        }

      
        /**
         * findById
         *
         * @param  mixed $id
         *
         * @return void
         */
        public function findById($id)
        {   

            $sql = 'SELECT * FROM '.$this->catalogName.' WHERE '.$this->primaryKey.' = :id';

            $params = [
                'id' => $id
            ];

            $result = $this->query($sql, $params);

            return $result->fetch();
        }

       
        /**
         * insert
         *
         * @param  mixed $fields
         *
         * @return void
         */
        private function insert($fields)
        {
        
    
            $sql = 'INSERT INTO '.$this->catalogName.'(';
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
    
            $fields = $this->processDates($fields);
    
            $this->query($sql, $fields);
        }


        /**
         * update
         *
         * @param  mixed $fields
         *
         * @return void
         */
        private function update($fields)
        {  
         
    
            $sql = 'UPDATE '.$this->catalogName.' SET';
    
            foreach($fields as $key => $value)
            {
                $sql .= ' '.$key.'= :'.$key.',' ;
            }
        
            $sql = rtrim($sql, ',');
    
            // set the primary key variable
            $fields['primaryKey'] = $fields['id'];
    
            $sql .= ' WHERE '.$this->primaryKey.' = :primaryKey';
    
            $fields = $this->processDates($fields);
    
            $this->query($sql, $fields);
        }
    
       
        /**
         * delete
         *
         * @param  mixed $id
         *
         * @return void
         */
        public function delete($id)
        {
    
            $sql = 'DELETE FROM '.$this->catalogName.' WHERE '.$this->primaryKey.' = :id';
    
            $params = [
                ':id' => $id
            ];
    
            $this->query($sql, $params);
        }

        
        /**
         * findAll
         *
         * @return void
         */
        public function findAll()
        {
    
            $sql = 'SELECT * FROM '.$this->catalogName;
            $result = $this->query($sql);
            return $result->fetchAll();
        }

       
        /**
         * processDates
         *
         * @param  mixed $fields
         *
         * @return void
         */
        private function processDates($fields)
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

       
        /**
         * save
         *
         * @param  mixed $record
         *
         * @return void
         */
        public function save($record)
        {
            try 
            {
                if ($record[$this->primaryKey] == '')
                {
                    $record[$this->primaryKey] = null;
                }
                $this->insert($record);
            }
            catch (PDOException $e)
            {
                $this->update($record);
            }
        }
    }