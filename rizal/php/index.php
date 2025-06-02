



<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Forum Login & Sign Up</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

    <div class="container">
        <!-- Form Login -->
        <div class="form-box login">
            <h2>Log in</h2>
            <form action="login.php" method="POST">
                <input type="text" name="username" placeholder="Username" required>
                <input type="password" name="password" placeholder="Password" required>
                <button type="submit">Login</button>
            </form>
            <br>
            <p>Belum punya akun? <a href="#" id="show-signup">Sign Up</a></p>
        </div>

        <!-- Form Sign Up -->
        <div class="form-box signup">
            <h2>Sign up</h2>
           <form id="signup-form" action="register.php" method="POST">
                <input type="email" name="Gmail" placeholder="Gmail" required>
                <input type="text" name="username" placeholder="Username" required>
                <input type="password" name="password" id="password" placeholder="Password" required>
                <input type="password" name="confirm_password" id="confirm_password" placeholder="Confirm Password" required>
                <button type="submit">Sign Up</button>
                <span id="error-message"></span>
                
            </form>
            <br>
    
            <p>Sudah punya akun? <a href="#" id="show-login">Login</a></p>

        </div>
    </div>

    <script src="script.js"></script>
</body>
</html>
