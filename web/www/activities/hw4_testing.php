<?php
    include("homework4.php");

    // Hint: include error printing!
?><!DOCTYPE html>
<html>
<head>
  <meta charset="UTF-8">  
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="author" content="your name">
  <meta name="description" content="include some description about your page">  
    
  <title>Homework 4 Test File</title>
</head>
<body>
<h1>Homework 4 Test File</h1>

<h2>Problem 1</h2>
<?php
    echo "Write tests for Problem 1 here\n";
    $test1 = [ [ "score" => 55, "max_points" => 100 ], [ "score" => 55, "max_points" => 100 ] ];
    echo calculateGrade($test1, false); // should be 55

    echo "\n";
    $test2 = [ [ "score" => 55, "max_points" => 100 ], [ "score" => 75, "max_points" => 100 ] ];
    echo calculateGrade($test2, true); // should be 55

    echo "\n";
    $test2 = [];
    echo calculateGrade($test2, true); // should be 55
    //...
    echo "Test for problem 2\n";
    echo gridCubbies(10, 1);

    echo "Test for problem 2\n";
    echo gridCubbies(1664, 1352);

    echo "Test for problem 2\n";
    echo gridCubbies(0, 0);

    $friend_book1 = ['Happy' => '111-111-1111', 'Sneezy' => '222-222-2222',
                'Doc' => '333-333-3333', 'Grumpy' => '444-444-4444', 'Bashful' => '555-555-5555',
                'Sleepy' => 'sleepy@uva.edu'];

    $friend_book2 = ['Sneezy' => 'sneezy@uva.edu', 'Doc' => 'doc@uva.edu', 
                    'Happy' => 'happy@uva.edu', 'Bashful' => 'bashful@uva.edu', 
                    'Sleepy' => 'sleepy@uva.edu'];
    echo "Test for problem 3\n";
    print_r(combineAddressBooks($friend_book1, $friend_book2));

    $friend_book1 = ['Happy' => '111-111-1111', 'Sneezy' => '222-222-2222',
                'Doc' => '333-333-3333', 'Grumpy' => '444-444-4444', 'Bashful' => '555-555-5555',
                'Sleepy' => 'sleepy@uva.edu'];

    $friend_book2 = ['Happy' => '111-111-1111', 'Sneezy' => '222-222-2222',
    'Doc' => '333-333-3333', 'Grumpy' => '444-444-4444', 'Bashful' => '555-555-5555',
    'Sleepy' => 'sleepy@uva.edu'];
    echo "Test for problem 3\n";
    print_r(combineAddressBooks($friend_book1, $friend_book2));


    $acronyms = "rofl lol afk";
    $searchString = "Rabbits on freezing lakes only like really old fleece leggings.";
    $acrosum = acronymSummary($acronyms, $searchString);
    print_r($acrosum);

    $acronyms = "rofl lolafk";
    $searchString = "Rabbits on freezing lakes only like really old fleece leggings.";
    $acrosum = acronymSummary($acronyms, $searchString);
    print_r($acrosum);

?>

<p>...</p>
</body>
</html>
