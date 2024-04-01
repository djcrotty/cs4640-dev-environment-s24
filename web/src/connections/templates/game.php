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
                <div class="col-xs-12">
                    <h3>Guesses: <?=$num_guesses?></h3>
                    <?php
                        for ($i = 0; $i < count($guesses_log); $i++) {
                            echo '<div class="col-md-4">
                            <p>'.$guesses_log[$i].'
                            </div>';
                        }
                    ?>
                </div>
                
            </div>
            <div>

            </div>
            <div class="row">
                    <?php
                    for ($i = 1; $i <= 4; $i++) {
                        if (in_array($i, $correct_words)) {
                            echo '<div class="card bg-success" style="width: 18rem;">';
                        }
                        else {
                            echo '<div class="card" style="width: 18rem;">';
                        }
                        echo 
                            '<div class="card-body">
                                <h5 class="card-title">'.$words[$i].'</h5>
                                <h6 class="card-subtitle mb-2 text-muted">'.$i.'</h6>
                            </div>
                        </div>';
                    }
                    ?>
            </div>
            <div class="row">
                    <?php
                    for ($i = 5; $i <= 8; $i++) {
                        if (in_array($i, $correct_words)) {
                            echo '<div class="card bg-success" style="width: 18rem;">';
                        }
                        else {
                            echo '<div class="card" style="width: 18rem;">';
                        }
                        echo 
                            '<div class="card-body">
                                <h5 class="card-title">'.$words[$i].'</h5>
                                <h6 class="card-subtitle mb-2 text-muted">'.$i.'</h6>
                            </div>
                        </div>';
                    }
                    ?>
            </div>
            <div class="row">
                    <?php
                    for ($i = 9; $i <= 12; $i++) {
                        if (in_array($i, $correct_words)) {
                            echo '<div class="card bg-success" style="width: 18rem;">';
                        }
                        else {
                            echo '<div class="card" style="width: 18rem;">';
                        }
                        echo 
                            '<div class="card-body">
                                <h5 class="card-title">'.$words[$i].'</h5>
                                <h6 class="card-subtitle mb-2 text-muted">'.$i.'</h6>
                            </div>
                        </div>';
                    }
                    ?>
            </div>
            <div class="row">
                    <?php
                    for ($i = 13; $i <= 16; $i++) {
                        if (in_array($i, $correct_words)) {
                            echo '<div class="card bg-success" style="width: 18rem;">';
                        }
                        else {
                            echo '<div class="card" style="width: 18rem;">';
                        }
                        echo 
                            '<div class="card-body">
                                <h5 class="card-title">'.$words[$i].'</h5>
                                <h6 class="card-subtitle mb-2 text-muted">'.$i.'</h6>
                            </div>
                        </div>';
                    }
                    ?>
            </div>
            <div class="row">
                <div class="col-xs-12">
                <form action="?command=answer" method="post">
                    <input type="hidden" name="questionid" value="<?=$question["id"]?>">

                    <div class="mb-3">
                        <label for="answer" class="form-label">Guess 4 Words of the Same Category (Input Numbers Associated with Words): </label>
                        <input type="text" class="form-control" id="trivia-answer" name="answer">
                    </div>

                    <button type="submit" class="btn btn-primary">Submit Answer</button>
                    <a href="?command=logout" class="btn btn-danger">Logout</a>
                    <a href="?command=gameOver" class="btn btn-danger">Give Up</a>
                </form>
                </div>
            </div>
        </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
</body>
</html>
