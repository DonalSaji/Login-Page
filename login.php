<?php
// Database connection
$host = 'localhost';
$user = 'root';
$password = ''; // Assuming no password is set
$database = 'login';
$table = 'user';

// Attempt to connect to MySQL database
$connection = mysqli_connect($host, $user, $password, $database);

// Check connection
if (!$connection) {
    die("Connection failed: " . mysqli_connect_error());
}


// Function to sanitize input data
function sanitize_input($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

// If form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['username']) && isset($_POST['pass'])) {
        // Login validation
        $email = sanitize_input($_POST['username']);
        $password = sanitize_input($_POST['pass']);

        // Prepare a SELECT statement
        $sql = "SELECT id, name, email, password FROM $table WHERE email = ?";

        if ($stmt = mysqli_prepare($connection, $sql)) {
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "s", $param_email);

            // Set parameters
            $param_email = $email;

            // Attempt to execute the prepared statement
            if (mysqli_stmt_execute($stmt)) {
                // Store result
                mysqli_stmt_store_result($stmt);

                // Check if email exists, if yes then verify password
                if (mysqli_stmt_num_rows($stmt) == 1) {
                    // Bind result variables
                    mysqli_stmt_bind_result($stmt, $id, $name, $email, $hashed_password);
                    if (mysqli_stmt_fetch($stmt)) {
                        if (password_verify($password, $hashed_password)) {
                            // Password is correct, start a new session
                            session_start();

                            // Store data in session variables
                            $_SESSION["loggedin"] = true;
                            $_SESSION["id"] = $id;
                            $_SESSION["name"] = $name;
                            $_SESSION["email"] = $email;

                            // Redirect user to welcome page
                            header("location: welcome.php");
                        } else {
                            // Display an error message if password is not valid
                            $password_err = "The password you entered was not valid.";
                            echo "<script>alert('$password_err');</script>";
                        }
                    }
                } else {
                    // Display an error message if email doesn't exist
                    $email_err = "No account found with that email.";
                    echo "<script>alert('$email_err');</script>";
                }
            } else {
                echo "Oops! Something went wrong. Please try again later.";
            }

            // Close statement
            mysqli_stmt_close($stmt);
        }
    } elseif (isset($_POST['name']) && isset($_POST['email']) && isset($_POST['password']) && isset($_POST['confirm_password'])) {
        // Create new user
        $name = sanitize_input($_POST['name']);
        $email = sanitize_input($_POST['email']);
        $password = sanitize_input($_POST['password']);

        // Validate password match
        if ($_POST['password'] !== $_POST['confirm_password']) {
            echo "<script>alert('Passwords do not match');</script>";
        } else {
            // Encrypt password
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);

            // Insert data into user table
            $sql = "INSERT INTO $table (name, email, password) VALUES (?, ?, ?)";

            if ($stmt = mysqli_prepare($connection, $sql)) {
                // Bind variables to the prepared statement as parameters
                mysqli_stmt_bind_param($stmt, "sss", $name, $email, $hashed_password);

                // Attempt to execute the prepared statement
                if (mysqli_stmt_execute($stmt)) {
                    echo "<script>alert('User created successfully');</script>";
                } else {
                    echo "Oops! Something went wrong. Please try again later.";
                }

                // Close statement
                mysqli_stmt_close($stmt);
            }
        }
    }
}

// Close connection
mysqli_close($connection);
?>
