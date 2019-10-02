<?php

    namespace Ninja;
    
    class EntryPoint
    {
        private $route;
        private $routes;
        private $method;

        /**
         * __construct
         *
         * @param  mixed $route
         *
         * @return void
         */
        public function __construct($route, $method, $routes)
        {
            $this->route = $route;
            $this->routes = $routes;
            $this->method = $method;
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
    
            include __DIR__ . '/../../templates/'.$templateFileName;
    
            return ob_get_clean();
        }


        /**
         * run
         *
         * @return void
         */
        public function run()
        {
            $routes = $this->routes->getRoutes();
            $controller = $routes[$this->route][$this->method]['controller'];
            $action = $routes[$this->route][$this->method]['action'];

            $page = $controller->$action();
            
            $title = $page['title'];

            if (isset($page['variables']))
            {
                $output = $this->loadTemplate($page['template'], $page['variables']);
            }
            else 
            {
                $output = $this->loadTemplate($page['template']);
            }

            include __DIR__ . '/../../templates/layout.html.php';
        }

    }