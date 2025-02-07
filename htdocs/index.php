<?php session_start(); // 🔥 Start session to store AI results ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>🌾 Wheat Disease Detector</title>

    <!-- Google Fonts & CSS Styling -->
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; font-family: 'Arial', sans-serif; }
        body { 
            background: linear-gradient(135deg, #4ECDC4, #556270); 
            color: white; 
            text-align: center; 
            min-height: 100vh; 
            padding: 20px; 
        }

        .container {
            max-width: 500px;
            background: white;
            padding: 30px;
            margin: auto;
            border-radius: 15px;
            box-shadow: 0px 10px 20px rgba(0, 0, 0, 0.3);
            text-align: center;
            color: black;
        }

        /* Upload Box */
        .upload-section { 
            border: 2px dashed #28a745; 
            padding: 20px; 
            cursor: pointer; 
            border-radius: 10px;
            transition: all 0.3s ease;
        }
        .upload-section:hover { background-color: #f1faff; }
        input[type="file"] { display: none; }

        /* Image Preview */
        .preview {
            width: 100%;
            max-width: 200px;
            height: auto;
            margin: 15px auto;
            display: none;
            border: 2px solid #ddd;
            border-radius: 10px;
        }

        /* Custom Button */
        .btn {
            background: #007BFF;
            color: white;
            padding: 10px 20px;
            border: none;
            font-size: 16px;
            cursor: pointer;
            border-radius: 5px;
            transition: all 0.3s ease;
        }
        .btn:hover { background: #0056b3; }

        /* Animated Loader */
        .loader {
            display: none;
            border: 4px solid #f3f3f3;
            border-top: 4px solid #007BFF;
            border-radius: 50%;
            width: 40px;
            height: 40px;
            animation: spin 1s linear infinite;
            margin: 15px auto;
        }
        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }

        /* Result Box */
        .result {
            margin-top: 20px;
            font-size: 18px;
            padding: 15px;
            border-radius: 5px;
            background: #f1f1f1;
            color: black;
            display: <?php echo isset($_SESSION['result']) ? 'block' : 'none'; ?>; /* Show only if result exists */
        }

    </style>
</head>
<body>

    <h2>🌾 AI-Powered Wheat Disease Detection</h2>

    <div class="container">
        <form id="uploadForm" action="predict.php" method="POST" enctype="multipart/form-data" onsubmit="startLoading()">
            
            <label class="upload-section" for="imageUpload">
                Click to Upload Image
                <input type="file" name="file" id="imageUpload" accept="image/*" required onchange="previewImage(event)">
            </label>

            <img id="preview" class="preview" alt="Image Preview">

            <button type="submit" class="btn">🔍 Analyze Image</button>
            <div class="loader" id="loader"></div>

        </form>

        <!-- Display AI Results -->
        <div class="result" id="result-box">
            <?php 
                if (isset($_SESSION['result'])) {  
                    echo $_SESSION['result'];  
                    unset($_SESSION['result']);  // 🔥 Reset session after showing
                }  
            ?>
        </div>
    </div>

    <script>
        function previewImage(event) {
            const preview = document.getElementById('preview');
            preview.src = URL.createObjectURL(event.target.files[0]);
            preview.style.display = "block";
        }

        function startLoading() {
            document.getElementById('uploadForm').style.display = "none";  // 🔥 Hide form
            document.getElementById('loader').style.display = "block";  // 🔥 Show loader
        }
    </script>

</body>
</html>