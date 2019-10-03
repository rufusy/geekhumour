<?php
    namespace Ninja\Ijdb\Controllers;
    
    use \Ninja\DatabaseTable;

    class Register 
    {
        private $authorsTable;


        public function __construct(DatabaseTable $authorsTable)
        {
            $this->authorsTable = $authorsTable;
        }


        public function registrationForm()
        {
            return [
                'title' => 'Register an account',
                'template' => 'register.html.php'
            ];
        }         


        public function success()
        {
            return [
                'title' => 'Registration Successful',
                'template' => 'registersuccess.html.php'
            ];
        }


        public function registerUser()
        {
            $author = $_POST['author'];

            $valid = true; // assume data is valid to begin with
            $errors = [];

            if (empty($author['name']))
            {
                $valid = false;
                $errors[] = 'Name is required';
            }
            if (empty($author['email']))
            {
                $valid = false;
                $errors[] = 'Email is required';
            }
            elseif (filter_var($author['email'], FILTER_VALIDATE_EMAIL) == false)
            {
                $valid = false;
                $errors[] = 'Email is not valid';
            }
            else 
            {
                $author['email'] = strtolower($author['email']);
                // search for the lower case version of $author['email]
                if (count($this->authorsTable->find('email', $author['email'])) > 0)
                {
                    $valid = false;
                    $errors[] = 'User with that email already exists';
                }
            }
            if (empty($author['password']))
            {
                $valid = false;
                $errors[] = 'Password is required';
            }


            if ($valid == true)
            {
                $author['password'] = password_hash($author['password'], PASSWORD_DEFAULT);
                $this->authorsTable->save($author);
                header('Location: /author/success');
            }

            else
            {
                return [
                    'title' => 'Register an account',
                    'template' => 'register.html.php',
                    'variables' => [
                        'errors' => $errors,
                        'author' => $author
                    ]
                ];
            }
            
        }
    }