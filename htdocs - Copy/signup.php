<!-- <!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login & Signup - Our Platform</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f8f9fa;
        }
        .container {
            max-width: 400px;
            margin-top: 100px;
            padding: 20px;
            background: white;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
    </style>
</head>
<body>
    <div class="container text-center">
        <h2 class="mb-4">Welcome to Our Platform</h2>
        
        <form action="auth/login.php" method="POST">
            <div class="mb-3">
                <input type="text" name="email" class="form-control" placeholder="Phone Number" required>
            </div>
            <div class="mb-3">
                <input type="password" name="password" class="form-control" placeholder="Password" required>
            </div>
            <div class="mb-3">
                <select name="user_type" class="form-select" required>
                    <option value="farmer">Farmer</option>
                    <option value="consumer">Consumer</option>
                </select>
            </div>
            <button type="submit" class="btn btn-primary w-100">Login</button>
        </form>
        <p class="mt-3">
            <a href="#signup" data-bs-toggle="collapse">Don't have an account? Sign up</a>
        </p>
        
        <div id="signup" class="collapse mt-4">
            <h2 class="mb-4">Sign Up</h2>
            <form action="auth/register.php" method="POST">
                <div class="mb-3">
                    <input type="text" name="name" class="form-control" placeholder="Full Name" required>
                </div>
                <div class="mb-3">
                    <input type="text" name="email" class="form-control" placeholder="Phone Number" required>
                </div>
                <div class="mb-3">
                    <input type="password" name="password" class="form-control" placeholder="Password" required>
                </div>
                <div class="mb-3">
                    <select name="user_type" class="form-select" required>
                        <option value="farmer">Farmer</option>
                        <option value="consumer">Consumer</option>
                    </select>
                </div>
                <button type="submit" class="btn btn-success w-100">Sign Up</button>
            </form>
            <p class="mt-3">
                <a href="#" data-bs-toggle="collapse" data-bs-target="#signup">Already have an account? Login</a>
            </p>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <div id="google_translate_element"></div>
<script type="text/javascript">
function googleTranslateElementInit() {
    new google.translate.TranslateElement({
        pageLanguage: 'en',
        includedLanguages: 'hi,en,gu,kn,ml,mr,pa,ta,te,bn,ur', // Hindi, Gujarati, Kannada, Malayalam, Marathi, Punjabi, Tamil, Telugu, Bengali, Urdu
        layout: google.translate.TranslateElement.InlineLayout.SIMPLE
    }, 'google_translate_element');
}
</script>
<script type="text/javascript" src="//translate.google.com/translate_a/element.js?cb=googleTranslateElementInit"></script>

 

</body>
</html> -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login & Signup - Our Platform</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f8f9fa;
            position: relative;
        }
        .container {
            max-width: 400px;
            margin-top: 100px;
            padding: 20px;
            background: white;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        /* Google Translate Styling */
        .translate-container {
            position: absolute;
            top: 20px;
            right: 10px;
            z-index: 1000;
        }
        /* Hide Google Translate Banner */
        .goog-te-banner-frame {
            display: none !important;
        }
        body { top: 0 !important; }
        /* Optional: Make the dropdown smaller */
        .goog-te-gadget {
            font-size: 12px !important;
        }
    </style>
</head>
<body>

    <!-- Google Translate Positioned at Top-Right -->
    <!-- <div class="translate-container">
        <div id="google_translate_element"></div>
    </div> -->

    <div class="container text-center">
        <h2 class="mb-4">Welcome to Our Platform</h2>
        
        <form action="auth/login.php" method="POST">
            <div class="mb-3">
                <input type="text" name="email" class="form-control" placeholder="Email or Phone Number" required>
            </div>
            <div class="mb-3">
                <input type="password" name="password" class="form-control" placeholder="Password" required>
            </div>
            <div class="mb-3">
                <select name="user_type" class="form-select" required>
                    <option value="farmer">Farmer</option>
                    <option value="consumer">Consumer</option>
                </select>
            </div>
            <button type="submit" class="btn btn-primary w-100">Login</button>
        </form>
        <p class="mt-3">
            <a href="#signup" data-bs-toggle="collapse">Don't have an account? Sign up</a>
        </p>
        
        <div id="signup" class="collapse mt-4">
            <h2 class="mb-4">Sign Up</h2>
            <form action="auth/register.php" method="POST">
                <div class="mb-3">
                    <input type="text" name="name" class="form-control" placeholder="Full Name" required>
                </div>
                <div class="mb-3">
                    <input type="text" name="email" class="form-control" placeholder="Email or Phone Number" required>
                </div>
                <div class="mb-3">
                    <input type="password" name="password" class="form-control" placeholder="Password" required>
                </div>
                <div class="mb-3">
                    <select name="user_type" class="form-select" required>
                        <option value="farmer">Farmer</option>
                        <option value="consumer">Consumer</option>
                    </select>
                </div>
                <button type="submit" class="btn btn-success w-100">Sign Up</button>
            </form>
            <p class="mt-3">
                <a href="#" data-bs-toggle="collapse" data-bs-target="#signup">Already have an account? Login</a>
            </p>
        </div>
    </div>
    <div class="translate-container">
        <div id="google_translate_element"></div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script type="text/javascript">
        function googleTranslateElementInit() {
            new google.translate.TranslateElement({
                pageLanguage: 'en',
                includedLanguages: 'hi,en,gu,kn,ml,mr,pa,ta,te,bn,ur', // Hindi, Gujarati, Kannada, Malayalam, Marathi, Punjabi, Tamil, Telugu, Bengali, Urdu
                layout: google.translate.TranslateElement.InlineLayout.SIMPLE
            }, 'google_translate_element');
        }
    </script>
    <script type="text/javascript" src="//translate.google.com/translate_a/element.js?cb=googleTranslateElementInit"></script>

</body>
</html>
