<?php
session_start(); // ✅ Use session storage for results

$prediction_key = "d4fa6569defe49a8b33239cdb0564d1a";
$endpoint_url = "https://southeastasia.api.cognitive.microsoft.com/customvision/v3.0/Prediction/4f29afdc-0422-4ed8-9601-f378a1b16cbe/classify/iterations/Iteration1/image";

error_reporting(E_ALL);
ini_set('display_errors', 1);

// Define precautions & treatments for each disease
$disease_solutions = [
    "Black Rust Wheat" => [
        "precaution" => "Monitor fields regularly, plant resistant wheat varieties, and ensure proper irrigation.",
        "cure" => "Apply fungicides like Triazole and avoid excess nitrogen application."
    ],
    "Loose Smut Wheat" => [
        "precaution" => "Use disease-free seeds and practice crop rotation.",
        "cure" => "Apply systemic fungicides such as Carboxin before planting."
    ],
    "Healthy Wheat" => [
        "precaution" => "Maintain proper crop care with balanced fertilizers and adequate watering.",
        "cure" => "No action needed! Keep monitoring for any changes."
    ]
];

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
        $_SESSION['result'] = "<p style='color: red;'>⚠ Unable to connect to Azure API.</p>";
        header("Location: index.php");
        exit;
    }

    $response_data = json_decode($response, true);

    // Process predictions
    $output = "<h3>📝 AI Prediction Results & Solutions:</h3><br>";

    foreach ($response_data["predictions"] as $prediction) {
        $prob = round($prediction["probability"] * 100, 2);
        $tag = $prediction["tagName"];

        $color = "green"; $emoji = "✅";
        if ($prob > 70) { $color = "red"; $emoji = "❌"; }
        elseif ($prob > 50) { $color = "orange"; $emoji = "⚠"; }

        // Check if there's a defined solution for this disease
        $precaution = isset($disease_solutions[$tag]) ? $disease_solutions[$tag]["precaution"] : "No precaution available.";
        $cure = isset($disease_solutions[$tag]) ? $disease_solutions[$tag]["cure"] : "No cure available.";

        $output .= "
            <div style='border: 2px solid $color; padding: 10px; margin: 10px 0; border-radius: 10px;'>
                <p style='color: $color; font-size: 20px;'><strong>$emoji $tag</strong> - Probability: $prob%</p>
                <p><strong>🛡 Precaution: </strong> $precaution</p>
                <p><strong>💊 Cure: </strong> $cure</p>
            </div>";
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