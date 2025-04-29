<?php
$servername = "localhost";
$username = "root";
$password = ""; // It's strongly recommended to set a password for your database
$dbname = "signup";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $fullname = $_POST["fullname"];
    $email = $_POST["email"];
    $password = $_POST["password"];
    
    // Hash the password for security
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);


    // Use prepared statements to prevent SQL injection
    $sql = "INSERT INTO signup (fullname, email, password) VALUES (?, ?, ?)";
    $stmt = $conn->prepare($sql);

    // Bind parameters and execute
    $stmt->bind_param("sss", $fullname, $email, $hashedPassword);

    if ($stmt->execute()) {
        echo "<script>
            alert('Registration Successful!');
            window.location.href = 'login.html';
          </script>";
        exit();
    } else {
        echo "Error: " . $stmt->error;
    }
    $stmt->close();
}
$conn->close();
?>