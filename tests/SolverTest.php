<?php

namespace Puzzle38\Tests;

use PHPUnit\Framework\TestCase;
use Puzzle38\Solver;

class SolverTest extends TestCase
{
    private array $lines;

    protected function setUp(): void
    {
        // Define the 15 lines that must each sum to 38
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
    }

    public function testSolveReturnsValidSolution(): void
    {
        $solver = new Solver();
        $solution = $solver->solve();

        // Assert solution is an array
        $this->assertIsArray($solution);

        // Assert all 19 positions are filled
        $this->assertCount(19, $solution);

        // Assert all positions A-S are present
        $positions = range('A', 'S');
        foreach ($positions as $pos) {
            $this->assertArrayHasKey($pos, $solution, "Solution missing position {$pos}");
        }

        // Assert all values are numbers 1-19
        $values = array_values($solution);
        sort($values);
        $this->assertEquals(range(1, 19), $values, 'Solution must contain numbers 1-19 exactly once');

        // Assert all 15 lines sum to 38
        foreach ($this->lines as $index => $line) {
            $sum = array_sum(array_map(fn($pos) => $solution[$pos], $line));
            $this->assertEquals(
                38,
                $sum,
                sprintf('Line %d (%s) must sum to 38, got %d', $index + 1, implode(', ', $line), $sum)
            );
        }
    }

    public function testSolveIsConsistent(): void
    {
        $solver = new Solver();
        $solution1 = $solver->solve();
        $solution2 = $solver->solve();

        // The solver should return a valid solution every time
        $this->assertIsArray($solution1);
        $this->assertIsArray($solution2);

        // Both should be valid (tested by the constraints above, but verify they're solutions)
        foreach ($this->lines as $line) {
            $sum1 = array_sum(array_map(fn($pos) => $solution1[$pos], $line));
            $sum2 = array_sum(array_map(fn($pos) => $solution2[$pos], $line));
            $this->assertEquals(38, $sum1);
            $this->assertEquals(38, $sum2);
        }
    }
}
