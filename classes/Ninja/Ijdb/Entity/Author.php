<?php

    namespace Ninja\Ijdb\Entity;
    
    use \Ninja\DatabaseTable;

    class Author
    {
        private $jokesTable;

        const EDIT_JOKES = 1;
        const DELETE_JOKES = 2;
        const LIST_CATEGORIES = 4;
        const EDIT_CATEGORIES = 8;
        const REMOVE_CATEGORIES = 16;
        const EDIT_USER_ACCESS = 32;

        public $id;
        public $name;
        public $email;
        public $password;
        public $permissions;

        public function __construct(DatabaseTable $jokesTable)
        {
            $this->jokesTable = $jokesTable;
        }
         
        public function hasPermission($permission)
        {
            return  $this->permissions & $permission;
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

