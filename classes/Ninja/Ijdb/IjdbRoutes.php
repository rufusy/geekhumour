<?php

    namespace Ninja\Ijdb;

    use \Ninja\DatabaseTable;
    use \Ninja\Routes;
    use \Ninja\Authentication;
    use \Ninja\Ijdb\Controllers\Joke;
    use \Ninja\Ijdb\Controllers\Register;
    use \Ninja\Ijdb\Controllers\Login;
    use \Ninja\Ijdb\Controllers\Category;



    class IjdbRoutes implements Routes
    {   
        
        private $authorsTable;
        private $jokesTable;
        private $categoriesTable;
        private $jokeCategoriesTable;
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
            $this->jokesTable = new DatabaseTable($pdo, $dbName, 'joke', 'id', '\Ninja\Ijdb\Entity\Joke', 
                                                    [&$this->authorsTable, &$this->jokeCategoriesTable]);
            $this->authorsTable = new DatabaseTable($pdo, $dbName, 'author', 'id', '\Ninja\Ijdb\Entity\Author', [&$this->jokesTable]);
            $this->categoriesTable = new DatabaseTable($pdo, $dbName, 'category', 'id', '\Ninja\Ijdb\Entity\Category', 
                                                        [&$this->jokesTable, &$this->jokeCategoriesTable]);
            $this->jokeCategoriesTable = new DatabaseTable($pdo, $dbName, 'joke_category', 'categoryId');
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
            $jokeController = new Joke($this->jokesTable, $this->authorsTable, $this->categoriesTable, $this->authentication);
            $authorController = new Register($this->authorsTable);
            $loginController = new Login($this->authentication);
            $categoryController = new Category($this->categoriesTable);


            /**
             * Web routes
             */
            $routes =[
                 /**
                 *  joke routes
                 * 
                 */
                '' => [
                    'GET' => [
                        'controller' => $jokeController,
                        'action' => 'index'
                    ]
                ],
                'joke/list' => [
                    'GET' => [
                        'controller' => $jokeController,
                        'action' => 'list'
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
                 * category routes
                 */
                'category' => [
                    'GET' => [
                        'controller' => $categoryController,
                        'action' => 'index'
                    ],
                    'login' => true,
                    'permissions' => \Ninja\Ijdb\Entity\Author::LIST_CATEGORIES
                ],
                'category/create' => [
                    'GET' => [
                        'controller' => $categoryController,
                        'action' => 'create'
                    ],
                    'login' => true,
                    'permissions' => \Ninja\Ijdb\Entity\Author::EDIT_CATEGORIES
                ],
                'category/edit' => [
                    'GET' => [
                        'controller' => $categoryController,
                        'action' => 'edit'
                    ],
                    'login' => true ,
                    'permissions' => \Ninja\Ijdb\Entity\Author::EDIT_CATEGORIES
                ],
                'category/store' => [
                    'POST' => [
                        'controller' => $categoryController,
                        'action' => 'store'
                    ],
                    'login' => true,
                    'permissions' => \Ninja\Ijdb\Entity\Author::EDIT_CATEGORIES
                ],
                'category/delete' => [
                    'POST' => [
                        'controller' => $categoryController,
                        'action' => 'destroy'
                    ],
                    'login' => true ,
                    'permissions' => \Ninja\Ijdb\Entity\Author::REMOVE_CATEGORIES
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
                'author/list' => [
                    'GET' => [
                        'controller' => $authorController,
                        'action' => 'list'
                    ],
                    'login' => true,
                    'permissions' => \Ninja\Ijdb\Entity\Author::EDIT_USER_ACCESS
                ],
                'author/permissions' => [
                    'GET' => [
                        'controller' => $authorController,
                        'action' => 'permissions'
                    ],
                    'POST' => [
                        'controller' => $authorController,
                        'action' => 'savePermissions'
                    ],
                    'login' => true,
                    'permissions' => \Ninja\Ijdb\Entity\Author::EDIT_USER_ACCESS
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

        /**
         * checkPermission
         *
         * @param  mixed $permission
         *
         * @return bool
         */
        public function checkPermission($permission): bool
        {
           $user = $this->authentication->getUser();
           return $user && $user->hasPermission($permission) ? true : false;
        }
    }
