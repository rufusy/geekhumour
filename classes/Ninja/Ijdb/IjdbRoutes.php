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
        public function callAction($route)
        {
            include_once __DIR__ . '/../../../includes/DatabaseConnection.php';

            $jokesTable = new DatabaseTable($pdo, $dbName, 'joke', 'id');
            $authorsTable = new DatabaseTable($pdo, $dbName, 'author', 'id');

            if($route === '')
            {
                $controller = new Joke($jokesTable, $authorsTable);
                $page = $controller->home();
            }
            elseif($route=== 'joke/list')
            {
                $controller = new  Joke($jokesTable, $authorsTable);
                $page = $controller->list();
            }
            elseif($route === 'joke/edit')
            {
                $controller = new  Joke($jokesTable, $authorsTable);
                $page = $controller->edit();
            }
            elseif($route === 'joke/delete')
            {
                $controller = new  Joke($jokesTable, $authorsTable);
                $page = $controller->delete();
            }
            elseif($route === 'register')
            {
                $controller = new  Joke($authorsTable);
                $page = $controller->showForm();
            }

            return $page;
        }
    }
