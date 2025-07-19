<?php include 'includes/header.php'; ?>

<div class="form-container">
    <h2 class="form-title">Login</h2>
    
    <?php
    // Handle login form submission
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $email = $_POST['email'];
        $password = $_POST['password'];
        
        // Basic validation
        if (empty($email) || empty($password)) {
            echo '<div class="error-message">Please fill in all fields.</div>';
        } else {
            // Check if user exists
            $sql = "SELECT * FROM users WHERE email = ?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("s", $email);
            $stmt->execute();
            $result = $stmt->get_result();
            
            if ($result->num_rows > 0) {
                $user = $result->fetch_assoc();
                
                // Verify password
                if (password_verify($password, $user['password'])) {
                    // Password is correct, set session variables
                    $_SESSION['user_id'] = $user['id'];
                    $_SESSION['username'] = $user['username'];
                    
                    // Redirect to homepage or requested page
                    $redirect = isset($_GET['redirect']) ? $_GET['redirect'] : 'index.php';
                    header("Location: $redirect");
                    exit;
                } else {
                    echo '<div class="error-message">Invalid email or password.</div>';
                }
            } else {
                echo '<div class="error-message">Invalid email or password.</div>';
            }
        }
    }
    ?>
    
    <form method="post" action="">
        <div class="form-group">
            <label for="email">Email</label>
            <input type="email" id="email" name="email" required>
        </div>
        <div class="form-group">
            <label for="password">Password</label>
            <input type="password" id="password" name="password" required>
        </div>
        <button type="submit" class="form-btn">Login</button>
    </form>
    
    <div class="form-footer">
        <p>Don't have an account? <a href="signup.php<?php echo isset($_GET['redirect']) ? '?redirect=' . $_GET['redirect'] : ''; ?>">Sign Up</a></p>
    </div>
</div>

<style>
    .form-container {
        max-width: 400px;
        margin: 40px auto;
    }
    
    .form-title {
        text-align: center;
        margin-bottom: 30px;
    }
    
    .form-group {
        margin-bottom: 20px;
    }
    
    .form-group label {
        display: block;
        margin-bottom: 8px;
        font-weight: bold;
    }
    
    .form-group input {
        width: 100%;
        padding: 12px;
        border: 1px solid #ddd;
        border-radius: 4px;
        font-size: 16px;
    }
    
    .form-btn {
        width: 100%;
        padding: 12px;
        background-color: #e74c3c;
        color: white;
        border: none;
        border-radius: 4px;
        font-size: 16px;
        font-weight: bold;
        cursor: pointer;
        transition: background-color 0.3s;
    }
    
    .form-btn:hover {
        background-color: #c0392b;
    }
    
    .form-footer {
        margin-top: 20px;
        text-align: center;
    }
    
    .form-footer a {
        color: #e74c3c;
    }
    
    .error-message {
        background-color: #f8d7da;
        color: #721c24;
        padding: 10px;
        border-radius: 4px;
        margin-bottom: 20px;
    }
</style>

<?php include 'includes/footer.php'; ?>