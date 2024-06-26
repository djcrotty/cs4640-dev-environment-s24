<!DOCTYPE html>
<html lang="en" data-bs-theme="light">
<head>
  <meta charset="UTF-8">  
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="author" content="CS4640 Spring 2024">
  <meta name="description" content="Our Front-Controller Trivia Game">  
  <title>PHP Form Example - Trivia</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"  integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN"  crossorigin="anonymous">       
</head>

<body>
    
<div class="container" style="margin-top: 15px;">
        <div class="row">
                <div class="col-xs-12">
                <h1>Connections Game</h1>
                <!-- Show the user's information and score -->
                <h2>Welcome <?=$name?>! (<?=$email?>)  Score: <?=$score?></h2>
                </div>
            </div>
            <div class="row">
                <div class="col-xs-12">
                    <?=$message?>
                </div>
            </div>
            <div class="row">
                <h2>The Categories are:</h2>
                    <?php
                        foreach ($categories as $key => $words) {
                            echo 
                            '<div class="card" style="width: 18rem;">
                                <div class="card-header">
                                    '.$key.'
                                </div>
                                <ul class="list-group list-group-flush">';
                            foreach ($words as $word) {
                                echo '<li class="list-group-item">'.$word.'</li>';
                            }
                            echo'</ul></div>';
                        }
                    ?>
            </div>
            <div class="row">
                <div class="col-xs-12">
                <form action="?command=resetGame" method="post">
                    <input type="hidden" name="questionid" value="<?=$question["id"]?>">


                    <button type="submit" class="btn btn-primary">Play Again!</button>
                    <a href="?command=logout" class="btn btn-danger">Logout</a>
                </form>
                </div>
            </div>
        </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
</body>
</html>
