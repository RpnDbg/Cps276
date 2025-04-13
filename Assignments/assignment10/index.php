<?php
// index.php

$output = "";
$acknowledgement = "";

// Only process if the form is submitted via POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    require 'php/rest_client.php';
    // Call the function that does everything: validate ZIP, cURL request, parse JSON
    $result = getWeather();
    // $result[0] = acknowledgement (errors or messages)
    // $result[1] = main HTML output (tables, city data)
    $acknowledgement = $result[0];
    $output = $result[1];
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Weather Lookup</title>
  <!-- Optional: Bootstrap CSS link -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css"/>
</head>
<body class="bg-light">
  <div class="container mt-5">
    <h1>Enter Zip Code to Get City Weather</h1>
    
    <form action="" method="POST" class="row gy-2 gx-3 align-items-center">
      <div class="col-auto">
        <label for="zip_code" class="col-form-label">Zip Code</label>
      </div>
      <div class="col-auto">
        <input type="text" name="zip_code" id="zip_code" class="form-control" />
      </div>
      <div class="col-auto">
        <button type="submit" class="btn btn-primary">Submit</button>
      </div>
    </form>

    <!-- Display any messages (errors, etc.) -->
    <div class="mt-3">
      <?php echo $acknowledgement; ?>
    </div>

    <!-- Display the main output (city data, tables, etc.) -->
    <div class="mt-3">
      <?php echo $output; ?>
    </div>
  </div>
</body>
</html>
