<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title><?=$title?></title>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/css/materialize.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/js/materialize.min.js"></script>

    <style>
        header 
        {
            padding: 25px 50px 75px 100px;
            color: blue;
            background-color: lightblue;
        }
        .errors 
        {
            padding: 1em;
            border: 1px solid red;
            background-color: lightyellow;
            color: red;
            margin-bottom: 1em;
            overflow: auto;
        }
        .errors ul 
        {
            margin-left: 1em;
        }
    </style>
</head>

<body>
    <div class="container">
        <header>
            <h1>Internet Joke Database </h1>
        </header>
        <nav>
            <div class="nav-wrapper">
                <ul id="nav-mobile" class="left hide-on-med-and-down">
                    <li><a href="/">Home</a></li>
                    <li><a href="/joke/list">Jokes List</a></li>
                    <li><a href="/joke/add">Add a new joke</a></li>
                    <li><a href="/category">Categories</a></li>
                    <li><a href="/category/create">Add a new category</a></li>


                    <?php if ($loggedIn): ?>
                        <li><a href="/logout">Log out</a></li>
                    <?php else: ?>
                        <li><a href="/login">Log in</a></li>
                    <?php endif; ?>
                </ul>
            </div>
        </nav>

        <main>
            <div class="container"><?=$output?></div>
            
        </main>

    </div>
</body>

</html>