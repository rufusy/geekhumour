<?php
    namespace Ninja\Ijdb\Entity;
    
    use \Ninja\DatabaseTable;

    class Joke
    {
        private $authorsTable;
        public $id;
        public $authorid;
        public $jokedate;
        public $joketext;

        public function __construct(DatabaseTable $authorsTable)
        {
            $this->authorsTable = $authorsTable;
        }

        public function getAuthor()
        {
            return $this->authorsTable->findById($this->authorid);
        }

    }