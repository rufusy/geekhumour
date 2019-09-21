<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title><?=$title?></title>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/css/materialize.min.css">
  <style>
      header {
        padding: 25px 50px 75px 100px;
        color: blue;
        background-color: lightblue;
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
                    <li><a href="index.php">Home</a></li>
                    <li><a href="jokes.php">Jokes List</a></li>
                    <li><a href="addjoke.php">Add a new joke</a></li>
                </ul>
            </div>
        </nav>

        <main>
            <div class="container"><?=$output?></div>
            
        </main>

    </div>
</body>

</html>