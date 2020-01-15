<?php
    namespace Ninja\Ijdb\Entity;
    
    use \Ninja\DatabaseTable;

    class Category 
    {
        public $id;
        public $name;
        private $jokesTable;
        private $jokeCategoriesTable;

        public function __construct(DatabaseTable $jokesTable, DatabaseTable $jokeCategoriesTable)
        {
            $this->jokeCategoriesTable = $jokeCategoriesTable;
            $this->jokesTable = $jokesTable;
        }

        public function getJokes()
        {
            $jokesCategories = $this->jokeCategoriesTable->find('categoryId', $this->id);
            $jokes = [];
            foreach ($jokesCategories as $jokesCategory)
            {
                $joke = $this->jokesTable->findById($jokesCategory->jokeId);
                if($joke)
                {
                    $jokes[] = $joke;
                }
            }
            return $jokes;
        }
    }