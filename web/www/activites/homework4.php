<?php
    /**
     * Homework 4 - PHP Introduction
     *
     * Computing ID: vpv4ds
     * Resources used: [php documentation https://www.php.net/manual/en/]
     */
     
    // Your functions here
    function calculateGrade($scores, $drop) {
        if(count($scores) == 0) {
            return 0;
        }
        $total_points = 0;
        $potential_points = 0;
        if ($drop) {
            $lowest = $scores[0]['score'] / $scores[0]['max_points'] * 100;
            // var_dump($lowest);
            $lowest_idx = 0;
            for ($i = 0; $i < count($scores); $i++) {
                $percentage = $scores[$i]['score'] / $scores[$i]['max_points'] * 100;
                // var_dump($percentage);
                if ($percentage < $lowest){
                    $lowest = $percentage;
                    $lowest_idx = $i;
                }
            }
            // print_r($lowest_idx);
            unset($scores[$lowest_idx]);
        }
        // var_dump($scores);
        foreach ($scores as $i => $value) {
            $total_points += $value['score'];
            $potential_points += $value['max_points'];
        }
        // if ($potential_points == 0) {
        //     return 0;
        // }
        return number_format($total_points/$potential_points * 100, 3);
    }

    function gridCubbies($width, $height) {
        $values = [];
        //bottom left
        if($width >= 1 and $height >= 1){
            $values[] = 1;
            $values[] = $height;
            $values[] = $width * $height - $height + 1;
            $values[] = $width * $height;

        }
        if($width >= 1 and $height >= 2){
            $values[] = 2;
            $values[] = $height - 1;
            $values[] = $width * $height - $height + 2;
            $values[] = $width * $height - 1;
        }
        if($width >= 2 and $height >= 1){
            $values[] = 1 + $height;
            $values[] = 2 * $height;
            $values[] = $width * ($height-1) + 1;
            $values[] = $width * $height - $height;

        }
        if($width >= 2 and $height >= 2){
            $values[] = 2 + $height;
            $values[] = 2 * $height - 1;
            $values[] = $width * ($height-1) + 2;
            $values[] = $width * $height - $height - 1;

        }
        $unique_values = array_unique($values);
        sort($unique_values);
        $str = "";
        foreach ($unique_values as $i => $value) {
            $str .= $value . ", ";
        }
        return substr($str, 0, strlen($str)-2);
    }
    function combineAddressBooks(...$friend_books) {
        $combine_book = [];
        foreach($friend_books as $friend_book){
            foreach ($friend_book as $name => $information) {
                if(array_key_exists($name, $combine_book) and !in_array($information, $combine_book[$name])) {
                    $combine_book[$name][] = $information;
                }
                else {
                    $combine_book[$name] = [$information];
                }
            }
        }
        return $combine_book;
    }

    function acronymSummary($acronyms, $searchString) {
        if($acronyms == NULL or $acronyms == "" or $searchString == ""){
            return [];
        }
        $acronyms_count = [];
        $acronyms_idv = explode(" ", $acronyms);
        $words = array_map(function($item) {return $item[0];}, explode(" ", $searchString));
        // var_dump($words);
        $first_char = strtolower(implode("", $words));
        // var_dump($first_char);
        foreach ($acronyms_idv as $i => $acronym) {
            $count = 0;
            for ($i = 0; $i <= strlen($first_char) - strlen($acronym); $i++) {
                if (strtolower($acronym) == substr($first_char, $i, strlen($acronym))){
                    $count++;
                }
            }
            //$acronyms_count[$acronym] = substr_count($first_char, $acronym);
            $acronyms_count[$acronym] = $count;
        }
        return $acronyms_count;
        // return [];
    }
    // No closing php tag needed since there is only PHP in this file
