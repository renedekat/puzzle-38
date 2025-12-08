# puzzle-38

A PHP-based solver for a hexagonal grid puzzle where numbers 1-19 must be arranged such that each row and diagonal sums to 38.

## The Puzzle

The puzzle consists of a hexagonal grid with 19 positions arranged in the following pattern:

```
      A  B  C
     D  E  F  G
    H  I  J  K  L
     M  N  O  P
       Q  R  S
```

### Rules

- Place numbers 1 through 19 in the grid (each number used exactly once)
- Each of the 5 rows must sum to 38
- Each of the 5 left-to-right diagonals must sum to 38
- Each of the 5 right-to-left diagonals must sum to 38

This gives us 15 lines in total that must all equal 38.

## Solution Method

The solver uses an optimised backtracking algorithm with constraint propagation:

1. **Position-by-position assignment** - Tries placing each unused number in the current position
2. **Early constraint checking** - Validates line sums after each placement
3. **Pruning** - Abandons branches when:
   - A line sum exceeds 38
   - A completed line doesn't equal 38
4. **Efficient line tracking** - Pre-computes which lines each position belongs to

## Running the Solver

### Requirements

- PHP 7.0 or higher

### Execution

```bash
php 38.php
```

The programme will output the solution in the hexagonal grid format, showing the placement of all 19 numbers.

### Example Output

```
Final Grid:

      15  13  10
     14  12  08  04
    19  11  07  05  01
     18  09  06  03
       17  16  02
```

## Algorithm Complexity

The backtracking algorithm explores the solution space systematically whilst pruning invalid branches early. This approach is significantly more efficient than brute-force enumeration of all 19! permutations.

## Licence

This is a personal puzzle-solving project.
