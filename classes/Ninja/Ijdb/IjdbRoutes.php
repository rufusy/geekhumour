<?php

    namespace Ninja\Ijdb;

    use \Ninja\DatabaseTable;
    use \Ninja\Routes;
    use \Ninja\Ijdb\Controllers\Joke;
    use \Ninja\Ijdb\Controllers\Register;


    class IjdbRoutes implements Routes
    {   
         
        /**
         * callAction
         *
         * @return $page
         */
        public function getRoutes()
        {
            include_once __DIR__ . '/../../../includes/DatabaseConnection.php';

            /**
             * Database tables
             */
            $jokesTable = new DatabaseTable($pdo, $dbName, 'joke', 'id');
            $authorsTable = new DatabaseTable($pdo, $dbName, 'author', 'id');

            /**
             * Controllers
             */
            $jokeController = new Joke($jokesTable, $authorsTable);
            $authorController = new Register($authorsTable);


            /**
             * Web routes
             */
            $routes =[
                '' => [
                    'GET' => [
                        'controller' => $jokeController,
                        'action' => 'home'
                    ]
                ],
                'joke/list' => [
                    'GET' => [
                        'controller' => $jokeController,
                        'action' => 'list'
                    ]
                ],
                'joke/edit' => [
                    'POST' => [
                        'controller' => $jokeController,
                        'action' => 'saveEdit'
                    ],
                    'GET' => [
                        'controller' => $jokeController,
                        'action' => 'edit'
                    ]
                ],
                'joke/delete' => [
                    'POST' => [
                        'controller' => $jokeController,
                        'action' => 'delete'
                    ]
                ],

                'author/register' => [
                    'GET' => [
                        'controller' => $authorController,
                        'action' => 'registrationForm'
                    ],
                    'POST' => [
                        'controller' => $authorController,
                        'action' => 'registerUser' 
                    ]
                ],
                'author/success' => [
                    'GET' => [
                        'controller' => $authorController,
                        'action' => 'success'
                    ]
                ]

            ];

            return $routes;
        }
    }
