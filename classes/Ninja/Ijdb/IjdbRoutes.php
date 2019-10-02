<?php

    namespace Ninja\Ijdb;

    use \Ninja\DatabaseTable;
    use \Ninja\Ijdb\Controllers\Joke;

    class IjdbRoutes
    {   
         
        /**
         * callAction
         *
         * @return $page
         */
        public function getRoutes()
        {
            include_once __DIR__ . '/../../../includes/DatabaseConnection.php';

            $jokesTable = new DatabaseTable($pdo, $dbName, 'joke', 'id');
            $authorsTable = new DatabaseTable($pdo, $dbName, 'author', 'id');
            $jokeController = new Joke($jokesTable, $authorsTable);

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
                ]
            ];

            return $routes;
        }
    }
