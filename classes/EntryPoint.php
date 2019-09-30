<?php

    class EntryPoint
    {
        private $route;

        /**
         * __construct
         *
         * @param  mixed $route
         *
         * @return void
         */
        public function __construct($route)
        {
            $this->route = $route;
            $this->checkUrl();
        }
        

       
        /**
         * checkUrl
         *
         * @return void
         */
        private function checkUrl()
        {
            if($this->route !== strtolower($this->route))
            {
                http_response_code(301);
                header('location:'.strtolower($this->route));
            }
        }


       
        /**
         * loadTemplate
         *
         * @param  mixed $templateFileName
         * @param  mixed $variables
         *
         * @return void
         */
        private function loadTemplate($templateFileName, $variables = [])
        {
            extract ($variables);
    
            ob_start();
    
            include __DIR__ . '/../templates/'.$templateFileName;
    
            return ob_get_clean();
        }


       
        /**
         * callAction
         *
         * @return $page
         */
        private function callAction()
        {
            include_once __DIR__ . '/../includes/DatabaseConnection.php';
            include __DIR__ . '/../classes/DatabaseTable.php';

            $jokesTable = new DatabaseTable($pdo, $dbName, 'joke', 'id');
            $authorsTable = new DatabaseTable($pdo, $dbName, 'author', 'id');

            if($this->route === '')
            {
                include __DIR__ . '/../controllers/JokeController.php';
                $controller = new JokeController($jokesTable, $authorsTable);
                $page = $controller->home();
            }
            elseif($this->route=== 'joke/list')
            {
                include __DIR__ . '/../controllers/JokeController.php';
                $controller = new JokeController($jokesTable, $authorsTable);
                $page = $controller->list();
            }
            elseif($this->route === 'joke/edit')
            {
                include __DIR__ . '/../controllers/JokeController.php';
                $controller = new JokeController($jokesTable, $authorsTable);
                $page = $controller->edit();
            }
            elseif($this->route === 'joke/delete')
            {
                include __DIR__ . '/../controllers/JokeController.php';
                $controller = new JokeController($jokesTable, $authorsTable);
                $page = $controller->delete();
            }
            elseif($this->route === 'register')
            {
                include __DIR__ . '/../controllers/RegisterController.php';
                $controller = new JokeController($authorsTable);
                $page = $controller->showForm();
            }

            return $page;
        }


        /**
         * run
         *
         * @return void
         */
        public function run()
        {
            $page = $this->callAction();
            
            $title = $page['title'];

            if (isset($page['variables']))
            {
                $output = $this->loadTemplate($page['template'], $page['variables']);
            }
            else 
            {
                $output = $this->loadTemplate($page['template']);
            }

            include __DIR__ . '/../templates/layout.html.php';
        }

    }