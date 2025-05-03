<?php
// Define a Validation class to handle input validation
class Validation {
    // Private array to store error messages
    private $errors = [];

    /**
     * Validate a value based on the given type using regular expressions.
     * Optionally allows a custom error message.
     *
     * @param string      $value          The input value to validate
     * @param string      $type           The type of validation (e.g., name, phone, email)
     * @param string|null $customErrorMsg Optional custom error message
     * @return bool       Returns true if the value passes validation, false otherwise
     */
    public function checkFormat($value, $type, $customErrorMsg = null) {
        // Define regular expressions for various data types
        $patterns = [
            'name'    => '/^[a-z\'\s-]{1,50}$/i',                // Letters, apostrophes, spaces, hyphens
            // **Accept either 123.456.7890 or 1234567890**
            'phone'   => '/^(\d{3}\.\d{3}\.\d{4}|\d{10})$/',
            'address' => '/^[a-zA-Z0-9\s,.\'-]{1,100}$/',        // Letters, numbers, spaces, commas, periods, apostrophes, hyphens
            'zip'     => '/^\d{5}(-\d{4})?$/',                   // US ZIP code: 12345 or 12345-6789
            'email'   => '/^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/',
            'none'    => '/.*/'
        ];

        $pattern = $patterns[$type] ?? '/.*/';

        if (!preg_match($pattern, $value)) {
            $errorMessage = $customErrorMsg ?? "Invalid $type format.";
            $this->errors[$type] = $errorMessage;
            return false;
        }

        return true;
    }

    /**
     * Retrieve all collected validation errors.
     * @return array Associative array of error messages
     */
    public function getErrors() {
        return $this->errors;
    }

    /**
     * Check if any validation errors exist.
     * @return bool Returns true if there are errors, false otherwise
     */
    public function hasErrors() {
        return !empty($this->errors);
    }
}
?>
