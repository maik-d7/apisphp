<?php

// USANDO MYSQLI
// if ($_SERVER['REQUEST_METHOD'] == 'POST') {
//     require_once("db.php");

//     $name = $_POST['name'];
//     $email = $_POST['email'];
//     $password = $_POST['password'];
//     $phone = $_POST['phone'];

//     $query = "INSERT INTO users (name, email, password, phone) VALUES ('$name','$email','$password','$phone')";

//     $result = $mysql->query($query);

//     if ($result === TRUE) {
//         echo "the user was created successfully";
//     } else {
//         echo "Error";
//         echo "Error: " . $mysql->error();
//     }
//     $mysql->close();
// }

// USANDO PDO
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    require_once("db.php");

    $name = isset($_POST['name']) ? trim($_POST['name']) : '';
    $email = isset($_POST['email']) ? trim($_POST['email']) : '';
    $password = isset($_POST['password']) ? trim($_POST['password']) : '';
    $phone = isset($_POST['phone']) ? trim($_POST['phone']) : '';

    if (empty($name) || empty($email) || empty($password) || empty($phone)) {
        echo json_encode(array("error" => "All fields are required"));
        exit;
    }

    $database = new Database();
    $db = $database->getConnection();

    try {
        $query = "INSERT INTO users (name, email, password, phone) VALUES (:name, :email, :password, :phone)";
        $stmt = $db->prepare($query);

        $stmt->bindParam(':name', $name, PDO::PARAM_STR);
        $stmt->bindParam(':email', $email, PDO::PARAM_STR);
        $stmt->bindParam(':password', $password, PDO::PARAM_STR);
        $stmt->bindParam(':phone', $phone, PDO::PARAM_STR);

        if ($stmt->execute()) {
            echo json_encode(array("message" => "The user was created successfully"));
        } else {
            echo json_encode(array("error" => "Failed to create the user"));
        }
    } catch (PDOException $e) {
        echo json_encode(array("error" => "Query failed: " . $e->getMessage()));
    }

    $db = null; // Cerrar la conexión
}