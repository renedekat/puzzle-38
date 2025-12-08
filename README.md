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

## Installation

### Requirements

- PHP 8.4 or higher
- Composer

### Setup

```bash
composer install
```

## Usage

### As a Library

```php
<?php

require_once 'vendor/autoload.php';

use Puzzle38\Solver;

$solver = new Solver();
$solution = $solver->solve();

// Returns an associative array mapping positions to numbers
// ['A' => 3, 'B' => 17, 'C' => 18, ...]
```

### Running Tests

```bash
vendor/bin/phpunit
```

The test suite validates that:
- All 19 positions (A-S) are filled
- Numbers 1-19 are used exactly once
- All 15 lines sum to 38
- The solver produces consistent results

### Example Output

```
Final Grid:

    03  17  18
  19  07  01  11
16  02  05  06  09
  12  04  08  14
    10  13  15
```

## Algorithm Complexity

The backtracking algorithm explores the solution space systematically whilst pruning invalid branches early. Key optimisations include:

- **No array copying** - Uses a boolean array to track used numbers instead of copying arrays on each recursion
- **Cached line counts** - Maintains a counter for filled positions per line rather than recounting each time
- **Early pruning** - Abandons branches as soon as constraints are violated

This approach is significantly more efficient than brute-force enumeration of all 19! permutations.

## Licence

This is a personal puzzle-solving project.
