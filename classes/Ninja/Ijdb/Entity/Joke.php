<?php
    namespace Ninja\Ijdb\Entity;
    
    use \Ninja\DatabaseTable;

    class Joke
    {
        private $authorsTable;
        private $author;
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
            if(empty($this->author))
            {
                $this->author = $this->authorsTable->findById($this->authorid);
            }
            return $this->author;
        }

    }