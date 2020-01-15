<?php
    namespace Ninja\Ijdb\Entity;
    
    use \Ninja\DatabaseTable;

    class Joke
    {
        public $id;
        public $authorid;
        public $jokedate;
        public $joketext;
        private $authorsTable;
        private $jokeCategoriesTable;
        private $author;

        public function __construct(DatabaseTable $authorsTable, DatabaseTable $jokeCategoriesTable)
        {
            $this->authorsTable = $authorsTable;
            $this->jokeCategoriesTable = $jokeCategoriesTable;
        }

        public function getAuthor()
        {
            if(empty($this->author))
            {
                $this->author = $this->authorsTable->findById($this->authorid);
            }
            return $this->author;
        }

        public function addCategory($categoryId)
        {
            $jokeCat = ['jokeId' => $this->id,
                        'categoryId' => $categoryId];

            $this->jokeCategoriesTable->save($jokeCat);
        }

        public function hasCategory($categoryId)
        {
            $jokeCategories = $this->jokeCategoriesTable->find('jokeId', $this->id);
            foreach($jokeCategories as $jokeCategory)
            {
                if($jokeCategory->categoryId == $categoryId)
                {
                    return true;
                }
            }
            return false;
        }

        public function clearCategories()
        {
            $this->jokeCategoriesTable->deleteWhere('jokeId', $this->id);
        }
    }