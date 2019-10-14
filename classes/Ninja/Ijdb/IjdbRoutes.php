<?php

    namespace Ninja\Ijdb;

    use \Ninja\DatabaseTable;
    use \Ninja\Routes;
    use \Ninja\Authentication;
    //use \Ninja\Ijdb\Entity\Author;
    use \Ninja\Ijdb\Controllers\Joke;
    use \Ninja\Ijdb\Controllers\Register;
    use \Ninja\Ijdb\Controllers\Login;



    class IjdbRoutes implements Routes
    {   
        
        private $authorsTable;
        private $jokesTable;
        private $authentication;


        /**
         * __construct
         *
         * @return void
         */
        public function __construct()
        {
            include_once __DIR__ . '/../../../includes/DatabaseConnection.php';

            /**
             * Database tables
             */
            $this->jokesTable = new DatabaseTable($pdo, $dbName, 'joke', 'id', '\Ninja\Ijdb\Entity\Joke', [&$this->authorsTable]);
            $this->authorsTable = new DatabaseTable($pdo, $dbName, 'author', 'id', '\Ninja\Ijdb\Entity\Author', [&$this->jokesTable]);
            $this->authentication = new Authentication($this->authorsTable, 'email', 'password');
        }
        

        /**
         * callAction
         *
         * @return $page
         */
        public function getRoutes(): array
        {
            /**
             * Controllers
             */
            $jokeController = new Joke($this->jokesTable, $this->authorsTable, $this->authentication);
            $authorController = new Register($this->authorsTable);
            $loginController = new Login($this->authentication);


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

                /**
                 *  joke routes
                 * 
                 */
                'joke/list' => [
                    'GET' => [
                        'controller' => $jokeController,
                        'action' => 'show'
                    ]
                ],
                'joke/add' => [
                    'GET' => [
                        'controller' => $jokeController,
                        'action' => 'create'
                    ],
                    'login' => true
                ],
                'joke/store' => [
                    'POST' => [
                        'controller' => $jokeController,
                        'action' => 'store'
                    ],
                    'login' => true
                ],
                'joke/edit' => [
                    'GET' => [
                        'controller' => $jokeController,
                        'action' => 'edit'
                    ],
                    'login' => true
                ],
                'joke/update' => [
                    'POST' => [
                        'controller' => $jokeController,
                        'action' => 'update'
                    ],
                    'login' => true
                ],
                'joke/delete' => [
                    'POST' => [
                        'controller' => $jokeController,
                        'action' => 'delete'
                    ],
                    'login' => true
                ],

                /**
                 *  author routes
                 */
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
                ],

                /**
                 *  login routes
                 */
                'login' => [
                    'GET' => [
                        'controller' => $loginController,
                        'action' => 'loginForm'
                    ],
                    'POST' => [
                        'controller' => $loginController,
                        'action' => 'processLogin'
                    ]
                ],

                'login/success' => [
                    'GET' => [
                        'controller' => $loginController,
                        'action' => 'success'
                    ],
                    'login' => true
                ],

                'login/error' => [
                    'GET' => [
                        'controller' => $loginController,
                        'action' => 'error'
                    ]
                ],

                'logout' => [
                    'GET' => [
                        'controller' => $loginController,
                        'action' => 'logout'
                    ]
                ]

            ];

            return $routes;
        }

        
        /**
         * getAuthentication
         *
         * @return void
         */
        public function getAuthentication(): Authentication
        {
            return $this->authentication;
        }
    }
