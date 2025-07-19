<?php include 'includes/header.php'; ?>

<div class="form-container">
    <h2 class="form-title">Create an Account</h2>
    
    <?php
    // Handle signup form submission
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $username = $_POST['username'];
        $email = $_POST['email'];
        $password = $_POST['password'];
        $confirm_password = $_POST['confirm_password'];
        
        // Basic validation
        if (empty($username) || empty($email) || empty($password) || empty($confirm_password)) {
            echo '<div class="error-message">Please fill in all fields.</div>';
        } elseif ($password !== $confirm_password) {
            echo '<div class="error-message">Passwords do not match.</div>';
        } elseif (strlen($password) < 6) {
            echo '<div class="error-message">Password must be at least 6 characters.</div>';
        } else {
            // Check if email already exists
            $sql = "SELECT * FROM users WHERE email = ?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("s", $email);
            $stmt->execute();
            $result = $stmt->get_result();
            
            if ($result->num_rows > 0) {
                echo '<div class="error-message">Email already in use. Please use a different email or login.</div>';
            } else {
                // Check if username already exists
                $sql = "SELECT * FROM users WHERE username = ?";
                $stmt = $conn->prepare($sql);
                $stmt->bind_param("s", $username);
                $stmt->execute();
                $result = $stmt->get_result();
                
                if ($result->num_rows > 0) {
                    echo '<div class="error-message">Username already taken. Please choose another one.</div>';
                } else {
                    // Hash password
                    $hashed_password = password_hash($password, PASSWORD_DEFAULT);
                    
                    // Insert user
                    $sql = "INSERT INTO users (username, email, password) VALUES (?, ?, ?)";
                    $stmt = $conn->prepare($sql);
                    $stmt->bind_param("sss", $username, $email, $hashed_password);
                    
                    if ($stmt->execute()) {
                        // Get the new user ID
                        $user_id = $conn->insert_id;
                        
                        // Set session variables
                        $_SESSION['user_id'] = $user_id;
                        $_SESSION['username'] = $username;
                        
                        // Redirect to homepage or requested page
                        $redirect = isset($_GET['redirect']) ? $_GET['redirect'] : 'index.php';
                        header("Location: $redirect");
                        exit;
                    } else {
                        echo '<div class="error-message">Error creating account. Please try again.</div>';
                    }
                }
            }
        }
    }
    ?>
    
    <form method="post" action="">
        <div class="form-group">
            <label for="username">Username</label>
            <input type="text" id="username" name="username" required>
        </div>
        <div class="form-group">
            <label for="email">Email</label>
            <input type="email" id="email" name="email" required>
        </div>
        <div class="form-group">
            <label for="password">Password</label>
            <input type="password" id="password" name="password" required>
        </div>
        <div class="form-group">
            <label for="confirm_password">Confirm Password</label>
            <input type="password" id="confirm_password" name="confirm_password" required>
        </div>
        <button type="submit" class="form-btn">Sign Up</button>
    </form>
    
    <div class="form-footer">
        <p>Already have an account? <a href="login.php<?php echo isset($_GET['redirect']) ? '?redirect=' . $_GET['redirect'] : ''; ?>">Login</a></p>
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