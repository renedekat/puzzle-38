<?php

// Grid of 19 numbers consisting of 15 rows of which each has to add up to 38
/*
 *      A  B  C
 *     D  E  F  G
 *    H  I  J  K  L
 *     M  N  O  P
 *       Q  R  S
 */

$positions = range('A', 'S');
$numbers   = range(1, 19);

// Define lines
$lines = [
    ['A','B','C'],
    ['D','E','F','G'],
    ['H','I','J','K','L'],
    ['M','N','O','P'],
    ['Q','R','S'],

    ['H','M','Q'],
    ['D','I','N','R'],
    ['A','E','J','O','S'],
    ['B','F','K','P'],
    ['C','G','L'],

    ['A','D','H'],
    ['B','E','I','M'],
    ['C','F','J','N','Q'],
    ['G','K','O','R'],
    ['L','P','S'],
];

$target = 38;

// Build lookup: which lines each position belongs to?
$linesForPosition = [];
foreach ($positions as $pos) {
    $linesForPosition[$pos] = [];
}
foreach ($lines as $idx => $line) {
    foreach ($line as $pos) {
        $linesForPosition[$pos][] = $idx;
    }
}

// Track current line sums and counts
$lineSums  = array_fill(0, count($lines), 0);
$lineCount = array_map('count', $lines);

// Sort positions by “constrainedness”
usort($positions, function ($a, $b) use ($linesForPosition) {
    return count($linesForPosition[$b]) <=> count($linesForPosition[$a]);
});

// Print final grid in original layout
function printGrid(array $assignment)
{
    echo "\nFinal Grid:\n\n";

    printf("      %2d  %2d  %2d\n", $assignment['A'], $assignment['B'], $assignment['C']);
    printf("     %2d  %2d  %2d  %2d\n", $assignment['D'], $assignment['E'], $assignment['F'], $assignment['G']);
    printf("    %2d  %2d  %2d  %2d  %2d\n", $assignment['H'], $assignment['I'], $assignment['J'], $assignment['K'], $assignment['L']);
    printf("     %2d  %2d  %2d  %2d\n", $assignment['M'], $assignment['N'], $assignment['O'], $assignment['P']);
    printf("       %2d  %2d  %2d\n", $assignment['Q'], $assignment['R'], $assignment['S']);

    echo "\n";
}

// Backtracking search
function solve($posIndex, $positions, $numbers, &$assignment, $lines, $linesForPosition, &$lineSums, $lineCount, $target)
{
    if ($posIndex === count($positions)) {
        return true;
    }

    $pos = $positions[$posIndex];

    foreach ($numbers as $i => $number) {

        $assignment[$pos] = $number;
        $valid = true;
        $affected = [];

        foreach ($linesForPosition[$pos] as $lineIndex) {
            $lineSums[$lineIndex] += $number;
            $affected[] = $lineIndex;

            // Count assigned slots in this line
            $used = 0;
            foreach ($lines[$lineIndex] as $p) {
                if (isset($assignment[$p])) {
                    $used++;
                }
            }

            // Too large already?
            if ($lineSums[$lineIndex] > $target) {
                $valid = false;
                break;
            }

            // If line full but wrong sum
            if ($used === $lineCount[$lineIndex] && $lineSums[$lineIndex] !== $target) {
                $valid = false;
                break;
            }
        }

        if ($valid) {
            $remaining = $numbers;
            unset($remaining[$i]);

            if (solve($posIndex + 1, $positions, $remaining, $assignment, $lines, $linesForPosition, $lineSums, $lineCount, $target)) {
                return true;
            }
        }

        // Undo
        foreach ($affected as $lineIndex) {
            $lineSums[$lineIndex] -= $number;
        }
        unset($assignment[$pos]);
    }

    return false;
}

// Run solver
$assignment = [];
if (solve(0, $positions, $numbers, $assignment, $lines, $linesForPosition, $lineSums, $lineCount, $target)) {
    printGrid($assignment);
} else {
    echo "No solution found.\n";
}

}
shuffle($range);
pc_permute(array_reverse($range));
