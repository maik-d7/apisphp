<?php
if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    require_once("db.php");

    $database = new Database();
    $db = $database->getConnection();

    try {
        // Modificar la consulta para obtener los últimos 10 registros
        $query = "SELECT * FROM users ORDER BY id DESC LIMIT 10";
        $stmt = $db->prepare($query);
        $stmt->execute();

        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
        
        if ($results) {
            echo json_encode($results);
        } else {
            echo json_encode(array("message" => "No records found"));
        }
    } catch (PDOException $e) {
        echo json_encode(array("error" => "Query failed: " . $e->getMessage()));
    }

    $db = null; // Cerramos la conexión a la base de datos
}
