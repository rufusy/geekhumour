<?php
    class IjdbRoutes
    {   
         
        /**
         * callAction
         *
         * @return $page
         */
        public function callAction($route)
        {
            include_once __DIR__ . '/../includes/DatabaseConnection.php';

            $jokesTable = new DatabaseTable($pdo, $dbName, 'joke', 'id');
            $authorsTable = new DatabaseTable($pdo, $dbName, 'author', 'id');

            if($route === '')
            {
                include __DIR__ . '/../controllers/JokeController.php';
                $controller = new JokeController($jokesTable, $authorsTable);
                $page = $controller->home();
            }
            elseif($route=== 'joke/list')
            {
                include __DIR__ . '/../controllers/JokeController.php';
                $controller = new JokeController($jokesTable, $authorsTable);
                $page = $controller->list();
            }
            elseif($route === 'joke/edit')
            {
                include __DIR__ . '/../controllers/JokeController.php';
                $controller = new JokeController($jokesTable, $authorsTable);
                $page = $controller->edit();
            }
            elseif($route === 'joke/delete')
            {
                include __DIR__ . '/../controllers/JokeController.php';
                $controller = new JokeController($jokesTable, $authorsTable);
                $page = $controller->delete();
            }
            elseif($route === 'register')
            {
                include __DIR__ . '/../controllers/RegisterController.php';
                $controller = new JokeController($authorsTable);
                $page = $controller->showForm();
            }

            return $page;
        }
    }
