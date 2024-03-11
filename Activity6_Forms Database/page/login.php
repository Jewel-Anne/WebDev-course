<?php
$servername = "localhost";
$username = "root";
$password = ""; // Use your MySQL password here if you have set one
$database = "maindb";

// Create a connection
$conn = new mysqli($servername, $username, $password, $database);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $email = $_POST['email'];
  $password = $_POST['password'];

  // Validate the submitted email and password
  // (You can add additional validation if needed)

  // Query the database to check if the email and password exist
  $sql = "SELECT * FROM registration WHERE email = '$email' AND password = '$password'";
  $result = mysqli_query($conn, $sql);

  if (mysqli_num_rows($result) === 1) {
    // User authenticated successfully
    // Redirect to welcome.html
    header("Location: login.html");
    exit();
  } else {
    // Invalid credentials
    // Redirect to failed.html
    header("Location: failed.html");
    exit();
  }
}
?>