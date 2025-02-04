<form action="auth/login.php" method="POST">
    <input type="email" name="email" placeholder="Email" required><br>
    <input type="password" name="password" placeholder="Password" required><br>
    <select name="user_type" required>
        <option value="farmer">Farmer</option>
        <option value="consumer">Consumer</option>
    </select><br>
    <button type="submit">Login</button>
</form>
<a href="signup.php">Don't have an account? Sign up</a>
