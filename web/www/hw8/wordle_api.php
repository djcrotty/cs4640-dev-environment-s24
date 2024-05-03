<?php
// REQUIRED HEADERS FOR CORS
// Allow access to our development server, localhost:4200
// header("Access-Control-Allow-Origin: http://localhost:4200");
header("Access-Control-Allow-Origin: https://cs4640.cs.virginia.edu/vpv4ds/hw8/index.html");
header("Access-Control-Allow-Headers: X-Requested-With, Content-Type, Origin, Authorization, Accept, Client-Security-Token, Accept-Encoding");
header("Access-Control-Max-Age: 1000");
header("Access-Control-Allow-Methods: POST, GET, OPTIONS, PUT");

$file_path = "/var/www/html/homework/cs4640-wordlist.txt";

$contents = file_get_contents($file_path);
$word_array = explode("\n", $contents);

$random_word = $word_array[array_rand($word_array)];

header("Content-Type: application/json");

echo json_encode($random_word);
