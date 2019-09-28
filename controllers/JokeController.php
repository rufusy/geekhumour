<?php

    class JokeController 
    {
        private $authorsTable;
        private $jokesTable;


        /**
         * __construct
         *
         * @param  mixed $jokesTable
         * @param  mixed $authorsTable
         *
         * @return void
         */
        public function __construct(DatabaseTable $jokesTable, DatabaseTable $authorsTable)
        {
            $this->jokesTable = $jokesTable;
            $this->authorsTable = $authorsTable;
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
                    'email' => $author['email']
                ];
            }

            $title = 'Jokes list';
            $totalJokes = $this->jokesTable->total();

            return [
                'title' => $title,
                'template' => 'jokes.html.php',
                'variables' => [
                    'totalJokes' => $totalJokes,
                    'jokes' => $jokes
                ]
            ];
        }


        /**
         * edit
         *
         * @return void
         */
        public function edit()
        {
            if(isset($_POST['joke']))
            {
                $joke = $_POST['joke'];
                $joke['authorid'] = 1;
                $joke['jokedate'] = new DateTime();

                $this->jokesTable->save($joke);

                header('location: index.php?action=list');
            }
            else
            {
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
                        'joke' => $joke ?? null
                    ]
                ];
            }
        }


        /**
         * delete
         *
         * @return void
         */
        public function delete()
        {
            $this->jokesTable->delete($_POST['id']);

            header('location:index.php?action=list');
        }
    }