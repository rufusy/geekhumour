<?php

    namespace Ninja\Ijdb\Controllers;
    
    use \Ninja\Authentication;

    class Login
    {

        private $authentication;

        /**
         * __construct
         *
         * @param  mixed $authentication
         *
         * @return void
         */
        public function __construct(Authentication $authentication)
        {
            $this->authentication = $authentication;
        }


        /**
         * loginForm
         *
         * @return void
         */
        public function loginForm()
        {
            return [
                'title' => 'Log in',
                'template' => 'login.html.php'
            ];

        }

        /**
         * processLogin
         *
         * @return void
         */
        public function processLogin()
        {
            $errors = [];

            if($this->authentication->login($_POST['email'], $_POST['password']))
            {
                header('location: /login/success');
            }
            else
            {
                $errors[] = 'Invalid Email/Password.';

                return [
                    'title' => 'Log in',
                    'template' => 'login.html.php',
                    'variables' => [
                        'errors' => $errors
                    ]
                ];
            }
        }


        /**
         * success
         *
         * @return void
         */
        public function success()
        {
            return [
                'title' => 'Login sucessful',
                'template' => 'loginsuccess.html.php'
            ];
        }


        /**
         * error
         *
         * @return void
         */
        public function error()
        {
            return [
                'title' => 'You are not logged in!',
                'template' => 'loginerror.html.php'
            ];
        }


        public function logout()
        {
            session_destroy();
            return [
                'title' => 'You have been logged out!',
                'template' => 'logout.html.php'
            ];
        }
    }