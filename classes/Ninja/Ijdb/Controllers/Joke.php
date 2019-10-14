<?php

    namespace Ninja\Ijdb\Controllers;
    
    use \Ninja\DatabaseTable;
    use \Ninja\Authentication;

    use \Ninja\Ijdb\Entity\Author;

    class Joke
    {
        private $authorsTable;
        private $jokesTable;
        private $authentication;


        /**
         * __construct
         *
         * @param  mixed $jokesTable
         * @param  mixed $authorsTable
         *
         * @return void
         */
        public function __construct(DatabaseTable $jokesTable, DatabaseTable $authorsTable, Authentication $authentication)
        {
            $this->jokesTable = $jokesTable;
            $this->authorsTable = $authorsTable;
            $this->authentication = $authentication;
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
         * list
         *
         * @return void
         */
        public function show()
        {
            $jokes = $this->jokesTable->findAll();
            $totalJokes = $this->jokesTable->total();
            $user = $this->authentication->getUser(); 

            return [
                'title' => 'Jokes list',
                'template' => 'jokes.html.php',
                'variables' => [
                    'totalJokes' => $totalJokes,
                    'jokes' => $jokes,
                    'userId' => $user->id ?? null
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

            header('location: /joke/list');
        }
        
      
        /**
         * edit
         *
         * @return void
         */
        public function edit()
        {

            $user = $this->authentication->getUser();

            if(isset($_GET['id']) && !empty($_GET['id']))
            {
                $joke = $this->jokesTable->findById($_GET['id']);
                $title = 'Edit joke';

                if($joke == null)
                {
                    header('location: /joke/list');
                }
            }
            
            return [
                'title' => $title,
                'template' => 'editjoke.html.php',
                'variables' => [
                    'joke' => $joke ?? null,
                    'userId' => $user->id ?? null              
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
                header('location: /joke/list');
            }
 
            $joke['jokedate'] = new \DateTime();

            $user->addJoke($joke);

            header('location: /joke/list');
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
                if($joke->authorid != $user->id)
                {
                    header('location: /joke/list');
                }
            }

            $this->jokesTable->delete($_POST['id']);

            header('location: /joke/list');
        }

    }