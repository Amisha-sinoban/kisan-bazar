<?php
session_start(); // ✅ Use session to store results

$prediction_key = "d4fa6569defe49a8b33239cdb0564d1a";
$endpoint_url = "https://southeastasia.api.cognitive.microsoft.com/customvision/v3.0/Prediction/4f29afdc-0422-4ed8-9601-f378a1b16cbe/classify/iterations/Iteration1/image";

error_reporting(E_ALL);
ini_set('display_errors', 1);

// Ensure an image is uploaded
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_FILES["file"])) {
    $image_path = $_FILES["file"]["tmp_name"];
    $image_data = file_get_contents($image_path);

    $headers = [
        "Content-Type: application/octet-stream",
        "Prediction-Key: " . $prediction_key
    ];

    // Send Image to Azure Custom Vision
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $endpoint_url);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $image_data);
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

    $response = curl_exec($ch);
    curl_close($ch);

    if (!$response) {
        $_SESSION['result'] = "<p style='color: red;'>⚠ Connection to Azure failed.</p>";
        header("Location: index.php");
        exit;
    }

    $response_data = json_decode($response, true);

    // Extract AI predictions
    $output = "<h3>📝 AI Results:</h3><br>";

    foreach ($response_data["predictions"] as $prediction) {
        $prob = round($prediction["probability"] * 100, 2);
        $tag = $prediction["tagName"];

        if ($prob > 80) {
            $color = "red";  
            $emoji = "❌";
        } elseif ($prob > 50) {
            $color = "orange"; 
            $emoji = "⚠";
        } else {
            $color = "green"; 
            $emoji = "✅";
        }

        $output .= "<p style='color: $color; font-size: 18px;'><strong>$emoji $tag</strong> - Probability: $prob%</p>";
    }

    $_SESSION['result'] = $output;
    
    header("Location: index.php");
    exit;
} else {
    $_SESSION['result'] = "<p style='color: red;'>⚠ No image uploaded.</p>";
    header("Location: index.php");
    exit;
}
?>