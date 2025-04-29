<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "signup";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST["email"];
    $password = $_POST["password"];

    // Prepare SQL statement
    $sql = "SELECT * FROM signup WHERE email = ?";
    $stmt = $conn->prepare("SELECT password FROM signup WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 1) {
        $user = $result->fetch_assoc();

        // Verify hashed password
        if (password_verify($password, $user["password"])) {
            $_SESSION["email"] = $user["email"];
            echo "<script>
                alert('Login successful!');
                window.location.href = 'ab.html';
              </script>";
        } else {
            echo "<script>
                alert('Invalid password.');
                window.location.href = 'login.html';
              </script>";
        }
    } else {
        echo "<script>
            alert('Email not found.');
            window.location.href = 'login.html';
          </script>";
    }

    $stmt->close();
}

$conn->close();
?>
