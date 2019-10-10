<?php

    namespace Ninja\Ijdb\Controllers;
    
    use \Ninja\DatabaseTable;
    use \Ninja\Authentication;

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
        public function list()
        {
            $result = $this->jokesTable->findAll();
            $jokes = [];

            foreach($result as $joke)
            {
                $author = $this->authorsTable->findById($joke['authorid']);

                $jokes[] = [
                    'id' => $joke['id'],
                    'joketext' => $joke['joketext'],
                    'jokedate' => $joke['jokedate'],
                    'name' => $author['name'],
                    'email' => $author['email'],
                    'authorId' => $author['id']
                ];
            }

            $title = 'Jokes list';
            $totalJokes = $this->jokesTable->total();

            $user = $this->authentication->getUser();

            return [
                'title' => $title,
                'template' => 'jokes.html.php',
                'variables' => [
                    'totalJokes' => $totalJokes,
                    'jokes' => $jokes,
                    'userId' => $user['id'] ?? null
                ]
            ];
        }


        /**
         * saveEdit
         *
         * @return void
         */
        public function saveEdit()
        {
            $user = $this->authentication->getUser();

            if(isset($_GET['id']))
            {
                $joke = $this->jokesTable->findById($_GET['id']);
                if($joke['authorid'] != $user['id'])
                {
                    return;
                }
            }

            $joke = $_POST['joke'];
            $joke['authorid'] = $user['id'];
            $joke['jokedate'] = new \DateTime();

            $this->jokesTable->save($joke);

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
            }
            else
                $title = 'Add joke';

            return [
                'title' => $title,
                'template' => 'editjoke.html.php',
                'variables' => [
                    'joke' => $joke ?? null,
                    'userId' => $user['id'] ?? null                ]
            ];
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
                if($joke['authorid'] != $user['id'])
                {
                    return;
                }
            }

            $this->jokesTable->delete($_POST['id']);

            header('location: /joke/list');
        }

    }