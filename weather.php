<?php
// Initialize $response variable
$response = '';

// Get the city name from the user input
$city = $_GET["city"];
if (!empty($city)) {

    // Define the API key and the API endpoint
    $api_key = "cde9d5d26979e29c75978438fe1e2d8d";
    $api_url = "https://api.openweathermap.org/data/2.5/weather?q=$city&appid=$api_key&units=metric";

    $ch = curl_init(); 

    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

    //grab URL and pass it to the variable.
    curl_setopt($ch, CURLOPT_URL, $api_url);

    $response = curl_exec($ch);
    // Check if the response is valid
    if (!$response) {
        echo "Sorry, something went wrong. Please try again later.";
        exit(); // Exit the script if there's an error
    }
}

$data = json_decode($response, true);
if (isset($data['message']) && $data['message'] === "city not found") {
    $weather = $data['message'];
} else {
    $temp = $data["main"]["temp"] ?? ''; // Using the null coalescing operator
    $humidity = $data["main"]["humidity"] ?? '';
    $wind = $data["wind"]["speed"] ?? '';

    // Display the weather information in a simple HTML table
    $weather = "<table>";  
    $weather .= "<tr><td>City</td><td>$city</td></tr>";  
    $weather .= "<tr><td>Temperature</td><td>$temp °C</td></tr>";
    $weather .= "<tr><td>Humidity</td><td>$humidity %</td></tr>";
    $weather .= "<tr><td>Wind speed</td><td>$wind m/s</td></tr>";
    $weather .= "</table>";
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Weather App</title>
    <link rel="stylesheet" href="elegent.css">
</head>
<body>
    <div class="main">
        <form method="GET">
            <label for="city">Enter a place:</label><br>
            <input type="text" id="city" name="city" placeholder="Nation / State / City / Town / Pin"><br>
            <div class="buttons" style="text-align: center;">
                <button type="submit">Get Weather</button>
                <a href="weather.php"><button style="background-color:gray;">Clear</button></a>
                <div name="op"><?php echo $weather ?? ''; ?></div>
            </div>
        </form><br>
        <div class="buttons" style="text-align: center;"></div>
    </div>
</body>
</html>
