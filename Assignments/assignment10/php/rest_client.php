<?php


require_once 'PdoMethods.php';

function getWeather() {
 
    if (!isset($_POST['zip_code']) || trim($_POST['zip_code']) === '') {
        $message = "<div class='alert alert-danger'>No zip code provided. Please enter a zip code.</div>";
        return [$message, ""];
    }
    
    $zip = trim($_POST['zip_code']);
    
   
    if (!preg_match('/^\d{5}$/', $zip)) {
        $message = "<div class='alert alert-danger'>The code you entered is not a valid zip code.</div>";
        return [$message, ""];
    }
    
    
    $crud = new PdoMethods();
    $sql = "SELECT * FROM zip_codes WHERE zip_code = :zip";
    $bindings = [
        [':zip', $zip, 'str']
    ];
    $records = $crud->selectBinded($sql, $bindings);
    
    if ($records == 'error') {
        $message = "<div class='alert alert-danger'>Error accessing the database.</div>";
        return [$message, ""];
    }
    
    if (count($records) == 0) {
        $message = "<div class='alert alert-danger'>Zip code not found in the database.</div>";
        return [$message, ""];
    }
    
   
    $url = "https://russet-v8.wccnet.edu/~sshaper/assignments/assignment10_rest/get_weather_json.php?zip_code=" . urlencode($zip);
    
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    $rawResponse = curl_exec($ch);
    
    if ($error = curl_error($ch)) {
        curl_close($ch);
        $message = "<div class='alert alert-danger'>There was an error retrieving the records: $error</div>";
        return [$message, ""];
    }
    curl_close($ch);
    
   
    $data = json_decode($rawResponse, true);
    if (json_last_error() !== JSON_ERROR_NONE) {
        $message = "<div class='alert alert-danger'>Invalid JSON response from server.</div>";
        return [$message, ""];
    }
    
    if (isset($data["error"])) {
        $message = "<div class='alert alert-danger'>" . $data["error"] . "</div>";
        return [$message, ""];
    }
    
 
    $acknowledgement = "";  
    $output = "";

    $searchedCity  = $data["searched_city"]["name"]         ?? "Unknown City";
    $temperature   = $data["searched_city"]["temperature"]  ?? "N/A";
    $humidity      = $data["searched_city"]["humidity"]     ?? "N/A";
    $forecastArray = $data["searched_city"]["forecast"]     ?? [];

    $output .= "<h2>$searchedCity</h2>";
    $output .= "<p>Temperature: $temperature</p>";
    $output .= "<p>Humidity: $humidity</p>";

    
    $output .= "<h4>3-Day Forecast</h4>";
    $output .= "<ul>";
    foreach ($forecastArray as $fItem) {
        $day = $fItem["day"] ?? "";
        $cond = $fItem["condition"] ?? "";
        $output .= "<li><strong>$day</strong>: $cond</li>";
    }
    $output .= "</ul>";

   
    $output .= "<hr>";
    if (!empty($data["higher_temperatures"])) {
        $output .= "<h4>Cities with Higher Temperature than $searchedCity</h4>";
        $output .= "<table class='table table-bordered'>";
        $output .= "<thead><tr><th>City</th><th>Temperature</th></tr></thead><tbody>";

        $count = 0;
        foreach ($data["higher_temperatures"] as $cityInfo) {
            if ($count === 3) break;
            $cityName = $cityInfo["name"]         ?? "Unknown";
            $cityTemp = $cityInfo["temperature"]  ?? "N/A";
            $output .= "<tr><td>$cityName</td><td>$cityTemp</td></tr>";
            $count++;
        }
        $output .= "</tbody></table>";
    } else {
        $output .= "<p>No cities have temperatures higher than $searchedCity.</p>";
    }
    
 
    $output .= "<hr>";
    if (!empty($data["lower_temperatures"])) {
        $output .= "<h4>Cities with Lower Temperature than $searchedCity</h4>";
        $output .= "<table class='table table-striped'>";
        $output .= "<thead><tr><th>City</th><th>Temperature</th></tr></thead><tbody>";

        $count = 0;
        foreach ($data["lower_temperatures"] as $cityInfo) {
            if ($count === 3) break;
            $cityName = $cityInfo["name"]         ?? "Unknown";
            $cityTemp = $cityInfo["temperature"]  ?? "N/A";
            $output .= "<tr><td>$cityName</td><td>$cityTemp</td></tr>";
            $count++;
        }
        $output .= "</tbody></table>";
    } else {
        $output .= "<p>No cities have temperatures lower than $searchedCity.</p>";
    }
    
    // 9. Return the acknowledgement and output for index.php to render
    return [$acknowledgement, $output];
}
