<?php

namespace Puzzle38;

class Solver
{
    private const TARGET = 38;

    private array $positions;
    private array $numbers;
    private array $lines;
    private array $linesForPosition;
    private array $lineSums;
    private array $lineCount;
    private array $lineUsedCount;

    public function __construct()
    {
        $this->positions = range('A', 'S');
        $this->numbers = range(1, 19);

        // Define lines
        $this->lines = [
            // Rows
            ['A', 'B', 'C'],
            ['D', 'E', 'F', 'G'],
            ['H', 'I', 'J', 'K', 'L'],
            ['M', 'N', 'O', 'P'],
            ['Q', 'R', 'S'],

            // Left-to-right diagonals
            ['H', 'M', 'Q'],
            ['D', 'I', 'N', 'R'],
            ['A', 'E', 'J', 'O', 'S'],
            ['B', 'F', 'K', 'P'],
            ['C', 'G', 'L'],

            // Right-to-left diagonals
            ['A', 'D', 'H'],
            ['B', 'E', 'I', 'M'],
            ['C', 'F', 'J', 'N', 'Q'],
            ['G', 'K', 'O', 'R'],
            ['L', 'P', 'S'],
        ];

        // Build lookup: which lines each position belongs to?
        $this->linesForPosition = [];
        foreach ($this->positions as $pos) {
            $this->linesForPosition[$pos] = [];
        }
        foreach ($this->lines as $idx => $line) {
            foreach ($line as $pos) {
                $this->linesForPosition[$pos][] = $idx;
            }
        }

        // Track current line sums and counts
        $this->lineSums = array_fill(0, count($this->lines), 0);
        $this->lineCount = array_map('count', $this->lines);
        $this->lineUsedCount = array_fill(0, count($this->lines), 0);
    }

    /**
     * Solve the puzzle and return the solution
     *
     * @return array<string, int> Solution mapping positions A-S to numbers 1-19
     */
    public function solve(): array
    {
        // Reset state for fresh solve
        $this->lineSums = array_fill(0, count($this->lines), 0);
        $this->lineUsedCount = array_fill(0, count($this->lines), 0);

        $assignment = [];
        $used = array_fill(1, 19, false); // Track which numbers 1-19 are used

        if ($this->solveRecursive(0, $this->positions, $used, $assignment)) {
            return $assignment;
        }

        return [];
    }

    /**
     * Backtracking search with optimisations
     */
    private function solveRecursive(
        int $posIndex,
        array $positions,
        array &$used,
        array &$assignment
    ): bool {
        if ($posIndex === count($positions)) {
            return true;
        }

        $pos = $positions[$posIndex];

        foreach ($this->numbers as $number) {
            // Skip if number already used
            if ($used[$number]) {
                continue;
            }

            $assignment[$pos] = $number;
            $used[$number] = true;
            $valid = true;
            $affected = [];

            foreach ($this->linesForPosition[$pos] as $lineIndex) {
                $this->lineSums[$lineIndex] += $number;
                $this->lineUsedCount[$lineIndex]++;
                $affected[] = $lineIndex;

                // Too large already?
                if ($this->lineSums[$lineIndex] > self::TARGET) {
                    $valid = false;
                    break;
                }

                // If line full but wrong sum
                if ($this->lineUsedCount[$lineIndex] === $this->lineCount[$lineIndex]
                    && $this->lineSums[$lineIndex] !== self::TARGET) {
                    $valid = false;
                    break;
                }
            }

            if ($valid && $this->solveRecursive($posIndex + 1, $positions, $used, $assignment)) {
                return true;
            }

            // Undo
            foreach ($affected as $lineIndex) {
                $this->lineSums[$lineIndex] -= $number;
                $this->lineUsedCount[$lineIndex]--;
            }
            $used[$number] = false;
            unset($assignment[$pos]);
        }

        return false;
    }
}
