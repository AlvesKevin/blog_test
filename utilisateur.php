<?php
$servername = "localhost:3306";
$username = "root";
$password = "root";
$dbname = "articles";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Remplacez ces valeurs par les informations d'authentification de l'utilisateur
$user_username = "Paul";
$user_password = "j9*!aQ2&VUc5#F7y@hG";

// Hachez le mot de passe
$hashed_password = password_hash($user_password, PASSWORD_DEFAULT);

$sql = "INSERT INTO users (username, password) VALUES (?, ?)";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ss", $user_username, $hashed_password);

if ($stmt->execute()) {
    echo "L'utilisateur a été ajouté avec succès.";
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}

$stmt->close();
$conn->close();
?>