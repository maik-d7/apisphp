<?php

// 
// if ($_SERVER['REQUEST_METHOD'] == 'GET') {
//     require_once("db.php");

//     $id = $_GET['id'];

//     $query = "SELECT * FROM users WHERE id = '$id'";
//     $result = $mysql->query($query);

//     if ($mysql->affected_rows > 0) {
//         while ($row = $result->fetch_assoc()) {
//             $array = $row;
//         }
//         echo json_encode($array);
//     } else {
//         echo "not found any rows";
//     }

//     $result->close();
//     $mysql->close();
// }

// USANDO PDO

if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    require_once("db.php");

    // Validar y sanitizar el ID
    $id = isset($_GET['id']) ? intval($_GET['id']) : 0;

    if ($id <= 0) {
        echo json_encode(array("error" => "Invalid ID"));
        exit;
    }

    $database = new Database();
    $db = $database->getConnection();

    try {
        $query = "SELECT * FROM users WHERE id = :id";
        $stmt = $db->prepare($query);

        // Vincular el parámetro
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();

        // Verificar si se encontró el registro
        if ($stmt->rowCount() > 0) {
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            echo json_encode($row); // Convertimos la fila a JSON y la imprimimos
        } else {
            echo json_encode(array("message" => "User not found"));
        }
    } catch (PDOException $e) {
        echo json_encode(array("error" => "Query failed: " . $e->getMessage()));
    }

    $db = null; // Cerramos la conexión a la base de datos
}
