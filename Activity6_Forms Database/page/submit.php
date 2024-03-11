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

// Retrieve form data from the POST request
$first_name = $_POST['first_name'];
$last_name = $_POST['last_name'];
$birthdate = $_POST['birthdate'];
$email = $_POST['email'];
$password = $_POST['password'];
$address = $_POST['address'];

//$address = "$street, $region, $province, $city, $brgy, $zip"; // Combine address inputs
$gender = $_POST['gender'];
$skills = isset($_POST['skills']) && is_array($_POST['skills']) ? $_POST['skills'] : array(); // Assign an empty array if skills are not selected or not an array
$specialization = isset($_POST['specialization']) && is_array($_POST['specialization']) ? $_POST['specialization'] : array(); // Assign an empty array if specialization is not selected or not an array
$resume = $_FILES['resume']['name'];
$cover_letter = $_POST['cover_letter'];
$agree_terms = isset($_POST['agree_terms']) ? $_POST['agree_terms'] : 0;

// Prepare and bind the form data to insert into the registration table
$stmt = $conn->prepare("INSERT INTO registration (first_name, last_name, birthdate, email, password, address, gender, skills, specialization, resume, cover_letter, agree_terms) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
$stmt->bind_param("ssssssssssss", $first_name, $last_name, $birthdate, $email, $password, $address, $gender, $skills_str, $specialization_str, $resume, $cover_letter, $agree_terms);

// Convert skills and specialization arrays to comma-separated strings
$skills_str = implode(", ", $skills);
$specialization_str = implode(", ", $specialization);

// Execute the prepared statement to insert the data into the registration table
if ($stmt->execute()) {
    echo "Data saved successfully.";
} else {
    echo "Error: " . $stmt->error;
}

// Close the prepared statement
$stmt->close();

// Close the database connection
$conn->close();

// Redirect to registered.html
header("Location: registered.html");
exit;
?>
