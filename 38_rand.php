<?php

// Grid of 19 numbers consisting of 15 rows of which each has to add up to 38
/*
 *      A  B  C
 *     D  E  F  G
 *    H  I  J  K  L
 *     M  N  O  P
 *       Q  R  S
 */

// Create range of available numbers
$range = range(1, 19);

// Create grid of positions
$positions = [];
foreach (range('A', 'S') as $letter) {
    $positions[$letter] = 0;
}

// Define available lines based on grid positions
$lines = [
    ['A', 'B', 'C'],
    ['D', 'E', 'F', 'G'],
    ['H', 'I', 'J', 'K', 'L'],
    ['M', 'N', 'O', 'P'],
    ['Q', 'R', 'S'],

    ['H', 'M', 'Q'],
    ['D', 'I', 'N', 'R'],
    ['A', 'E', 'J', 'O', 'S'],
    ['B', 'F', 'K', 'P'],
    ['C', 'G', 'L'],

    ['A', 'D', 'H'],
    ['B', 'E', 'I', 'M'],
    ['C', 'F', 'J', 'N', 'Q'],
    ['G', 'K', 'O', 'R'],
    ['L', 'P', 'S'],

];

$highest_valid_lines = 0;

$continue = true;
while ($continue) {
    $tmp_range = $range;
    shuffle($tmp_range);
    $tmp_perms = $tmp_range;
    array_splice($tmp_perms, 3);
    $first_score = array_sum($tmp_perms);

    if (38 == $first_score) {
        //echo implode(" ", $tmp_range) . "\n";
        // Assign numbers to positions
        $index = 0;
        foreach ($positions as $letter => $value) {
            $positions[$letter] = $tmp_range[$index];
            $index++;
        }

        // Check if all lines add up to 38. If a non 38 sum is encountered break and continue. If number of valid lines is 15 print_r $positions since that's the solution
        $valid_lines = 0;
        foreach ($lines as $line) {
            $total = 0;
            foreach ($line as $letter) {
                $total += $positions[$letter];
            }
            if (38 == $total) {
                $valid_lines++;
            } else {
                //break;
            }
        }

        if ($highest_valid_lines < $valid_lines) {
            $highest_valid_lines = $valid_lines;
        }
        // If all lines add up to 38, we've found ourselves a winner. Let's output and exit
        if (count($lines) == $valid_lines) {
            print_r($positions);
            $continue = false;
        } else {
            echo 'Valid lines '.$valid_lines.'highest: '.$highest_valid_lines."\n";
        }
    } else {
        //echo $first_score . "\n";
    }
}
