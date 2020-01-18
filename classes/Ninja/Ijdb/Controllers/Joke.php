<?php

    namespace Ninja\Ijdb\Controllers;
    
    use \Ninja\DatabaseTable;
    use \Ninja\Authentication;

    use \Ninja\Ijdb\Entity\Author;

    class Joke
    {
        private $authorsTable;
        private $jokesTable;
        private $categoriesTable;
        private $authentication;


        /**
         * __construct
         *
         * @param  mixed $jokesTable
         * @param  mixed $authorsTable
         *
         * @return void
         */
        public function __construct(DatabaseTable $jokesTable, DatabaseTable $authorsTable, DatabaseTable $categoriesTable, Authentication $authentication)
        {
            $this->jokesTable = $jokesTable;
            $this->authorsTable = $authorsTable;
            $this->authentication = $authentication;
            $this->categoriesTable = $categoriesTable;
        }


        /**
         * home
         *
         * @return void
         */
        public function home()
        {
           $title = 'Internet joke database';

          
           return [
               'title' => $title,
               'template' => 'home.html.php'
            ];
        }
   
        /**
         * index
         *
         * @return void
         */
        public function index()
        {
            $jokes = $this->jokesTable->findAll();
            $totalJokes = $this->jokesTable->total();
            $categories = $this->categoriesTable->findAll();
            $user = $this->authentication->getUser(); 

            return [
                'title' => 'Jokes list',
                'template' => 'jokes.html.php',
                'variables' => [
                    'totalJokes' => $totalJokes,
                    'jokes' => $jokes,
                    'user' => $user,
                    'categories' => $categories
                ]
            ];
        }

        
        /**
         * list
         *
         * @return void
         */
        public function list()
        {
            if(isset($_GET['category']) && !empty($_GET['category']))
            {
                $category = $this->categoriesTable->findById($_GET['category']); 
                $jokes = $category->getJokes();   
            }
            else
            {
                $jokes = $this->jokesTable->findAll();
            }

            return [
                'title' => $category->name,
                'template' => 'jokesList.html.php',
                'variables' => [
                    'jokes' => $jokes,
                    'category' => $category
                ]
            ];
        }


        /**
         * create
         *
         * @return void
         */
        public function create()
        {
            return [
                'title' => 'Add joke',
                'template' => 'addjoke.html.php'
            ];
        }


        /**
         * store
         *
         * @return void
         */
        public function store()
        {
            $user = $this->authentication->getUser(); 
            
            $joke = $_POST['joke'];
            $joke['jokedate'] = new \DateTime();

            $user->addJoke($joke);

            header('location: /');
        }
        
      
        /**
         * edit
         *
         * @return void
         */
        public function edit()
        {

            $user = $this->authentication->getUser();
            $categories = $this->categoriesTable->findAll();

            if(isset($_GET['id']) && !empty($_GET['id']))
            {
                $joke = $this->jokesTable->findById($_GET['id']);
                $title = 'Edit joke';

                if($joke == null)
                {
                    header('location: /');
                }
            }
            
            return [
                'title' => $title,
                'template' => 'editjoke.html.php',
                'variables' => [
                    'joke' => $joke ?? null,
                    'user' => $user,                    
                    'categories' => $categories          
                ]
            ];
        }
        

        /**
         * update
         *
         * @return void
         */
        public function update()
        {
            $user = $this->authentication->getUser(); 
            $joke = $_POST['joke'];
            
            if($joke['id'] != $user->id)
            {
                header('location: /');
            }
 
            $joke['jokedate'] = new \DateTime();

            $jokeEntity = $user->addJoke($joke);
            $jokeEntity->clearCategories();

            foreach($_POST['category'] as $categoryId)
            {
                $jokeEntity->addCategory($categoryId);
            }

            header('location: /');
        }


        /**
         * delete
         *
         * @return void
         */
        public function delete()
        {
            $user = $this->authentication->getUser();

            if(isset($_POST['id']))
            {
                $joke = $this->jokesTable->findById($_POST['id']);
                if($joke->authorid != $user->id && !$user->hasPermission(\Ninja\Ijdb\Entity\Author::DELETE_JOKES))
                {
                    header('location: /');
                }
            }

            $this->jokesTable->delete($_POST['id']);

            header('location: /');
        }

    }