<?php
if(!isset($_GET["rows"]) && !isset($_GET["columns"])) {
    exit("please enter number of rows and columns");
}
else {
    $rows = $_GET["rows"];
    $columns = $_GET["columns"];
    $light_positions = [];
    if($rows * $columns <= 10) {
        for($x = 0; $x < $columns; $x ++) {
            for($y = 0; $y < $rows; $y ++) {
                $light_positions[] = array("x" => $x, "y" => $y);
            }
        }
    }
    else {
        while (count($light_positions) < 10) {
            $pos_x = random_int(0, $columns - 1);
            $pos_y = random_int(0, $rows - 1);
            $position = array("x" => $pos_x, "y" => $pos_y);
            if(!in_array($position, $light_positions)) {
                $light_positions[] = $position;
            }
        }
    }
}
header("Content-Type: application/json");
echo json_encode($light_positions);
?>