<?php
    namespace Ninja\Ijdb\Controllers;

    use \Ninja\DatabaseTable;

    class Category 
    {
        private $categoriesTable;

        /**
         * __construct
         *
         * @param  mixed $categoriesTable
         *
         * @return void
         */
        public function __construct(DatabaseTable $categoriesTable)
        {
            $this->categoriesTable = $categoriesTable;
        }

        /**
         * index
         *
         * @return void
         */
        public function index()
        {
            $categories = $this->categoriesTable->findAll();
            $totalCategories = $this->categoriesTable->total();

            $title = 'Joke Categories';

            return [
                'title' => $title,
                'template' => 'categories.html.php',
                'variables' => [
                    'categories' => $categories,
                    'totalCategories' => $totalCategories
                ]
            ];
        }

        public function create()
        {
            return [
                'title' => 'Add category',
                'template' => 'category.html.php'
            ];
        }

        public function edit()
        {
            if(isset($_GET['id']) && !empty($_GET['id']))
            {
                $category = $this->categoriesTable->findById($_GET['id']);               
            }

            return [
                'title' => 'Edit Category',
                'template' => 'category.html.php',
                'variables' => [
                    'category' => $category ?? null
                ]
            ];
        }

        public function store()
        {
            $category = $_POST['category'];
            $this->categoriesTable->save($category);
            header('location: /category');
        }

        public function destroy()
        {

            if(isset($_POST['id']))
            {
                $this->categoriesTable->delete($_POST['id']);
            }
            header('location: /category');
        }
    }