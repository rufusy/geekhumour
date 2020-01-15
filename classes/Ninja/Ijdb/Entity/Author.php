<?php

    namespace Ninja\Ijdb\Entity;
    
    use \Ninja\DatabaseTable;

    class Author
    {
        public $id;
        public $name;
        public $email;
        public $password;

        private $jokesTable;


        public function __construct(DatabaseTable $jokesTable)
        {
            $this->jokesTable = $jokesTable;
        }


        public function getJokes()
        {
            return $this->jokesTable->find('authorid', $this->id);
        }


        public function addJoke($joke)
        {
            $joke['authorid'] = $this->id;

            return $this->jokesTable->save($joke);
        }

        
    }

