<?php
class Calculator {
    public function calc($operator, $num1 = null, $num2 = null) {
        // Validate that operator is a string and one of the allowed operations
        if (!is_string($operator) || !in_array($operator, ['+', '-', '*', '/'])) {
            return "<p>Cannot perform operation. You must have three arguments. A string for the operator (+,-,*,/) and two integers or floats for the numbers.</p>";
        }

        // Validate that both numbers are provided and are numeric
        if (!is_numeric($num1) || !is_numeric($num2)) {
            return "<p>Cannot perform operation. You must have three arguments. A string for the operator (+,-,*,/) and two integers or floats for the numbers.</p>";
        }

        // Prevent division by zero
        if ($operator === '/' && $num2 == 0) {
            return "<p>The calculation is $num1 / $num2. The answer is cannot divide a number by zero.</p>";
        }

        // Perform the calculation
        switch ($operator) {
            case '+':
                $result = $num1 + $num2;
                break;
            case '-':
                $result = $num1 - $num2;
                break;
            case '*':
                $result = $num1 * $num2;
                break;
            case '/':
                $result = $num1 / $num2;
                break;
        }

        // Return formatted output
        return "<p>The calculation is $num1 $operator $num2. The answer is $result.</p>";
    }
}
?>
