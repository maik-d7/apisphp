<?php

// suando MySQLi
// if ($_SERVER['REQUEST_METHOD'] == 'POST') {

//     require_once("db.php");
//     $id = $_POST['id'];

//     $query = "DELETE FROM users WHERE id ='$id'";
//     $result = $mysql->query($query);

//     if ($mysql->affected_rows > 0) {
//         if ($result === TRUE) {
//             echo "Eliminado successfully";
//         }
//     } else {
//         echo "not found any rows";
//     }
// }


// USANDO PDO

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    require_once("db.php");

    // Validar y sanitizar el ID de entrada
    $id = isset($_POST['id']) ? intval($_POST['id']) : 0;

    // Verificar que el ID no esté vacío
    if ($id <= 0) {
        echo json_encode(array("error" => "Invalid ID"));
        exit;
    }

    $database = new Database();
    $db = $database->getConnection();

    try {
        // Preparar la consulta DELETE
        $query = "DELETE FROM users WHERE id = :id";
        $stmt = $db->prepare($query);

        // Vincular el parámetro de la consulta con el valor
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);

        // Ejecutar la consulta
        if ($stmt->execute()) {
            if ($stmt->rowCount() > 0) {
                echo json_encode(array("message" => "Deleted successfully"));
            } else {
                echo json_encode(array("error" => "No rows found"));
            }
        } else {
            echo json_encode(array("error" => "Delete failed"));
        }
    } catch (PDOException $e) {
        echo json_encode(array("error" => "Query failed: " . $e->getMessage()));
    }

    $db = null; // Cerramos la conexión a la base de datos
}