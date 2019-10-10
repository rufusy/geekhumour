<?php

    namespace Ninja;

    class Authentication
    {
        private $users;
        private $userNameColumn;
        private $passwordColumn;


        /**
         * __construct
         *
         * @param  mixed $users
         * @param  mixed $userNameColumn
         * @param  mixed $passwordColumn
         *
         * @return void
         */
        public function __construct(DatabaseTable $users, $userNameColumn, $passwordColumn)
        {
            session_start();
            $this->users = $users;
            $this->userNameColumn = $userNameColumn;
            $this->passwordColumn = $passwordColumn;
        }


        /**
         * login
         *
         * @param  mixed $userName
         * @param  mixed $password
         *
         * @return void
         */
        public function login($userName, $password)
        {
            $user = $this->users->find($this->userNameColumn, strtolower($userName));

            if(!empty($user) && password_verify($password, $user[0][$this->passwordColumn]))
            {
                session_regenerate_id();
                $_SESSION['username'] = $userName;
                $_SESSION['password'] = $user[0][$this->passwordColumn];
                return  true;
            }
            else
            {
                return false;
            }
        }

        
        /**
         * isLoggedIn
         *
         * @return void
         */
        public function isLoggedIn()
        {
            if(empty($_SESSION['username']))
            {
                return false;
            }
            $user = $this->users->find($this->userNameColumn, strtolower($_SESSION['username']));
            if(!empty($user) && $user[0][$this->passwordColumn] === $_SESSION['password'])
            {
                return true;
            }
            else
            {
                return false;
            }
        }


        /**
         * getUser
         *
         * @return void
         * 
         * returns record of logged in user
         */
        public function getUser()
        {
            if($this->isLoggedIn())
            {
                return $this->users->find($this->userNameColumn, strtolower($_SESSION['username']))[0];
            }
            else
            {
                return false;
            }
        }
    }