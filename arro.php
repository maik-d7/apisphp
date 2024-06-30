<?php

// USANDO MYSQLI
// if($_SERVER['REQUEST_METHOD'] == 'GET'){
//     require_once("db.php");

// //    $id = $_GET['id'];

//     $query = "SELECT * FROM users";
//     $result = $mysql->query($query);

//     $array = array(); // Creamos un arreglo vacío para almacenar los objetos JSON

//     if($mysql->affected_rows > 0){
//         while($row = $result->fetch_assoc()){
//             $array[] = $row; // Agregamos cada fila de la tabla al arreglo como un objeto JSON
//         }
//         echo json_encode($array); // Imprimimos el arreglo completo como JSON
//     }
//     else{
//         echo "not found any rows";
//     }

//     $result->close();
//     $mysql->close();
// }


// USANDO PDO
if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    require_once("db.php");

    $database = new Database();
    $db = $database->getConnection();

    try {
        $query = "SELECT * FROM users";
        $stmt = $db->prepare($query);
        $stmt->execute();

        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

        if (count($result) > 0) {
            echo json_encode($result); // Convertimos el arreglo a JSON y lo imprimimos
        } else {
            echo json_encode(array("message" => "No records found."));
        }
    } catch (PDOException $e) {
        echo json_encode(array("error" => "Query failed: " . $e->getMessage()));
    }

    $db = null; // Cerramos la conexión a la base de datos
}

?>