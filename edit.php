<?php

// usndo MySQLi

// if ($_SERVER['REQUEST_METHOD'] == 'POST') {
//     require_once("db.php");

//     $id = $_POST['id'];
//     $name = $_POST['name'];
//     $email = $_POST['email'];
//     $password = $_POST['password'];
//     $phone = $_POST['phone'];

//     $query = "UPDATE users SET name = '$name', email='$email', password= '$password', phone = '$phone' WHERE id = '$id'";
//     $result = $mysql->query($query);

//     if ($mysql->affected_rows > 0) {
//         if ($result === TRUE) {
//             echo "Udate successfully";
//         } else {
//             echo "Error.";
//         }
//     } else {
//         echo "Not found any rows";
//     }
//     $mysql->close();
// }

// USANDO PDO

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    require_once("db.php");

    // Crear una instancia de la clase Database y obtener la conexión
    $database = new Database();
    $db = $database->getConnection();

    // Validar y sanitizar los datos de entrada
    $id = isset($_POST['id']) ? intval($_POST['id']) : 0;
    $name = isset($_POST['name']) ? $_POST['name'] : '';
    $email = isset($_POST['email']) ? $_POST['email'] : '';
    $password = isset($_POST['password']) ? $_POST['password'] : '';
    $phone = isset($_POST['phone']) ? $_POST['phone'] : '';

    // Verificar que el ID no esté vacío
    if ($id <= 0 || empty($name) || empty($email) || empty($password) || empty($phone)) {
        echo json_encode(array("error" => "Invalid input data"));
        exit;
    }

    try {
        // Preparar la consulta UPDATE
        $query = "UPDATE users SET name = :name, email = :email, password = :password, phone = :phone WHERE id = :id";
        $stmt = $db->prepare($query);

        // Vincular los parámetros de la consulta con los valores
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->bindParam(':name', $name, PDO::PARAM_STR);
        $stmt->bindParam(':email', $email, PDO::PARAM_STR);
        $stmt->bindParam(':password', $password, PDO::PARAM_STR);
        $stmt->bindParam(':phone', $phone, PDO::PARAM_STR);

        // Ejecutar la consulta
        if ($stmt->execute()) {
            if ($stmt->rowCount() > 0) {
                echo json_encode(array("message" => "Update successful"));
            } else {
                echo json_encode(array("error" => "No rows affected"));
            }
        } else {
            echo json_encode(array("error" => "Update failed"));
        }
    } catch (PDOException $e) {
        echo json_encode(array("error" => "Query failed: " . $e->getMessage()));
    }

    $db = null; // Cerramos la conexión a la base de datos
}
